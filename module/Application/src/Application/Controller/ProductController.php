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
        $returnData = array();
        //@todo All product return the same images
        foreach ($products as $product) {
            $row = array();
            $row['id']   = $product->getId();
            $row['name'] = $product->getName();
            $row['sku']  = $product->getSku();
            $row['cost'] = $product->getCost();
            $row['price'] = $product->getPrice();
            $row['description'] = $product->getDescription();
            $row['stock'] = $product->getStock();
            $row['picture'] = $product->getPicture();
            $row['productImages'] = array();
            foreach ($product->getProductImages() as $productImage) {
                $row['productImages'][] = $productImage->getUrl();
            }
            $returnData[] = $row;
        }

        return new jsonModel($returnData);
    }


}



