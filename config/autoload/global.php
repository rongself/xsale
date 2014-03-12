<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=xsale;host=localhost',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            //'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            //for zft toolbar
            'Zend\Db\Adapter\Adapter' => function($sm) {
                    $config = $sm->get('Configuration');
                    $modules = $sm->get('ModuleManager')->getLoadedModules();

                    if (isset($modules['BjyProfiler'])) { // module is enabled in application.config.php
                        $adapter = new BjyProfiler\Db\Adapter\ProfilingAdapter($config['db']);
                        $adapter->setProfiler(new BjyProfiler\Db\Profiler\Profiler());
                        if (isset($config['db']['options']) && is_array($config['db']['options'])) {
                            $options = $config['db']['options'];
                        } else {
                            $options = array();
                        }
                        $adapter->injectProfilingStatementPrototype($options);
                    } else {
                        $adapter = new Zend\Db\Adapter\Adapter($config['db']);
                    }

                    return $adapter;
                }
        ),
    ),
);
