<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-5-22
 * Time: 下午1:57
 */

namespace Application\Service;

use Doctrine\ORM\Query;

class StatisticsService extends AbstractService{

    public function getTotalProfitWeekly()
    {
        return $this->objectManager->getConnection()->fetchAll(
            'SELECT MAX(p.date) as date,p.profit,p.price_amount FROM xsv_total_profit_weekly p GROUP BY p.week'
        );
    }

    public function getTotalProfitDaily(\DateTime $startDate=null,\DateTime $endDate=null)
    {
        $where = '';
        if($startDate!==null&&$endDate!==null){
            $where = 'WHERE p.date BETWEEN :startDate AND :endDate';
            $startDate = $startDate->format('Y-m-d H:i:s');
            $endDate = $endDate->format('Y-m-d H:i:s');
        }
        $sth = $this->objectManager->getConnection()
            ->prepare(
                'SELECT p.date ,p.profit,p.price_amount FROM xsv_total_profit_weekly p '.$where
            );
        $sth->bindParam(':startDate',$startDate);
        $sth->bindParam(':endDate',$endDate);
        $sth->execute();
        return $sth->fetchAll();
    }

    public function getSum(\DateTime $startDate=null,\DateTime $endDate=null)
    {
        $where = '';
        if($startDate!==null&&$endDate!==null){
            $where = 'WHERE p.date BETWEEN :startDate AND :endDate';
            $startDate = $startDate->format('Y-m-d H:i:s');
            $endDate = $endDate->format('Y-m-d H:i:s');
        }
        $sth = $this->objectManager->getConnection()
            ->prepare(
                'SELECT SUM(p.profit) as totalProfit,SUM(p.price_amount) as totalPriceAmount FROM xsv_total_profit_weekly p '.$where
            );
        $sth->bindParam(':startDate',$startDate);
        $sth->bindParam(':endDate',$endDate);
        $sth->execute();
        return $sth->fetch();
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
                DESC
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
                DESC
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