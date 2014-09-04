<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-5-6
 * Time: 下午10:42
 */

namespace Application\Lib\Authentication;


class Password {

    public static  function BuildPassword($pwdString)
    {
        return md5($pwdString);
    }
} 