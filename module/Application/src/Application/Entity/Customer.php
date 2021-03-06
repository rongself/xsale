<?php
namespace Application\Entity;
use Application\Entity\Exception\ValidationException;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="xs_customers")
 */
class Customer extends AbstractEntity
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=20, nullable=true, name="name")
     */
    private $name;

    /** 
     * @ORM\Column(type="string", length=20, nullable=false, name="phone_number",unique=true)
     */
    private $phoneNumber;

    /** 
     * @ORM\Column(type="string", length=32, nullable=true, name="wechat")
     */
    private $wechat;

    /** 
     * @ORM\Column(type="string", length=32, nullable=true, name="qq")
     */
    private $qq;

    /** 
     * @ORM\Column(type="datetime", nullable=true, name="create_time")
     */
    private $createTime;

    /**
     * @ORM\Column(type="boolean", nullable=true, name="is_vip")
     */
    private $isVip;

    /**
     * @ORM\Column(type="float", nullable=true, name="balance", precision=10, scale=0)
     */
    private $balance;

    /** 
     * @ORM\Column(type="text", nullable=true, name="remark")
     */
    private $remark;

    /** 
     * @ORM\OneToMany(targetEntity="Application\Entity\Order", mappedBy="customer", cascade={"persist"})
     */
    private $orders;

    /**
     * Constructor
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Customer
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
     * @return Customer
     */
    public function setPhoneNumber($phoneNumber)
    {
        if(!$phoneNumber){
            throw new ValidationException('手机号码不能为空','phoneNumber');
        }
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
     * @return Customer
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
     * @return Customer
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
     * @return Customer
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
     * Set isVip
     *
     * @param string $isVip
     * @return Customer
     */
    public function setIsVip($isVip)
    {
        $this->isVip = $isVip;

        return $this;
    }

    /**
     * Get isVip
     *
     * @return string
     */
    public function getIsVip()
    {
        return $this->isVip;
    }

    /**
     * Set remark
     *
     * @param string $remark
     * @return Customer
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
     * Add order
     *
     * @param \Application\Entity\Order $order
     * @return Customer
     */
    public function addOrder(\Application\Entity\Order $order = null)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \Application\Entity\Order $order
     * @return Customer
     */
    public function removeOrder(\Application\Entity\Order $order = null)
    {
        $this->orders->removeElement($order);

        return $this;
    }

    /**
     * Get order
     *
     * @return \Application\Entity\Order 
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param mixed $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }
}
