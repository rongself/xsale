<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-4-19
 * Time: 上午10:25
 */

namespace Application\Service;


use Application\Entity\Customer;

class CustomerService extends AbstractService {

    public function getAutoCompleteSource()
    {
        //@todo auto-complete speed optimize
        $products = $this->getRepository()->createQueryBuilder('o')
            ->select('o.phoneNumber,o.isVip')
            //->where('o.phoneNumber LIKE :query')
            //->setParameter('query', $query.'%')
            //->setMaxResults($limit)
            ->getQuery()
            ->getResult();
        return $products;
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
    public function getPaginator()
    {
        return parent::getPaginator('SELECT o FROM Application\Entity\Customer o');
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
            ->from('Application\Entity\Customer','o')
            ->where($qb->expr()->in('o.id',$ids));
        return $qb->getQuery()->execute();
    }

    public function create(Customer $customer)
    {
        $this->objectManager->persist($customer);
        $this->objectManager->flush();
    }

    public function isPhoneNumberExists($phoneNumber)
    {
        $result = $this->getRepository()->findOneBy(array('phoneNumber'=>$phoneNumber));
        return $result!==null;
    }

}