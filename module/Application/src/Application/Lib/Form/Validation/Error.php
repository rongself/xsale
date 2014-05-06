<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-5-5
 * Time: 上午11:40
 */

namespace Application\Lib\Form\Validation;


class Error extends AbstractError{

    private $field;
    private $errorMessage;

    public function __construct($field,$error)
    {
        $this->setField($field);
        $this->setErrorMessage($error);
    }

    /**
     * @return mixed
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param mixed $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param mixed $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }
} 