<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-10-13
 * Time: 下午4:51
 */

namespace Application\Form;


use Zend\Form\Form;
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Digits;
use Zend\Validator\StringLength;

class Recharge extends Form {
    protected $inputFilter;

    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('recharge');
        $this->setAttribute('class','form-horizontal');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
                'placeholder'=>'输入姓名'
            ),
            'options' => array(
                'label' => '姓名',
            ),
        ));
        $this->add(array(
            'name' => 'phoneNumber',
            'attributes' => array(
                'type'  => 'text',
                'placeholder'=>'输入手机号'
            ),
            'options' => array(
                'label' => '手机号',
            ),
        ));
        $this->add(array(
            'name' => 'money',
            'attributes' => array(
                'type'  => 'text',
                'id' => 'money',
                'placeholder'=>'输入要充值金额'
            ),
            'options' => array(
                'label' => '充值金额',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => '充值',
                'id' => 'submitbutton',
            ),
            'options' => array(
                'label' => '&nbsp;',
            ),
        ));
        $this->setInputFilter($this->buildInputFilter());
    }

    public function buildInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new Factory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'name',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 5,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'money',
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'Digits'
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
} 