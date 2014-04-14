<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-4-14
 * Time: 下午10:36
 */

namespace Application\Service;


use Zend\Server\Cache;

abstract class AbstractService {
    protected $cache;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $objectManager;
    public function __construct($sm)
    {
        $this->cache = new Cache();
        if(!isset($this->objectManager)){
            $this->objectManager = $sm->get('Doctrine\ORM\EntityManager');
        }
    }
} 