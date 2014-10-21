<?php

class Sitemaster_EasyAjax_Model_Observer
{

    public function getJson()
    {
        $core = Mage::getSingleton('sitemasterAjax/core');
        if ($core->isSitemasterAjax() && !$core->isProceed()) {
            $core->setProceed();
            $messages = Mage::getSingleton('sitemasterAjax/message_storage');
            $response = Mage::getModel('sitemasterAjax/response');
            $response->setMessages($messages->getMessages());
            $response->loadContent(
                (array) Mage::app()->getRequest()->getParam('action_content', array()),
                (array) Mage::app()->getRequest()->getParam('custom_content', array())
            );
            $response->sendResponse();
        }
    }
}
