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
 * Magazine admin controller
 *
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Ultimate Module Creator
 */
class Unideal_Topads_Adminhtml_Topads_MagazineController
    extends Unideal_Topads_Controller_Adminhtml_Topads {
    /**
     * init the magazine
     * @access protected
     * @return Unideal_Topads_Model_Magazine
     */
    protected function _initMagazine(){
        $magazineId  = (int) $this->getRequest()->getParam('id');
        $magazine    = Mage::getModel('unideal_topads/magazine');
        if ($magazineId) {
            $magazine->load($magazineId);
        }
        Mage::register('current_magazine', $magazine);
        return $magazine;
    }
     /**
     * default action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function indexAction() {
        $this->loadLayout();
        $this->_title(Mage::helper('unideal_topads')->__('Image Banners'))
             ->_title(Mage::helper('unideal_topads')->__('Magazines'));
        $this->renderLayout();
    }
    /**
     * grid action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function gridAction() {
        $this->loadLayout()->renderLayout();
    }
    /**
     * edit magazine - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction() {
        $magazineId    = $this->getRequest()->getParam('id');
        $magazine      = $this->_initMagazine();
        if ($magazineId && !$magazine->getId()) {
            $this->_getSession()->addError(Mage::helper('unideal_topads')->__('This magazine no longer exists.'));
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getMagazineData(true);
        if (!empty($data)) {
            $magazine->setData($data);
        }
        Mage::register('magazine_data', $magazine);
        $this->loadLayout();
        $this->_title(Mage::helper('unideal_topads')->__('Image Banners'))
             ->_title(Mage::helper('unideal_topads')->__('Magazines'));
        if ($magazine->getId()){
            $this->_title($magazine->getName());
        }
        else{
            $this->_title(Mage::helper('unideal_topads')->__('Add magazine'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }
    /**
     * new magazine action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function newAction() {
        $this->_forward('edit');
    }
    /**
     * save magazine - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction() {
        if ($data = $this->getRequest()->getPost('magazine')) {
            try {
                $magazine = $this->_initMagazine();
                $magazine->addData($data);
                $imageName = $this->_uploadAndGetName('image', Mage::helper('unideal_topads/magazine_image')->getImageBaseDir(), $data);
                $magazine->setData('image', $imageName);
                $magazine->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('unideal_topads')->__('Magazine was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $magazine->getId()));
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
                Mage::getSingleton('adminhtml/session')->setMagazineData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            catch (Exception $e) {
                Mage::logException($e);
                if (isset($data['image']['value'])){
                    $data['image'] = $data['image']['value'];
                }
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('unideal_topads')->__('There was a problem saving the magazine.'));
                Mage::getSingleton('adminhtml/session')->setMagazineData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('unideal_topads')->__('Unable to find magazine to save.'));
        $this->_redirect('*/*/');
    }
    /**
     * delete magazine - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0) {
            try {
                $magazine = Mage::getModel('unideal_topads/magazine');
                $magazine->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('unideal_topads')->__('Magazine was successfully deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('unideal_topads')->__('There was an error deleting magazine.'));
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('unideal_topads')->__('Could not find magazine to delete.'));
        $this->_redirect('*/*/');
    }
    /**
     * mass delete magazine - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction() {
        $magazineIds = $this->getRequest()->getParam('magazine');
        if(!is_array($magazineIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('unideal_topads')->__('Please select magazines to delete.'));
        }
        else {
            try {
                foreach ($magazineIds as $magazineId) {
                    $magazine = Mage::getModel('unideal_topads/magazine');
                    $magazine->setId($magazineId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('unideal_topads')->__('Total of %d magazines were successfully deleted.', count($magazineIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('unideal_topads')->__('There was an error deleting magazines.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * mass status change - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massStatusAction(){
        $magazineIds = $this->getRequest()->getParam('magazine');
        if(!is_array($magazineIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('unideal_topads')->__('Please select magazines.'));
        }
        else {
            try {
                foreach ($magazineIds as $magazineId) {
                $magazine = Mage::getSingleton('unideal_topads/magazine')->load($magazineId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d magazines were successfully updated.', count($magazineIds)));
            }
            catch (Mage_Core_Exception $e){
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('unideal_topads')->__('There was an error updating magazines.'));
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }
    /**
     * export as csv - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportCsvAction(){
        $fileName   = 'magazine.csv';
        $content    = $this->getLayout()->createBlock('unideal_topads/adminhtml_magazine_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as MsExcel - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportExcelAction(){
        $fileName   = 'magazine.xls';
        $content    = $this->getLayout()->createBlock('unideal_topads/adminhtml_magazine_grid')->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * export as xml - action
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportXmlAction(){
        $fileName   = 'magazine.xml';
        $content    = $this->getLayout()->createBlock('unideal_topads/adminhtml_magazine_grid')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    /**
     * Check if admin has permissions to visit related pages
     * @access protected
     * @return boolean
     * @author Ultimate Module Creator
     */
    protected function _isAllowed() {
        return Mage::getSingleton('admin/session')->isAllowed('cms/unideal_topads/magazine');
    }
}
