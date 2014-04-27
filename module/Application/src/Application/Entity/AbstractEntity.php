<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-3-8
 * Time: 下午3:43
 */

namespace Application\Entity;

use JsonSerializable;
use Traversable;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractEntity implements JsonSerializable {

    public function __construct(array $data = null)
    {
        if($data!=null){
            $ref = new \ReflectionClass($this);
            $methods = $ref->getMethods();
            foreach ($data as $key=>$value)
            {
                $methodsName = 'set'.ucfirst($key);
                if($ref->hasMethod($methodsName))
                {
                    $this->$methodsName($value);
                }
            }
        }
    }

    public function jsonSerialize()
    {

//        $array = array();
//        $ref = new \ReflectionClass($this);
//        $methods = $ref->getMethods();
//        foreach($methods as $methodsName){
//            $prefix = substr($methodsName,0,3);
//            if($prefix == 'get'){
//                $varName = lcfirst(substr($methodsName,3));
//                $array[$varName] = $this->$methodsName();
//            }
//        }
        return get_object_vars($this);

    }



} 