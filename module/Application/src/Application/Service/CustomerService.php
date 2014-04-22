<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-4-19
 * Time: 上午10:25
 */

namespace Application\Service;


class CustomerService extends AbstractService {

    public function getAutoCompleteSource()
    {
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
}