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
 * Magazine collection resource model
 *
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Fabrice Fetsch
 */
class Unideal_Topads_Model_Resource_Magazine_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract {
    protected $_joinedFields = array();
    /**
     * constructor
     * @access public
     * @return void
     * @author Fabrice Fetsch
     */
    protected function _construct(){
        parent::_construct();
        $this->_init('unideal_topads/magazine');
        $this->_map['fields']['store'] = 'store_table.store_id';
    }
    /**
     * Add filter by store
     * @access public
     * @param int|Mage_Core_Model_Store $store
     * @param bool $withAdmin
     * @return Unideal_Topads_Model_Resource_Magazine_Collection
     * @author Fabrice Fetsch
     */
    public function addStoreFilter($store, $withAdmin = true){
        if (!isset($this->_joinedFields['store'])){
            if ($store instanceof Mage_Core_Model_Store) {
                $store = array($store->getId());
            }
            if (!is_array($store)) {
                $store = array($store);
            }
            if ($withAdmin) {
                $store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
            }
            $this->addFilter('store', array('in' => $store), 'public');
            $this->_joinedFields['store'] = true;
        }
        return $this;
    }
    /**
     * Join store relation table if there is store filter
     * @access protected
     * @return Unideal_Topads_Model_Resource_Magazine_Collection
     * @author Fabrice Fetsch
     */
    protected function _renderFiltersBefore(){
        if ($this->getFilter('store')) {
            $this->getSelect()->join(
                array('store_table' => $this->getTable('unideal_topads/magazine_store')),
                'main_table.entity_id = store_table.magazine_id',
                array()
            )->group('main_table.entity_id');
            /*
             * Allow analytic functions usage because of one field grouping
             */
            $this->_useAnalyticFunction = true;
        }
        return parent::_renderFiltersBefore();
    }
    /**
     * get magazines as array
     * @access protected
     * @param string $valueField
     * @param string $labelField
     * @param array $additional
     * @return array
     * @author Fabrice Fetsch
     */
    protected function _toOptionArray($valueField='entity_id', $labelField='name', $additional=array()){
        return parent::_toOptionArray($valueField, $labelField, $additional);
    }
    /**
     * get options hash
     * @access protected
     * @param string $valueField
     * @param string $labelField
     * @return array
     * @author Fabrice Fetsch
     */
    protected function _toOptionHash($valueField='entity_id', $labelField='name'){
        return parent::_toOptionHash($valueField, $labelField);
    }
    /**
     * Get SQL for get record count.
     * Extra GROUP BY strip added.
     * @access public
     * @return Varien_Db_Select
     * @author Fabrice Fetsch
     */
    public function getSelectCountSql(){
        $countSelect = parent::getSelectCountSql();
        $countSelect->reset(Zend_Db_Select::GROUP);
        return $countSelect;
    }
}
