<?php
$this->ImportClass("web.editpage", "EditPage");

/**
* Polls edit page.
* @author Artem Mikhmel <amikhmel@activemedia.com.ua>
* @version 1.0
* @package  Libraries
* @access public
**/
class PollsadminEditPage extends EditPage {
	// Class name
	var $ClassName = "PollsadminEditPage";
	// Class version
	var $Version = "1.0";

	/** Handler  page
	* @var string   $handler
	*/
	var $handler="pollsadminedit";
	/** ListHandler  page
	* @var string   $handler
	*/
	var $listHandler="pollsadminlist";
	/**  Flag to show if page need spesial priveleges
	*  @var    bool    $moder_page
	**/
	var $moder_page = false;
	/**
	* Edit control class name
	* @access public
	**/
	var $editcontrol="itemseditcontrol";

	var $XslTemplate="itemsedit";

    /**
    * Method handles ResetItem event
    * Resets polls results
    * @access   piblic
    **/
	function OnResetItem(){
		if(strlen($this->host_library_ID)){
			$this->library_ID =$this->host_library_ID;
		}
		$this->Storage->ResetPoll($this->item_id);
		$url="?page=".$this->listHandler."&".$this->library_ID."_start=".$this->start."&".$this->library_ID."_order_by=".$this->order_by."&library=".$this->library_ID."&".$this->library_ID."_parent_id=".$this->parent_id."&".$this->restore;
		$this->AfterSubmitRedirect($url);
	}

	function  ValidateBeforeAdd(){

		if($this->library_ID=="polls"){
			$this->UpdateSystem();
			if ($this->_data["system"]!=""){
				preg_match('~[0-9a-zA-Z-]*~', $this->_data["system"], $exp);
				if ($exp[0] != $this->_data["system"]){
					$this->AddErrorMessage("MESSAGES", "SYSTEM_NAME_INVALID");
					$this->validator->formerr_arr["system"]=1;
				}
			}

		}

		parent::ValidateBeforeAdd();
		/*if(($this->library_ID=="votes") && ($this->_data["parent_id"]>0)){
		unset($this->validator->formerr_arr["icon"]);
		unset($this->validator->formerr_arr["picture"]);
		}*/
	}

	/*function UpdateSystem(){
		$title=$this->_data["caption_ru"];
		$system=$this->_data["system"];
		if ($title!="" && $system==""){
			$this->_data["system"]=DataManipulator::TranslitToUrl($title);
		}
	} */

	function UpdateSystem(){
		$l=$this->Page->Kernel->Languages[0];
		$title=$this->_data["caption_".$l];
		$system=$this->_data["system"];
		if ($title!="" && $system==""){
			$this->_data["system"]=DataManipulator::TranslitToUrl($title);
		}
	}

	function InitLibraryData(){
		parent::InitLibraryData();

		if ($this->library_ID=="polls_variants"){
			foreach ($this->Storage->columns AS $i=>$column){
				if ($column["name"]=="system"){
					unset($this->Storage->columns[$i]["notnull"]);
				}
			}
		}
	}

//end of class
}

?>