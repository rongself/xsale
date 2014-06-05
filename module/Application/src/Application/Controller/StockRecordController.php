<?php
namespace Application\Controller;

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
        $res = $this->stockRecordService->delete($id);
        if($res){
            return $this->redirect()->toRoute('stock-record/wildcard');
        }
    }

    public function deleteMultipleAction()
    {
        if($this->getRequest()->isPost())
        {
            $ids = $this->params()->fromPost('ids');
            $this->stockRecordService->deleteIn($ids);
            return new JsonModel(array('success'=>true,'error'=>array()));
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











