<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Stat
  * @access public
 **/

$this->ImportClass("web.editpage", "EditPage", "libraries");
$this->ImportClass("web.helper.packagehelper", "PackageHelper");

class PropsPage extends EditPage  {

    var $ClassName = "PropsPage";
    var $Version = "1.0";
    var $library_ID = "new";
    var $XslTemplate = "itemsedit";
    var $handler="props";
    var $PageMode = "Backend";
    var $access_role_id = array("ADMIN", "STRUCTURE_MANAGER");

    /** Method creates child controls
     * @access public
     */
    function ControlOnLoad(){
    	$this->Request->SetValue("library", "props");
    	$id=$this->Request->ToString("id","0");
    	if ($id!=0)
    		$this->Request->SetValue("item_id", $id);

    	//$this->UseBanners=Engine::isPackageExists($this->Kernel, "banners");
        parent::ControlOnLoad();
    }

    function OnDefault(){
    	$this->Request->SetValue("event", "EditItem");
    	$this->Page->Event="EditItem";
        $this->OnEditItem();
    }

    function OnGoBack(){
    	if ($this->is_context_frame)
			$url = "?package=context&page=contextframe&event=close";
		else
    		$url = "?package=content&page=structure".$this->restore;
        $this->AfterSubmitRedirect($url);
    }

    function OnBeforeCreateEditControl(){
        parent::OnBeforeCreateEditControl();
        PackageHelper::setClassesSelect($this);
    }

    function OnAfterEdit() {
    	parent::OnAfterEdit();

        $this->Storage->RebuildPagesPath();
        if ($this->is_context_frame && $this->Event!="DoApplyItem")
	      	$url = "?package=context&page=contextframe&event=refresh&MESSAGE[]=EDIT_ITEM_SAVED";
	    else {
	    	if ($this->Event=="DoApplyItem")
	    		$url = "?page=props&package=content&id=".$this->item_id."&MESSAGE[]=PAGE_PROPS_SAVED&restore=".str_replace("&amp;", "&", rawurlencode($this->restore));
    		else
    			$url = "?page=structure&package=content&MESSAGE[]=PAGE_PROPS_SAVED".$this->restore;
    	}
    	//echo pr($url);
        $this->AfterSubmitRedirect($url);
    }

    function ValidateBeforeAdd(){
        parent::ValidateBeforeAdd();
        //if (!preg_match('/^[a-zA-Z0-9-_]{1,}$/', $this->_data['name']) && $this->_data['name']!=""){
        if ( !PackageHelper::CheckPageName($this->_data['name']) ){
            $this->AddErrorMessage('MESSAGES', 'INVALID_PAGE_NAME');
            $this->validator->formerr_arr["name"] = 1;
            //return;
        }

        $data = array('name' => $this->_data['name']);
        $item=$this->Storage->Get(array("id"=>$this->item_id));
        if ($this->Storage->GetCount($data, "", array('where' => ' id<>'.$this->item_id.' AND parent_id='.$item["parent_id"]))){
            $this->AddErrorMessage('MESSAGES', 'PAGE_NAME_EXISTS');
            $this->validator->formerr_arr["name"] = 1;
            //return;
        }
    }

    function InitLibraryData()  {
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