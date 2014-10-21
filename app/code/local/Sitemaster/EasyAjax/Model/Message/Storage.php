<?php

class Sitemaster_EasyAjax_Model_Message_Storage
{

    protected $_messages = array();


    public function addMessage($code, $type)
    {
        $this->_messages[] = array ('code' => $code, 'type' => $type);
        return $this;
    }

    public function getMessages()
    {
        return $this->_messages;
    }
}
