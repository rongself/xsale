<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * XsCustomers
 *
 * @ORM\Table(name="xs_customers")
 * @ORM\Entity
 */
class XsCustomers extends \Application\Entity\AbstractEntity
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
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=true, name="name")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=true, name="phone_number")
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=32, nullable=true, name="wechat")
     */
    private $wechat;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=32, nullable=true, name="qq")
     */
    private $qq;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true, name="create_time")
     */
    private $createTime;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true, name="remark")
     */
    private $remark;



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
     * Set name
     *
     * @param string $name
     * @return XsCustomers
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
     * Set phoneNumber
     *
     * @param string $phoneNumber
     * @return XsCustomers
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string 
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set wechat
     *
     * @param string $wechat
     * @return XsCustomers
     */
    public function setWechat($wechat)
    {
        $this->wechat = $wechat;

        return $this;
    }

    /**
     * Get wechat
     *
     * @return string 
     */
    public function getWechat()
    {
        return $this->wechat;
    }

    /**
     * Set qq
     *
     * @param string $qq
     * @return XsCustomers
     */
    public function setQq($qq)
    {
        $this->qq = $qq;

        return $this;
    }

    /**
     * Get qq
     *
     * @return string 
     */
    public function getQq()
    {
        return $this->qq;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     * @return XsCustomers
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
     * Set remark
     *
     * @param string $remark
     * @return XsCustomers
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
}
