<?php
	$this->ImportClass("web.editpage","EditPage", "libraries");
	/**
	 * Templates edit page class
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package	Publications
	 * @subpackage pages
	 * @access public
	 **/
	class TemplatesEditPage extends EditPage {
		// Class name
		var $ClassName = "TemplatesEditPage";
		// Class version
		var $Version = "1.0";

		/** Handler  page
		* @var string   $handler
		*/
		var $handler="templatesedit";
		/** ListHandler  page
		* @var string   $handler
		*/
		var $listHandler="templateslist";

        /**    XSL template name
        * @var     string     $XslTemplate
        */
        var $XslTemplate = "itemsedit";

       /**  Access to this page roles
        * @var     array     $access_role_id
        **/
        var $access_role_id = array("ADMIN","PUBLICATIONS_MANAGER");


        function InitLibraryData()  {
	        parent::InitLibraryData();
    	}


}

?>