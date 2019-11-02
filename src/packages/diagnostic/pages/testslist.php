<?php
	$this->ImportClass("web.listpage", "ListPage", "libraries");
	/**
	 * Tests list page class.
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package	Publications
	 * @subpackage pages
	 * @access public
	 **/
	class TestsListPage extends ListPage {
		// Class name
		var $ClassName = "TestsListPage";
		// Class version
		var $Version = "1.0";
		/**    Self page name
		* @var     string     $self
		*/
		var $self="testslist";
		/**    HAndler page name
		* @var     string     $handler
		*/
		var $handler="testsedit";
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