<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-3-26
 * Time: 下午4:33
 */

namespace Application\Service;

use Application\Entity\Account;
use Application\Entity\Exception\ValidationException;
use Application\Entity\Product;
use Application\Entity\ProductImage;
use Application\Entity\StockItem;
use Application\Entity\StockRecord;
use Application\Lib\Entity\Serializor;
use Doctrine\ORM\Query\Expr\OrderBy;

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
            $stockItem= $this->createStockItem($productEntity,$product->cost,$product->stock);
            $stockItem->setStockRecord($stockRecord);
            $stockRecord->addStockItem($stockItem);
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

        $totalPrice = 0;
        $oldItems = clone $stockRecord->getStockItems();
        $newItemIds = array();
        foreach($data->stockProducts as $product){
            $totalPrice +=round(floatval($product->cost)*intval($product->stock),2);
            if(isset($product->itemId)){
                $newItemIds[] = $product->itemId;
            }else{
                //没有itemId传过来,是新的item,指向已存在的产品或新的产品
                $productEntity = $this->saveProduct($product);
                $newItem = $this->createStockItem($productEntity,$product->cost,$product->stock);
                $newItem->setStockRecord($stockRecord);
                $stockRecord->addStockItem($newItem);
            }
        }
        $stockRecord->setTotalPrice($totalPrice);
        $stockRecord->setStockTime(new \DateTime($data->stockTime));

        /**
         * @var $item StockItem
         */
        foreach($oldItems as $item){
            if(!in_array($item->getId(),$newItemIds)){
                //删除的item,从库存减去此次进货的数量
                $item->getProduct()->setStock($item->getProduct()->getStock()-$item->getQuantity());
                $this->objectManager->remove($item);
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

    public function getPaginator($keyword=null,$orderBy=null)
    {
        $qb = $this->getRepository()->createQueryBuilder('o');
        if(isset($keyword)){
            $qb->where($qb->expr()->eq('o.id',':keyword'))->setParameter('keyword',$keyword);
        }
        switch($orderBy['sort']){
            case 'id':
                break;
            default:
                $orderBy['sort']='o.stockTime';
                break;
        }
        $orderBy['order'] = $orderBy['order']=='asc'?'ASC':'DESC';

        if(isset($orderBy)&&is_array($orderBy)){
            $qb->orderBy(new OrderBy($orderBy['sort'],$orderBy['order']));
        }
        return parent::getPaginator($qb->getQuery());
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
     * @param $stockItem
     * @return Product|null|object
     */
    private function saveProduct($stockItem,$rollback=0)
    {
        $productEntity = $this->objectManager->getRepository('Application\Entity\Product')->findOneBy(array('sku'=>$stockItem->sku));
        if(intval($stockItem->stock)<=0) throw new ValidationException('进货数量必须大于0','stock');
        if($productEntity==null){
            // if sku is not exists,add it
            $productEntity = new Product();
            $productEntity->setName($stockItem->name);
            $productEntity->setCost(round(floatval($stockItem->cost),2));
            $productEntity->setStock(intval($stockItem->stock));
            $productEntity->setPrice(round(floatval($stockItem->price),2));
            $productEntity->setDescription($stockItem->description);
            $productEntity->setSku($stockItem->sku);
            $productEntity->setCreateTime(new \DateTime());
        }else{
            // if sku exists, update the information
            $productEntity->setName($stockItem->name);
            $productEntity->setCost(round(floatval($stockItem->cost),2));
            $productEntity->setStock((int)$productEntity->getStock()+(int)$stockItem->stock-$rollback);
            $productEntity->setPrice(round(floatval($stockItem->price),2));
            $productEntity->setDescription($stockItem->description);
        }
        return $productEntity;
    }

    private function createStockItem(Product $productEntity, $price, $quantity)
    {
        $stockItem = new StockItem();
        $stockItem->setProduct($productEntity);
        $stockItem->setPrice($price);
        $stockItem->setQuantity($quantity);
        $stockItem->setCreateTime(new \DateTime());
        return $stockItem;
    }
}