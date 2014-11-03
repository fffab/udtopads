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
 * Magazine admin edit form
 *
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Ultimate Module Creator
 */
class Unideal_Topads_Block_Adminhtml_Magazine_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container {
    /**
     * constructor
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function __construct(){
        parent::__construct();
        $this->_blockGroup = 'unideal_topads';
        $this->_controller = 'adminhtml_magazine';
        $this->_updateButton('save', 'label', Mage::helper('unideal_topads')->__('Save Magazine'));
        $this->_updateButton('delete', 'label', Mage::helper('unideal_topads')->__('Delete Magazine'));
        $this->_addButton('saveandcontinue', array(
            'label'        => Mage::helper('unideal_topads')->__('Save And Continue Edit'),
            'onclick'    => 'saveAndContinueEdit()',
            'class'        => 'save',
        ), -100);
        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
    /**
     * get the edit form header
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getHeaderText(){
        if( Mage::registry('current_magazine') && Mage::registry('current_magazine')->getId() ) {
            return Mage::helper('unideal_topads')->__("Edit Magazine '%s'", $this->escapeHtml(Mage::registry('current_magazine')->getName()));
        }
        else {
            return Mage::helper('unideal_topads')->__('Add Magazine');
        }
    }
}
