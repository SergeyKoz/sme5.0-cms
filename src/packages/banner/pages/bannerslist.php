<?php
	$this->ImportClass("web.listpage", "ListPage");
	/**
	 * Banners list page class.
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package	System
	 * @subpackage pages
	 * @access public
	 **/
	class BannersListPage extends ListPage {
		// Class name
		var $ClassName = "BannersListPage";
		// Class version
		var $Version = "1.0";
		/**    Self page name
		* @var     string     $self
		*/
		var $self = "bannerslist";
		/**    HAndler page name
		* @var     string     $handler
		*/
		var $handler = "bannersedit";
		/**    XSL template name
		* @var     string     $XslTemplate
		*/
		var $XslTemplate = "itemslist";
      /**  Access to this page roles
		* @var     array     $access_role_id
		**/
		var $access_role_id = array("BANNER_ADMINISTRATOR",
		                            "BANNER_PUBLISHER");
    /**
	  * Method executes on page load
	  * @access public
	  **/
		function ControlOnLoad()  {
		    $this->libs = array("banner_groups");
		    parent::ControlOnLoad();
		}

}
?>
