<?php

class Sitemaster_LinkPartners_Helper_Data extends Infortis_Brands_Helper_Data
{
	/**
	 * Get path of the directory with brand images
	 *
	 * @return string
	 */
	public function getBrandImagePath()
	{
		return 'wysiwyg/infortis/partners/';
	}

	/**
	 * Get module settings
	 *
	 * @return string
	 */
	public function getCfg($optionString)
	{
		return Mage::getStoreConfig('sitemaster_linkpartners/' . $optionString);
	}

	/**
	 * Get config flag: show brand image
	 *
	 * @return string
	 */
	public function isShowImage()
	{
		return Mage::getStoreConfig('sitemaster_linkpartners/general/show_image');
		//return $this->getCfg('general/show_image');
	}

	/**
	 * Get config flag: show brand name (simple text) if brand image doesn't exist
	 *
	 * @return string
	 */
	public function isShowImageFallbackToText()
	{
		return Mage::getStoreConfig('sitemaster_linkpartners/general/show_image_fallback_to_text');
		//return $this->getCfg('general/show_image_fallback_to_text');
	}

	/**
	 * Get config: logo is a link to search results
	 *
	 * @return string
	 */
	public function getCfgLinkToSearch()
	{
		return Mage::getStoreConfig('sitemaster_linkpartners/general/link_search_enabled');
	}
}
