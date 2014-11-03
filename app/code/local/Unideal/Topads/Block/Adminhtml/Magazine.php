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
 * Magazine admin block
 *
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Fabrice Fetsch
 */
class Unideal_Topads_Block_Adminhtml_Magazine
    extends Mage_Adminhtml_Block_Widget_Grid_Container {
    /**
     * constructor
     * @access public
     * @return void
     * @author Fabrice Fetsch
     */
    public function __construct(){
        $this->_controller         = 'adminhtml_magazine';
        $this->_blockGroup         = 'unideal_topads';
        parent::__construct();
        $this->_headerText         = Mage::helper('unideal_topads')->__('Magazine');
        $this->_updateButton('add', 'label', Mage::helper('unideal_topads')->__('Add Magazine'));

    }
}
