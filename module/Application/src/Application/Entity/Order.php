<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="xs_orders")
 */
class Order
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /** 
     * @ORM\Column(type="float", nullable=true, name="total_price", precision=10, scale=0)
     */
    private $totalPrice;

    /** 
     * @ORM\Column(type="datetime", nullable=true, name="create_time")
     */
    private $createTime;

    /** 
     * @ORM\OneToMany(targetEntity="Application\Entity\OrderCart", mappedBy="order",cascade={"persist"})
     */
    private $orderCarts;

    /** 
     * @ORM\ManyToOne(targetEntity="Application\Entity\Customer", inversedBy="orders", cascade={"persist"})
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", nullable=true)
     */
    private $customer;

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
     * @return Order
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
     * @return Order
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
     * Constructor
     */
    public function __construct()
    {
        $this->orderCarts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add orderCarts
     *
     * @param \Application\Entity\OrderCart $orderCarts
     * @return Order
     */
    public function addOrderCart(\Application\Entity\OrderCart $orderCarts)
    {
        $this->orderCarts[] = $orderCarts;

        return $this;
    }

    /**
     * Remove orderCarts
     *
     * @param \Application\Entity\OrderCart $orderCarts
     */
    public function removeOrderCart(\Application\Entity\OrderCart $orderCarts)
    {
        $this->orderCarts->removeElement($orderCarts);
    }

    /**
     * Get orderCarts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrderCarts()
    {
        return $this->orderCarts;
    }

    /**
     * Set customer
     *
     * @param \Application\Entity\Customer $customer
     * @return Order
     */
    public function setCustomer(\Application\Entity\Customer $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Application\Entity\Customer 
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
