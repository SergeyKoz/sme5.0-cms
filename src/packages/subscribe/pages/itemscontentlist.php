<?php
	$this->ImportClass("web.listpage", "ListPage");
	/**
	* Example class for  list pages.
	* @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	* @version 1.0
	* @package        Libraries
	* @subpackage pages
	* @access public
	**/
	class ItemsContentListPage extends ListPage {
		// Class name
		var $ClassName = "ItemsContentListPage";
		// Class version
		var $Version = "1.0";
		/**    Self page name
		* @var     string     $self
		*/
		var $self="itemscontentlist";

		/**    HAndler page name
		* @var     string     $handler
		*/
		var $handler="itemscontentedit";

		var $listcontrol="subscribeadminlistcontrol";

		var $XslTemplate="itemscontentlist";

		function ControlOnLoad(){
			parent::ControlOnLoad();
			$file=$this->Kernel->Settings->GetItem("MODULE", "Path")."CACHE/subscribeprocess.txt";
			if(!file_exists($file)){
				$handle = fopen($file, 'w');
				fwrite($handle, "100");
				fclose($handle);
				$mask = umask(0);
				@chmod($file, 0777);
				@umask($mask);
			}
		}

	}
?>