<?php
namespace Application\Controller;

use Application\Entity\Exception\ValidationException;
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
        $page = intval($this->params('page',1));
        $paginator = $this->saleRecordService->getPaginator();
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(10);
        return array('paginator'=>$paginator);
    }

    public function createRecordAction()
    {
        $returnData = array('success'=>false,'error'=>array());
        if($this->getRequest()->isPost()){
            $jsonData = $this->getRequest()->getPost('saleRecord');
            $saleRecord = Json::decode($jsonData);
            try{
                $this->saleRecordService->create($saleRecord);
            }
            catch (ValidationException $e)
            {
                $returnData['error'] = $e->getValidationError();
                return new JsonModel($returnData);
            }
            $returnData['success'] = true;
            return new JsonModel($returnData);
        }

    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $res = $this->saleRecordService->delete($id);
        if($res){
            return $this->redirect()->toRoute('sale-record/wildcard');
        }
    }

    public function deleteMultipleAction()
    {
        if($this->getRequest()->isPost())
        {
            $ids = $this->params()->fromPost('ids');
            $this->saleRecordService->deleteIn($ids);
            return new JsonModel(array('success'=>true,'error'=>array()));
        }
    }

    public function editRecordAction()
    {
        // action body
    }


}





