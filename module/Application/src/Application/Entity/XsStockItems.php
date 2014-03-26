<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * XsStockItems
 *
 * @ORM\Table(name="xs_stock_items")
 * @ORM\Entity
 */
class XsStockItems extends \Application\Entity\AbstractEntity
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
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false, name="stock_record_id")
     */
    private $stockRecordId;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false, name="product_id")
     */
    private $productId;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false, name="price", precision=10, scale=0)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false, name="quantity")
     */
    private $quantity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false, name="create_time")
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
     * Set stockRecordId
     *
     * @param integer $stockRecordId
     * @return XsStockItems
     */
    public function setStockRecordId($stockRecordId)
    {
        $this->stockRecordId = $stockRecordId;

        return $this;
    }

    /**
     * Get stockRecordId
     *
     * @return integer 
     */
    public function getStockRecordId()
    {
        return $this->stockRecordId;
    }

    /**
     * Set productId
     *
     * @param integer $productId
     * @return XsStockItems
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;

        return $this;
    }

    /**
     * Get productId
     *
     * @return integer 
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return XsStockItems
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return XsStockItems
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     * @return XsStockItems
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
