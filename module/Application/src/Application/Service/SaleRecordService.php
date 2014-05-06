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
            throw new ValidationException('There are no product in the order','saleProducts');
        }
        $now = new \DateTime();
        $saleRecord = new Order();
        $orderItem = new OrderCart();
        if($data->phoneNumber){
            $customer = $this->objectManager->getRepository('Application\Entity\Customer')->findOneBy(array('phoneNumber'=>$data->phoneNumber));
            if(!isset($customer)){
                $customer = new Customer();
                $customer->setPhoneNumber($data->phoneNumber);
            }
            $saleRecord->setCustomer($customer);
        }
        $saleRecord->setTotalPrice($data->totalPrice);
        $saleRecord->setCreateTime($now);
        foreach($data->saleProducts as $product){
            /**@var $productEntity \Application\Entity\Product*/
            $productEntity = $this->objectManager->getRepository('Application\Entity\Product')->findOneBy(array('sku'=>$product->sku));
            if($productEntity==null){
                // if sku is not exists,add it
                throw new ValidationException("该产品不存在于库存中,也许你需要先进货:)",'sku');
            }
            $item = clone $orderItem;
            $stock = intval($productEntity->getStock());
            $productEntity->setStock($stock-intval($product->quantity));
            $item->setProduct($productEntity);
            $item->setPrice($product->price);
            $item->setQuantity($product->quantity);
            $item->setCreateTime($now);
            $item->setOrder($saleRecord);
            $saleRecord->addOrderCart($item);
            //@todo not work
        }
        $this->objectManager->persist($saleRecord);
        $this->objectManager->flush();
        return true;
    }

    public function getPaginator()
    {
        return parent::getPaginator('SELECT o,c FROM Application\Entity\Order o LEFT JOIN o.customer c');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $qb = $this->objectManager->createQueryBuilder();
        $qb->delete()
            ->from('Application\Entity\Order','o')
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
            ->from('Application\Entity\Order','o')
            ->where($qb->expr()->in('o.id',$ids));
        return $qb->getQuery()->execute();
    }
    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    function getRepository()
    {
        return  $customer = $this->objectManager->getRepository('Application\Entity\Order');
    }
}