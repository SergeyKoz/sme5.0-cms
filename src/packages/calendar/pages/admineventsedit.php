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
class AdminEventsEditPage extends EditPage {

	// Class name
	var $ClassName = "AdminEventsEditPage";

	// Class version
	var $Version = "1.0";

	/** Handler  page
	* @var string   $handler
	*/
	var $handler="admineventsedit";
	/** ListHandler  page
	* @var string   $handler
	*/
	var $listHandler="admineventslist";
	var $access_role_id = array("ADMIN","CALENDAR_EDITOR");


	function ControlOnLoad(){
		parent::ControlOnLoad();
		$category_id=$this->Request->ToNumber("category_id", 0);
		if (empty($this->Request->Form) && $category_id>0){
			$this->Request->Form["category_id"]=$category_id;
		}
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

		if (strtotime($this->_data["date_start"])>strtotime($this->_data["date_end"])){
			$this->AddErrorMessage("MESSAGES","MSG_NOT_VALID_DATE_END");
			$this->validator->formerr_arr["date_end"] = 1;
		}
	}

	function InitLibraryData(){
		if (!Engine::isPackageExists($this->Kernel, "tags")){
			$this->RemoveFieldFromLibrary("tags_%s");
		}
		parent::InitLibraryData();
    }

    function XmlControlOnRender(&$xmlWriter){
    	$itemsEdit=&$this->Controls["ItemsEdit"];
        foreach ($itemsEdit->allfields as $lang=>$fields){
        	foreach ($fields AS $field){
	        	switch ($field["control"]){
					case "repeat": $this->DrawRepeat($lang, $field["field_name"], $this->GetFieldCaption($field, $itemsEdit->sectionname), $itemsEdit);break;
				}
			}
		}
        parent::XmlControlOnRender($xmlWriter);
    }

	function DrawRepeat($_lang, $field_name, $_caption,&$control){
		$control->Page->Kernel->ImportClass("web.controls.repeatcontrol","RepeatControl", "calendar");
		$control->Controls[$_lang]->AddControl(new RepeatControl($field_name, "control" ));
		$array = array(
			"name"=>$field_name,
			"caption"=>$_caption,
			$field_name=>$control->_data[$field_name],
			"repeat_every_count"=>$control->_data["repeat_every_count"],
			"repeat_every_term"=>$control->_data["repeat_every_term"],
			"repeat_end"=>$control->_data["repeat_end"],
			"repeat_end_iterations"=>$control->_data["repeat_end_iterations"],
			"repeat_end_day"=>$control->_data["repeat_end_day"]);
		$control->Controls[$_lang]->Controls[$field_name]->InitControl($array);
	}

	function GetFieldCaption($field, $sectionname){
		$caption="";
		if ($this->Page->Kernel->Localization->HasItem($sectionname, $field["field_name"])){
			$caption=$this->Page->Kernel->Localization->GetItem($sectionname, $field["field_name"]);
		}else{
			$caption=$this->Page->Kernel->Localization->GetItem("main", $field["field_name"]);
		}
		return $caption;
	}


	function GetLangFieldsData($lang, &$data){
		parent::GetLangFieldsData($lang, $data);

		for ($i=0; $i<sizeof($this->form_fields[$lang]); $i++){
			if($this->form_fields[$lang][$i]["control"] == "repeat"){
				$data["repeat_event"]=($this->Request->Value("repeat_event")==1 ? 1 :0);
				$data["repeat_every_count"]=$this->Request->ToNumber("repeat_every_count", 1);
				$data["repeat_every_term"]=$this->Request->Value("repeat_every_term");

				$data["repeat_end"]=$this->Request->Value("repeat_end");
				$data["repeat_end_iterations"]=$this->Request->ToNumber("repeat_end_iterations", 1);
				$data["repeat_end_day"]=$this->Request->Value("repeat_end_day_year")."-".
				$this->Request->Value("repeat_end_day_month")."-".
				$this->Request->Value("repeat_end_day_day");
			}
		}
	}

	function UpdateSystem(){
    	$title=$this->_data["title_".$this->Kernel->Languages[0]];
    	$system=$this->_data["system"];
        if ($title!="" && $system==""){
        	$this->_data["system"]=DataManipulator::TranslitToUrl($title);
        }
    }

	function OnAfterEdit(){
        parent::OnAfterEdit();
      	$this->Storage->UpdateMixed($this->_data);
    }

    function OnAfterAdd(){
        parent::OnAfterAdd();
       	$this->Storage->UpdateMixed($this->_data);
    }

} //--end of class
?>