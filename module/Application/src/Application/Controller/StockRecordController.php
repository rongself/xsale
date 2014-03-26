<?php
namespace Application\Controller;

use Application\Entity\XsProductImages;
use Application\Entity\XsProducts;
use Application\Entity\XsStockRecords;
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
            /**@todo 只insert了new product,还未创建stock record ,图片还有问题*/
            foreach($data->stockProducts as $product){
                $productEntity = $objectManager->getRepository('Application\Entity\XsProducts')->findOneBy(array('sku'=>$product->sku));
                if($productEntity==null){
                    // if sku is not exists,add it
                    $productEntity = new XsProducts();
                    $productEntity->setName($product->name);
                    $productEntity->setCost($product->cost);
                    $productEntity->setStock($product->stock);
                    $productEntity->setPrice($product->price);
                    $productEntity->setDescription($product->description);
                    $productEntity->setSku($product->sku);
                    $productEntity->setCreateTime(new \DateTime());

                    $objectManager->persist($productEntity);
                }else{
                    // if sku exists, update the information
                    $productEntity->setName($product->name);
                    $productEntity->setCost($product->cost);
                    $productEntity->setStock((int)$productEntity->getStock()+(int)$product->stock);
                    $productEntity->setPrice($product->price);
                    $productEntity->setDescription($product->description);
                }
                $objectManager->flush();
                //whether sku exist,always add pictures
                $imageTemp = new XsProductImages();
                $i = 0;
                foreach ($product->pictures as $picture) {
                    $image = clone $imageTemp;
                    $image = $image->setProductId($productEntity->getId());
                    if($i==0){
                        //set as default image(0)
                        $image->setType(0);
                        $productEntity->setPicture($picture);
                    }else{
                        //set as description image(1)
                        $image->setType(1);
                    }
                    $image->setUrl($picture);
                    $image->setCreateTime(new \DateTime());
                    $objectManager->persist($image);
                    $i++;
                }
            }
            $objectManager->flush();
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











