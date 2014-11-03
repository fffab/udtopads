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
 * Banner edit form tab
 *
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Ultimate Module Creator
 */
class Unideal_Topads_Block_Adminhtml_Banner_Edit_Tab_Form
    extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * prepare the form
     * @access protected
     * @return Unideal_Topads_Block_Adminhtml_Banner_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('banner_');
        $form->setFieldNameSuffix('banner');
        $this->setForm($form);
        $fieldset = $form->addFieldset('banner_form', array('legend'=>Mage::helper('unideal_topads')->__('Banner')));
        $fieldset->addType('image', Mage::getConfig()->getBlockClassName('unideal_topads/adminhtml_banner_helper_image'));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('unideal_topads')->__('Name'),
            'name'  => 'name',
            'required'  => true,
            'class' => 'required-entry',

        ));

        $fieldset->addField('image', 'image', array(
            'label' => Mage::helper('unideal_topads')->__('Image'),
            'name'  => 'image',

        ));

        $fieldset->addField('alt', 'text', array(
            'label' => Mage::helper('unideal_topads')->__('Alt text'),
            'name'  => 'alt',
            'required'  => true,
            'class' => 'required-entry',

        ));

        $fieldset->addField('link', 'text', array(
            'label' => Mage::helper('unideal_topads')->__('Link'),
            'name'  => 'link',
            'required'  => true,
            'class' => 'required-entry',

        ));
        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('unideal_topads')->__('Status'),
            'name'  => 'status',
            'values'=> array(
                array(
                    'value' => 1,
                    'label' => Mage::helper('unideal_topads')->__('Enabled'),
                ),
                array(
                    'value' => 0,
                    'label' => Mage::helper('unideal_topads')->__('Disabled'),
                ),
            ),
        ));
        if (Mage::app()->isSingleStoreMode()){
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_banner')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $formValues = Mage::registry('current_banner')->getDefaultValues();
        if (!is_array($formValues)){
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getBannerData()){
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getBannerData());
            Mage::getSingleton('adminhtml/session')->setBannerData(null);
        }
        elseif (Mage::registry('current_banner')){
            $formValues = array_merge($formValues, Mage::registry('current_banner')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
