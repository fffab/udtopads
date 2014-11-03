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
 * Banner admin edit tabs
 *
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Ultimate Module Creator
 */
class Unideal_Topads_Block_Adminhtml_Banner_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs {
    /**
     * Initialize Tabs
     * @access public
     * @author Ultimate Module Creator
     */
    public function __construct() {
        parent::__construct();
        $this->setId('banner_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('unideal_topads')->__('Banner'));
    }
    /**
     * before render html
     * @access protected
     * @return Unideal_Topads_Block_Adminhtml_Banner_Edit_Tabs
     * @author Ultimate Module Creator
     */
    protected function _beforeToHtml(){
        $this->addTab('form_banner', array(
            'label'        => Mage::helper('unideal_topads')->__('Banner'),
            'title'        => Mage::helper('unideal_topads')->__('Banner'),
            'content'     => $this->getLayout()->createBlock('unideal_topads/adminhtml_banner_edit_tab_form')->toHtml(),
        ));
        if (!Mage::app()->isSingleStoreMode()){
            $this->addTab('form_store_banner', array(
                'label'        => Mage::helper('unideal_topads')->__('Store views'),
                'title'        => Mage::helper('unideal_topads')->__('Store views'),
                'content'     => $this->getLayout()->createBlock('unideal_topads/adminhtml_banner_edit_tab_stores')->toHtml(),
            ));
        }
        $this->addTab('products', array(
            'label' => Mage::helper('unideal_topads')->__('Associated products'),
            'url'   => $this->getUrl('*/*/products', array('_current' => true)),
            'class'    => 'ajax'
        ));
        return parent::_beforeToHtml();
    }
    /**
     * Retrieve banner entity
     * @access public
     * @return Unideal_Topads_Model_Banner
     * @author Ultimate Module Creator
     */
    public function getBanner(){
        return Mage::registry('current_banner');
    }
}
