<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Application/Entity')
            ),

            'orm_default' => array(
                'drivers' => array(
                    'Application\Entity' => 'application_entities'
                )
            )
        )
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/[:controller[/:action]]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'=>'Index',
                        'action' => 'index',
                        '__NAMESPACE__' => 'Application\Controller'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Wildcard'
                    )
                )
            ),
            'login' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '[/account]/login',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'=>'account',
                        'action' => 'login',
                        '__NAMESPACE__' => 'Application\Controller'
                    ),
                ),
            ),
            'logout' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '[/account]/logout',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'=>'account',
                        'action' => 'logout',
                        '__NAMESPACE__' => 'Application\Controller'
                    ),
                ),
            ),
            'sale-record' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/sale-record[/:action]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'=>'sale-record',
                        'action' => 'index',
                        '__NAMESPACE__' => 'Application\Controller'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Wildcard'
                    )
                )
            ),
            'stock-record' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/stock-record[/:action]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'=>'stock-record',
                        'action' => 'index',
                        '__NAMESPACE__' => 'Application\Controller'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Wildcard'
                    )
                )
            ),
            'customer' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/customer[/:action]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'=>'customer',
                        'action' => 'index',
                        '__NAMESPACE__' => 'Application\Controller'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Wildcard'
                    )
                )
            ),
            'product' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/product[/:action]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'=>'product',
                        'action' => 'index',
                        '__NAMESPACE__' => 'Application\Controller'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Wildcard'
                    )
                )
            ),
            'account' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/account[/:action]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'=>'account',
                        'action' => 'index',
                        '__NAMESPACE__' => 'Application\Controller'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Wildcard'
                    )
                )
            ),
            'setting' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/setting[/:action]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'=>'setting',
                        'action' => 'system',
                        '__NAMESPACE__' => 'Application\Controller'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Wildcard'
                    )
                )
            ),
            'statistics' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/statistics[/:action]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller'=>'statistics',
                        'action' => 'profit',
                        '__NAMESPACE__' => 'Application\Controller'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'wildcard' => array(
                        'type' => 'Wildcard'
                    )
                )
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
            //'Application\Service\ServiceAbstractFactory'
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'factories'=>array(
            'Zend\Authentication\AuthenticationService' => function($serviceManager) {
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
             },
            'ProductService'=>function(Zend\ServiceManager\ServiceManager $sm){
                return new Application\Service\ProductService($sm->get('Doctrine\ORM\EntityManager'));
             },
            'StockRecordService' => function(Zend\ServiceManager\ServiceManager $sm) {
                return new \Application\Service\StockRecordService($sm->get('Doctrine\ORM\EntityManager'));
             },
            'SaleRecordService' => function(Zend\ServiceManager\ServiceManager $sm) {
                return new \Application\Service\SaleRecordService($sm->get('Doctrine\ORM\EntityManager'));
            },
            'CustomerService' => function(Zend\ServiceManager\ServiceManager $sm) {
                return new Application\Service\CustomerService($sm->get('Doctrine\ORM\EntityManager'));
            },
            'AccountService' => function(Zend\ServiceManager\ServiceManager $sm) {
                return new Application\Service\AccountService($sm->get('Doctrine\ORM\EntityManager'));
            },
            'StatisticsService' => function(Zend\ServiceManager\ServiceManager $sm) {
                    return new Application\Service\StatisticsService($sm->get('Doctrine\ORM\EntityManager'));
            },
        ),
    ),
    'translator' => array(
        'locale' => 'zh_CN',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            //'Application\Controller\Index' => 'Application\Controller\IndexController',
            //'Application\Controller\Account' => 'Application\Controller\AccountController',
            //'Application\Controller\Customer' => 'Application\Controller\CustomerController',
            'Application\Controller\Error' => 'Application\Controller\ErrorController',
            //'Application\Controller\Product' => 'Application\Controller\ProductController',
            //'Application\Controller\SaleRecord' => 'Application\Controller\SaleRecordController',
            'Application\Controller\Setting' => 'Application\Controller\SettingController',
            //'Application\Controller\Statistics' => 'Application\Controller\StatisticsController',
            //'Application\Controller\StockRecord' => 'Application\Controller\StockRecordController',
            'Application\Controller\FileUploader' => 'Application\Controller\FileUploaderController'
        ),
        'factories' => array(
            'Application\Controller\Index' => function ($sm) {
                    return new Application\Controller\IndexController(
                        $sm->getServiceLocator()->get('StatisticsService')
                    );
                },
            'Application\Controller\Product' => function ($sm) {
                return new Application\Controller\ProductController(
                    $sm->getServiceLocator()->get('ProductService')
                );
            },
            'Application\Controller\StockRecord' => function ($sm) {
                return new Application\Controller\StockRecordController(
                    $sm->getServiceLocator()->get('StockRecordService')
                );
            },
            'Application\Controller\SaleRecord' => function ($sm) {
                    return new Application\Controller\SaleRecordController(
                        $sm->getServiceLocator()->get('SaleRecordService')
                    );
                },
            'Application\Controller\Customer' => function ($sm) {
                return new Application\Controller\CustomerController(
                    $sm->getServiceLocator()->get('CustomerService')
                );
            },
            'Application\Controller\Account' => function ($sm) {
                return new Application\Controller\AccountController(
                    $sm->getServiceLocator()->get('AccountService'),
                    $sm->getServiceLocator()->get('Zend\Authentication\AuthenticationService')
                );
            },
            'Application\Controller\Statistics' => function ($sm) {
                    return new Application\Controller\StatisticsController(
                        $sm->getServiceLocator()->get('StatisticsService')
                    );
                },

        )
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy'
        ),
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/layout-blank'    =>  __DIR__ . '/../view/layout/layout-blank.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'imageuploader'           =>__DIR__.'/../view/shared/imageuploader.phtml',
            'sku-autocomplete'       =>__DIR__.'/../view/shared/sku-autocomplete.phtml',
            'customer-autocomplete'  =>__DIR__.'/../view/shared/customer-autocomplete.phtml',
            'paginator-control-bar'  =>__DIR__.'/../view/shared/paginator-control-bar.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
