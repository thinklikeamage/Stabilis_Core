<?php

abstract class Stabilis_Core_Controller_Front_Action extends Mage_Core_Controller_Front_Action {
    
    protected abstract function _getHelper();
    
    public function preDispatch() {
        $helper = $this->_getHelper();
        /* @var $helper Stabilis_Core_Helper_Abstract */
        
        if(!$helper->isModuleEnabled()) {
            $this->setFlag($this->getRequest()->getActionName(), self::FLAG_NO_DISPATCH, true);
            $this->_redirectReferer();
        } else {
            return parent::preDispatch();
        }
    }
    
}
