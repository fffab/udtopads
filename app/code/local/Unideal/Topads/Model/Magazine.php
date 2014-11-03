<?php
/**
 * Unideal_Topads extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Unideal
 * @package        Unideal_Topads
 * @copyright      Copyright (c) 2014
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Magazine model
 *
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Ultimate Module Creator
 */
class Unideal_Topads_Model_Magazine
    extends Mage_Core_Model_Abstract {
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'unideal_topads_magazine';
    const CACHE_TAG = 'unideal_topads_magazine';
    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'unideal_topads_magazine';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'magazine';
    /**
     * constructor
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function _construct(){
        parent::_construct();
        $this->_init('unideal_topads/magazine');
    }
    /**
     * before save magazine
     * @access protected
     * @return Unideal_Topads_Model_Magazine
     * @author Ultimate Module Creator
     */
    protected function _beforeSave(){
        parent::_beforeSave();
        $now = Mage::getSingleton('core/date')->gmtDate();
        if ($this->isObjectNew()){
            $this->setCreatedAt($now);
        }
        $this->setUpdatedAt($now);
        return $this;
    }
    /**
     * save magazine relation
     * @access public
     * @return Unideal_Topads_Model_Magazine
     * @author Ultimate Module Creator
     */
    protected function _afterSave() {
        return parent::_afterSave();
    }
    /**
     * get default values
     * @access public
     * @return array
     * @author Ultimate Module Creator
     */
    public function getDefaultValues() {
        $values = array();
        $values['status'] = 1;
        return $values;
    }
}
