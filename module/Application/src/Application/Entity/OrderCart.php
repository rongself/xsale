<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(
 *     name="xs_order_cart", 
 *     uniqueConstraints={@ORM\UniqueConstraint(name="orderanditem", columns={"order_id","product_id"})}
 * )
 */
class OrderCart
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /** 
     * @ORM\Column(type="float", nullable=false, name="price", precision=10, scale=0)
     */
    private $price;

    /** 
     * @ORM\Column(type="integer", nullable=false, name="quantity")
     */
    private $quantity;

    /** 
     * @ORM\Column(type="datetime", nullable=false, name="create_time")
     */
    private $createTime;

    /** 
     * @ORM\Column(type="integer",nullable=true)
     */
    private $order_id;

    /** 
     * @ORM\Column(type="integer",nullable=true)
     */
    private $product_id;

    /** 
     * @ORM\ManyToOne(targetEntity="Application\Entity\Product", inversedBy="orderCart", cascade={"persist"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    private $product;

    /** 
     * @ORM\ManyToOne(targetEntity="Application\Entity\Order", inversedBy="orderCarts", cascade={"persist"})
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", nullable=false,onDelete="CASCADE")
     */
    private $order;

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
     * Set price
     *
     * @param float $price
     * @return OrderCart
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
     * @return OrderCart
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
     * @return OrderCart
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

    /**
     * Set order_id
     *
     * @param string $orderId
     * @return OrderCart
     */
    public function setOrderId($orderId)
    {
        $this->order_id = $orderId;

        return $this;
    }

    /**
     * Get order_id
     *
     * @return string 
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Set product_id
     *
     * @param string $productId
     * @return OrderCart
     */
    public function setProductId($productId)
    {
        $this->product_id = $productId;

        return $this;
    }

    /**
     * Get product_id
     *
     * @return string 
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * Set product
     *
     * @param \Application\Entity\Product $product
     * @return OrderCart
     */
    public function setProduct(\Application\Entity\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \Application\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set order
     *
     * @param \Application\Entity\Order $order
     * @return OrderCart
     */
    public function setOrder(\Application\Entity\Order $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Application\Entity\Order 
     */
    public function getOrder()
    {
        return $this->order;
    }
}
