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
        //var_dump($data);exit;
        $profitData = array();
        $priceData = array();
        foreach($data as $item){
            $profitData[] = [strtotime($item['date'].' UTC')*1000,$item['profit']];
            $priceData[] = [strtotime($item['date'].' UTC')*1000,$item['priceAmount']];
            //var_dump($item['date']);
        }
        $sum = $this->statisticsService->getSum();
        return new JsonModel(array('profitData'=>$profitData,'priceData'=>$priceData,'sum'=>$sum));
    }
}







