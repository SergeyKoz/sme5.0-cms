<?php
	$this->ImportClass("web.listpage", "ListPage");
	/**
	 * Banner places page class.
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package	Banner
	 * @subpackage pages
	 * @access public
	 **/
	class BannerPlacesListPage extends ListPage {
		// Class name
		var $ClassName = "BannerPlacesListPage";
		// Class version
		var $Version = "1.0";
		/**    Self page name
		* @var     string     $self
		*/
		var $self = "bannerplaceslist";
		/**    HAndler page name
		* @var     string     $handler
		*/
		var $handler = "bannerplacesedit";
		/**    XSL template name
		* @var     string     $XslTemplate
		*/
		var $XslTemplate = "itemslist";
      /**  Access to this page roles
		* @var     array     $access_role_id
		**/
		var $access_role_id = array("BANNER_ADMINISTRATOR");

    /**
	  * Method executes on page load
	  * @access public
	  **/
		function ControlOnLoad()  {
		    $this->libs = array("banner_places");
		    parent::ControlOnLoad();
		}
}
?>
