<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * XsProductImages
 *
 * @ORM\Table(name="xs_product_images")
 * @ORM\Entity
 */
class XsProductImages extends \Application\Entity\AbstractEntity
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
     * @ORM\ManyToOne(targetEntity="Application\Entity\XsProducts", inversedBy="productImages")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $productId;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false, name="url")
     */
    private $url;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false, name="type")
     */
    private $type;

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
     * Set productId
     *
     * @param integer $productId
     * @return XsProductImages
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
     * Set url
     *
     * @param string $url
     * @return XsProductImages
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
     * @return XsProductImages
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
     * @return XsProductImages
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
