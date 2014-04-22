<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
class CustomerController extends AbstractActionController
{

    /**
     * @var \Application\Service\CustomerService
     */
    private $customerService;

    public function __construct(\Application\Service\CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function indexAction()
    {
        // action body
    }

    public function createCustomerAction()
    {
        // action body
    }

    public function editCustomerAction()
    {
        // action body
    }

    public function getCustomersJsonAction()
    {
        $returnData = $this->customerService->getAutoCompleteSource();
        return new JsonModel($returnData);
    }
}





