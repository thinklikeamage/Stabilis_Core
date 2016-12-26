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
 * Form renderer block for admin users.
 * 
 * @category    Stabilis
 * @package     Stabilis_Core
 * @author      Luke A. Leber <lukeleber@gmail.com>
 */
class Stabilis_Core_Block_Adminhtml_Widget_Form_Renderer_Admin_User extends Varien_Data_Form_Element_Abstract {

    /** @var string XML system configuration path for the admin user grid renderer format field */
    const XML_PATH_STABILIS_CORE_FORM_RENDERER_ADMIN_USER_FORMAT = 'stabilis_core/form_renderer/admin_user_format';

    /** @var string Fallback format in the event that no format is defined by the system configuration */
    const FALLBACK_FORMAT = '%s %s <%s>';
    
    /**
     * Internal Constructor
     */
    protected function _construct() {
        parent::_construct();
        $this->setType('admin_user');
    }
    
    /**
     * Retrieves the element HTML of the user whose ID is set as the value of this field.  This method 
     * shall return the translated string "N/A" if no value is set or if the user does not exist.
     * 
     * @return string
     */
    protected function _getElementHtml() {

        $value = $this->getValue();
        
        if($value) {
            $user = Mage::getModel('admin/user')->load($value);
            /* @var $user Mage_Admin_Model_User */            
            
            if($user->getId()) {
                $format = Mage::getStoreConfig(self::XML_PATH_STABILIS_CORE_FORM_RENDERER_ADMIN_USER_FORMAT);
                return '<span id="' . $this->getHtmlId() . '">' . 
                        Mage::helper('core')->escapeHtml(
                            sprintf($format ? $format : static::FALLBACK_FORMAT, 
                                    $user->getFirstname(), 
                                    $user->getLastname(), 
                                    $user->getEmail())) . 
                        '</span>' . $this->getAfterElementHtml();
            }
        }
        return Mage::helper('sslider')->__('N/A');
    }
    
    /**
     * Retrieves the element HTML of the user whose ID is set as the value of this field.  <strong>Please 
     * overide the protected {@link _getElementHtml} method if you wish to override this method.</strong>
     * 
     * @return string
     */
    public /*final*/ function getElementHtml() {
        if(!$this->hasData('element_html')) {
            $this->setData('element_html', $this->_getElementHtml());
        }
        return $this->getData('element_html');
    }
    
}
