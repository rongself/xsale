<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-3-26
 * Time: 下午4:33
 */

namespace Application\Service;

use Application\Entity\Order;
use Application\Entity\OrderCart;
use Application\Entity\Product;
use Zend\Di\ServiceLocator;

class SaleRecordService extends AbstractService{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $objectManager;

    public function __construct(ServiceLocatorInterface $sm,CustomerService $customerService)
    {
        $this->objectManager = $sm->get('Doctrine\ORM\EntityManager');
    }
    public function create($data){
        $now = new \DateTime();
        $saleRecord = new Order();
        $orderItem = new OrderCart();
        $productTempl = new Product();
        $customer = $this->objectManager->getRepository('Application\Entity\Customer')->findOneBy(array('phoneNumber'=>$data->phoneNumber));
        if(isset($customer)){
            $saleRecord->setCustomer($customer);
        }
        $saleRecord->setTotalPrice($data->totalPrice);
        $saleRecord->setCreateTime($now);
        foreach($data->saleProducts as $product){
            /**@var $productEntity \Application\Entity\Product*/
            $productEntity = $this->objectManager->getRepository('Application\Entity\Product')->findOneBy(array('sku'=>$product->sku));
            if($productEntity==null){
                // if sku is not exists,add it
                throw new Exception();
            }
            $stockItem = clone $orderItem;
            $stockItem->setProduct($productEntity);
            $stockItem->setPrice($product->cost);
            $stockItem->setQuantity($product->stock);
            $stockItem->setCreateTime($now);
            $stockItem->setStockRecord($saleRecord);
            $saleRecord->addStockItem($stockItem);
            //whether sku exist,always add pictures

        }
        $this->objectManager->persist($saleRecord);
        $this->objectManager->flush();
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    function getRepository()
    {
        return  $customer = $this->objectManager->getRepository('Application\Entity\Order');
    }
}