<?php
/**
 * Created by PhpStorm.
 * User: Ron Choi
 * Date: 14-10-14
 * Time: 下午5:39
 */

namespace Application\Lib\View\Helper;

use Zend\Form\Element;
use Zend\Form\ElementInterface;
use Zend\Form\Element\Collection as CollectionElement;
use Zend\Form\FieldsetInterface;
use Zend\Form\View\Helper\FormCollection;
use Zend\View\Helper\AbstractHelper as BaseAbstractHelper;

class BootstrapFormConllection extends FormCollection{

    public function render(ElementInterface $element)
    {
        $this->setDefaultElementHelper('bootstrapFormRow');
        $renderer = $this->getView();
        if (!method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable
            return '';
        }

        $attributes       = $element->getAttributes();
        $markup           = '';
        $templateMarkup   = '';
        $escapeHtmlHelper = $this->getEscapeHtmlHelper();
        $elementHelper    = $this->getElementHelper();
        $fieldsetHelper   = $this->getFieldsetHelper();

        if ($element instanceof CollectionElement && $element->shouldCreateTemplate()) {
            $templateMarkup = $this->renderTemplate($element);
        }

        foreach ($element->getIterator() as $elementOrFieldset) {
            if ($elementOrFieldset instanceof FieldsetInterface) {
                $markup .= $fieldsetHelper($elementOrFieldset);
            } elseif ($elementOrFieldset instanceof ElementInterface) {
                $markup .= call_user_func($elementHelper,$elementOrFieldset);
            }
        }

        // If $templateMarkup is not empty, use it for simplify adding new element in JavaScript
        if (!empty($templateMarkup)) {
            $markup .= $templateMarkup;
        }

        // Every collection is wrapped by a fieldset if needed
        if ($this->shouldWrap) {
            $label = $element->getLabel();
            $legend = '';

            if (!empty($label)) {

                if (null !== ($translator = $this->getTranslator())) {
                    $label = $translator->translate(
                        $label,
                        $this->getTranslatorTextDomain()
                    );
                }

                $label = $escapeHtmlHelper($label);

                $legend = sprintf(
                    '<legend>%s</legend>',
                    $label
                );
            }

            $attributesString = $this->createAttributesString($attributes);
            if (!empty($attributesString)) {
                $attributesString = ' ' . $attributesString;
            }

            $markup = $legend.$markup;
        }

        return $markup;
    }
}