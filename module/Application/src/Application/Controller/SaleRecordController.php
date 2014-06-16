<?php
namespace Application\Controller;

use Application\Entity\Exception\ValidationException;
use Application\Lib\View\Model\JsonResultModel;
use Application\Service\SaleRecordService;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
class SaleRecordController extends AbstractActionController
{
    /**
     * @var \Application\Service\SaleRecordService
     */
    private $saleRecordService;

    public function __construct(SaleRecordService $saleRecordService)
    {
       $this->saleRecordService = $saleRecordService;
    }

    public function indexAction()
    {
        //show message
        $headScript = $this->getServiceLocator()->get('viewhelpermanager')->get('headScript');
        $this->Message()->listener($headScript);

        $keyword = $this->params('keyword');

        $page = intval($this->params('page',1));
        $paginator = $this->saleRecordService->getPaginator($keyword);
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(10);
        return array('paginator'=>$paginator);
    }

    public function historyAction()
    {
        //show message
        $headScript = $this->getServiceLocator()->get('viewhelpermanager')->get('headScript');
        $this->Message()->listener($headScript);

        $keyword = $this->params('keyword');

        $page = intval($this->params('page',1));
        $id = intval($this->params('id'));
        $paginator = $this->saleRecordService->getHistoryPaginator($id,$keyword);
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(10);
        return array('paginator'=>$paginator);
    }

    public function createRecordAction()
    {
        $resultModel = new JsonResultModel();
        if($this->getRequest()->isPost()){
            $jsonData = $this->getRequest()->getPost('saleRecord');
            $saleRecord = Json::decode($jsonData);
            try{
                $this->saleRecordService->create($saleRecord);
            }
            catch (ValidationException $e)
            {
                $resultModel->setErrors($e->getValidationError());
                return $resultModel;
            }
            return $resultModel;
        }

    }

    public function deleteAction()
    {
        $id = $this->params('id');
        try{
            $this->saleRecordService->delete($id);
        }catch (ValidationException $e){
            $message = implode(',',$e->getValidationError());
            $this->Message()->error($message);
            return $this->redirect()->toRoute('sale-record/wildcard');
        }
        $this->Message()->success('操作成功');
        return $this->redirect()->toRoute('sale-record/wildcard');
    }

    public function deleteMultipleAction()
    {
        if($this->getRequest()->isPost())
        {
            $result = new JsonResultModel();
            $ids = $this->params()->fromPost('ids');
            try{
                $this->saleRecordService->deleteIn($ids);
            }catch (ValidationException $e){
                $message = implode(',',$e->getValidationError());
                $result->addErrors('stock',$message);
            }
            return $result;
        }
    }

    public function editRecordAction()
    {
        $id = $this->params('id');
        if($this->getRequest()->isPost()){
            $result = new JsonResultModel();
            $jsonStr = $this->getRequest()->getPost('saleRecord');
            $data = json_decode($jsonStr);
            try{
                $this->saleRecordService->edit($data);
            }catch (ValidationException $e){
                $message = implode(',',$e->getValidationError());
                $result->addErrors('undefined',$message);
            }
            return $result;
        }
        return array('id'=>$id);
    }

    public function ajaxGetRecordAction()
    {
        $id = $this->params()->fromQuery('id');
        $record = $this->saleRecordService->getSaleRecordArrayById($id);
        return new JsonModel($record);
    }
}





