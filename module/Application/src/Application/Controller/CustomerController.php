<?php
namespace Application\Controller;

use Application\Entity\Customer;
use Application\Entity\Exception\ValidationException;
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
        $returnData = array('success'=>false,'error'=>array());
        if($this->getRequest()->isPost()){
            try{
                $jsonData = $this->params()->fromPost('customer');
                $customer = new Customer(Json::decode($jsonData,Json::TYPE_ARRAY));
                $customer->setCreateTime(new \DateTime());//@todo 这一行抛出异常被捕获处理后,会不会执行下一行??
                $this->customerService->create($customer);
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

    public function ajaxIsPhoneNumberExistsAction(){
        $phoneNumber = $this->getRequest()->getPost('phoneNumber');
        $return = $this->customerService->isPhoneNumberExists($phoneNumber);
        return new JsonModel(array('result'=>$return));
    }

    public function getCustomersJsonAction()
    {
        $returnData = $this->customerService->getAutoCompleteSource();
        return new JsonModel($returnData);
    }
}





