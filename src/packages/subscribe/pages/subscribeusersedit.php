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
	class SubscribeUsersEditPage extends EditPage {
		// Class name
		var $ClassName = "SubscribeUsersEditPage";
		// Class version
		var $Version = "1.0";

		/** Handler  page
		* @var string   $handler
		*/
		var $handler="subscribeusersedit";
		/** ListHandler  page
		* @var string   $handler
		*/
		var $listHandler="subscribeuserslist";

		var $XslTemplate="itemsedit";

		function InitLibraryData(){
			if ($this->library_ID=="userthemelist"){
		    	if (!$this->Kernel->MultiLanguage){
		   			$this->RemoveFieldFromLibrary("lang_ver");
				}
	   		}
	        parent::InitLibraryData();
    	}

	}
?>