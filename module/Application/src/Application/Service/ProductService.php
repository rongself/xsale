<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-3-26
 * Time: 下午4:40
 */

namespace Application\Service;


class ProductService extends  AbstractService
{
    public function save($data)
    {

    }

    public function SearchProductsBySku($query){
        $products = $this->objectManager->getRepository("\Application\Entity\Product")->createQueryBuilder('o')
            ->where('o.sku LIKE :query')
            ->setParameter('query', $query.'%')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
        return $products;
    }

    public function getAllProducts(){
        $products = $this->objectManager->getRepository("\Application\Entity\Product")->findAll();
    }
} 