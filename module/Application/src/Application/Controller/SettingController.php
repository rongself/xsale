<?php
namespace Application\Controller;

use Application\Entity\Setting;
use Application\Lib\System\Config\Config;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
class SettingController extends AbstractActionController
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $setting = new Setting();
        $setting->setKey('softwareName');
        $setting->setValue('Xsale');
        $setting->setName('HAHAHHA');
        $setting->setDescription('nothing');

        $config = Config::getInstance($this->getServiceLocator());
        var_dump($config->get('softwareName'));
    }

    public function systemAction()
    {
        // action body
    }

    public function othersAction()
    {
        // action body
    }


}





