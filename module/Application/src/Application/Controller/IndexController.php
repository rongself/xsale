<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Entity\ProductImage;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\DateTime;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
//          //@todo one to many 映射错误
//          $m = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
//          $product = $m->getRepository('Application\Entity\Product')->find(10);
//          $img = new ProductImage();
//          $img->setProduct($product);
//          $img->setUrl('xxxx');
//          $img->setType(1);
//          $img->setCreateTime(new \DateTime());
//
//          $product->addProductImage($img);
//          $m->flush();
//
//        exit;
    }
}
