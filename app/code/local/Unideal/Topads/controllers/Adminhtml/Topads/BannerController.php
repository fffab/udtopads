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
 * Banner admin controller
 *
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Fabrice Fetsch
 */
class Unideal_Topads_Adminhtml_Topads_BannerController
    extends Unideal_Topads_Controller_Adminhtml_Topads {
    /**
     * init the banner
     * @access protected
     * @return Unideal_Topads_Model_Banner
     */
    protected function _initBanner(){
        $bannerId  = (int) $this->getRequest()->getParam('id');
        $banner    = Mage::getModel('unideal_topads/banner');
        if ($bannerId) {
            $banner->load($bannerId);
        }
        Mage::register('current_banner', $banner);
        return $banner;
    }
     /**
     * default action
     * @access public
     * @return void
     * @author Fabrice Fetsch
     */
    public function indexAction() {
        $this->loadLayout();
        $this->_title(Mage::helper('unideal_topads')->__('Image Banners'))
             ->_title(Mage::helper('unideal_topads')->__('Banners'));
        $this->renderLayout();
    }
    /**
     * grid action
     * @access public
     * @return void
     * @author Fabrice Fetsch
     */
    public function gridAction() {
        $this->loadLayout()->renderLayout();
    }
    /**
     * edit banner - action
     * @access public
     * @return void
     * @author Fabrice Fetsch
     */
    public function editAction() {
        $bannerId    = $this->getRequest()->getParam('id');
        $banner      = $this->_initBanner();
        if ($bannerId && !$banner->getId()) {
            $this->_getSession()->addError(Mage::helper('unideal_topads')->__('This banner no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getBannerData(true);
        if (!empty($data)) {
            $banner->setData($data);
        }
        Mage::register('banner_data', $banner);
        $this->loadLayout();
        $this->_title(Mage::helper('unideal_topads')->__('Image Banners'))
             ->_title(Mage::helper('unideal_topads')->__('Banners'));
        if ($banner->getId()){
            $this->_title($banner->getName());
        }
        else{
            $this->_title(Mage::helper('unideal_topads')->__('Add banner'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }
    /**
     * new banner action
     * @access public
     * @return void
     * @author Fabrice Fetsch
     */
    public function newAction() {
        $this->_forward('edit');
    }
    /**
     * save banner - action
     * @access public
     * @return void
     * @author Fabrice Fetsch
     */
    public function saveAction() {
        if ($data = $this->getRequest()->getPost('banner')) {
            try {
                $banner = $this->_initBanner();
                $banner->addData($data);
                $imageName = $this->_uploadAndGetName('image', Mage::helper('unideal_topads/banner_image')->getImageBaseDir(), $data);
                $banner->setData('image', $imageName);
                $banner->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('unideal_topads')->__('Banner was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $banner->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                if (isset($data['image']['value'])){
                    $data['image'] = $data['image']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setBannerData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['image']['value'])){
                    $data['image'] = $data['image']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('unideal_topads')->__('There was a problem saving the banner.'));
                Mage::getSingleton('adminhtml/session')->setBannerData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('unideal_topads')->__('Unable to find banner to save.'));
        $this->_redirect('*/*/');
    }
    /**
     * delete banner - action
     * @access public
     * @return void
     * @author Fabrice Fetsch
     */
    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0) {
            try {
                $banner = Mage::getModel('unideal_topads/banner');
                $banner->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('unideal_topads')->__('Banner was successfully deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('unideal_topads')->__('There was an error deleting banner.'));
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('unideal_topads')->__('Could not find banner to delete.'));
        $this->_redirect('*/*/');
    }
    /**
     * mass delete banner - action
     * @access public
     * @return void
     * @author Fabrice Fetsch
     */
    public function massDeleteAction() {
        $bannerIds = $this->getRequest()->getParam('banner');
        if(!is_array($bannerIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('unideal_topads')->__('Please select banners to delete.'));
        }
        else {
            try {
                foreach ($bannerIds as $bannerId) {
                    $banner = Mage::getModel('unideal_topads/banner');
                    $banner->setId($bannerId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('unideal_topads')->__('Total of %d banners were successfully deleted.', count($bannerIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('unideal_topads')->__('There was an error deleting banners.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass status change - action
     * @access public
     * @return void
     * @author Fabrice Fetsch
     */
    public function massStatusAction(){
        $bannerIds = $this->getRequest()->getParam('banner');
        if(!is_array($bannerIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('unideal_topads')->__('Please select banners.'));
        }
        else {
            try {
                foreach ($bannerIds as $bannerId) {
                $banner = Mage::getSingleton('unideal_topads/banner')->load($bannerId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d banners were successfully updated.', count($bannerIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('unideal_topads')->__('There was an error updating banners.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * export as csv - action
     * @access public
     * @return void
     * @author Fabrice Fetsch
     */
    public function exportCsvAction(){
        $fileName   = 'banner.csv';
        $content    = $this->getLayout()->createBlock('unideal_topads/adminhtml_banner_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as MsExcel - action
     * @access public
     * @return void
     * @author Fabrice Fetsch
     */
    public function exportExcelAction(){
        $fileName   = 'banner.xls';
        $content    = $this->getLayout()->createBlock('unideal_topads/adminhtml_banner_grid')->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as xml - action
     * @access public
     * @return void
     * @author Fabrice Fetsch
     */
    public function exportXmlAction(){
        $fileName   = 'banner.xml';
        $content    = $this->getLayout()->createBlock('unideal_topads/adminhtml_banner_grid')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * Check if admin has permissions to visit related pages
     * @access protected
     * @return boolean
     * @author Fabrice Fetsch
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('cms/unideal_topads/banner');
    }
}
