<?php
namespace Application\Controller;

use Application\Entity\XsProductImages;
use Application\Entity\XsProducts;
use Application\Entity\XsStockRecords;
use Application\Service\StockRecordService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
class StockRecordController extends AbstractActionController
{

    protected $productTable;
    public function indexAction()
    {
        // action body
    }

    public function createRecordAction()
    {
        $stockRecordService = new StockRecordService($this->getServiceLocator());
        if($this->getRequest()->isPost()){
            $jsonStr = $this->getRequest()->getPost('stockRecord');
            $data = json_decode($jsonStr);

            $stockRecordService->create($data);
            //set stock record
            //$stockRecordEntity = new XsStockRecords();

            return new jsonModel(array('success'=>true,'errors'=>null));
        }
    }

    public function deleteRecordAction()
    {
        // action body
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











