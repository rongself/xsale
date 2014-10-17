<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-4-19
 * Time: 上午10:25
 */

namespace Application\Service;


use Application\Entity\Customer;
use Application\Entity\VipArchive;

class CustomerService extends AbstractService {

    public function getAutoCompleteSource()
    {
        //@todo auto-complete speed optimize
        $customers = $this->getRepository()->createQueryBuilder('o')
            ->select('o.phoneNumber,o.isVip,o.name')
            //->where('o.phoneNumber LIKE :query')
            //->setParameter('query', $query.'%')
            //->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        return $customers;
    }
    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    function getRepository()
    {
        return $this->objectManager->getRepository('Application\Entity\Customer');
    }

    /**
     * @return \Zend\Paginator\Paginator
     */
    public function getPaginator($keyword=null)
    {
        $qb = $this->getRepository()->createQueryBuilder('o');
        if(isset($keyword)){
            $qb->where($qb->expr()->like('o.name',':keyword'))
                ->orWhere($qb->expr()->like('o.phoneNumber',':keyword'))
                ->orWhere($qb->expr()->like('o.wechat',':keyword'))
                ->setParameter('keyword',"%{$keyword}%");
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
            ->from('Application\Entity\Customer','o')
            ->where($qb->expr()->eq('o.id',':id'))->setParameter('id',$id);
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
            ->from('Application\Entity\Customer','o')
            ->where($qb->expr()->in('o.id',':ids'))->setParameter(':ids',$ids,Type::SIMPLE_ARRAY);
        return $qb->getQuery()->execute();
    }

    public function create(Customer $customer)
    {
        if($customer->getIsVip()){
            $vipArchive = new VipArchive();
            $vipArchive->setCustomer($customer);
            $vipArchive->setBalance(0);
            $customer->setVipArchive($vipArchive);
        }
        $this->objectManager->persist($customer);
        $this->objectManager->flush();
    }

    public function isPhoneNumberExists($phoneNumber)
    {
        $result = $this->getRepository()->findOneBy(array('phoneNumber'=>$phoneNumber));
        return $result!==null;
    }

    public function edit(array $customerArr)
    {
        if(!isset($customerArr['id'])) throw new \Exception('系统错误:修改id为空');
        $customer = $this->getCustomerById($customerArr['id']);
        $customer->setPhoneNumber($customerArr['phoneNumber']);
        $customer->setRemark($customerArr['remark']);
        $customer->setIsVip($customerArr['isVip']);
        $customer->setName($customerArr['name']);
        $customer->setQq($customerArr['qq']);
        $customer->setWechat($customerArr['wechat']);
        $this->objectManager->flush();
    }

    /**
     * @param $id
     * @return null|Customer
     */
    public function getCustomerById($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @return int
     */
    public function getVipCount()
    {
        $qb = $this->objectManager->createQueryBuilder('c');
        $resultArray =  $qb->select($qb->expr()->count('c.id'))
                ->from('Application\Entity\Customer','c')
                ->where($qb->expr()->eq('c.isVip',true))
                ->getQuery()
                ->getSingleResult();
        return intval($resultArray[1]);
    }
}