<?php
$this->ImportClass("web.editpage", "EditPage");
       /**
        * User and user group edit page
        * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
        * @version 1.0
        * @package        System
        * @subpackage pages
        * @access public
        **/
class AdminEventsCategoriesEditPage extends EditPage {

	// Class name
	var $ClassName = "AdminEventsCategoriesEditPage";

	// Class version
	var $Version = "1.0";

	/** Handler  page
	* @var string   $handler
	*/
	var $handler="admineventscategoriesedit";
	/** ListHandler  page
	* @var string   $handler
	*/
	var $listHandler="admineventscategorieslist";

	var $XslTemplate="itemsedit";

	var $access_role_id = array("ADMIN","CALENDAR_EDITOR");


	function ControlOnLoad(){
		parent::ControlOnLoad();
	}

	function ValidateBeforeAdd(){
		$this->UpdateSystem();
        if ($this->_data["system"]!=""){
        	preg_match('~[0-9a-zA-Z-]*~', $this->_data["system"], $exp);
			if ($exp[0] != $this->_data["system"]){
				$this->AddErrorMessage("MESSAGES", "SYSTEM_NAME_INVALID");
				$this->validator->formerr_arr["system"]=1;
			}
		}
		parent::ValidateBeforeAdd();
	}

	function UpdateSystem(){
		$language=$this->Kernel->Languages[0];
    	$title=$this->_data["caption_".$language];
    	$system=$this->_data["system"];
        if ($title!="" && $system==""){
        	$this->_data["system"]=DataManipulator::TranslitToUrl($title);
        }
    }

} //--end of class
?>