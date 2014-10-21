<?php

class Sitemaster_EasyAjax_Model_Core
{

    protected $_isSitemasterAjax = null;

    protected $_proceed = false;

    public function isSitemasterAjax()
    {
        if ($this->_isSitemasterAjax === null) {
            $this->_isSitemasterAjax = Mage::app()->getRequest()->isXmlHttpRequest()
                && Mage::app()->getRequest()->getParam('sitemaster_ajax', false);
        }
        return (bool) $this->_isSitemasterAjax;
    }


    public function setSitemasterAjax($value = true)
    {
        $this->_isSitemasterAjax = (bool) $value;
    }


    public function isProceed()
    {
        return (bool) $this->_proceed;
    }


    public function setProceed()
    {
        $this->_proceed = true;

        return $this;
    }

}
