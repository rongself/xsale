<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-3-26
 * Time: 下午4:33
 */

namespace Application\Service;

use Application\Entity\Customer;
use Application\Entity\Order;
use Application\Entity\OrderCart;
use Application\Lib\Entity\Serializor;
use Zend\Paginator\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Application\Entity\Exception\ValidationException;
use Zend\Di\ServiceLocator;

class SaleRecordService extends AbstractService{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $objectManager;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager)
    {
        $this->objectManager = $entityManager;
    }
    public function create($data){
        if(!isset($data)||empty($data)){
            throw new ValidationException('Data invalid','saleRecord');
        }
        if(!isset($data->saleProducts)||empty($data->saleProducts)){
            throw new ValidationException('There are no product in this order','saleProducts');
        }
        $now = new \DateTime();
        $saleRecord = new Order();
        $orderItem = new OrderCart();
        $totalPrice = 0;
        $totalCost = 0;
        if($data->phoneNumber){
            $customer = $this->objectManager->getRepository('Application\Entity\Customer')->findOneBy(array('phoneNumber'=>$data->phoneNumber));
            if(!isset($customer)){
                $customer = new Customer();
                $customer->setPhoneNumber($data->phoneNumber);
                $customer->setIsVip(0);
                $customer->setCreateTime($now);
            }
            $saleRecord->setCustomer($customer);
        }
        foreach($data->saleProducts as $product){
            /**@var $productEntity \Application\Entity\Product*/
            $productEntity = $this->objectManager->getRepository('Application\Entity\Product')->findOneBy(array('sku'=>$product->sku));
            if($productEntity==null){
                // if sku is not exists,add it
                throw new ValidationException("产品 {$product->sku} 不存在于库存中,也许你需要先进货:)",'sku');
            }
            $item = clone $orderItem;
            $stock = intval($productEntity->getStock());
            $productEntity->setStock($stock-intval($product->quantity));
            $item->setProduct($productEntity);
            $item->setPrice(round($product->price,2));
            $item->setQuantity($product->quantity);
            $item->setCreateTime($now);
            $item->setOrder($saleRecord);
            $saleRecord->addOrderCart($item);

            $totalPrice +=round(floatval($product->price)*intval($product->quantity),2);
            $totalCost +=round(floatval($productEntity->getCost())*intval($product->quantity),2);
        }
        $saleRecord->setTotalPrice($totalPrice);
        $saleRecord->setTotalCost($totalCost);
        $saleRecord->setCreateTime($now);
        $saleRecord->setOrderTime(new \DateTime($data->orderTime));
        $this->objectManager->persist($saleRecord);
        $this->objectManager->flush();
        return true;
    }

    public function edit($data)
    {
        $saleRecord = $this->getSaleRecordById($data->id);
        if($saleRecord==null) throw new \Exception("Can not found this stock record by id:'{$data->id}'");
        if(!isset($data)||empty($data)){
            throw new ValidationException('Data invalid','saleRecord');
        }
        if(!isset($data->saleProducts)||empty($data->saleProducts)){
            throw new ValidationException('There are no product in this order','saleProducts');
        }
        $now = new \DateTime();
        $orderItem = new OrderCart();
        $totalPrice = 0;
        $totalCost = 0;
        if($data->phoneNumber){
            $customer = $this->objectManager->getRepository('Application\Entity\Customer')->findOneBy(array('phoneNumber'=>$data->phoneNumber));
            if(!isset($customer)){
                $customer = new Customer();
                $customer->setPhoneNumber($data->phoneNumber);
                $customer->setIsVip(0);
                $customer->setCreateTime($now);
            }
            $saleRecord->setCustomer($customer);
        }
        $oldItems = clone $saleRecord->getOrderCarts();
        foreach($data->saleProducts as $product){
            /**@var $productEntity \Application\Entity\Product*/
            $productEntity = $this->objectManager->getRepository('Application\Entity\Product')->findOneBy(array('sku'=>$product->sku));
            if($productEntity==null){
                // if sku is not exists,add it
                throw new ValidationException("产品 {$product->sku} 不存在于库存中,也许你需要先进货:)",'sku');
            }
            if(isset($product->itemId)){
                $newItemIds[] = $product->itemId;
            }else{
                //没有itemId传过来,是新的item,指向已存在的产品或新的产品
                $stock = intval($productEntity->getStock());
                $productEntity->setStock($stock-intval($product->quantity));
                $newItem = $this->creatSaleItem($productEntity,$product->price,$product->quantity);
                $newItem->setOrder($saleRecord);
                $saleRecord->addOrderCart($newItem);
            }

            $totalPrice +=round(floatval($product->price)*intval($product->quantity),2);
            $totalCost +=round(floatval($productEntity->getCost())*intval($product->quantity),2);
        }

        /**
         * @var $item StockItem
         */
        foreach($oldItems as $item){
            if(!in_array($item->getId(),$newItemIds)){
                //删除的item,从库存减去此次进货的数量
                $item->getProduct()->setStock($item->getProduct()->getStock()+$item->getQuantity());
                $this->objectManager->remove($item);
            }
        }
        $saleRecord->setTotalPrice($totalPrice);
        $saleRecord->setTotalCost($totalCost);
        $saleRecord->setCreateTime($now);
        $saleRecord->setOrderTime(new \DateTime($data->orderTime));
        $this->objectManager->flush();
        return true;
    }

    public function getPaginator($keyword=null)
    {
        $qb = $this->getRepository()->createQueryBuilder('o');
        if(isset($keyword)){
            $qb->where($qb->expr()->eq('o.id',$keyword));
        }
        return parent::getPaginator($qb->getQuery());
    }

    public function getSaleroom()
    {
        $qb = $this->objectManager->createQueryBuilder('o');
        $result =  $qb->select('SUM(o.totalPrice)')
            ->from('Application\Entity\Order','o')
            ->getQuery()
            ->getSingleScalarResult();
        return intval($result);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $record = $this->getSaleRecordById($id);
        $items = $record->getOrderCarts();
        /**
         * @var $item \Application\Entity\OrderCart
         */
        foreach($items as $item){
            $item->getProduct()->setStock($item->getProduct()->getStock()+$item->getQuantity());
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
            $record = $this->getSaleRecordById($id);
            $items = $record->getOrderCarts();
            /**
             * @var $item \Application\Entity\OrderCart
             */
            foreach($items as $item){
                $item->getProduct()->setStock($item->getProduct()->getStock()+$item->getQuantity());
            }
            $this->objectManager->remove($record);
        }
        $this->objectManager->flush();
        return $ids;
    }
    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    function getRepository()
    {
        return  $customer = $this->objectManager->getRepository('Application\Entity\Order');
    }

    /**
     * @param $id
     * @return null|\Application\Entity\Order
     */
    private function getSaleRecordById($id)
    {
        return $this->getRepository()->find($id);
    }

    public function getSaleRecordArrayById($id)
    {
        $record = $this->getSaleRecordById($id);
        return Serializor::toArray($record,4,array(),array('Application\Entity\Account'=>array('password'),'Application\Entity\Customer'=>array('orders')));
    }

    private function creatSaleItem($productEntity, $price, $quantity)
    {
        $item = new OrderCart();
        $item->setProduct($productEntity);
        $item->setPrice(round($price,2));
        $item->setQuantity($quantity);
        $item->setCreateTime(new \DateTime());
        return $item;
    }

}