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
 * Banner - product relation resource model collection
 *
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Ultimate Module Creator
 */
class Unideal_Topads_Model_Resource_Banner_Product_Collection
    extends Mage_Catalog_Model_Resource_Product_Collection {
    /**
     * remember if fields have been joined
     * @var bool
     */
    protected $_joinedFields = false;
    /**
     * join the link table
     * @access public
     * @return Unideal_Topads_Model_Resource_Banner_Product_Collection
     * @author Ultimate Module Creator
     */
    public function joinFields(){
        if (!$this->_joinedFields){
            $this->getSelect()->join(
                array('related' => $this->getTable('unideal_topads/banner_product')),
                'related.product_id = e.entity_id',
                array('position')
            );
            $this->_joinedFields = true;
        }
        return $this;
    }
    /**
     * add banner filter
     * @access public
     * @param Unideal_Topads_Model_Banner | int $banner
     * @return Unideal_Topads_Model_Resource_Banner_Product_Collection
     * @author Ultimate Module Creator
     */
    public function addBannerFilter($banner){
        if ($banner instanceof Unideal_Topads_Model_Banner){
            $banner = $banner->getId();
        }
        if (!$this->_joinedFields){
            $this->joinFields();
        }
        $this->getSelect()->where('related.banner_id = ?', $banner);
        return $this;
    }
}
