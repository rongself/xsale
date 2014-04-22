<?php
namespace Application\Controller;

use Application\Service\CustomerService;
use Application\Service\ProductService;
use Application\Service\SaleRecordService;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
class SaleRecordController extends AbstractActionController
{
    /**
     * @var \Application\Service\CustomerService
     */
    private $customerService;
    /**
     * @var \Application\Service\SaleRecordService
     */
    private $saleRecordService;
    /**
     * @var \Application\Service\ProductService
     */
    private $productService;

    public function __construct(CustomerService $customerService,SaleRecordService $saleRecordService,ProductService $productService)
    {
       $this->customerService = $customerService;
       $this->saleRecordService = $saleRecordService;
       $this->productService = $productService;
    }

    public function indexAction()
    {
        // action body
    }

    public function createRecordAction()
    {
        if($this->getRequest()->isPost()){
            $jsonData = $this->getRequest()->getPost('saleRecord');
            $saleRecord = Json::decode($jsonData);
            $this->saleRecordService->create($saleRecord);

        }

    }

    public function editRecordAction()
    {
        // action body
    }


}





