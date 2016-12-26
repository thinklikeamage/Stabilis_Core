<?php

class Stabilis_Core_Block_Adminhtml_Catalog_Product_Widget_Chooser extends Mage_Adminhtml_Block_Catalog_Product_Widget_Chooser {
    
    /**
     * Prepare chooser element HTML
     *
     * @param Varien_Data_Form_Element_Abstract $element Form Element
     * @return Varien_Data_Form_Element_Abstract
     */
    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $uniqId = Mage::helper('core')->uniqHash($element->getId());

        $sourceUrl = $this->getUrl('*/catalog_product_widget/chooser', array(
            'uniq_id' => $element->getForm()->getHtmlIdPrefix() . $uniqId . $element->getForm()->getHtmlIdSuffix(),
            'use_massaction' => false,
        ));

        $chooser = $this->getLayout()->createBlock('stabilis/adminhtml_widget_chooser')
            ->setElement($element)
            ->setTranslationHelper(Mage::helper('stabilis'))
            ->setConfig(
                array(
                    'button' => array(
                        'open'  => Mage::helper('stabilis')->__('Select Product...')
                    )
                )
            )->setFieldsetId($this->getFieldsetId())
            ->setSourceUrl($sourceUrl)
            ->setUniqId($uniqId);

        $element->setDependencyId($element->getForm()->getHtmlIdPrefix() . $uniqId . $element->getForm()->getHtmlIdSuffix() . 'label');
        $this->setDependencyId($element->getForm()->getHtmlIdPrefix() . $uniqId . $element->getForm()->getHtmlIdSuffix() . 'value');

        if ($element->getValue()) {
            $value = explode('/', $element->getValue());
            $productId = false;
            if (isset($value[0]) && isset($value[1]) && $value[0] == 'product') {
                $productId = $value[1];
            }
            $categoryId = isset($value[2]) ? $value[2] : false;
            $label = '';
            if ($categoryId) {
                $label = Mage::getResourceSingleton('catalog/category')
                    ->getAttributeRawValue($categoryId, 'name', Mage::app()->getStore()) . '/';
            }
            if ($productId) {
                $label .= Mage::getResourceSingleton('catalog/product')
                    ->getAttributeRawValue($productId, 'name', Mage::app()->getStore());
            }
            $chooser->setLabel($label);
        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }   
}
