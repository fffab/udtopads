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
 * Banner helper
 *
 * @category    Unideal
 * @package     Unideal_Topads
 * @author      Fabrice Fetsch
 */
class Unideal_Topads_Helper_Banner
    extends Mage_Core_Helper_Abstract {
    /**
     * check if breadcrumbs can be used
     * @access public
     * @return bool
     * @author Fabrice Fetsch
     */
    public function getUseBreadcrumbs(){
        return Mage::getStoreConfigFlag('unideal_topads/banner/breadcrumbs');
    }
}
