<?php
namespace Application\Controller;

use Application\Service\ProductService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
class ProductController extends AbstractActionController
{
    /**
     * @var \Application\Service\ProductService
     */
    private $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function indexAction()
    {
        $page = intval($this->params('page',1));
        $paginator = $this->productService->getPaginator();
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(10);
        return array('paginator'=>$paginator);
    }

    public function editProductAction()
    {
        // action body
    }

    public function getProductsJsonAction()
    {
        $products = $this->productService->getAll();
        $returnData = array();
        foreach ($products as $product) {
            $row = array();
            $row['id']   = $product->getId();
            $row['name'] = $product->getName();
            $row['sku']  = $product->getSku();
            $row['cost'] = $product->getCost();
            $row['price'] = $product->getPrice();
            $row['description'] = $product->getDescription();
            $row['stock'] = $product->getStock();
            $row['picture'] = $product->getPicture();
            $row['productImages'] = array();
            foreach ($product->getProductImages() as $productImage) {
                $row['productImages'][] = $productImage->getUrl();
            }
            $returnData[] = $row;
        }

        return new jsonModel($returnData);
    }

    public function ajaxIsProductExistsAction(){
        $sku = $this->getRequest()->getPost('sku');
        $return = $this->productService->IsProductExists($sku);
        return new JsonModel(array('result'=>$return));
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        $res = $this->productService->delete($id);
        if($res){
            return $this->redirect()->toRoute('product/wildcard');
        }
    }

    public function deleteMultipleAction()
    {
        if($this->getRequest()->isPost())
        {
            $ids = $this->params()->fromPost('ids');
            $this->productService->deleteIn($ids);
            return new JsonModel(array('success'=>true,'error'=>array()));
        }
    }

}



