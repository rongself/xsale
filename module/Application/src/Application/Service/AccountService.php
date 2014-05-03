<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-5-2
 * Time: 下午11:15
 */

namespace Application\Service;


use Application\Entity\Account;

class AccountService extends AbstractService{

    public function getPaginator()
    {
        return parent::getPaginator('SELECT o FROM Application\Entity\Account o');
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
            ->where($qb->expr()->eq('o.id',$id));
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
            ->where($qb->expr()->in('o.id',$ids));
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

    public function create(Account $account)
    {
        $this->objectManager->persist($account);
        $this->objectManager->flush();
    }
}