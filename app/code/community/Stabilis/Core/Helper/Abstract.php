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
 * Abstract helper class for all Stabilis extensions.
 *
 * @category    Stabilis
 * @package     Stabilis_Core
 * @author      Luke A. Leber <lukeleber@gmail.com>
 */
abstract class Stabilis_Core_Helper_Abstract extends Mage_Core_Helper_Abstract {

    /** @var string constant for the event emitted before pseudo-construction */
    const EVENT_PRE_PSEUDO_CONSTRUCTOR = 'stabilis_core_helper_pseudoconstruct_before';

    /** @var string constant for the event emitted when pseudo-construction fails with an exception */
    const EVENT_PSEUDO_CONSTRUCTOR_EXCEPTION = 'stabilis_core_helper_pseudoconstruct_exception';

    /** @var string constant for the event emitted after pseudo-construction */
    const EVENT_POST_PSEUDO_CONSTRUCTOR = 'stabilis_core_helper_pseudoconstruct_after';

    /** @var $data Varien_Object */
    protected $_data;

    /**
     * Wrapper for Mage::logException, although this behavior can be changed in derived classes.
     *
     * @param Exception $e the exception to log
     * 
     * @return \Stabilis_Core_Helper_Abstract $this
     */
    public function logException(Exception $e) {
        Mage::logException($e);
        return $this;
    }

    /**
     * Pseudo-constructor
     *
     * @return \Stabilis_Core_Helper_Abstract
     *
     * @throws Exception
     */
    protected function _construct() {
        return $this;
    }

    /**
     * Internal constructor
     *
     * Please override the {@link Stabilis_Core_Helper_Abstract::_construct} method instead.
     *
     * @throws Exception if the pseudo-constructor fails with an exception.
     *
     */
    public final function __construct() {
        $this->_data = new Varien_Object(func_get_args());
        Mage::dispatchEvent(self::EVENT_PRE_PSEUDO_CONSTRUCTOR, array('helper' => $this));
        try {
            $result = $this->_construct();
        } catch(Exception $e) {
            $this->logException($e);
            Mage::dispatchEvent(self::EVENT_PSEUDO_CONSTRUCTOR_EXCEPTION, array('helper' => $this, 'exception' => $e));
            throw $e;
        }
        Mage::dispatchEvent(self::EVENT_POST_PSEUDO_CONSTRUCTOR, array('helper' => $this, 'result' => $result));
    }

    /**
     * If $key is empty, checks whether there's any data in the object
     * Otherwise checks if the specified attribute is set.
     *
     * @param string $key
     * @return boolean
     */
    public function hasData($key = '') {
        return $this->_data->hasData($key);
    }

    /**
     * Overwrite data in the object.
     *
     * $key can be string or array.
     * If $key is string, the attribute value will be overwritten by $value
     *
     * If $key is an array, it will overwrite all the data in the object.
     *
     * $isChanged will specify if the object needs to be saved after an update.
     *
     * @param string|array $key
     * @param mixed $value
     * @param boolean $isChanged
     * @return Varien_Object
     */
    public function setData($key, $value = null) {
        return $this->_data->setData($key, $value);
    }

    /**
     * Retrieves data from the object
     *
     * If $key is empty will return all the data as an array
     * Otherwise it will return value of the attribute specified by $key
     *
     * If $index is specified it will assume that attribute data is an array
     * and retrieve corresponding member.
     *
     * @param string $key
     * @param string|int $index
     * @param mixed $default
     * @return mixed
     */
    public function getData($key = '', $index = null) {
        return $this->_data->getData($key, $index);
    }    
}
