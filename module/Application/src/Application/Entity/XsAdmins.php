<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * XsAdmins
 *
 * @ORM\Table(name="xs_admins")
 * @ORM\Entity
 */
class XsAdmins extends \Application\Entity\AbstractEntity
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
     * @ORM\Column(type="string", length=32, nullable=false, name="username")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=32, nullable=false, name="password")
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true, name="create_time")
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
     * @return XsAdmins
     */
    public function setUsername($username)
    {
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
     * @return XsAdmins
     */
    public function setPassword($password)
    {
        $this->password = $password;

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
     * @return XsAdmins
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
