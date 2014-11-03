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
 * Magazine admin edit tabs
 *
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Fabrice Fetsch
 */
class Unideal_Topads_Block_Adminhtml_Magazine_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs {
    /**
     * Initialize Tabs
     * @access public
     * @author Fabrice Fetsch
     */
    public function __construct() {
        parent::__construct();
        $this->setId('magazine_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('unideal_topads')->__('Magazine'));
    }
    /**
     * before render html
     * @access protected
     * @return Unideal_Topads_Block_Adminhtml_Magazine_Edit_Tabs
     * @author Fabrice Fetsch
     */
    protected function _beforeToHtml(){
        $this->addTab('form_magazine', array(
            'label'        => Mage::helper('unideal_topads')->__('Magazine'),
            'title'        => Mage::helper('unideal_topads')->__('Magazine'),
            'content'     => $this->getLayout()->createBlock('unideal_topads/adminhtml_magazine_edit_tab_form')->toHtml(),
        ));
        if (!Mage::app()->isSingleStoreMode()){
            $this->addTab('form_store_magazine', array(
                'label'        => Mage::helper('unideal_topads')->__('Store views'),
                'title'        => Mage::helper('unideal_topads')->__('Store views'),
                'content'     => $this->getLayout()->createBlock('unideal_topads/adminhtml_magazine_edit_tab_stores')->toHtml(),
            ));
        }
        return parent::_beforeToHtml();
    }
    /**
     * Retrieve magazine entity
     * @access public
     * @return Unideal_Topads_Model_Magazine
     * @author Fabrice Fetsch
     */
    public function getMagazine(){
        return Mage::registry('current_magazine');
    }
}
