<?php

class Sitemaster_Ultimo_Model_System_Config_Source_Layout_Element_Productinfo
{
    public function toOptionArray()
    {
		return array(
			array('value' => 0, 'label' => Mage::helper('sitemaster_ultimo')->__('Disable Completely (Review and Tabs)')),
            array('value' => 1, 'label' => Mage::helper('sitemaster_ultimo')->__('Only tabs')),
            array('value' => 2, 'label' => Mage::helper('sitemaster_ultimo')->__('Only Review')),
			array('value' => 3, 'label' => Mage::helper('sitemaster_ultimo')->__('Both'))
        );
    }
}