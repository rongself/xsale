<?php
/**
 * Created by PhpStorm.
 * User: Ron
 * Date: 14-4-26
 * Time: 上午11:43
 */

namespace Application\Entity\Exception;


class ValidationException extends \Exception {

    private $validationError = array();

    /**
     * @param string $field
     * @param int $message
     */
    public function __construct($message,$field = 0)
    {
        $this->setValidationError($message,$field = 0);
        parent::__construct($message);
    }

    /**
     * @return array
     */
    public function getValidationError()
    {
        return $this->validationError;
    }

    /**
     * @param $field
     * @param $message
     */
    private  function setValidationError($message,$field = 0)
    {
        $this->validationError[] = array($field=>$message);
    }
} 