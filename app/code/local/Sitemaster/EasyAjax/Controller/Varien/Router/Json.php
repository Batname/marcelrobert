<?php

class Sitemaster_EasyAjax_Controller_Varien_Router_Json extends Mage_Core_Controller_Varien_Router_Standard
{

    public function collectRoutes($configArea, $useRouterName)
    {
        parent::collectRoutes($configArea, 'standard');
    }


    public function match(Zend_Controller_Request_Http $request)
    {
        $path = trim($request->getPathInfo(), '/');

        if (strrpos($path, '.json') === strlen($path) - 5) {
            $request->setPathInfo(substr($path, 0, strlen($path) - 5));
            Mage::getSingleton('sitemasterAjax/core')->setSitemasterAjax(true);

            return parent::match($request);
        }

        return false;
    }
}