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
        //var_dump($data = $this->statisticsService->getSum());exit;
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
        $startDate = $this->params()->fromQuery('startDate',null);
        $endDate = $this->params()->fromQuery('endDate',null);
        if($startDate==null&&$endDate==null){
            $data = $this->statisticsService->getTotalProfitDaily();
            $sum = $this->statisticsService->getSum();
        }else{
            $data = $this->statisticsService->getTotalProfitDaily(new \DateTime($startDate),new \DateTime($endDate));
            $sum = $this->statisticsService->getSum(new \DateTime($startDate),new \DateTime($endDate));
        }

        $profitData = array();
        $priceData = array();
        $profitList = array();
        foreach($data as $item){
            $date = new \DateTime($item['date']);
            $profitData[] = [$date->getTimestamp()*1000,$item['profit']];
            $priceData[] = [$date->getTimestamp()*1000,$item['price_amount']];
            $profitList[] = array('date'=>$item['date'],'profit'=>$item['profit'],'priceAmount'=>$item['price_amount']);
        }
        return new JsonModel(array('profitList'=>$profitList,'profitData'=>$profitData,'priceData'=>$priceData,'sum'=>$sum));
    }
}







