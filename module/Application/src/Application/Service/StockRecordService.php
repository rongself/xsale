<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-3-26
 * Time: 下午4:33
 */

namespace Application\Service;

use Application\Entity\Account;
use Application\Entity\Product;
use Application\Entity\ProductImage;
use Application\Entity\StockItem;
use Application\Entity\StockRecord;

class StockRecordService extends AbstractService {

    public function create($data,Account $user){
        $now = new \DateTime();
        $totalPrice = 0;
        $stockRecord = new StockRecord();
        $stockItemTempl = new StockItem();
        $productTempl = new Product();
        foreach($data->stockProducts as $product){
            $totalPrice +=round(floatval($product->cost)*intval($product->stock),2);
            /**@var $productEntity \Application\Entity\Product*/
            $productEntity = $this->objectManager->getRepository('Application\Entity\Product')->findOneBy(array('sku'=>$product->sku));
            if($productEntity==null){
                // if sku is not exists,add it
                $productEntity = clone $productTempl;
                $productEntity->setName($product->name);
                $productEntity->setCost(round(floatval($product->cost),2));
                $productEntity->setStock(intval($product->stock));
                $productEntity->setPrice(round(floatval($product->price),2));
                $productEntity->setDescription($product->description);
                $productEntity->setSku($product->sku);
                $productEntity->setCreateTime($now);
            }else{
                // if sku exists, update the information
                $productEntity->setName($product->name);
                $productEntity->setCost(round(floatval($product->cost),2));
                $productEntity->setStock((int)$productEntity->getStock()+(int)$product->stock);
                $productEntity->setPrice(round(floatval($product->price),2));
                $productEntity->setDescription($product->description);
            }
            $stockItem = clone $stockItemTempl;
            $stockItem->setProduct($productEntity);
            $stockItem->setPrice($product->cost);
            $stockItem->setQuantity($product->stock);
            $stockItem->setCreateTime($now);
            $stockItem->setStockRecord($stockRecord);
            $stockRecord->addStockItem($stockItem);
            $stockRecord->setAdmin($user);
            //whether sku exist,always add pictures
            $imageTemp = new ProductImage();
            $i = 0;
            foreach ($product->pictures as $picture) {
                $image = clone $imageTemp;
                $image->setProduct($productEntity);
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
        $stockRecord->setTotalPrice($totalPrice);
        $stockRecord->setCreateTime($now);
        $stockRecord->setStockTime(new \DateTime($data->stockTime));
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