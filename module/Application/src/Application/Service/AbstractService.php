<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-4-14
 * Time: 下午10:36
 */

namespace Application\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;

abstract class AbstractService{
    protected $cache;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $objectManager;
    public function __construct($entityManager)
    {
        $this->objectManager = $entityManager;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    abstract function getRepository();
} 