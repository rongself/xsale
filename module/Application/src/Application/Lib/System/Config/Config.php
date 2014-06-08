<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-6-6
 * Time: 下午8:17
 */

namespace Application\Lib\System\Config;


class Config extends AbstractConfig {
    private static $instance;
    private function __construct(){}
    public static  function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get($value){}

    public function set($key,$value){}
} 