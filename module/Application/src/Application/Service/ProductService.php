<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-3-26
 * Time: 下午4:40
 */

namespace Application\Service;


use Zend\ModuleManager\ModuleManager;

class ProductService extends  AbstractService
{
    public function save($data)
    {
    }

    public function SearchProductsBySku($query,$limit=5)
    {
        $products = $this->getRepository()->createQueryBuilder('o')
            ->where('o.sku LIKE :query')
            ->setParameter('query', $query.'%')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        return $products;
    }

    public function getAllProducts()
    {
        return $this->getRepository()->findAll();
    }

    public function IsProductExists($sku)
    {
        $result = $this->getRepository()->findOneBy(array('sku'=>$sku));
        return $result!==null;
    }

    function getRepository()
    {
        return $this->objectManager->getRepository('Application\Entity\Product');
    }
}