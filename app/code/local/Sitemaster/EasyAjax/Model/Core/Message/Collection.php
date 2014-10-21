<?php

class Sitemaster_EasyAjax_Model_Core_Message_Collection extends Mage_Core_Model_Message_Collection
{

    public function add(Mage_Core_Model_Message_Abstract $message)
    {

        if (!Mage::helper('core')->isModuleEnabled('Sitemaster_EasyAjax')
            || !Mage::getSingleton('sitemasterAjax/core')->isSitemasterAjax()
        ) {
            $this->addMessage($message);
        }

        return $this;
    }
}
