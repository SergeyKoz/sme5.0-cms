<?php
	$this->ImportClass("web.editpage", "EditPage");
	/**
	 * Settings edit page
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package	System
	 * @subpackage pages
	 * @access public
	 **/
	class SettingsPage extends EditPage {

		// Class name
		var $ClassName = "SettingsPage";

		// Class version
		var $Version = "1.0";

		/** Handler  page
		* @var string   $handler
		*/
		var $handler="settings";
		/** ListHandler  page
		* @var string   $handler
		*/
		var $listHandler="settings";

		function ControlOnLoad(){
			$this->Request->SetValue("item_id",1);
			parent::ControlOnLoad();
		}

		function OnDefault(){
	        $this->OnEditItem();
	    }

	    /*function OnDo(){
	        $this->OnDoEditItem();
	    } */

	    function OnAfterEdit(){
      		//$this->restore.="&MESSAGE[]=MSG_DATA_SAVED";
      		parent::OnAfterEdit();
      	}

      	function OnBeforeCreateEditControl(){
	        parent::OnBeforeCreateEditControl();
	    }

}

?>