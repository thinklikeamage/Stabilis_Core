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
 * Block class that adds numeric input validation to a widget form element
 *
 * @category    Stabilis
 * @package     Stabilis_Core
 * @author      Luke A. Leber <lukeleber@gmail.com>
 */
class Stabilis_Core_Block_Adminhtml_Widget_Form_Renderer_Element_Numeric extends Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset_Element {

    /**
     * Renders the provided element.
     * 
     * @param Varien_Data_Form_Element_Abstract $element the element to render
     * 
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element) {
        $element->setType('text');
        $element->addClass('validate-digits');
        return parent::render($element);
    }
    
}
