<?php
	$this->ImportClass("web.listpage", "ListPage");
	/**
	 * Users list page class.
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package	System
	 * @subpackage pages
	 * @access public
	 **/
	class UsersListPage extends ListPage {
		// Class name
		var $ClassName = "UsersListPage";
		// Class version
		var $Version = "1.0";
		/**    Self page name
		* @var     string     $self
		*/
		var $self = "userslist";
		/**    HAndler page name
		* @var     string     $handler
		*/
		var $handler = "usersedit";
		/**    XSL template name
		* @var     string     $XslTemplate
		*/
		var $XslTemplate = "itemslist";
      /**  Access to this page roles
		* @var     array     $access_role_id
		**/
		var $access_role_id = array("ADMIN");

}
?>
