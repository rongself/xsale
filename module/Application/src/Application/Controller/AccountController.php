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
       $this->_helper->layout()->disableLayout();
    }


}







