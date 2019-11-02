<?php
	$this->ImportClass("web.editpage", "EditPage");
	/**
	 * Banner places edit page
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package	Banner
	 * @subpackage pages
	 * @access public
	 **/
	class BannerPlacesEditPage extends EditPage {

		// Class name
		var $ClassName = "BannerPlacesEditPage";

		// Class version
		var $Version = "1.0";

		/** Handler  page
		* @var string   $handler
		*/
		var $handler="bannerplacesedit";
		/** ListHandler  page
		* @var string   $handler
		*/
		var $listHandler="bannerplaceslist";
       /**    XSL template name
		* @var     string     $XslTemplate
		*/
		var $XslTemplate = "itemsedit";

	  /**  Access to this page roles
		* @var     array     $access_role_id
		**/
		var $access_role_id = array("BANNER_ADMINISTRATOR");

 } //--end of class


?>