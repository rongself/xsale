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
            'SELECT MAX(p.date) as date,p.profit,p.priceAmount FROM \Application\Entity\ProfitWeekly p GROUP BY p.week'
        )->getResult();
    }

    public function getTotalProfitDaily()
    {
        return $this->objectManager->createQuery(
            'SELECT p.date ,p.profit,p.priceAmount FROM \Application\Entity\ProfitWeekly p'
        )->getResult();
    }

    public function getSum()
    {
        return $this->objectManager->createQuery(
            'SELECT SUM(p.profit) as totalProfit,SUM(p.priceAmount) as totalPriceAmount FROM \Application\Entity\ProfitWeekly p'
        )->getSingleResult();
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    function getRepository()
    {
        return null;
    }
}