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
 * Banner product model
 *
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Ultimate Module Creator
 */
class Unideal_Topads_Model_Banner_Product
    extends Mage_Core_Model_Abstract {
    /**
     * Initialize resource
     * @access protected
     * @return void
     * @author Ultimate Module Creator
     */
    protected function _construct(){
        $this->_init('unideal_topads/banner_product');
    }
    /**
     * Save data for banner-product relation
     * @access public
     * @param  Unideal_Topads_Model_Banner $banner
     * @return Unideal_Topads_Model_Banner_Product
     * @author Ultimate Module Creator
     */
    public function saveBannerRelation($banner){
        $data = $banner->getProductsData();
        if (!is_null($data)) {
            $this->_getResource()->saveBannerRelation($banner, $data);
        }
        return $this;
    }
    /**
     * get products for banner
     * @access public
     * @param Unideal_Topads_Model_Banner $banner
     * @return Unideal_Topads_Model_Resource_Banner_Product_Collection
     * @author Ultimate Module Creator
     */
    public function getProductCollection($banner){
        $collection = Mage::getResourceModel('unideal_topads/banner_product_collection')
            ->addBannerFilter($banner);
        return $collection;
    }
}
