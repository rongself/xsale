<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-4-16
 * Time: 下午1:01
 */

namespace Application\Service;


use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ServiceAbstractFactory implements AbstractFactoryInterface{

    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if (class_exists($requestedName.'Controller')){
            return true;
        }
        return false;
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        var_dump($name);
        exit;
    }
}