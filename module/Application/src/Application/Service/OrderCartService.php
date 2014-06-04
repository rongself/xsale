<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-6-4
 * Time: 下午1:15
 */

namespace Application\Service;


class OrderCartService extends AbstractService{

    public function getQuantityOfSale()
    {
        $qb = $this->objectManager->createQueryBuilder('o');
        $result =  $qb->select('SUM(o.quantity)')
            ->from('Application\Entity\OrderCart','o')
            ->getQuery()
            ->getSingleScalarResult();
        return intval($result);
    }
    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    function getRepository()
    {
        // TODO: Implement getRepository() method.
    }
}