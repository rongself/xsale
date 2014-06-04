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

    public function getPaginator()
    {
        return parent::getPaginator('SELECT o,c FROM Application\Entity\Order o LEFT JOIN o.customer c');
    }

    public function getSaleroom()
    {
        $qb = $this->objectManager->createQueryBuilder('o');
        $result =  $qb->select('SUM(o.totalPrice)')
            ->from('Application\Entity\Order','o')
            ->getQuery()
            ->getSingleScalarResult();
        return $result;
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