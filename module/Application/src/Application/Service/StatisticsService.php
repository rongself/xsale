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

    public function getTopSale($count=5,$lastDayCount=7)
    {
        $sth = $this->objectManager->getConnection()
            ->prepare(
                'SELECT
                    SUM(oc.quantity) as sold,
                    oc.product_id,
                    p.picture,
                    p.`name`,
                    p.`sku`
                FROM
                    xs_order_cart oc
                LEFT JOIN xs_products p ON oc.product_id = p.id
                LEFT JOIN xs_orders o ON oc.order_id = o.id
                WHERE o.order_time > ADDDATE(NOW(),:lastDayCount)
                GROUP BY p.id
                ORDER BY sold DESC
                LIMIT :count'
            );
        $sth->bindParam(':lastDayCount',intval(-$lastDayCount));
        $sth->bindParam(':count',$count,\PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function getRecentOrder($count=3)
    {
        $sth = $this->objectManager->getConnection()
            ->prepare(
                'SELECT
                    oc.quantity,
                    oc.price,
                    o.order_time,
                    oc.order_id,
                    oc.product_id,
                    p.picture,
                    p.`name`,
                    p.`sku`
                FROM
                    xs_order_cart oc
                LEFT JOIN xs_products p ON oc.product_id = p.id
                LEFT JOIN xs_orders o ON oc.order_id = o.id
                ORDER BY
                    o.order_time
                LIMIT :count'
            );
        $sth->bindParam(':count',$count,\PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function getRecentStock($count=3)
    {
        $sth = $this->objectManager->getConnection()
            ->prepare(
                'SELECT
                    si.quantity,
                    si.price,
                    sr.stock_time,
                    si.stock_record_id,
                    si.product_id,
                    p.picture,
                    p.`name`,
                    p.`sku`
                FROM
                    xs_stock_items si
                LEFT JOIN xs_products p ON  si.product_id = p.id
                LEFT JOIN xs_stock_records sr ON  si.stock_record_id = sr.id
                ORDER BY
                    sr.stock_time
                LIMIT :count'
            );
        $sth->bindParam(':count',$count,\PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetchAll();
    }
    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    function getRepository()
    {
        return null;
    }
}