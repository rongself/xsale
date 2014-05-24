<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="xs_stock_records")
 */
class StockRecord extends AbstractEntity
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /** 
     * @ORM\Column(type="float", nullable=false, name="total_price", precision=10, scale=0)
     */
    private $totalPrice;

    /** 
     * @ORM\Column(type="datetime", nullable=false, name="stock_time")
     */
    private $stockTime;

    /** 
     * @ORM\Column(type="datetime", nullable=false, name="create_time")
     */
    private $createTime;

    /** 
     * @ORM\OneToMany(targetEntity="Application\Entity\StockItem", mappedBy="stockRecord", cascade={"persist"})
     */
    private $stockItems;

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
     * @return StockRecord
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
     * @return StockRecord
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
        $this->stockItems = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add stockItems
     *
     * @param \Application\Entity\StockItem $stockItems
     * @return StockRecord
     */
    public function addStockItem(\Application\Entity\StockItem $stockItems)
    {
        $this->stockItems[] = $stockItems;

        return $this;
    }

    /**
     * Remove stockItems
     *
     * @param \Application\Entity\StockItem $stockItems
     */
    public function removeStockItem(\Application\Entity\StockItem $stockItems)
    {
        $this->stockItems->removeElement($stockItems);
    }

    /**
     * Get stockItems
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStockItems()
    {
        return $this->stockItems;
    }

    /**
     * @return mixed
     */
    public function getStockTime()
    {
        return $this->stockTime;
    }

    /**
     * @param mixed $stockTime
     */
    public function setStockTime($stockTime)
    {
        $this->stockTime = $stockTime;
    }
}
