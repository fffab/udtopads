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
 * Banner - product relation model
 *
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Ultimate Module Creator
 */
class Unideal_Topads_Model_Resource_Banner_Product
    extends Mage_Core_Model_Resource_Db_Abstract {
    /**
     * initialize resource model
     * @access protected
     * @see Mage_Core_Model_Resource_Abstract::_construct()
     * @author Ultimate Module Creator
     */
    protected function  _construct(){
        $this->_init('unideal_topads/banner_product', 'rel_id');
    }
    /**
     * Save banner - product relations
     * @access public
     * @param Unideal_Topads_Model_Banner $banner
     * @param array $data
     * @return Unideal_Topads_Model_Resource_Banner_Product
     * @author Ultimate Module Creator
     */
    public function saveBannerRelation($banner, $data){
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('banner_id=?', $banner->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $productId => $info) {
            $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                'banner_id'      => $banner->getId(),
                'product_id'     => $productId,
                'position'      => @$info['position']
            ));
        }
        return $this;
    }
    /**
     * Save  product - banner relations
     * @access public
     * @param Mage_Catalog_Model_Product $prooduct
     * @param array $data
     * @return Unideal_Topads_Model_Resource_Banner_Product
     * @@author Ultimate Module Creator
     */
    public function saveProductRelation($product, $data){
        if (!is_array($data)) {
            $data = array();
        }
        $deleteCondition = $this->_getWriteAdapter()->quoteInto('product_id=?', $product->getId());
        $this->_getWriteAdapter()->delete($this->getMainTable(), $deleteCondition);

        foreach ($data as $bannerId => $info) {
            $this->_getWriteAdapter()->insert($this->getMainTable(), array(
                'banner_id' => $bannerId,
                'product_id' => $product->getId(),
                'position'   => @$info['position']
            ));
        }
        return $this;
    }
}
