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
 * Abstract administrator controller action for all Stabilis extensions.
 *
 * @category    Stabilis
 * @package     Stabilis_Core
 * @author      Luke A. Leber <lukeleber@gmail.com>
 */
abstract class Stabilis_Core_Controller_Adminhtml_Abstract extends Mage_Adminhtml_Controller_Action {

    /** @var string identifier for the event dispatched prior to running an ACL check */
    const STABILIS_CONTROLLER_IS_ALLOWED_BEFORE = 'stabilis_controller_is_allowed_before';

    /** @var string identifier for the event dispatched after running an ACL check */
    const STABILIS_CONTROLLER_IS_ALLOWED_AFTER  = 'stabilis_controller_is_allowed_after';

    /**
     * Retrieves the ACL base path to check for this action
     *
     * @return string
     */
    protected abstract function _getAclBasePath();

    /**
     * {@inheritDoc}
     *
     * <strong><em>Stabilis administrator actions require access control granularity down to the action.</em>></strong>
     *
     * @return bool
     */
    protected function _isAllowed() {
        $action = $this->getRequest()->getActionName();
        Mage::dispatchEvent(self::STABILIS_CONTROLLER_IS_ALLOWED_BEFORE, array('controller' => $this, 'action' => $action));
        $allowed = Mage::getSingleton('admin/session')->isAllowed($this->_getAclBasePath() . "/{$action}");
        Mage::dispatchEvent(self::STABILIS_CONTROLLER_IS_ALLOWED_AFTER, array('controller' => $this, 'action' => $action, 'allowed' => $allowed));
        return $allowed;
    }
    
    /**
     * Is the current user allowed to use the provided action?
     * 
     * @param string $action
     * 
     * @return bool
     */
    public function isAllowed($action) {
        return Mage::getSingleton('admin/session')->isAllowed($this->_getAclBasePath() . "/{$action}");
    }
}
