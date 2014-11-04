<?php

class Unideal_Topads_Block_Magazine
    extends Mage_Core_Block_Template {
    
    public function displayMagazine()
     {
        $collection             = Mage::getModel('unideal_topads/magazine')
                                ->getCollection()
                                ->addFilter('status', '1');
        
        $magazine = array();
        $i = 0;
        
        foreach($collection as $data)
        {     
            $magazine[$i]['name']     = $data->getData('name');
            $magazine[$i]['image']    = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'magazine/image'.$data->getData('image');
            $magazine[$i]['alt']      = $data->getData('alt');
            $magazine[$i]['link']     = $data->getData('link');
            $i++;
        }
        
        $random = rand (0,(count($magazine)-1));
               
        return $magazine[$random];
     }    
}
