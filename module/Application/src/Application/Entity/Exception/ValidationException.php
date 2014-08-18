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
     * @param string $message
     * @param string $field
     */
    public function __construct($message,$field = 0)
    {
        $this->setValidationError($message,$field);
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
        $this->validationError[$field] = $message;
    }
} 