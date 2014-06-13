<?php
namespace Application\Controller;

use Application\Entity\Exception\ValidationException;
use Application\Entity\Product;
use Application\Lib\View\Model\JsonResultModel;
use Application\Service\ProductService;
use Doctrine\DBAL\DBALException;
use Zend\Json\Json;
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
        $headScript = $this->getServiceLocator()->get('viewhelpermanager')->get('headScript');
        $this->Message()->listener($headScript);

        $keyword = $this->params('keyword');

        $page = intval($this->params('page',1));
        $paginator = $this->productService->getPaginator($keyword);
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(10);
        return array('paginator'=>$paginator);
    }

    public function editProductAction()
    {
        if($this->getRequest()->isPost()){
            $resultModel = new JsonResultModel();
            try{
                $jsonData = $this->params()->fromPost('product');
                $product = Json::decode($jsonData,Json::TYPE_ARRAY);
                $this->productService->edit(new Product($product));
            }catch (ValidationException $e){
                $resultModel->setErrors($e->getValidationError());
                return $resultModel;
            }catch(\Exception $e){
                $resultModel->addErrors('undefined',$e->getMessage());
                return $resultModel;
            }
            return $resultModel;
        }
        $id = $this->params('id');
        $productinfo = $this->productService->getProductById($id);
        return array('product'=>$productinfo);
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
        $return = $this->productService->isProductExists($sku);
        return new JsonModel(array('result'=>$return));
    }

    public function deleteAction()
    {
        $id = $this->params('id');
        try{
            $this->productService->delete($id);
        }catch (DBALException $e){
            $this->Message()->error('删除失败,原因可能是进货记录或销售记录中包含了此产品,请先删除这些记录后再试');
            return $this->redirect()->toRoute('product/wildcard');
        }
        $this->Message()->success('操作成功');
        return $this->redirect()->toRoute('product/wildcard');
    }

    public function deleteMultipleAction()
    {
        if($this->getRequest()->isPost())
        {
            $ids = $this->params()->fromPost('ids');
            $model = new JsonResultModel();
            try{
                $this->productService->deleteIn($ids);
            }catch (DBALException $e){
                $model->addErrors('','删除失败,原因可能是存在此客户购买的进货记录或销售记录,请先删除这些记录后再试');
            }
            return $model;
        }
    }

}



