<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-3-26
 * Time: 下午4:33
 */

namespace Application\Service;

use Application\Entity\XsProductImages;
use Zend\Di\ServiceLocator;

class StockRecordService {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $objectManager;

    public function __construct($sm)
    {
        $serviceLocator = new ServiceLocator();
        $this->objectManager = $sm->get('Doctrine\ORM\EntityManager');
    }
    public function create($data){
        foreach($data->stockProducts as $product){
            $productEntity = $this->objectManager->getRepository('Application\Entity\XsProducts')->findOneBy(array('sku'=>$product->sku));
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

                $this->objectManager->persist($productEntity);
            }else{
                // if sku exists, update the information
                $productEntity->setName($product->name);
                $productEntity->setCost($product->cost);
                $productEntity->setStock((int)$productEntity->getStock()+(int)$product->stock);
                $productEntity->setPrice($product->price);
                $productEntity->setDescription($product->description);
            }
            $this->objectManager->flush();
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
                $this->objectManager->persist($image);
                $i++;
            }
        }
        $this->objectManager->flush();
    }
} 