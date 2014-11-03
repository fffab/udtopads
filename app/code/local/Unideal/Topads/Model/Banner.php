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
 * Banner model
 *
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Ultimate Module Creator
 */
class Unideal_Topads_Model_Banner
    extends Mage_Core_Model_Abstract {
    /**
     * Entity code.
     * Can be used as part of method name for entity processing
     */
    const ENTITY    = 'unideal_topads_banner';
    const CACHE_TAG = 'unideal_topads_banner';
    /**
     * Prefix of model events names
     * @var string
     */
    protected $_eventPrefix = 'unideal_topads_banner';

    /**
     * Parameter name in event
     * @var string
     */
    protected $_eventObject = 'banner';
    protected $_productInstance = null;
    /**
     * constructor
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function _construct(){
        parent::_construct();
        $this->_init('unideal_topads/banner');
    }
    /**
     * before save banner
     * @access protected
     * @return Unideal_Topads_Model_Banner
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
     * save banner relation
     * @access public
     * @return Unideal_Topads_Model_Banner
     * @author Ultimate Module Creator
     */
    protected function _afterSave() {
        $this->getProductInstance()->saveBannerRelation($this);
        return parent::_afterSave();
    }
    /**
     * get product relation model
     * @access public
     * @return Unideal_Topads_Model_Banner_Product
     * @author Ultimate Module Creator
     */
    public function getProductInstance(){
        if (!$this->_productInstance) {
            $this->_productInstance = Mage::getSingleton('unideal_topads/banner_product');
        }
        return $this->_productInstance;
    }
    /**
     * get selected products array
     * @access public
     * @return array
     * @author Ultimate Module Creator
     */
    public function getSelectedProducts(){
        if (!$this->hasSelectedProducts()) {
            $products = array();
            foreach ($this->getSelectedProductsCollection() as $product) {
                $products[] = $product;
            }
            $this->setSelectedProducts($products);
        }
        return $this->getData('selected_products');
    }
    /**
     * Retrieve collection selected products
     * @access public
     * @return Unideal_Topads_Resource_Banner_Product_Collection
     * @author Ultimate Module Creator
     */
    public function getSelectedProductsCollection(){
        $collection = $this->getProductInstance()->getProductCollection($this);
        return $collection;
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
        $values['name'] = 'Name of the banner';

        return $values;
    }
}
