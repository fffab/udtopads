<?php

class Unideal_Topads_Block_Banner
    extends Mage_Core_Block_Template {
    
    public function displayBanner()
     {
        $collection             = Mage::getModel('unideal_topads/banner')
                                ->getCollection()
                                ->addFilter('status', '1');
        
        $banner = array();
        $i = 0;
        
        foreach($collection as $data)
        {     
            $banner[$i]['name']     = $data->getData('name');
            $banner[$i]['image']    = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'banner/image'.$data->getData('image');
            $banner[$i]['alt']      = $data->getData('alt');
            $banner[$i]['link']     = $data->getData('link');
            $i++;
        }
        
        $random = rand (0,(count($banner)-1));
               
        return $banner[$random];
     }    
}
