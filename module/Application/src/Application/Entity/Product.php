<?php
namespace Application\Entity;
use Application\Entity\Exception\ValidationException;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="xs_products", uniqueConstraints={@ORM\UniqueConstraint(name="sku_unique", columns={"sku"})})
 */
class Product extends AbstractEntity
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=30, nullable=true, name="sku",unique=true)
     */
    private $sku;

    /** 
     * @ORM\Column(type="string", length=30, nullable=true, name="name")
     */
    private $name;

    /** 
     * @ORM\Column(type="float", nullable=false, name="cost", precision=10, scale=0)
     */
    private $cost;

    /** 
     * @ORM\Column(type="float", nullable=true, name="price", precision=10, scale=0)
     */
    private $price;

    /** 
     * @ORM\Column(type="text", nullable=true, name="description")
     */
    private $description;

    /** 
     * @ORM\Column(type="text", nullable=true, name="picture")
     */
    private $picture;

    /** 
     * @ORM\Column(type="integer", nullable=false, name="stock")
     */
    private $stock;

    /** 
     * @ORM\Column(type="text", nullable=true, name="remark")
     */
    private $remark;

    /** 
     * @ORM\Column(type="datetime", nullable=false, name="create_time")
     */
    private $createTime;

    /** 
     * @ORM\OneToMany(targetEntity="Application\Entity\OrderCart", mappedBy="product", cascade={"persist"})
     */
    private $orderCart;

    /** 
     * @ORM\OneToMany(targetEntity="Application\Entity\ProductImage", mappedBy="product", cascade={"persist"})
     */
    private $productImages;

    /** 
     * @ORM\OneToMany(targetEntity="Application\Entity\StockItem", mappedBy="product", cascade={"persist"})
     */
    private $stockItems;

    /**
     * Constructor
     */
    public function __construct(array $product=null)
    {
        if($product!=null){
            parent::__construct($product);
        }
        $this->productImages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->stockItems = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set sku
     *
     * @param string $sku
     * @return Product
     */
    public function setSku($sku)
    {
        if(!preg_match("/^[a-z0-9_#-]+$/",$sku)) throw new ValidationException('款号只能是字母,数字,_,-,#组合','sku');
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string 
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set cost
     *
     * @param float $cost
     * @return Product
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return float 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
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
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return Product
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     * @return Product
     */
    public function setStock($stock)
    {
        if(intval($stock)<0)
        {
            throw new ValidationException($this->getSku().':库存不足','stock');
        }
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set remark
     *
     * @param string $remark
     * @return Product
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * Get remark
     *
     * @return string 
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     * @return Product
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
     * Add productImages
     *
     * @param \Application\Entity\ProductImage $productImages
     * @return Product
     */
    public function addProductImage(\Application\Entity\ProductImage $productImages)
    {
        $this->productImages[] = $productImages;

        return $this;
    }

    /**
     * Remove productImages
     *
     * @param \Application\Entity\ProductImage $productImages
     */
    public function removeProductImage(\Application\Entity\ProductImage $productImages)
    {
        $this->productImages->removeElement($productImages);
    }

    /**
     * Get productImages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductImages()
    {
        return $this->productImages;
    }

    /**
     * Add stockItems
     *
     * @param \Application\Entity\StockItem $stockItems
     * @return Product
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
     * Add orderCart
     *
     * @param \Application\Entity\OrderCart $orderCart
     * @return Product
     */
    public function addOrderCart(\Application\Entity\OrderCart $orderCart)
    {
        $this->orderCart[] = $orderCart;

        return $this;
    }

    /**
     * Remove orderCart
     *
     * @param \Application\Entity\OrderCart $orderCart
     */
    public function removeOrderCart(\Application\Entity\OrderCart $orderCart)
    {
        $this->orderCart->removeElement($orderCart);
    }

    /**
     * Get orderCart
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrderCart()
    {
        return $this->orderCart;
    }

}
