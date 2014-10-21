<?php

class Sitemaster_EasyAjax_Model_Response extends Varien_Object
{

    protected $_response;

    public function sendResponse()
    {
        $this->_response = Mage::app()->getResponse();

        //check redirect
        if ($this->_response->isRedirect()) {
            $headers = $this->_response->getHeaders();
            $redirect = '';
            foreach ($headers AS $header) {
                if ("Location" == $header["name"]) {
                    $redirect = $header["value"];
                    break;
                }
            }
            if ($redirect) {
                $this->setRedirect($redirect);
            }
        }

        $this->_response->clearHeaders();
        $this->_response->setHeader('Content-Type', 'application/json');
        $this->_response->clearBody();
        $this->_response->setBody($this->toJson());
        $this->_response->sendResponse();
        exit;
    }

    public function loadContent($actionContent, $customContent)
    {
        if ($actionContent) {
            $layout = $this->_loadControllerLayouts();
            $actionContentData = array();
            foreach ($actionContent as $_content) {
                $_block = $layout->getBlock($_content);
                if ($_block) {
                    $actionContentData[$_content] = $_block->toHtml();
                }
            }
            if ($actionContentData) {
                $this->setActionContentData($actionContentData);
            }
        }

        if ($customContent) {
            $layout = $this->_loadCustomLayouts();
            $customContentData = array();
            foreach ($customContent as $_content) {
                $_block = $layout->getBlock($_content);
                if ($_block) {
                    $customContentData[$_content] = $_block->toHtml();
                }
            }
            if ($customContentData) {
                $this->setCustomContentData($customContentData);
            }
        }
    }

    protected function _loadControllerLayouts()
    {
        $layout = Mage::app()->getLayout();
        $update = $layout->getUpdate();
        // load default handle
        $update->addHandle('default');
        // load store handle
        $update->addHandle('STORE_'.Mage::app()->getStore()->getCode());
        // load theme handle
        $package = Mage::getSingleton('core/design_package');
        $update->addHandle(
            'THEME_'.$package->getArea().'_'.$package->getPackageName().'_'.$package->getTheme('layout')
        );
        // load action handle
        $fullActionName = Mage::app()->getRequest()->getRequestedRouteName() . '_' .
            Mage::app()->getRequest()->getRequestedControllerName() . '_' .
            Mage::app()->getRequest()->getRequestedActionName();
        $update->addHandle(strtolower($fullActionName));

        //load updates
        Mage::dispatchEvent(
            'controller_action_layout_load_before',
            array('action' => Mage::app()->getFrontController()->getAction(), 'layout' => $layout)
        );
        $update->load();
        //generate xml
        $layout->generateXml();
        //generate layout blocks
        $layout->generateBlocks();

        return $layout;
    }

    protected function _loadCustomLayouts()
    {
        $layout = Mage::app()->getLayout();
        $update = $layout->getUpdate();
        // load default custom handle
        $update->addHandle('sitemaster_ajax_default');
        // load action handle
        $fullActionName = Mage::app()->getRequest()->getRequestedRouteName() . '_' .
            Mage::app()->getRequest()->getRequestedControllerName() . '_' .
            Mage::app()->getRequest()->getRequestedActionName();
        $update->addHandle('sitemaster_ajax_' . strtolower($fullActionName));

        if (Mage::app()->useCache('layout')) {
            $cacheId = $update->getCacheId().'_sitemaster_ajax';
            $update->setCacheId($cacheId);

            if (!Mage::app()->loadCache($cacheId)) {
                foreach ($update->getHandles() as $handle) {
                    $update->merge($handle);
                }

                $update->saveCache();
            } else {
                //load updates from cache
                $update->load();
            }
        } else {
            //load updates
            $update->load();
        }

        //generate xml
        $layout->generateXml();
        //generate layout blocks
        $layout->generateBlocks();

        return $layout;
    }
}
