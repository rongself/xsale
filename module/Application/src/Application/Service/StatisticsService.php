<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-5-22
 * Time: 下午1:57
 */

namespace Application\Service;

use Application\Entity\ProfitWeekly;
use Doctrine\ORM\Query;

class StatisticsService extends AbstractService{

    public function getTotalProfitWeekly()
    {
        return $this->objectManager->createQuery(
            'SELECT p.date,p.profit FROM \Application\Entity\ProfitWeekly p'
        )->getResult();
    }
    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    function getRepository()
    {
        return null;
    }
}