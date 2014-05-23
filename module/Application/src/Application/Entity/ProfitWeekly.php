<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-5-22
 * Time: 下午2:51
 */

namespace Application\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="xsv_total_profit_weekly")
 */
class ProfitWeekly extends AbstractEntity{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
 * @ORM\Column(type="float", nullable=true, name="profit", precision=10, scale=0)
 */
    private $profit;

    /**
     * @ORM\Column(type="float", nullable=true, name="price_amount", precision=10, scale=0)
     */
    private $priceAmount;

    /**
     * @ORM\Column(type="float",  nullable=false, name="month", precision=10, scale=0)
     */
    private $month;

    /**
     * @ORM\Column(type="float", nullable=false, name="week", precision=10, scale=0)
     */
    private $week;

    /**
     * @ORM\Column(type="float", nullable=false, name="year", precision=10, scale=0)
     */
    private $year;

    /**
     * @ORM\Column(type="string",length=50, nullable=false, name="date")
     */
    private $date;


    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return mixed
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getProfit()
    {
        return $this->profit;
    }

    /**
     * @return mixed
     */
    public function getPriceAmount()
    {
        return $this->priceAmount;
    }

} 