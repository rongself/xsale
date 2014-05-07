<?php
namespace Application\Controller;

use Application\Entity\Account;
use Application\Entity\Exception\ValidationException;
use Application\Lib\View\Model\JsonResultModel;
use Application\Service\AccountService;
use Zend\Authentication\AuthenticationService;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class AccountController extends AbstractActionController
{

    /**
     * @var AccountService
     */
    private $accountService;

    /**
     * @var AuthenticationService
     */
    private $authenticationService;

    public function __construct(AccountService $accountService,AuthenticationService $authenticationService)
    {
        $this->accountService = $accountService;
        $this->authenticationService = $authenticationService;
    }

    public function indexAction()
    {
        if(!$this->authenticationService->hasIdentity()){
            return $this->redirect()->toRoute('login');
        }
        $page = intval($this->params('page',1));
        $paginator = $this->accountService->getPaginator();
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(10);
        return array('paginator'=>$paginator);
    }

    public function createAccountAction()
    {
        $resultModel = new JsonResultModel();
        if($this->getRequest()->isPost()){
            try{
                $jsonData = $this->params()->fromPost('account');
                $account = new Account(Json::decode($jsonData,Json::TYPE_ARRAY));
                $account->setCreateTime(new \DateTime());//@todo 这一行抛出异常被捕获处理后,会不会执行下一行??会!
                $this->accountService->create($account);
            }catch (ValidationException $e){
                $resultModel->setErrors($e->getValidationError());
                return $resultModel;
            }catch(\Exception $e){
                $resultModel->addErrors('error',$e->getMessage());
                return $resultModel;
            }
            return $resultModel;
        }

    }

    public function editAccountAction()
    {
        $account = $this->authenticationService->getIdentity();
        $id = $account->getId();
        $resultModel = new JsonResultModel();
        if($this->getRequest()->isPost()){
            try{
                $name = $this->params()->fromPost('name');
                $this->accountService->editAccount($id,$name);
            }catch (ValidationException $ve){
                return $resultModel->setErrors($ve->getValidationError());
            }catch(\Exception $e){
                return $resultModel->addErrors('error','unknow error');
            }
        }
        return array('account'=>$account);
    }
    public function changePasswordAction()
    {
        $resultModel = new JsonResultModel();
        if($this->getRequest()->isPost()){
            try{
                $jsonData = $this->params()->fromPost('password');
                $data = Json::decode($jsonData);
                $this->accountService->changePassword($this->authenticationService->getIdentity()->getId(),$data->password,$data->newPassword);
            }catch (ValidationException $ve){
                return $resultModel->setErrors($ve->getValidationError());
            }catch(\Exception $e){
                return $resultModel->addErrors('error','unknow error');
            }
            return $resultModel;
        }
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

        if($this->authenticationService->hasIdentity()){
            return $this->redirect()->toRoute('home');
        }
        $this->layout('layout/layout-blank');
        $resultModel = new JsonResultModel();
        if($this->getRequest()->isPost()){
            $jsonData = $this->getRequest()->getPost('login');
            $data = Json::decode($jsonData,Json::TYPE_ARRAY);
            // If you used another name for the authentication service, change it here
            $adapter = $this->authenticationService->getAdapter();
            $adapter->setIdentityValue($data['username']);
            $adapter->setCredentialValue($data['password']);
            $authResult = $this->authenticationService->authenticate();

            //@todo remember me
            if ($authResult->isValid()) {
                if($data['rememberMe']){
                    $this->authenticationService->getStorage()->getManager()->rememberMe(36000);
                }
                return $resultModel;
            }else{
                $resultModel->addErrors('password','登录名或密码错误');
                return $resultModel;
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







