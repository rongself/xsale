<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="xs_stock_items")
 */
class StockItem
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\Product", inversedBy="stockItems", cascade={"persist"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Entity\StockRecord", inversedBy="stockItems", cascade={"persist"})
     * @ORM\JoinColumn(name="stock_record_id", referencedColumnName="id", nullable=false)
     */
    private $stockRecord;

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
     * @return StockItem
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
     * @return StockItem
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
     * @return StockItem
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
     * Set product
     *
     * @param \Application\Entity\Product $product
     * @return StockItem
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
     * Set stockRecord
     *
     * @param \Application\Entity\StockRecord $stockRecord
     * @return StockItem
     */
    public function setStockRecord(\Application\Entity\StockRecord $stockRecord)
    {
        $this->stockRecord = $stockRecord;

        return $this;
    }

    /**
     * Get stockRecord
     *
     * @return \Application\Entity\StockRecord 
     */
    public function getStockRecord()
    {
        return $this->stockRecord;
    }
}
