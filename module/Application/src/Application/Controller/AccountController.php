<?php
namespace Application\Controller;

use Application\Entity\Account;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class AccountController extends AbstractActionController
{

    /**
     * @var \Application\Service\AccountService
     */
    private $accountService;

    public function __construct(\Application\Service\AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function indexAction()
    {
        /**
         * @var $authService \Zend\Authentication\AuthenticationService
         */
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if(!$authService->hasIdentity()){
            return $this->redirect()->toRoute('login');
        }
        $page = intval($this->params('page',1));
        $paginator = $this->accountService->getPaginator();
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(10);
        return array('paginator'=>$paginator);
    }

    public function createAccountAction()
    {
        $returnData = array('success'=>false,'error'=>array());
        if($this->getRequest()->isPost()){
            try{
                $jsonData = $this->params()->fromPost('account');
                $account = new Account(Json::decode($jsonData,Json::TYPE_ARRAY));
                $account->setCreateTime(new \DateTime());//@todo 这一行抛出异常被捕获处理后,会不会执行下一行??
                $this->accountService->create($account);
            }catch (ValidationException $e){
                $returnData['error'] = $e->getValidationError();
                return new JsonModel($returnData);
            }catch(\Exception $e){
                $returnData['error'] = $e->getMessage();
                return new JsonModel($returnData);
            }
            $returnData['success'] = true;
            return new JsonModel($returnData);
        }

    }

    public function editAccountAction()
    {
        return new ViewModel();
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $res = $this->accountService->delete($id);
        if($res){
            return $this->redirect()->toRoute('account/wildcard');
        }
    }

    public function deleteMultipleAction()
    {
        if($this->getRequest()->isPost())
        {
            $ids = $this->params()->fromPost('ids');
            $this->accountService->deleteIn($ids);
            return new JsonModel(array('success'=>true,'error'=>array()));
        }
    }

    public function ajaxIsUsernameExistsAction(){
        $username = $this->getRequest()->getPost('account');
        $return = $this->accountService->isUsernameExists($username);
        return new JsonModel(array('result'=>$return));
    }

    public function loginAction()
    {
        /**
         * @var $authService \Zend\Authentication\AuthenticationService
         */
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if($authService->hasIdentity()){
            return $this->redirect()->toRoute('home');
        }
        $this->layout('layout/layout-blank');
        $returnData = array('success'=>false,'error'=>array());
        if($this->getRequest()->isPost()){
            $jsonData = $this->getRequest()->getPost('login');
            $data = Json::decode($jsonData,Json::TYPE_ARRAY);
            // If you used another name for the authentication service, change it here
            $adapter = $authService->getAdapter();
            $adapter->setIdentityValue($data['username']);
            $adapter->setCredentialValue($data['password']);
            $authResult = $authService->authenticate();

            //@todo remember me
            if ($authResult->isValid()) {
                $returnData['success'] = true;
                return new JsonModel($returnData);
            }else{
                $returnData['error'] = '登录名或密码错误';
                return new JsonModel($returnData);
            }
        }

    }

    public function logoutAction()
    {
        /**
         * @var $authService \Zend\Authentication\AuthenticationService
         */
        $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

        if($authService->hasIdentity()){
            $authService->clearIdentity();
        }
        return $this->redirect()->toRoute('login');
    }


}







