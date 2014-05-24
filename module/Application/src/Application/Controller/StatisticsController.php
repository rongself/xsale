<?php
namespace Application\Controller;

use Application\Service\StatisticsService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
class StatisticsController extends AbstractActionController
{

    private $statisticsService;
    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }
    public function indexAction()
    {
        // action body
    }

    public function profitAction()
    {
        // action body
    }

    public function soldAction()
    {
        // action body
    }

    public function hotSellAction()
    {
        // action body
    }

    public function ajaxGetTotalProfitWeeklyAction()
    {
        $data = $this->statisticsService->getTotalProfitWeekly();
        $profitData = array();
        $priceData = array();
        foreach($data as $item){
            $date = new \DateTime($item['date']);
            $profitData[] = [$date->getTimestamp()*1000,$item['profit']];
            $priceData[] = [$date->getTimestamp()*1000,$item['priceAmount']];
        }
        $sum = $this->statisticsService->getSum();
        return new JsonModel(array('profitData'=>$profitData,'priceData'=>$priceData,'sum'=>$sum));
    }
}







