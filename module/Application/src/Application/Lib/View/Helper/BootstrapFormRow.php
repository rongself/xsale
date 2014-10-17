<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-10-15
 * Time: 上午9:37
 */

namespace Application\Lib\View\Helper;


use Zend\Form\View\Helper\FormRow;
use Zend\Form\Element\Button;
use Zend\Form\ElementInterface;
use Zend\Form\Exception;

class BootstrapFormRow extends FormRow{
    /**
     * Utility form helper that renders a label (if it exists), an element and errors
     *
     * @param  ElementInterface $element
     * @throws \Zend\Form\Exception\DomainException
     * @return string
     */
    public function render(ElementInterface $element)
    {
        $escapeHtmlHelper    = $this->getEscapeHtmlHelper();
        $labelHelper         = $this->getLabelHelper();
        $elementHelper       = $this->getElementHelper();
        $elementErrorsHelper = $this->getElementErrorsHelper();

        $label           = $element->getLabel();
        $inputErrorClass = $this->getInputErrorClass();

        if (isset($label) && '' !== $label) {
            // Translate the label
            if (null !== ($translator = $this->getTranslator())) {
                $label = $translator->translate(
                    $label, $this->getTranslatorTextDomain()
                );
            }
        }

        // Does this element have errors ?
        if (count($element->getMessages()) > 0 && !empty($inputErrorClass)) {
            $classAttributes = ($element->hasAttribute('class') ? $element->getAttribute('class') . ' ' : '');
            $classAttributes = $classAttributes . $inputErrorClass;

            $element->setAttribute('class', $classAttributes);
        }

        if ($this->partial) {
            $vars = array(
                'element'           => $element,
                'label'             => $label,
                'labelAttributes'   => $this->labelAttributes,
                'labelPosition'     => $this->labelPosition,
                'renderErrors'      => $this->renderErrors,
            );

            return $this->view->render($this->partial, $vars);
        }

        if ($this->renderErrors) {
            $elementErrors = $elementErrorsHelper->render($element,array('class'=>'validationMessage'));
        }

        $this->setInputErrorClass('form-control '.$this->getInputErrorClass());

        if(!$element->hasAttribute('class')){
            switch($element->getAttributes()['type']){
                case 'text':
                    $element->setAttribute('class','form-control');
                    break;
                case 'submit':
                    $element->setAttribute('class','btn btn-success');
                    break;
                default:
                    break;
            }
        }

        $elementString = $elementHelper->render($element);

        if (isset($label) && '' !== $label) {
            $label = $escapeHtmlHelper($label);
            $labelAttributes = $element->getLabelAttributes();

            if (empty($labelAttributes)) {
                $labelAttributes = $this->labelAttributes;
            }
            $labelAttributes['class'] = $labelAttributes['class'].' control-label col-lg-3';
            // Multicheckbox elements have to be handled differently as the HTML standard does not allow nested
            // labels. The semantic way is to group them inside a fieldset
            $type = $element->getAttribute('type');
            if ($type === 'multi_checkbox' || $type === 'radio') {
                $markup = sprintf(
                    '<fieldset><legend>%s</legend>%s</fieldset>',
                    $label,
                    $elementString);
                if ($this->renderErrors) {
                    $markup .= $elementErrors;
                }
            } else {
                if ($element->hasAttribute('id')) {
                    $labelOpen = '';
                    $labelClose = '';
                    $label = sprintf('<label class="control-label col-lg-3" for="%s">%s</label>',$this->getId($element),$element->getLabel());
                } else {
                    $labelOpen  = $labelHelper->openTag($labelAttributes);
                    $labelClose = $labelHelper->closeTag();
                }

                if ($label !== '' && !$element->hasAttribute('id')) {
                    $label = '<span>' . $label . '</span>';
                }

                // Button element is a special case, because label is always rendered inside it
                if ($element instanceof Button) {
                    $labelOpen = $labelClose = $label = '';
                }
                if ($this->renderErrors){
                    $markup = '<div class="form-group">'.$labelOpen . $label . $labelClose . '<div class="col-lg-9">'.$elementString.$elementErrors.'</div>'.'</div>';
                }else{
                    $markup = '<div class="form-group">'.$labelOpen . $label . $labelClose . '<div class="col-lg-9">'.$elementString.'</div>'.'</div>';
                }

            }

        } else {
            if ($this->renderErrors) {
                $markup = $elementString . $elementErrors;
            } else {
                $markup = $elementString;
            }
        }

        return $markup;
    }
} 