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
 * Magazine resource model
 *
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Fabrice Fetsch
 */
class Unideal_Topads_Model_Resource_Magazine
    extends Mage_Core_Model_Resource_Db_Abstract {
    /**
     * constructor
     * @access public
     * @author Fabrice Fetsch
     */
    public function _construct(){
        $this->_init('unideal_topads/magazine', 'entity_id');
    }
    /**
     * Get store ids to which specified item is assigned
     * @access public
     * @param int $magazineId
     * @return array
     * @author Fabrice Fetsch
     */
    public function lookupStoreIds($magazineId){
        $adapter = $this->_getReadAdapter();
        $select  = $adapter->select()
            ->from($this->getTable('unideal_topads/magazine_store'), 'store_id')
            ->where('magazine_id = ?',(int)$magazineId);
        return $adapter->fetchCol($select);
    }
    /**
     * Perform operations after object load
     * @access public
     * @param Mage_Core_Model_Abstract $object
     * @return Unideal_Topads_Model_Resource_Magazine
     * @author Fabrice Fetsch
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object){
        if ($object->getId()) {
            $stores = $this->lookupStoreIds($object->getId());
            $object->setData('store_id', $stores);
        }
        return parent::_afterLoad($object);
    }

    /**
     * Retrieve select object for load object data
     *
     * @param string $field
     * @param mixed $value
     * @param Unideal_Topads_Model_Magazine $object
     * @return Zend_Db_Select
     */
    protected function _getLoadSelect($field, $value, $object){
        $select = parent::_getLoadSelect($field, $value, $object);
        if ($object->getStoreId()) {
            $storeIds = array(Mage_Core_Model_App::ADMIN_STORE_ID, (int)$object->getStoreId());
            $select->join(
                array('topads_magazine_store' => $this->getTable('unideal_topads/magazine_store')),
                $this->getMainTable() . '.entity_id = topads_magazine_store.magazine_id',
                array()
            )
            ->where('topads_magazine_store.store_id IN (?)', $storeIds)
            ->order('topads_magazine_store.store_id DESC')
            ->limit(1);
        }
        return $select;
    }
    /**
     * Assign magazine to store views
     * @access protected
     * @param Mage_Core_Model_Abstract $object
     * @return Unideal_Topads_Model_Resource_Magazine
     * @author Fabrice Fetsch
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object){
        $oldStores = $this->lookupStoreIds($object->getId());
        $newStores = (array)$object->getStores();
        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }
        $table  = $this->getTable('unideal_topads/magazine_store');
        $insert = array_diff($newStores, $oldStores);
        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = array(
                'magazine_id = ?' => (int) $object->getId(),
                'store_id IN (?)' => $delete
            );
            $this->_getWriteAdapter()->delete($table, $where);
        }
        if ($insert) {
            $data = array();
            foreach ($insert as $storeId) {
                $data[] = array(
                    'magazine_id'  => (int) $object->getId(),
                    'store_id' => (int) $storeId
                );
            }
            $this->_getWriteAdapter()->insertMultiple($table, $data);
        }
        return parent::_afterSave($object);
    }}
