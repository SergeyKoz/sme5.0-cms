<?php
	$this->ImportClass("web.editpage", "EditPage");
	/**
	 * Test class for edit pages.
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package	Libraries
	 * @subpackage pages
	 * @access public
	 **/
	class ItemsEditPage extends EditPage {
		// Class name
		var $ClassName = "ItemsEditPage";
		// Class version
		var $Version = "1.0";

		/** Handler  page
		* @var string   $handler
		*/
		var $handler="itemsedit";
		/** ListHandler  page
		* @var string   $handler
		*/
		var $listHandler="itemslist";


}

?>