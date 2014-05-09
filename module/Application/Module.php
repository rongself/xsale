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

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $serviceManager = $e->getApplication()->getServiceManager();
        $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
        $myService = $serviceManager->get('Config');
        $viewModel->xsaleConfig = $myService['upload'];

        // Set event
        $eventManager        = $e->getApplication()->getEventManager();
        $eventManager->attach(array('dispatch',MvcEvent::EVENT_DISPATCH_ERROR,MvcEvent::EVENT_RENDER_ERROR), array($this, 'dispatchHandle'));
    }

    /**
     * 路由分发后才能获取controller和action名称
     * @param MvcEvent $e
     */
    public function dispatchHandle(MvcEvent $e)
    {
        //$serviceManager = $e->getApplication()->getServiceManager();
        $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
        $viewModel->controller = $e->getRouteMatch()->getParam("__CONTROLLER__");
        $viewModel->action = $e->getRouteMatch()->getParam('action');
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
