<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Stabilis to newer
 * versions in the future. If you wish to customize Stabilis for your
 * needs please do so within the local code pool.
 *
 * @category    Stabilis
 * @package     Stabilis_Core
 * @copyright  Copyright (c) 2007-2016 Luke A. Leber (https://www.thinklikeamage.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * A tab friendly chooser widget that works with form html id prefixes and suffixes.
 *
 * @category    Stabilis
 * @package     Stabilis_Core
 * @author      Luke A. Leber <lukeleber@gmail.com>
 */
class Stabilis_Core_Block_Adminhtml_Widget_Chooser extends Mage_Widget_Block_Adminhtml_Widget_Chooser {
    
    /**
     * Return chooser HTML and init scripts
     *
     * @return string
     */
    protected function _toHtml()
    {
        $element   = $this->getElement();
        /* @var $element Varien_Data_Form_Element_Abstract */
        
        $fieldset  = $element->getForm()->getElement($this->getFieldsetId());
        /* @var $fieldset Varien_Data_Form_Element_Fieldset */
        
        $chooserId = $this->getUniqId();
        $config    = $this->getConfig();

        // add chooser element to fieldset
        $chooser = $fieldset->addField('chooser' . $element->getId(), 'note', array(
            'label'       => $config->getLabel() ? $config->getLabel() : '',
            'value_class' => 'value2',
        ));
        $hiddenHtml = '';
        if ($this->getHiddenEnabled()) {
            $hidden = new Varien_Data_Form_Element_Hidden($element->getData());
            $hidden->setId("{$chooserId}value")->setForm($element->getForm());
            if ($element->getRequired()) {
                $hidden->addClass('required-entry');
            }
            $hiddenHtml = $hidden->getElementHtml();
            $element->setValue('');
        }

        $chooserId = $element->getForm()->getHtmlIdPrefix() . $chooserId . $element->getForm()->getHtmlIdSuffix();
        
        $buttons = $config->getButtons();
        $chooseButton = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setType('button')
            ->setId($chooserId . 'control')
            ->setClass('btn-chooser')
            ->setLabel($buttons['open'])
            ->setOnclick($chooserId.'.choose()')
            ->setDisabled($element->getReadonly());
        $chooser->setData('after_element_html', $hiddenHtml . $chooseButton->toHtml());

        // render label and chooser scripts
        $configJson = Mage::helper('core')->jsonEncode($config->getData());
        return '
            <label class="widget-option-label" id="' . $chooserId . 'label">'
            . $this->quoteEscape($this->getLabel() ? $this->getLabel() : Mage::helper('widget')->__('Not Selected'))
            . '</label>
            <div id="' . $chooserId . 'advice-container" class="hidden"></div>
            <script type="text/javascript">//<![CDATA[
                (function() {
                    var instantiate'.$chooserId.'Chooser = function() {
                        window.' . $chooserId . ' = new WysiwygWidget.chooser(
                            "' . $chooserId . '",
                            "' . $this->getSourceUrl() . '",
                            ' . $configJson . '
                        );
                        if ($("' . $chooserId . 'value")) {
                            $("' . $chooserId . 'value").advaiceContainer = "' . $chooserId . 'advice-container";
                        }
                    }

                    if (document.loaded) { //allow load over ajax
                        instantiate'.$chooserId.'Chooser();
                    } else {
                        document.observe("dom:loaded", instantiate'.$chooserId.'Chooser);
                    }
                })();
            //]]></script>
        ';
    }
}
