<?php
namespace Application\Controller;

use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
class CustomerController extends AbstractActionController
{

    /**
     * @var \Application\Service\CustomerService
     */
    private $customerService;
    //@todo 增加会员充值功能,要点:充值记录,消费记录,记得锁表
    public function __construct(\Application\Service\CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function indexAction()
    {
        $page = intval($this->params('page',1));
        $paginator = $this->customerService->getPaginator();
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(10);
        return array('paginator'=>$paginator);
    }

    public function createCustomerAction()
    {
        if($this->getRequest()->isPost()){
            $jsonData = $this->params()->fromPost('customer');
            $customer = Json::decode($jsonData);
            $this->customerService->create($customer);
        }
    }

    public function editCustomerAction()
    {
        // action body
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $res = $this->customerService->delete($id);
        if($res){
            return $this->redirect()->toRoute('customer/wildcard');
        }
    }

    public function deleteMultipleAction()
    {
        if($this->getRequest()->isPost())
        {
            $ids = $this->params()->fromPost('ids');
            $this->customerService->deleteIn($ids);
            return new JsonModel(array('success'=>true,'error'=>array()));
        }
    }

    public function getCustomersJsonAction()
    {
        $returnData = $this->customerService->getAutoCompleteSource();
        return new JsonModel($returnData);
    }
}





