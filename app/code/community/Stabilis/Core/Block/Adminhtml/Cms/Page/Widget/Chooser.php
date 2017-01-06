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
 * A tab friendly CMS page chooser that works with form html id prefixes 
 * and suffixes.  This class also adds convenience dependency identifiers.
 *
 * @category    Stabilis
 * @package     Stabilis_Core
 * @author      Luke A. Leber <lukeleber@gmail.com>
 */
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
