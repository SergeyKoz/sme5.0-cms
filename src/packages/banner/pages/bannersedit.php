<?php
	$this->ImportClass("web.editpage", "EditPage");
	/**
	 * Banner edit page
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package	Banner
	 * @subpackage pages
	 * @access public
	 **/
	class BannersEditPage extends EditPage {

		// Class name
		var $ClassName = "BannersEditPage";

		// Class version
		var $Version = "1.0";

		/** Handler  page
		* @var string   $handler
		*/
		var $handler="bannersedit";
		/** ListHandler  page
		* @var string   $handler
		*/
		var $listHandler="bannerslist";
       /**    XSL template name
		* @var     string     $XslTemplate
		*/
		var $XslTemplate = "itemsedit";

	  /**  Access to this page roles
		* @var     array     $access_role_id
		**/
		var $access_role_id = array("BANNER_ADMINISTRATOR",
		                            "BANNER_PUBLISHER");

		function InitLibraryData(){
	    	if (!$this->Kernel->MultiLanguage)
	   			$this->RemoveFieldFromLibrary("language");
	        parent::InitLibraryData();
    	}

 } //--end of class


?>