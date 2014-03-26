<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * XsOrderCart
 *
 * @ORM\Table(
 *     name="xs_order_cart", 
 *     uniqueConstraints={@ORM\UniqueConstraint(name="orderanditem", columns={"order_id","product_id"})}
 * )
 * @ORM\Entity
 */
class XsOrderCart extends \Application\Entity\AbstractEntity
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
     * @ORM\Column(type="integer", nullable=false, name="order_id")
     */
    private $orderId;

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
     * Set orderId
     *
     * @param integer $orderId
     * @return XsOrderCart
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return integer 
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * Set productId
     *
     * @param integer $productId
     * @return XsOrderCart
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
     * @return XsOrderCart
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
     * @return XsOrderCart
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
     * @return XsOrderCart
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
