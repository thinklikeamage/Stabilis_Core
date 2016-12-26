<?php

class Stabilis_Core_Block_Adminhtml_Catalog_Category_Widget_Chooser extends Mage_Adminhtml_Block_Catalog_Category_Widget_Chooser {

    /**
     * Prepare chooser element HTML
     *
     * @param Varien_Data_Form_Element_Abstract $element Form Element
     * @return Varien_Data_Form_Element_Abstract
     */
    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $uniqId = Mage::helper('core')->uniqHash($element->getId());
        
        $sourceUrl = $this->getUrl(
            '*/catalog_category_widget/chooser', 
            array(
                'uniq_id' => $element->getForm()->getHtmlIdPrefix() . $uniqId . $element->getForm()->getHtmlIdSuffix(), 
                'use_massaction' => false
            )
        );

        $chooser = $this->getLayout()->createBlock('stabilis/adminhtml_widget_chooser')
            ->setElement($element)
            ->setTranslationHelper(Mage::helper('stabilis'))
            ->setConfig(
                array(
                    'button' => array(
                        'open' => Mage::helper('stabilis')->__('Select Category...')
                    )
                )
            )
            ->setFieldsetId($this->getFieldsetId())
            ->setSourceUrl($sourceUrl)
            ->setUniqId($uniqId);

        $element->setDependencyId($element->getForm()->getHtmlIdPrefix() . $uniqId . $element->getForm()->getHtmlIdSuffix() . 'label');
        $this->setDependencyId($element->getForm()->getHtmlIdPrefix() . $uniqId . $element->getForm()->getHtmlIdSuffix() . 'value');
        
        if ($element->getValue()) {
            $value = explode('/', $element->getValue());
            $categoryId = false;
            if (isset($value[0]) && isset($value[1]) && $value[0] == 'category') {
                $categoryId = $value[1];
            }
            if ($categoryId) {
                $label = $this->_getModelAttributeByEntityId('catalog/category', 'name', $categoryId);
                $chooser->setLabel($label);
            }
        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }
}