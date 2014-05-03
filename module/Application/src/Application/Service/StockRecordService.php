<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-3-26
 * Time: 下午4:33
 */

namespace Application\Service;

use Application\Entity\Product;
use Application\Entity\ProductImage;
use Application\Entity\StockItem;
use Application\Entity\StockRecord;

class StockRecordService extends AbstractService {

    public function create($data){
        $now = new \DateTime();
        $stockRecord = new StockRecord();
        $stockItemTempl = new StockItem();
        $productTempl = new Product();
        $stockRecord->setTotalPrice($data->totalPrice);
        $stockRecord->setCreateTime($now);
        foreach($data->stockProducts as $product){
            /**@var $productEntity \Application\Entity\Product*/
            $productEntity = $this->objectManager->getRepository('Application\Entity\Product')->findOneBy(array('sku'=>$product->sku));
            if($productEntity==null){
                // if sku is not exists,add it
                $productEntity = clone $productTempl;
                $productEntity->setName($product->name);
                $productEntity->setCost($product->cost);
                $productEntity->setStock($product->stock);
                $productEntity->setPrice($product->price);
                $productEntity->setDescription($product->description);
                $productEntity->setSku($product->sku);
                $productEntity->setCreateTime($now);
            }else{
                // if sku exists, update the information
                $productEntity->setName($product->name);
                $productEntity->setCost($product->cost);
                $productEntity->setStock((int)$productEntity->getStock()+(int)$product->stock);
                $productEntity->setPrice($product->price);
                $productEntity->setDescription($product->description);
            }
            $stockItem = clone $stockItemTempl;
            $stockItem->setProduct($productEntity);
            $stockItem->setPrice($product->cost);
            $stockItem->setQuantity($product->stock);
            $stockItem->setCreateTime($now);
            $stockItem->setStockRecord($stockRecord);
            $stockRecord->addStockItem($stockItem);
            //whether sku exist,always add pictures
            $imageTemp = new ProductImage();
            $i = 0;
            foreach ($product->pictures as $picture) {
                $image = clone $imageTemp;
                if($i==0){
                    //set as default image(0)
                    $image->setType(0);
                    $productEntity->setPicture($picture);
                }else{
                    //set as description image(1)
                    $image->setType(1);
                }
                $image->setUrl($picture);
                $image->setCreateTime($now);
                $productEntity->addProductImage($image);
                $i++;
            }
        }
        $this->objectManager->persist($stockRecord);
        $this->objectManager->flush();
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    function getRepository()
    {
        // TODO: Implement getRepository() method.
    }

    public function getPaginator()
    {
        return parent::getPaginator('SELECT o FROM Application\Entity\StockRecord o');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $qb = $this->objectManager->createQueryBuilder();
        $qb->delete()
            ->from('Application\Entity\StockRecord','o')
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
            ->from('Application\Entity\StockRecord','o')
            ->where($qb->expr()->in('o.id',$ids));
        return $qb->getQuery()->execute();
    }
}