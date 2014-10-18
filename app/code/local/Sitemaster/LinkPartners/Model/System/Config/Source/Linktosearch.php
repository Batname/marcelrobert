<?php

class Sitemaster_LinkPartners_Model_System_Config_Source_Linktosearch extends Infortis_Brands_Model_System_Config_Source_Linktosearch
{
	public function toOptionArray()
	{
		return array(
			array('value' => 3,				'label' => Mage::helper('sitemaster_linkpartners')->__('-- No Link --')),
			array('value' => 1,				'label' => Mage::helper('sitemaster_linkpartners')->__('Quick Search Results')),
			array('value' => 2,				'label' => Mage::helper('sitemaster_linkpartners')->__('Advanced Search Results')),
			array('value' => 0,				'label' => Mage::helper('sitemaster_linkpartners')->__('Custom Page (more options...)')),
		);
	}
}