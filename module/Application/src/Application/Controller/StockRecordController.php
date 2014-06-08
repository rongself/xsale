<?php
namespace Application\Controller;

use Application\Entity\Exception\ValidationException;
use Application\Lib\View\Model\JsonResultModel;
use Application\Service\StockRecordService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
class StockRecordController extends AbstractActionController
{

    /**
     * @var StockRecordService
     */
    protected $stockRecordService;

    public function __construct(StockRecordService $stockRecordService)
    {
        $this->stockRecordService = $stockRecordService;
    }

    public function indexAction()
    {
        //show message
        $headScript = $this->getServiceLocator()->get('viewhelpermanager')->get('headScript');
        $this->Message()->listener($headScript);

        $page = intval($this->params('page',1));
        $paginator = $this->stockRecordService->getPaginator();
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(10);
        return array('paginator'=>$paginator);
    }

    public function createRecordAction()
    {
        if($this->getRequest()->isPost()){
            $jsonStr = $this->getRequest()->getPost('stockRecord');
            $data = json_decode($jsonStr);
            $this->stockRecordService->create($data,$this->identity());
            return new jsonModel(array('success'=>true,'errors'=>null));
        }
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        try{
            $this->stockRecordService->delete($id);
        }catch (ValidationException $e){
            $message = implode(',',$e->getValidationError());
            $this->Message()->error($message);
            return $this->redirect()->toRoute('stock-record/wildcard');
        }
        $this->Message()->success('操作成功');
        return $this->redirect()->toRoute('stock-record/wildcard');
    }

    public function deleteMultipleAction()
    {
        if($this->getRequest()->isPost())
        {
            $result = new JsonResultModel();
            $ids = $this->params()->fromPost('ids');
            try{
                $this->stockRecordService->deleteIn($ids);
            }catch (ValidationException $e){
                $message = implode(',',$e->getValidationError());
                $result->addErrors('stock',$message);
            }
            return $result;
        }
    }

    public function editRecordAction()
    {
        // action body
    }

    public function recordDetailAction()
    {
        // action body
    }


}











