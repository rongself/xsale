<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Lib\Acl\Acl;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\SimpleRouteStack;
use Zend\Validator\AbstractValidator;
use Zend\View\Model\JsonModel;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        //translate the messages of validators
        $translator = new \Zend\Mvc\I18n\Translator();
        $translator->addTranslationFile(
            'phpArray',
            './vendor/zendframework/zendframework/resources/languages/zh/Zend_Validate.php'
        );
        $translator->setLocale('zh_CN');
        AbstractValidator::setDefaultTranslator($translator);

        if(php_sapi_name() === 'cli'){
            return false;
        }
        $this->initAcl($e);
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $serviceManager = $e->getApplication()->getServiceManager();

        $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
        $config = $serviceManager->get('Config');
        $viewModel->xsaleConfig = $config['upload'];
        $viewModel->about = $config['about'];

        $customerService = $serviceManager->get('CustomerService');
        $viewModel->vipCount = $customerService->getVipCount();

        $saleRecordService = $serviceManager->get('SaleRecordService');
        $viewModel->saleroom = $saleRecordService->getSaleroom();

        $orderItemService = $serviceManager->get('OrderCartService');
        $viewModel->quantityOfSale = $orderItemService->getQuantityOfSale();

        // Set event
        $eventManager = $e->getApplication()->getEventManager();
        //$eventManager->attach(array('dispatch',MvcEvent::EVENT_DISPATCH_ERROR,MvcEvent::EVENT_RENDER_ERROR), array($this, 'dispatchHandle'));
        $eventManager-> attach(array(MvcEvent::EVENT_ROUTE,MvcEvent::EVENT_RENDER_ERROR,MvcEvent::EVENT_DISPATCH_ERROR), array($this, 'checkAcl'));

    }

    /**
     * 路由分发后才能获取controller和action名称
     * @param MvcEvent $e
     */
    public function dispatchHandle(MvcEvent $e)
    {

        $controllerIns = $e->getTarget();
        $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
        $controller = $e->getRouteMatch()->getParam("__CONTROLLER__");
        $action = $e->getRouteMatch()->getParam('action');
        if(!($viewModel instanceof JsonModel))
        {
            $viewModel->controller = $controller;
            $viewModel->action = $action;
        }

        //check Identity globally
        $auth = $e->getApplication()->getServiceManager()->get('Zend\Authentication\AuthenticationService');
        if($controller!=='account'&&$action!=='login')
        {
            if(!$auth->hasIdentity()){
                return $controllerIns->plugin('redirect')->toRoute('login');
            }
            $userRole = 'super-admin';
            $route = strtolower($controller.'/'.$action);
            $acl = Acl::getInstance();
            if (!$acl-> isAllowed($userRole, $route)) {
                $response = $e -> getResponse();
                //location to page or what ever
                $response -> getHeaders() -> addHeaderLine('Location', $e -> getRequest() -> getBaseUrl() . '/404');
                $response -> setStatusCode(404);
            }
        }
    }

    public function initAcl(MvcEvent $e) {
        $acl = Acl::getInstance();
    }

    public function checkAcl(MvcEvent $e) {
        /**
         * @var $controllerIns \Zend\Mvc\Application
         */
        $response = $e -> getResponse();
        $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
        $controller = $e->getRouteMatch()->getParam("__CONTROLLER__");
        $action = $e->getRouteMatch()->getParam('action');
        if(!($viewModel instanceof JsonModel))
        {
            $viewModel->controller = $controller;
            $viewModel->action = $action;
        }
        //check Identity globally
        $auth = $e->getApplication()->getServiceManager()->get('Zend\Authentication\AuthenticationService');
        if(!($controller==='account'&&$action==='login'))
        {
            if(!$auth->hasIdentity()){

                $response -> getHeaders() -> addHeaderLine('Location', $e -> getRequest() -> getBaseUrl() . '/account/login');
                $response -> setStatusCode(302);
                $response->sendHeaders();
                return $response;
            }else{
                $userRole = $auth->getIdentity()->getRole();
                $route = strtolower($controller.'/'.$action);
                $acl = Acl::getInstance();

                if (!$acl-> isAllowed($userRole, $route)) {

                    $response -> getHeaders() -> addHeaderLine('Location', $e -> getRequest() -> getBaseUrl() . '/404');
                    $response -> setStatusCode(404);
                    $response->sendHeaders();
                    return $response;
                }
            }
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
            ),
        );
    }

    public function getControllerConfig()
    {
        return array(

        );
    }
}
