<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $serviceManager = $e->getApplication()->getServiceManager();

        $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
        $config = $serviceManager->get('Config');
        $viewModel->xsaleConfig = $config['upload'];

        $customerService = $serviceManager->get('CustomerService');
        $viewModel->vipCount = $customerService->getVipCount();

        $saleRecordService = $serviceManager->get('SaleRecordService');
        $viewModel->saleroom = $saleRecordService->getSaleroom();

        $orderItemService = $serviceManager->get('OrderCartService');
        $viewModel->quantityOfSale = $orderItemService->getQuantityOfSale();

        // Set event
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(array('dispatch',MvcEvent::EVENT_DISPATCH_ERROR,MvcEvent::EVENT_RENDER_ERROR), array($this, 'dispatchHandle'));
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
