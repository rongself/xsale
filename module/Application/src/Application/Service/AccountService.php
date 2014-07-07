<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-5-2
 * Time: 下午11:15
 */

namespace Application\Service;


use Application\Entity\Account;
use Application\Entity\Exception\ValidationException;
use Application\Lib\Acl\RoleType;
use Application\Lib\Authentication\Password;
use Doctrine\DBAL\Types\Type;

class AccountService extends AbstractService{

    public function getPaginator($keyword=null)
    {
        $qb = $this->getRepository()->createQueryBuilder('o');
        if(isset($keyword)){
            $qb->where($qb->expr()->like('o.username',':keyword'))
                ->orWhere($qb->expr()->like('o.name',':keyword'))
                ->setParameter('keyword',"%{$keyword}%");
        }
        return parent::getPaginator($qb->getQuery());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $qb = $this->objectManager->createQueryBuilder();
        $qb->delete()
            ->from('Application\Entity\Account','o')
            ->where($qb->expr()->eq('o.id',':id'))->setParameter('id',$id);
        return $qb->getQuery()->execute();
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteIn(array $ids)
    {
        $qb = $this->objectManager->createQueryBuilder();
        $qb->delete()
            ->from('Application\Entity\Account','o')
            ->where($qb->expr()->in('o.id',':ids'))->setParameter(':ids',$ids,Type::SIMPLE_ARRAY);
        return $qb->getQuery()->execute();
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    function getRepository()
    {
        return $this->objectManager->getRepository('Application\Entity\Account');
    }

    public function isUsernameExists($username)
    {
        $result = $this->getRepository()->findOneBy(array('username'=>$username));
        return $result!==null;
    }

    /**
     * @param Account $account
     */
    public function create(Account $account)
    {
        $this->objectManager->persist($account);
        $this->objectManager->flush();
    }

    /**
     * @param $id
     * @param $oldPassword
     * @param $newPassword
     * @throws \Application\Entity\Exception\ValidationException
     */
    public function changePassword($id, $oldPassword, $newPassword)
    {
        /**
         * @var $result \Application\Entity\Account
         */
        $result = $this->getRepository()->findOneBy(array('password'=>Password::BuildPassword($oldPassword),'id'=>$id));
        if($result===null){
            throw new ValidationException('原密码错误','password');
        }else{
            $result->setPassword($newPassword);
            $this->objectManager->flush($result);
        }
    }

    public function resetPassword($id,$newPassword)
    {
        /**
         * @var $result \Application\Entity\Account
         */
        $result = $this->getRepository()->find($id);
        if($result===null){
            throw new ValidationException('用户不存在','password');
        }else if($result->getRole()==RoleType::SUPER_ADMIN){
            throw new ValidationException('不能重置超级管理员的密码','password');
        }else{
            $result->setPassword($newPassword);
            $this->objectManager->flush($result);
        }
    }

    /**
     * @param $id
     * @param $name
     */
    public function editAccount($id, $name)
    {
        /**
         * @var $result \Application\Entity\Account
         */
        $result = $this->getAccountById($id);
        $result->setName($name);
        $this->objectManager->flush($result);
    }

    public function getAccountById($id)
    {
        return $this->getRepository()->find($id);
    }
}