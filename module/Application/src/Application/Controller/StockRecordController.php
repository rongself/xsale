<?php
namespace Application\Controller;

use Application\Entity\XsProducts;
use Zend\I18n\Validator\DateTime;
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
        /**
         * @var \Doctrine\ORM\EntityManager $objectManager
         */
        $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        if($this->getRequest()->isPost()){
            $jsonStr = $this->getRequest()->getPost('stockRecord');
            $data = json_decode($jsonStr);
            foreach($data->stockProducts as $product){
                $productEntity = $objectManager->getRepository('Application\Entity\XsProducts')->findOneBy(array('sku'=>$product->sku));
                if($productEntity==null){
                    $row = new XsProducts();
                    $row->setName($product->name);
                    $row->setCost($product->cost);
                    $row->setStock($product->stock);
                    $row->setPrice($product->price);
                    $row->setDescription($product->description);
                    $row->setPicture($product->price);
                    $row->setSku($product->sku);
                    $row->setCreateTime(new \DateTime());
                    $objectManager->persist($row);
                }else{
                    $productEntity->setName($product->name);
                    $productEntity->setCost($product->cost);
                    $productEntity->setStock((int)$productEntity->getStock()+(int)$product->stock);
                    $productEntity->setPrice($product->price);
                    $productEntity->setDescription($product->description);
                    $productEntity->setPicture($product->price);
                }
            }
            $objectManager->flush();
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











