<?php

class Sitemaster_EasyAjax_Model_Core_Message extends Mage_Core_Model_Message
{
    protected function _factory($code, $type, $class='', $method='')
    {
        if (Mage::helper('core')->isModuleEnabled('Sitemaster_EasyAjax') && Mage::getSingleton('sitemasterAjax/core')->isSitemasterAjax()) {
            Mage::getSingleton('sitemasterAjax/message_storage')->addMessage($code, $type);
        }
        return parent::_factory($code, $type, $class, $method);
    }
}
