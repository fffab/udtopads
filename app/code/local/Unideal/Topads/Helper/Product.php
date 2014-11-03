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
 * Product helper
 *
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Ultimate Module Creator
 */
class Unideal_Topads_Helper_Product
    extends Unideal_Topads_Helper_Data {
    /**
     * get the selected banners for a product
     * @access public
     * @param Mage_Catalog_Model_Product $product
     * @return array()
     * @author Ultimate Module Creator
     */
    public function getSelectedBanners(Mage_Catalog_Model_Product $product){
        if (!$product->hasSelectedBanners()) {
            $banners = array();
            foreach ($this->getSelectedBannersCollection($product) as $banner) {
                $banners[] = $banner;
            }
            $product->setSelectedBanners($banners);
        }
        return $product->getData('selected_banners');
    }
    /**
     * get banner collection for a product
     * @access public
     * @param Mage_Catalog_Model_Product $product
     * @return Unideal_Topads_Model_Resource_Banner_Collection
     * @author Ultimate Module Creator
     */
    public function getSelectedBannersCollection(Mage_Catalog_Model_Product $product){
        $collection = Mage::getResourceSingleton('unideal_topads/banner_collection')
            ->addProductFilter($product);
        return $collection;
    }
}
