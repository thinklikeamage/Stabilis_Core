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
 * Grid renderer block for admin users.
 * 
 * @category    Stabilis
 * @package     Stabilis_Core
 * @author      Luke A. Leber <lukeleber@gmail.com>
 */
class Stabilis_Core_Block_Adminhtml_Widget_Grid_Renderer_Admin_User extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    /** @var string XML system configuration path for the admin user grid renderer format field */
    const XML_PATH_STABILIS_CORE_GRID_RENDERER_ADMIN_USER_FORMAT = 'stabilis_core/grid_renderer/admin_user_format';

    /** @var string Fallback format in the event that no format is defined by the system configuration */
    const FALLBACK_FORMAT = '%s %s <%s>';

    /**
     * Renders the user whose ID is set as the value of this column based upon the configured format.  This method 
     * shall return the translated string "N/A" if no value is set or if the user does not exist.
     * 
     * @param   Varien_Object $row
     * @return  string
     */
    protected function _render(Varien_Object $row) {
        $userId = $row->getData($this->getColumn()->getIndex());
        if($userId) {
            $user = Mage::getModel('admin/user')->load($userId);
            /* @var $user Mage_Admin_Model_User */
            if($user->getId()) {
                $format = Mage::getStoreConfig(self::XML_PATH_STABILIS_CORE_GRID_RENDERER_ADMIN_USER_FORMAT);
                /* @var $format string */
                return $this->escapeHtml(sprintf(
                    $format ? $format : static::FALLBACK_FORMAT, $user->getFirstname(), $user->getLastname(), $user->getEmail()));
            }
        }
        return $this->__('N/A');        
    }
    
    /**
     * Renders the user whose ID is set as the value of this column based upon the configured format.  <strong>Please 
     * overide the protected {@link _render} method if you wish to override this method.</strong>
     * 
     * @param   Varien_Object $row
     * @return  string
     */
    public /*final*/ function render(Varien_Object $row) {
        if(!$this->hasData('html')) {
            $this->setData('html', $this->_render($row));
        }
        return $this->getData('html');
    }
}
