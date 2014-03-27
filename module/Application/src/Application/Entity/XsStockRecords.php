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
     * @ORM\Column(type="datetime", nullable=true, name="stock_date")
     */
    private $stockDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=false, name="create_time")
     */
    private $createTime;

    /**
     * @ORM\ManyToMany(targetEntity="Application\Entity\XsProducts")
     * @ORM\JoinTable(name="xs_stock_items",
     *      joinColumns={@ORM\JoinColumn(name="stock_record_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}
     *      )
     */
    private $stockProducts;



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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stockProducts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add stockProducts
     *
     * @param \Application\Entity\XsProducts $stockProducts
     * @return XsStockRecords
     */
    public function addStockProduct(\Application\Entity\XsProducts $stockProducts)
    {
        $this->stockProducts[] = $stockProducts;

        return $this;
    }

    /**
     * Remove stockProducts
     *
     * @param \Application\Entity\XsProducts $stockProducts
     */
    public function removeStockProduct(\Application\Entity\XsProducts $stockProducts)
    {
        $this->stockProducts->removeElement($stockProducts);
    }

    /**
     * Get stockProducts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStockProducts()
    {
        return $this->stockProducts;
    }
}
