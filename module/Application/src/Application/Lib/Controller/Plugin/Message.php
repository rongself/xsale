<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-6-2
 * Time: 下午5:59
 */

namespace Application\Lib\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Session\Container;
use Zend\View\Helper\HeadScript;

class Message extends AbstractPlugin{

    /**
     * @var \Zend\Session\Container
     */
    private $sessionStore;
    public function __construct()
    {
        $this->sessionStore = new Container('message');
    }

    private function show($message,$type)
    {
        $this->sessionStore->message = $message;
        $this->sessionStore->type = $type;
    }

    public function success($message)
    {
        $this->show($message,MessageType::SUCCESS);
    }

    public function error($message)
    {
        $this->show($message,MessageType::ERROR);
    }

    public function listener(HeadScript $headScript)
    {
        if(isset($this->sessionStore->message)&&isset($this->sessionStore->type)){
            $headScript->appendScript(
                "require(['main'],function(){
                    require(['message'],function(message){
                        message.{$this->sessionStore->type}('{$this->sessionStore->message}');
                    });
               });"
            );
            $this->sessionStore->getManager()->getStorage()->clear('message');
        }
    }
}

/**
 * Class MessageType
 * @package Application\Lib\Controller\Plugin
 * it's the function name of /module/message.js
 */
class MessageType {
    const  ERROR = 'error';
    const  SUCCESS = 'success';
}