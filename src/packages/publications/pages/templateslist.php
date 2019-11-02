<?php
	$this->ImportClass("web.listpage", "ListPage", "libraries");
	/**
	 * Templates list page class.
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package	Publications
	 * @subpackage pages
	 * @access public
	 **/
	class TemplatesListPage extends ListPage {
		// Class name
		var $ClassName = "TemplatesListPage";
		// Class version
		var $Version = "1.0";
		/**    Self page name
		* @var     string     $self
		*/
		var $self="templateslist";
		/**    HAndler page name
		* @var     string     $handler
		*/
		var $handler="templatesedit";
        /**    XSL template name
        * @var     string     $XslTemplate
        */
        var $XslTemplate = "itemslist";

        //var $listcontrol="templateslistcontrol";

      /**  Access to this page roles
        * @var     array     $access_role_id
        **/
        var $access_role_id = array("ADMIN","PUBLICATIONS_MANAGER");


}
?>