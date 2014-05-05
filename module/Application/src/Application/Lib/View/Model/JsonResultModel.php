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

    private $result;

    private $errors;

    public function __construct(array $errors = array())
    {
        if(empty($errors))
        {
            $this->setResult(true);
        }else{
            $this->setErrors($errors);
        }
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result = false)
    {
        $this->result = $result;
        parent::setVariable('result',$result);
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
     */
    public function addErrors($field,$error)
    {
        $this->errors[$field] = $error;
        $this->setErrors($this->errors);
    }

    /**
     * @param mixed $errors
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
        parent::setVariable('errors',$errors);
    }


} 