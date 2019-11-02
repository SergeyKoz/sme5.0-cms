<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Stat
  * @access public
 **/
$this->ImportClass("web.editpage", "EditPage", "libraries");

class EditContentPage extends EditPage  {

    var $ClassName = "EditContentPage";
    var $Version = "1.0";
    var $XslTemplate = "contentedit";
    var $PageMode = "Backend";
    var $handler="editcontent";
    var $access_role_id = array("ADMIN", "STRUCTURE_MANAGER", "CONTENT_EDITOR");

    /** Method creates child controls
     * @access public
     */
    function ControlOnLoad(){
    	$this->Request->SetValue("library", "editcontent");
    	$id=$this->Request->ToString("id","0");
    	if ($id!=0) $this->Request->SetValue("item_id", $id);

    	$language=$this->Request->ToString("lng", "");

    	$this->Language=$language!="" ? $language : $this->Page->Language;


    	if ($this->Event=="Default") {
    		$this->Event="EditItem";
    		$this->Request->SetValue("event", "EditItem");
    	}



        parent::ControlOnLoad();
    }

    function CheckLibraryAccess(){
    	$this->listSettings->SetItem("FIELD_0", "FIELD_NAME", "content_".$this->Language);
    	$this->listSettings->SetItem("FIELD_1", "VALUE", $this->Language);


    	if (Engine::isPackageExists($this->Kernel, "tags")){
    		$this->listSettings->SetItem("FIELD_2", "FIELD_NAME", "tag_".$this->Language);
    		$this->listSettings->SetItem("FIELD_2", "FIELD_WORDS_NAME", "tag_".$this->Language);
    	}


		parent::CheckLibraryAccess();
	}

    function OnAfterEdit() {
    	parent::OnAfterEdit();
    	if (!$this->is_context_frame){
	    	$url = "?page=editcontent&package=content&id=".$this->item_id."&lng=".$this->Language."&MESSAGE[]=PAGE_SAVED";
	        $this->Page->Response->Redirect($url);
        }
    }

    function ValidateBeforeAdd(){
	    $formfield_arr=&$this->validator->formfield_arr;
	    foreach ($this->Page->Kernel->Languages as $language){
		    for ($i=0; $i<count($formfield_arr); $i++)
	            if ($formfield_arr[$i]["name"]=="title_".$language)
	            	unset($formfield_arr[$i]["notnull"]);
     	}
	   	parent::ValidateBeforeAdd();
	}

}

?>