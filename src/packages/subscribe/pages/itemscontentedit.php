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
	class ItemsContentEditPage extends EditPage {
		// Class name
		var $ClassName = "ItemsContentEditPage";
		// Class version
		var $Version = "1.0";

		/** Handler  page
		* @var string   $handler
		*/
		var $handler="itemscontentedit";
		/** ListHandler  page
		* @var string   $handler
		*/
		var $listHandler="itemscontentlist";

		var $XslTemplate="itemsedit";

		function InitLibraryData(){
			if ($this->library_ID=="contentlist" || $this->library_ID=="archivelist"){
		    	if (!$this->Kernel->MultiLanguage){
		   			$this->RemoveFieldFromLibrary("lang_ver");
				}
	   		}
	        parent::InitLibraryData();
    	}

	}
?>