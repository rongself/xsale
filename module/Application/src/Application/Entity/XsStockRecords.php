<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * XsStockRecords
 *
 * @ORM\Table(name="xs_stock_records")
 * @ORM\Entity
 */
class XsStockRecords extends \Application\Entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="total_price", type="float", precision=10, scale=0, nullable=true)
     */
    private $totalPrice;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="stock_date", type="datetime", nullable=true)
     */
    private $stockDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_time", type="datetime", nullable=false)
     */
    private $createTime;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set totalPrice
     *
     * @param float $totalPrice
     * @return XsStockRecords
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return float 
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set stockDate
     *
     * @param \DateTime $stockDate
     * @return XsStockRecords
     */
    public function setStockDate($stockDate)
    {
        $this->stockDate = $stockDate;

        return $this;
    }

    /**
     * Get stockDate
     *
     * @return \DateTime 
     */
    public function getStockDate()
    {
        return $this->stockDate;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     * @return XsStockRecords
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Get createTime
     *
     * @return \DateTime 
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }
}
