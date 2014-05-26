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
use Application\Service\StatisticsService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\DateTime;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    private $statisticsService;
    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    public function indexAction()
    {
        return array(
            'recentOrder'=>$this->statisticsService->getRecentOrder(),
            'recentStock'=>$this->statisticsService->getRecentStock(),
            'topSale'=>$this->statisticsService->getTopSale(10,30),
        );
    }
}
