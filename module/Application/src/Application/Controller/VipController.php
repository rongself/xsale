<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-10-10
 * Time: 上午9:53
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class VipController extends AbstractActionController {
    /**
     * @var VipArchiveService
     */
    protected $vipArchiveService;

    public function __construct(VipArchiveService $vipArchiveService)
    {
        $this->vipArchiveService = $vipArchiveService;
    }

    public function rechargeAction()
    {

    }
} 