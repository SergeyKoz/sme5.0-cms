<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Stat
  * @access public
 **/

$this->ImportClass("web.editpage", "EditPage", "libraries");
$this->ImportClass("web.helper.packagehelper", "PackageHelper");

class NewPage extends EditPage  {

    var $ClassName = "NewPage";
    var $Version = "1.0";
    var $library_ID = "new";
    var $XslTemplate = "itemsedit";
    var $handler="new";

    var $PageMode = "Backend";
    var $access_role_id = array("ADMIN", "STRUCTURE_MANAGER");

    /** Method creates child controls
     * @access public
     */
    function ControlOnLoad(){
    	$this->Request->SetValue("library", "new");
    	$parent_id=$this->Request->ToNumber("parent_id", 0);
        if ($parent_id>0) $this->Request->Form["parent_id"]=$parent_id;
        //$this->UseBanners=Engine::isPackageExists($this->Kernel, "banners");
        parent::ControlOnLoad();
    }

    function OnDefault(){
    	$this->Request->SetValue("event", "AddItem");
        $this->OnAddItem();
    }

    function OnGoBack(){
    	if ($this->is_context_frame)
			$url = "?package=context&page=contextframe&event=close";
		else
    		$url="?package=content&page=structure".$this->restore;
        $this->AfterSubmitRedirect($url);
    }

    function OnAfterAdd() {
    	parent::OnAfterAdd();

    	// set order_num
        $data = array('id' => $this->_data["id"], 'order_num' => $this->_data["id"]);
        $this->Storage->Update($data);

        $this->Storage->RebuildPagesPath();

        if ($this->is_context_frame)
			$url = "?package=context&page=contextframe&event=refresh&MESSAGE[]=EDIT_ITEM_CREATED";
		else
    		$url = "?page=structure&package=content&MESSAGE[]=PAGE_ADDED".$this->restore;

        $this->AfterSubmitRedirect($url);
    }

    function ValidateBeforeAdd(){
        parent::ValidateBeforeAdd();

        if (!PackageHelper::CheckPageName($this->_data['name'])){
            $this->AddErrorMessage('MESSAGES', 'INVALID_PAGE_NAME');
            $this->validator->formerr_arr["name"] = 1;
            return;
        }

        $data = array('name' => $this->_data['name'], "parent_id"=>$this->_data['parent_id']);
        if ($this->Storage->GetCount($data)){
            $this->AddErrorMessage('MESSAGES', 'PAGE_NAME_EXISTS');
            $this->validator->formerr_arr["name"] = 1;
            return;
        }
    }

    function OnBeforeCreateEditControl(){
        parent::OnBeforeCreateEditControl();
        PackageHelper::setClassesSelect($this);
    }

    function InitLibraryData(){
    	$m=false;
     	if ($this->Kernel->Settings->HasItem("DEFAULT", "MultiLanguage"))
	        if ($this->Kernel->Settings->GetItem("DEFAULT", "MultiLanguage")==1)  $m=true;

        if (!$m){
	    	$fields_count = $this->listSettings->GetItem("LIST","FIELDS_COUNT");
	    	for ($i=0; $i<$fields_count; $i++)
	    		if ($this->listSettings->GetItem("FIELD_".$i, "FIELD_NAME")=="active_%s" ){
	    			$this->listSettings->SetItem("FIELD_".$i, "EDIT_CONTROL", "hidden");
	    			$this->listSettings->SetItem("FIELD_".$i, "VALUE", 1);
	    		}
    	}
    	//if (!$this->UseBanners)
   		//	$this->RemoveFieldFromLibrary("banner_id");
        parent::InitLibraryData();
    }

}

?>