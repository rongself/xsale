<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-3-8
 * Time: 下午3:43
 */

namespace Application\Entity;

use JsonSerializable;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractEntity implements JsonSerializable {

    public function jsonSerialize(){

        $array = array();
        $methods =  get_class_methods(get_class($this));
        foreach($methods as $methodsName){
            $prefix = substr($methodsName,0,3);
            if($prefix == 'get'){
                $varName = lcfirst(substr($methodsName,3));
                $array[$varName] = $this->$methodsName();
            }
        }
        return $array;

    }


} 