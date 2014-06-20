<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-19
 * Time: 下午5:51
 */

namespace Application\Lib\Acl;


use Zend\Permissions\Acl\Resource\GenericResource;
use Zend\Permissions\Acl\Role\GenericRole;

class Acl extends \Zend\Permissions\Acl\Acl{
    protected $_roles;
    protected $__resources;
    protected static  $_instance;

    private function __construct()
    {
        $this->_roles = include $_SERVER['DOCUMENT_ROOT'].'/../config/module.acl.roles.php';
        $this->_resources = include $_SERVER['DOCUMENT_ROOT'].'/../config/module.resources.php';
        $this->load();
    }
    public static  function getInstance()
    {
        if(!isset(self::$_instance)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    public function load()
    {
        if(empty($this->_roles)) throw new \Exception('no roles found');
        if(empty($this->_resources)) throw new \Exception('no resources found');
        foreach($this->_resources as $key=>$value){
            $root = new GenericResource($key);
            $this->addResource($root);
            foreach($value as $sKey=>$sValue){
                $second = new GenericResource($sKey);
                $this->addResource($second,$root);
                foreach($sValue as $tValue){
                    $third = new GenericResource($tValue);
                    $this->addResource($third,$second);
                }
            }
        }
        foreach($this->_roles as $key=>$value){
            $role = new GenericRole($key);
            $this->addRole($role);
            $this->allow($role,$value);
        }
    }
} 