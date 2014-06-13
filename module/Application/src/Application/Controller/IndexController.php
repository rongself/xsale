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
use Application\Service\ProductService;
use Application\Service\StatisticsService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\DateTime;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    private $statisticsService;
    private $productService;
    public function __construct(StatisticsService $statisticsService,ProductService $productService)
    {
        $this->statisticsService = $statisticsService;
        $this->productService = $productService;
    }

    public function indexAction()
    {
        return array(
            'recentOrder'=>$this->statisticsService->getRecentOrder(5),
            'recentStock'=>$this->statisticsService->getRecentStock(5),
            'topSale'=>$this->statisticsService->getTopSale(5,30),
            'stockWarning'=>$this->productService->getStockLessProduct(1)
        );
    }
}
