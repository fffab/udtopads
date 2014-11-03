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
 * Magazine edit form tab
 *
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Fabrice Fetsch
 */
class Unideal_Topads_Block_Adminhtml_Magazine_Edit_Tab_Form
    extends Mage_Adminhtml_Block_Widget_Form {
    /**
     * prepare the form
     * @access protected
     * @return Unideal_Topads_Block_Adminhtml_Magazine_Edit_Tab_Form
     * @author Fabrice Fetsch
     */
    protected function _prepareForm(){
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('magazine_');
        $form->setFieldNameSuffix('magazine');
        $this->setForm($form);
        $fieldset = $form->addFieldset('magazine_form', array('legend'=>Mage::helper('unideal_topads')->__('Magazine')));
        $fieldset->addType('image', Mage::getConfig()->getBlockClassName('unideal_topads/adminhtml_magazine_helper_image'));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('unideal_topads')->__('Name'),
            'name'  => 'name',
            'required'  => true,
            'class' => 'required-entry',

        ));
        
        $fieldset->addField('image', 'image', array(
            'label' => Mage::helper('unideal_topads')->__('Image Magazine'),
            'name'  => 'image',

        ));
        
        $fieldset->addField('alt', 'text', array(
            'label' => Mage::helper('unideal_topads')->__('Alt text'),
            'name'  => 'alt',

        ));
        
        $fieldset->addField('link', 'text', array(
            'label' => Mage::helper('unideal_topads')->__('link'),
            'name'  => 'link',

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
            Mage::registry('current_magazine')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $formValues = Mage::registry('current_magazine')->getDefaultValues();
        if (!is_array($formValues)){
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getMagazineData()){
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getMagazineData());
            Mage::getSingleton('adminhtml/session')->setMagazineData(null);
        }
        elseif (Mage::registry('current_magazine')){
            $formValues = array_merge($formValues, Mage::registry('current_magazine')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
