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
 * Banner - product controller
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Ultimate Module Creator
 */
require_once ("Mage/Adminhtml/controllers/Catalog/ProductController.php");
class Unideal_Topads_Adminhtml_Topads_Banner_Catalog_ProductController
    extends Mage_Adminhtml_Catalog_ProductController {
    /**
     * construct
     * @access protected
     * @return void
     * @author Ultimate Module Creator
     */
    protected function _construct(){
        // Define module dependent translate
        $this->setUsedModuleName('Unideal_Topads');
    }
    /**
     * banners in the catalog page
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function bannersAction(){
        $this->_initProduct();
        $this->loadLayout();
        $this->getLayout()->getBlock('product.edit.tab.banner')
            ->setProductBanners($this->getRequest()->getPost('product_banners', null));
        $this->renderLayout();
    }
    /**
     * banners grid in the catalog page
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function bannersGridAction(){
        $this->_initProduct();
        $this->loadLayout();
        $this->getLayout()->getBlock('product.edit.tab.banner')
            ->setProductBanners($this->getRequest()->getPost('product_banners', null));
        $this->renderLayout();
    }
}
