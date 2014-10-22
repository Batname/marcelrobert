<?php
class Sitemaster_Wishlist_Block_Customer_Wishlist_Item_Options extends Mage_Wishlist_Block_Customer_Wishlist_Item_Options
{
    public function getTemplate()
    {
        $template = Mage::app()->getLayout()->createBlock('core/template')->getTemplate();
        if ($template) {
            return $template;
        }

        $item = $this->getItem();

        // If $item is it not instance of Mage_Wishlist_Block_Customer_Wishlist_Item_Options
        if ($item){
            $data = $this->getOptionsRenderCfg($item->getProduct()->getTypeId());

            if (empty($data['template'])) {
                $data = $this->getOptionsRenderCfg('default');
            }
        }else{
            $data = $this->getOptionsRenderCfg('default');
        }

        return empty($data['template']) ? '' : $data['template'];
    }
}