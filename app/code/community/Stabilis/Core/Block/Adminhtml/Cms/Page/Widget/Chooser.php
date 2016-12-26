<?php

class Stabilis_Core_Block_Adminhtml_Cms_Page_Widget_Chooser extends Mage_Adminhtml_Block_Cms_Page_Widget_Chooser {

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
            '*/cms_page_widget/chooser', 
            array(
                'uniq_id' => $element->getForm()->getHtmlIdPrefix() . $uniqId . $element->getForm()->getHtmlIdSuffix(), 
            )
        );

        $chooser = $this->getLayout()->createBlock('stabilis/adminhtml_widget_chooser')
            ->setElement($element)
            ->setTranslationHelper(Mage::helper('stabilis'))
            ->setConfig(
                array(
                    'button' => array(
                        'open' => Mage::helper('stabilis')->__('Select CMS Page...')
                    )
                )
            )
            ->setFieldsetId($this->getFieldsetId())
            ->setSourceUrl($sourceUrl)
            ->setUniqId($uniqId);

        $element->setDependencyId($element->getForm()->getHtmlIdPrefix() . $uniqId . $element->getForm()->getHtmlIdSuffix() . 'label');
        $this->setDependencyId($element->getForm()->getHtmlIdPrefix() . $uniqId . $element->getForm()->getHtmlIdSuffix() . 'value');

        if ($element->getValue()) {
            $page = Mage::getModel('cms/page')->load((int)$element->getValue());
            if ($page->getId()) {
                $chooser->setLabel($page->getTitle());
            }
        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }
}
