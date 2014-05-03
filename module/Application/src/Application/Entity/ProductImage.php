<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="xs_product_images")
 */
class ProductImage extends AbstractEntity
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /** 
     * @ORM\Column(type="text", nullable=false, name="url")
     */
    private $url;

    /** 
     * @ORM\Column(type="boolean", nullable=false, name="type")
     */
    private $type;

    /** 
     * @ORM\Column(type="datetime", nullable=false, name="create_time")
     */
    private $createTime;

    /** 
     * @ORM\ManyToOne(targetEntity="Application\Entity\Product", inversedBy="productImages", cascade={"persist"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    private $product;


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
     * Set url
     *
     * @param string $url
     * @return ProductImage
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set type
     *
     * @param boolean $type
     * @return ProductImage
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return boolean 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     * @return ProductImage
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
     * @return ProductImage
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
}
