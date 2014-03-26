<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * XsProducts
 *
 * @ORM\Table(name="xs_products", uniqueConstraints={@ORM\UniqueConstraint(name="sku_unique", columns={"sku"})})
 * @ORM\Entity
 */
class XsProducts extends \Application\Entity\AbstractEntity
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
     * @ORM\OneToMany(targetEntity="Application\Entity\XsProductImages", mappedBy="productId")
     **/
    private $productImages;

    public function __construct() {
        $this->productImages = new ArrayCollection();
    }

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30, nullable=true, name="sku")
     */
    private $sku;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30, nullable=true, name="name")
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=false, name="cost", precision=10, scale=0)
     */
    private $cost;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, name="price", precision=10, scale=0)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, name="description")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, name="picture")
     */
    private $picture;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false, name="stock")
     */
    private $stock;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, name="remark")
     */
    private $remark;

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
     * Set sku
     *
     * @param string $sku
     * @return XsProducts
     */
    public function setSku($sku)
    {
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
     * @return XsProducts
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
     * @return XsProducts
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
     * @return XsProducts
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
     * @return XsProducts
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
     * @return XsProducts
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
     * @return XsProducts
     */
    public function setStock($stock)
    {
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
     * @return XsProducts
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
     * @return XsProducts
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
     * @param \Application\Entity\XsProductImages $productImages
     * @return XsProducts
     */
    public function addProductImage(\Application\Entity\XsProductImages $productImages)
    {
        $this->productImages[] = $productImages;

        return $this;
    }

    /**
     * Remove productImages
     *
     * @param \Application\Entity\XsProductImages $productImages
     */
    public function removeProductImage(\Application\Entity\XsProductImages $productImages)
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
}
