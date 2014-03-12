<?php
namespace Application\Controller;

use Application\Entity\XsProducts;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
class ProductController extends AbstractActionController
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function editProductAction()
    {
        // action body
    }

    public function getProductsJsonAction()
    {
        /**
         * @var \Doctrine\ORM\EntityManager $objectManager
         */
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $products = $objectManager->getRepository('\Application\Entity\XsProducts')->findAll();
        return new jsonModel($products);
    }


}



