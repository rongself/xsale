<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-3-26
 * Time: 下午4:40
 */

namespace Application\Service;

use Application\Entity\Exception\ValidationException;
use Application\Entity\Product;
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

    public function isProductExists($sku)
    {
        $result = $this->getRepository()->findOneBy(array('sku'=>$sku));
        return $result!==null;
    }

    public function getPaginator($keyword=null)
    {
        $qb = $this->getRepository()->createQueryBuilder('o');
        if(isset($keyword)){
            $qb->where($qb->expr()->like('o.sku',$qb->expr()->literal("%{$keyword}%")))
               ->orWhere($qb->expr()->like('o.name',$qb->expr()->literal("%{$keyword}%")));
        }
        return parent::getPaginator($qb->getQuery());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $qb = $this->objectManager->createQueryBuilder();
        $qb->delete()
            ->from('Application\Entity\Product','o')
            ->where($qb->expr()->eq('o.id',$id));
        return $qb->getQuery()->execute();
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteIn(array $ids)
    {
        $qb = $this->objectManager->createQueryBuilder();
        $qb->delete()
            ->from('Application\Entity\Product','o')
            ->where($qb->expr()->in('o.id',$ids));
        return $qb->getQuery()->execute();
    }

    function getRepository()
    {
        return $this->objectManager->getRepository('Application\Entity\Product');
    }

    public function getProductById($id)
    {
        return $this->getRepository()->find($id);
    }

    public function edit(Product $product)
    {
        $productEntity = $this->getProductById($product->getId());
        if($product->getSku()!=$productEntity->getSku()){
            if(!$this->isProductExists($product->getSku())){
                $productEntity->setSku($product->getSku());
            }else{
                throw new ValidationException('此款号的产品已存在','sku');
            }
        }
        $productEntity->setCost($product->getCost());
        $productEntity->setDescription($product->getDescription());
        $productEntity->setName($product->getName());
        $productEntity->setPrice($product->getPrice());
        $productEntity->setStock($product->getStock());
        $this->objectManager->flush();

    }

    /**
     * @param $sku
     * @return null|Product
     */
    public function getProductBySku($sku)
    {
        return $this->getRepository()->findOneBy(array('sku'=>$sku));
    }

    public function getStockLessProduct($minLimiter)
    {
        $products = $this->getRepository()->createQueryBuilder('o')
            ->where('o.stock<=:query')
            ->setParameter('query',$minLimiter)
            ->getQuery()
            ->getResult();
        return $products;
    }
}