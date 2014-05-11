<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-5-5
 * Time: 上午11:24
 */

namespace Application\Lib\View\Model;


use Zend\View\Model\JsonModel;

class JsonResultModel extends JsonModel {

    private $success;

    private $errors;

    /**
     * @param array $errors
     */
    public function __construct(array $errors = array())
    {
         $this->setErrors($errors);
    }

    /**
     * @return mixed
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @param $result
     * @return $this
     */
    private function setSuccess($result)
    {
        $this->success = $result;
        parent::setVariable('success',$result);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $field
     * @param $error
     * @return $this
     */
    public function addErrors($field,$error)
    {
        $errors = $this->errors;
        $errors[$field] = $error;
        return $this->setErrors($errors);
    }

    /**
     * @param array $errors
     * @return $this
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
        if(empty($errors))
        {
            $this->setSuccess(true);
        }else{
            $this->setSuccess(false);
        }
        parent::setVariable('errors',$errors);
        return $this;
    }


} 