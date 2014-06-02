<?php
namespace Application\Controller;

use Application\Entity\Customer;
use Application\Entity\Exception\ValidationException;
use Application\Lib\View\Model\JsonResultModel;
use Doctrine\DBAL\DBALException;
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
        $headScript = $this->getServiceLocator()->get('viewhelpermanager')->get('headScript');
        $this->Message()->listener($headScript);

        $page = intval($this->params('page',1));
        $paginator = $this->customerService->getPaginator();
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(10);
        return array('paginator'=>$paginator);
    }

    public function createCustomerAction()
    {
        $resultModel = new JsonResultModel();
        if($this->getRequest()->isPost()){
            try{
                $jsonData = $this->params()->fromPost('customer');
                $customer = new Customer(Json::decode($jsonData,Json::TYPE_ARRAY));
                $customer->setCreateTime(new \DateTime());//@todo 这一行抛出异常被捕获处理后,会不会执行下一行??
                $this->customerService->create($customer);
            }catch (ValidationException $e){
                $resultModel->setErrors($e->getValidationError());
                return $resultModel;
            }catch(\Exception $e){
                $resultModel->addErrors('undefined',$e->getMessage());
                return $resultModel;
            }
            return $resultModel;
        }

    }

    public function editCustomerAction()
    {

        if($this->getRequest()->isPost()){
            $resultModel = new JsonResultModel();
            try{
                $jsonData = $this->params()->fromPost('customer');
                $customer = Json::decode($jsonData,Json::TYPE_ARRAY);
                $this->customerService->edit($customer);
            }catch (ValidationException $e){
                $resultModel->setErrors($e->getValidationError());
                return $resultModel;
            }catch(\Exception $e){
                $resultModel->addErrors('undefined',$e->getMessage());
                return $resultModel;
            }
            return $resultModel;
        }
        $id = $this->params('id');
        $customerInfo = $this->customerService->getCustomerById($id);
        return array('customer'=>$customerInfo);
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        try{
            $this->customerService->delete($id);
        }catch (DBALException $e){
            $this->Message()->error('删除失败,原因可能是存在此客户购买的进货记录或销售记录,请先删除这些记录后再试');
            return $this->redirect()->toRoute('customer/wildcard');
        }
        $this->Message()->success('操作成功');
        return $this->redirect()->toRoute('customer/wildcard');
    }

    public function deleteMultipleAction()
    {
        if($this->getRequest()->isPost())
        {
            $ids = $this->params()->fromPost('ids');
            $model = new JsonResultModel();
            try{
                $this->customerService->deleteIn($ids);
            }catch (DBALException $e){
                $model->addErrors('','删除失败,原因可能是存在此客户购买的进货记录或销售记录,请先删除这些记录后再试');
            }
            return $model;
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





