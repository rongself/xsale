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
use Application\Lib\Entity\Serializor;

class StockRecordService extends AbstractService {

    public function create($data,Account $user){
        $now = new \DateTime();
        $totalPrice = 0;
        $stockRecord = new StockRecord();
        $stockItemTempl = new StockItem();
        $productTempl = new Product();
        foreach($data->stockProducts as $product){
            $totalPrice +=round(floatval($product->cost)*intval($product->stock),2);
            $productEntity = $this->saveProduct($product);
            $stockItem= $this->creatStockItem($productEntity,$product->cost,$product->stock);

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
        $stockRecord->setAdmin($user);
        $stockRecord->setTotalPrice($totalPrice);
        $stockRecord->setCreateTime($now);
        $stockRecord->setStockTime(new \DateTime($data->stockTime));
        $this->objectManager->persist($stockRecord);
        $this->objectManager->flush();
    }

    public function edit($data)
    {
        $stockRecord = $this->getStockRecordbyId($data->id);
        if($stockRecord==null) throw new \Exception("Can not found this stock record by id:'{$data->id}'");

        $now = new \DateTime();
        $totalPrice = 0;
        $oldItems = $stockRecord->getStockItems();
        $newItemIds = array();
        $newProducts = array();
        foreach($data->stockProducts as $product){
            $totalPrice +=round(floatval($product->cost)*intval($product->stock),2);
            if(isset($product->itemId)){
                $newItemIds[] = $product->itemId;
                $newProducts[$product->itemId] = $product;
            }else{
                //没有itemId传过来,是新的item,指向已存在的产品或新的产品
                $productEntity = $this->saveProduct($product);
                $newItem = $this->creatStockItem($productEntity,$product->cost,$product->stock);
                $newItem->setStockRecord($stockRecord);
                $stockRecord->addStockItem($newItem);
            }
        }
        $stockRecord->setTotalPrice($totalPrice);
        $stockRecord->setStockTime(new \DateTime($data->stockTime));

        /**
         * @var $item StockItem
         */
        $productTempl = new Product();
        foreach($oldItems as $item){
            if(!in_array($item->getId(),$newItemIds)){
                //删除的item,从库存减去此次进货的数量
                $item->getProduct()->setStock($item->getProduct()->getStock()-$item->getQuantity());
                $this->objectManager->remove($item);
            }else{
                //已存在的item,修改指向已存在的产品或新的产品,因为item已存在,所以已经加过库存,要先减去以前加上的部分,然后再加上现在的进货数量
                $newProduct = $newProducts[$item->getId()];
                $productEntity = $this->saveProduct($newProduct,$item->getQuantity());

                $item->setProduct($productEntity);
                $item->setPrice($newProduct->cost);
                $item->setQuantity($newProduct->stock);
                $item->setCreateTime($now);
            }
        }
        $this->objectManager->flush();

    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    function getRepository()
    {
        return $this->objectManager->getRepository('Application\Entity\StockRecord');
    }

    /**
     * @param $id
     * @return null|\Application\Entity\StockRecord
     */
    public function getStockRecordById($id)
    {
        return $this->getRepository()->find($id);
    }

    public function getStockRecordArrayById($id)
    {
        $record = $this->getStockRecordById($id);
        return Serializor::toArray($record,4,array(),array('Application\Entity\Account'=>array('password','stockRecords')));
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
        $record = $this->getStockRecordById($id);
        $items = $record->getStockItems();
        /**
         * @var $item \Application\Entity\StockItem
         */
        foreach($items as $item){
            $item->getProduct()->setStock($item->getProduct()->getStock()-$item->getQuantity());
        }
        $this->objectManager->remove($record);
        $this->objectManager->flush();
        return $id;
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteIn(array $ids)
    {
        foreach($ids as $id)
        {
            $record = $this->getStockRecordById($id);
            $items = $record->getStockItems();
            /**
             * @var $item \Application\Entity\StockItem
             */
            foreach($items as $item){
                $item->getProduct()->setStock($item->getProduct()->getStock()-$item->getQuantity());
            }
            $this->objectManager->remove($record);
        }
        $this->objectManager->flush();
        return $ids;
    }

    /**
     * update or insert product
     * @param $product
     * @return Product|null|object
     */
    private function saveProduct($product,$rollback=0)
    {
        $productEntity = $this->objectManager->getRepository('Application\Entity\Product')->findOneBy(array('sku'=>$product->sku));
        if($productEntity==null){
            // if sku is not exists,add it
            $productEntity = new Product();
            $productEntity->setName($product->name);
            $productEntity->setCost(round(floatval($product->cost),2));
            $productEntity->setStock(intval($product->stock));
            $productEntity->setPrice(round(floatval($product->price),2));
            $productEntity->setDescription($product->description);
            $productEntity->setSku($product->sku);
            $productEntity->setCreateTime(new \DateTime());
        }else{
            // if sku exists, update the information
            $productEntity->setName($product->name);
            $productEntity->setCost(round(floatval($product->cost),2));
            $productEntity->setStock((int)$productEntity->getStock()+(int)$product->stock-$rollback);
            $productEntity->setPrice(round(floatval($product->price),2));
            $productEntity->setDescription($product->description);
        }
        return $productEntity;
    }

    private function creatStockItem(Product $productEntity, $price, $quantity)
    {
        $stockItem = new StockItem();
        $stockItem->setProduct($productEntity);
        $stockItem->setPrice($price);
        $stockItem->setQuantity($quantity);
        $stockItem->setCreateTime(new \DateTime());
        return $stockItem;
    }
}