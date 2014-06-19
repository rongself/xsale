<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-6-17
 * Time: 下午3:01
 */

namespace ApplicationTest\Service;


use Application\test\Bootstrap;

class ProductServiceTest extends \PHPUnit_Framework_TestCase {

    protected  $productService;

    protected function setUp()
    {
        $serviceManager = Bootstrap::getServiceManager();
        $this->productService = $serviceManager->get('ProductService');
    }

    public function testIsProductExists()
    {
        $result = $this->productService->isProductExists('#xxx');
        $this->assertTrue($result,'isProductExists test fail');
    }
}
 