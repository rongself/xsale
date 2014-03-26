<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * XsOrders
 *
 * @ORM\Table(name="xs_orders")
 * @ORM\Entity
 */
class XsOrders extends \Application\Entity\AbstractEntity
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", name="id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, name="total_price", precision=10, scale=0)
     */
    private $totalPrice;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true, name="create_time")
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
     * @return XsOrders
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
     * Set createTime
     *
     * @param \DateTime $createTime
     * @return XsOrders
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
