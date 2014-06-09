<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-6-6
 * Time: 下午8:17
 */

namespace Application\Lib\System\Config;


use Application\Entity\Setting;

class Config extends AbstractConfig {
    private static $instance;
    private $serviceManager;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repository;
    /**
     * @var \Zend\Cache\Storage\Adapter\Filesystem
     */
    private $cache;
    private function __construct($sm)
    {
        $this->serviceManager = $sm;
        $this->cache = $this->serviceManager->get('CacheServerOne');
        $this->loadSettingList();
    }

    private function loadSettingList()
    {
        $this->entityManager = $this->serviceManager->get('Doctrine\ORM\EntityManager');
        $this->repository = $this->entityManager->getRepository('Application\Entity\Setting');
    }

    public static  function getInstance($sm)
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self($sm);
        }
        return self::$instance;
    }

    public function get($key)
    {
        if($this->cache->hasItem($key)){
            $item = $this->cache->getItem($key);
        }else{
            $item = $this->repository->findOneBy(array('key'=>$key));
            if(isset($item)){
                $this->cache->addItem($key,$item);
            }else{
                throw new \Exception("Can not find the setting by key '{$key}'");
            }
        }
        return $item;
    }

    public function set($key,$value)
    {
        $item = $this->repository->findOneBy(array('key'=>$key));
        if(isset($item))
        {
            $item->setValue($value);
            $this->cache->removeItem($key);
        }else{
            throw new \Exception("Can not find the setting by key '{$key}'");
        }
    }

    public function add(Setting $setting)
    {
        $this->entityManager->persist($setting);
        $this->entityManager->flush();
    }
}