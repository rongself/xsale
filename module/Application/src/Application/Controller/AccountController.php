<?php
namespace Application\Controller;

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
        return new ViewModel();
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

    public function loginAction()
    {
       $this->_helper->layout()->disableLayout();
    }


}







