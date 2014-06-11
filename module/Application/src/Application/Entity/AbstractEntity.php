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
        return get_object_vars($this);
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

} 