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

    }

    public function createRecordAction()
    {
        if($this->getRequest()->isPost()){
            $jsonStr = $this->getRequest()->getPost('stockRecord');
            $data = json_decode($jsonStr);
            $this->stockRecordService->create($data);
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











