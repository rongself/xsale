<?php
namespace Application\Entity;
use Application\Entity\Exception\ValidationException;
use Application\Lib\Authentication\Password;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="xs_admins")
 */
class Account extends AbstractEntity
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=32, nullable=false, name="username",unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=32, nullable=false, name="name")
     */
    private $name;

    /** 
     * @ORM\Column(type="string", length=32, nullable=false, name="password")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="Application\Entity\StockRecord", mappedBy="admin", cascade={"persist"})
     */
    private $stockRecords;

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
     * Set username
     *
     * @param string $username
     * @return Account
     * @throws ValidationException
     */
    public function setUsername($username)
    {
        if(!isset($username)) throw new ValidationException('用户名不能为空','username');
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Account
     * @throws ValidationException
     */
    public function setPassword($password)
    {
        if(!isset($password)) throw new ValidationException('密码不能为空','password');
        $this->password = Password::buildPassword($password);
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set createTime
     *
     * @param \DateTime $createTime
     * @return Admin
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
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Account
     * @throws ValidationException
     */
    public function setName($name)
    {
        if(!isset($name)) throw new ValidationException('姓名不能为空','name');
        $this->name = $name;
    }

    /**
     * Add order
     *
     * @param \Application\Entity\StockRecord $stockRecord
     * @return Customer
     */
    public function addStockRecord(\Application\Entity\StockRecord $stockRecord = null)
    {
        $this->stockRecords[] = $stockRecord;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \Application\Entity\StockRecord $stockRecord
     * @return Customer
     */
    public function removeStockRecord(\Application\Entity\StockRecord $stockRecord = null)
    {
        $this->stockRecords->removeElement($stockRecord);

        return $this;
    }

    /**
     * Get order
     *
     * @return \Application\Entity\StockRecord
     */
    public function getStockRecords()
    {
        return $this->stockRecords;
    }
}
