<?php

namespace Application\Controller;

use Application\Custom\UploadHandler;
use Zend\Config\Writer\Json;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class FileUploaderController extends AbstractActionController
{

    public function imageUploaderAction()
    {
//        $upload = new \Zend\File\Transfer\Transfer();
//        $upload->setDestination('/uploads/img/');
//
//        $rtn = array('success' => null);
//
//        if ($this->getRequest()->isPost()) {
//            $files = $upload->getFileInfo();
//            foreach ($files as $file => $info) {
//                if (!$upload->isUploaded($file)) {
//                    print "<h3>Not Uploaded</h3>";
//                    Debug::dump($file);
//                    continue;
//                }
//                if (!$upload->isValid($file)) {
//                    print "<h4>Not Valid</h4>";
//                    Debug::dump($file);
//                    continue;
//                }
//            }
//
//            $rtn['success'] = $upload->receive();
//        }
        $uploader = new UploadHandler();
        return new JsonModel($uploader->getBody());
    }


}

