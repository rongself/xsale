<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AccountController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }

    public function createAccountAction()
    {
        return new ViewModel();
    }

    public function editAccountAction()
    {
        return new ViewModel();
    }

    public function loginAction()
    {
       $this->_helper->layout()->disableLayout();
    }


}







