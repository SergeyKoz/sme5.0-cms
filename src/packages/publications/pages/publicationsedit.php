<?php
$this->ImportClass("web.editpage", "EditPage");
/**
 * Publications edit page class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package	Publications
 * @subpackage pages
 * @access public
 **/
class PublicationsEditPage extends EditPage {
	// Class name
	var $ClassName = "PublicationsEditPage";
	// Class version
	var $Version = "1.0";

	/** Handler  page
	* @var string   $handler
	*/
	var $handler="publicationsedit";

	/** ListHandler  page
	* @var string   $handler
	*/
	var $listHandler="publicationslist";

	/**  Access to this page roles
	* @var     array     $access_role_id
	**/
	var $access_role_id = array("ADMIN","PUBLICATIONS_MANAGER", "PUBLICATIONS_PUBLISHER", "PUBLICATIONS_EDITOR");

	/**
	* Method executes on page load
	* @access public
	*/
	function ControlOnLoad(){
		parent::ControlOnLoad();
		$this->CommentEnabled=Engine::isPackageExists($this->Kernel, "comments");
		$this->UseTags=Engine::isPackageExists($this->Kernel, "tags");

		$this->saved_library_ID = $this->library_ID;
	}


	/**
	* Method redirects user to selected branch of tree
	* @access	public
	*/
	function OnJump(){
		if(!$this->error){
			$new_parent = $this->Request->ToNumber("destination",0);
			if(strlen($this->host_library_ID)){
				$this->library_ID =$this->host_library_ID;
			}
			$this->AfterSubmitRedirect("?page=".$this->listHandler."&".$this->library_ID."_start=".$this->start."&".$this->library_ID."_order_by=".$this->order_by."&library=".$this->library_ID."&".$this->library_ID."_parent_id=".$new_parent."".$message);
		}
	}

	/**
	* Method executes before deleting sub-categories when mega-delete is in action
	* @param   AbstractTable $sub_Storage Subcategory table object
	* @access   public
	**/
	function OnBeforeSubMegaDelete(&$sub_Storage){

	}

	/**
	* Method executes when user change template using template combobox
	* @access   public
	**/
	function onChangeTemplate() {
		$_item_id = $this->Request->Value("item_id");
		if (intval($_item_id)==0){
			$this->Request->SetValue("event","AddItem");
			$this->OnAddItem();
		}else{
			$this->Request->SetValue("event","EditItem");
			$this->OnEditItem();
		}
	}

    /**
    * Method copies publication when published  publication edited by editor
    * @access private
    ***/
	function CopyEditPublication(){
		$this->_data["copy_of_id"] = $this->_data["publication_id"];
		$old_publication_id = $this->_data["publication_id"];

		$this->_data["is_modified"] = 1;
		$insert_data = $this->_data;
		unset($insert_data["publication_id"]);
		$this->Storage->Insert($insert_data);
		$this->_data["publication_id"] = $this->Storage->getInsertId();
		$new_publication_id = $this->_data["publication_id"];

		$pp_storage = DataFactory::GetStorage($this, "PublicationParamsTable");
		$_list = $pp_storage->GetList(array("publication_id" => $old_publication_id));
		for($i=0; $i<$_list->RecordCount; $i++){
			$_tmp = $_list->Read();
			unset($_tmp["pp_id"]);
			$_tmp["publication_id"] = $new_publication_id;
			$pp_storage->Insert($_tmp);
		}
		unset($this->_data["_created_by"]);
		$this->item_id = $new_publication_id;
	}

	/**
	* Method executes before data of item be updated
	* @access   public
	**/
	function OnBeforeEdit() {
		if(strpos($this->library_ID, "publications") !== false){
			$this->removeParamColumns();
			$this->stored_version = $this->Storage->Get(array("publication_id" => $this->_data["publication_id"]));
			$this->_data["is_declined"] = 0;
			if(!$this->UserIsManager()){
				if($this->stored_version["is_modified"] == 0){
					$this->CopyEditPublication();
				}
			}
		}
	}

	/**
	* Method executes after data of item be updated
	* @access   public
	**/
	function OnAfterEdit()    {
		//save paramaters definitions
		if(strpos($this->saved_library_ID, "publications") !== false){
			$this->UpdateProductParams();
		}

		if(strpos($this->saved_library_ID, "mapping") !== false){
		}

	}

	/**
	* Method executes before data of item be inserted
	* @access   public
	**/
	function OnBeforeAdd(){
		$this->removeParamColumns();
		if(strpos($this->saved_library_ID, "publications") !== false){
			if($this->UserIsManager()){
				$this->_data["copy_of_id"]=0;
				$this->_data["is_modified"]=0;
			} else {
				$this->_data["copy_of_id"]=0;
				$this->_data["is_modified"]=1;
			}
		}
	}


	/**
	* Method checks if user has admin rights for this module
	* returns true if user is a manager< false otherwise
	* @return bool
	* @access private
	*
	**/
	function UserIsManager(){
		return $this->Auth->isRoleExists("PUBLICATIONS_PUBLISHER,PUBLICATIONS_MANAGER");
	}

	/**
	* Method executes after data of item be inserted
	* @access   public
	**/
	function OnAfterAdd()    {
		parent::OnAfterAdd();
		//save paramaters definitions
		if(strpos($this->saved_library_ID, "publications") !== false){
			$this->UpdateProductParams();
		}
		if(strpos($this->saved_library_ID, "mapping") !== false){

		}
	}

	/**
	* Method remove all "param_" columns definitions from products storage
	* @access   private
	**/
	function removeParamColumns(){
		$_columns = array();
		foreach   ($this->Storage->columns as $i => $column){
			if (strpos($column["name"],"param_")===false){
				$_columns[] = $column;
			}
		}
		$this->Storage->columns = $_columns;
		$this->addSortFieldValues();
		//$this->addSystem();
	}

	/**
	* Method fills internal fields
	* @access   public
	**/
	function addSortFieldValues(){
		if($this->custom_date_field != ''){
			$this->_data["_sort_date"] = $this->_data[$this->custom_date_field];
		} else {
			$this->_data["_sort_date"] = date("Y-m-d H:i:s", time());
		}

		if($this->custom_caption_field == ''){
			$this->custom_caption_field = "caption";
		}

		foreach($this->Kernel->Languages as $language){
			$this->_data[sprintf("_sort_caption_%s", $language)] = $this->_data[sprintf($this->custom_caption_field, $language)];
		}
	}

    /*function addSystem(){
    	$system=DataManipulator::TranslitEncode($this->_data["caption"]);
    }*/

	/**
	* Method gets date values from request
	* @param    array   $param    Array with param data
	* @param    string   $language_prefix   LAnguage prefix
	* @return   string  Formatted date string
	* @access   public
	**/
	function prepareDateValue($param, $language_prefix=""){
		$value = $this->Request->Value("param_".$param["tp_id"]."_year".$language_prefix)."-".
			$this->Request->Value("param_".$param["tp_id"]."_month".$language_prefix)."-".
			$this->Request->Value("param_".$param["tp_id"]."_day".$language_prefix)."";
		if(!$param["cut_to_length"]){
			$value .= " ".$this->Request->Value("param_".$param["tp_id"]."_hour".$language_prefix).":".
			$this->Request->Value("param_".$param["tp_id"]."_minute".$language_prefix).":".
			$this->Request->Value("param_".$param["tp_id"]."_second".$language_prefix)."";
		} // fulldate
		return $value;
	}

	/**
	* Method update product parameters values in storage
	* @access   private
	**/
	function UpdateProductParams() {
		//--get all params ids for current template
		//--create storage object

		$storage = DataFactory::GetStorage($this, "PublicationParamsTable");

		$field_prefix = "";
		if($this->Auth->isRoleExists("PUBLICATIONS_PUBLISHER,PUBLICATIONS_MANAGER")){
			$field_prefix = "";
		}

		//--delete all old template params
		$arr = array("publication_id" => $this->item_id);
		$storage->DeleteByKey($arr);

		//--get all param records for this template  and insert product params
		$tp_Storage = DataFactory::GetStorage($this, "TemplateParamsTable");
		$_list = $tp_Storage->getTemplateParameters($this->Request->Value("template_id"));
		if ($_list->RecordCount != 0){
			$mixed_fields=array("text", "textarea", "spaweditor");
			$mixed=array();
			while($param = $_list->Read()){
				if($param["is_multilang"]==1){
					foreach($this->Kernel->Languages as $language){
						$value = $this->Request->Value("param_".$param["tp_id"]."_".$language);

						if($param["system_name"] == "date"){
							$value = $this->prepareDateValue($param, "_".$language);
						}

						if (in_array($param["system_name"], $mixed_fields)){
							$mixed["langs"]["mixed_content_".$language].="\n".$value;
						}

						$insert_array = array(
							"publication_id"  => $this->item_id,
							"language" => $language,
							"param_id"      => $param["tp_id"],
							"param_value"   => $value);
						//--insert parameter
						$storage->Insert($insert_array);
					}
				} else {
					$value = $this->Request->Value("param_".$param["tp_id"]);
					if($param["system_name"] == "date"){
						$value = $this->prepareDateValue($param);
					}

					if (in_array($param["system_name"], $mixed_fields)){
						$mixed["other"].="\n".$value;
					}

					$insert_array = array(
						"publication_id"  => $this->item_id,
						"language" => "",
						"param_id"      => $param["tp_id"],
						"param_value"   => $value);

					//--insert parameter
					$storage->Insert($insert_array);
				}

			}

			if (count($mixed["langs"])){
				$mixed_langs=array_keys($mixed["langs"]);
				foreach ($mixed["langs"] as $key=>$value){
					$v=$mixed["langs"][$key]."\n".$mixed["other"];
					$v=preg_replace("~<(.*?)>~", "\n", $v);
					$v=$this->Storage->SqlString($v);
					$mixed["langs"][$key]=$key."=".$v;
				}
				$SQL=sprintf("UPDATE %s SET %s WHERE publication_id=%d",
				$this->Storage->defaultTableName,
				implode(",", $mixed["langs"]), $this->item_id);
				$this->Storage->Connection->ExecuteNonQuery($SQL);
			}

		}
		//generate system name
	}
	/**
	* Method process main library section
	* @access   private
	**/
	function ProcessMainSection(){
		if(strpos($this->library_ID, "publications") !== false){
			$this->listSettings->SetItem("MAIN","GROUP_NAME","params");
			$this->listSettings->SetItem("MAIN","GROUP_TITLE",$this->Kernel->Localization->GetItem($this->library_ID,"PARAMETERS_GROUP_NAME"));
		}
		parent::ProcessMainSection();
	}

	/**
	* Method initialize library data
	* @access   private
	**/
	function InitLibraryData(){
		if (!$this->CommentEnabled){
			if(strpos($this->library_ID, "publications") !== false){
				$this->RemoveFieldFromLibrary("disable_comments");
			}
			if($this->library_ID=="mapping"){
				$this->RemoveFieldFromLibrary("enable_comments");
			}
		}

		if (!$this->UseTags && $this->library_ID=="mapping"){
			$this->RemoveFieldFromLibrary("tags_%s");
		}

		parent::InitLibraryData();
		if(strpos($this->library_ID, "publications") !== false){
			$this->SetParametersDefinition();
		}
	}

	/**
	* Method set parameters definitions in library for current template
	* @access   private
	**/
	function SetParametersDefinition(){
		if ($this->debug_mode){
			echo $this->ClassName."::SetParametersDefinition();"."<HR>";
		}
		$tp_Storage = DataFactory::GetStorage($this, "TemplateParamsTable");
		//get template_id
		$_template_id = $this->getTemplateId();

		$fields_count = $this->listSettings->GetItem("LIST","FIELDS_COUNT");
		$old_fields_count = $fields_count;
		//get parameters list
		$_list = $tp_Storage->GetTemplateParameters($_template_id);

		if ($_list->RecordCount != 0){
			while ($param = $_list->Read()){
				//add this parameter to library
				$this->AddParameter($fields_count,$param);
				$fields_count++;
			}
		}

		$templates_Storage = DataFactory::GetStorage($this, "TemplatesTable");
		$_template = $templates_Storage->Get(array("template_id"=>$_template_id));

		if ($_template["is_category"]!=1){
			foreach($this->form_fields["main"] as $i=>$f){
				if ($this->form_fields["main"][$i]["field_name"]=="template_id_preset"){
					unset($this->form_fields["main"][$i]);
				}
			}
			$this->form_fields["main"]=array_values($this->form_fields["main"]);
		}

		if ($_template["enable_tags"]==1 && $this->UseTags){
			$this->AddTagsParameter($fields_count);
			$fields_count++;
		}

		if ($_template["enable_seo_params"]==1){
			$this->AddSEOParameters($fields_count);
			$fields_count=$fields_count+3;
		}

		//set fields count in library
		$this->listSettings->SetItem("LIST","FIELDS_COUNT",$fields_count,true);
		for($i=$old_fields_count; $i<($fields_count); $i++){
			$this->GetFieldSettings($i);
		}// for
	}

    /**
      * Method get current template id
      * @return     int     Template ID
      * @access   private
      **/
	function getTemplateId(){
		$_template_id = $this->Request->Value("template_id");
		if (intval($_template_id)==0){
			if (intval($this->item_id)){
				$item = $this->Storage->Get(array($this->key_field => $this->item_id));
				$_template_id = $item["template_id"];
			}else{
				if ($this->parent_id>0){
					$item = $this->Storage->Get(array($this->key_field => $this->parent_id));
					$_template_id=$item["template_id_preset"];
					if ($_template_id>0){
						$this->Request->Form["template_id"]=$_template_id;
					}
				}
				if (!($_template_id>0)){
					$templates_Storage = DataFactory::GetStorage($this, "TemplatesTable");
					$_list = $templates_Storage->GetList(null,array("caption" => 1),1,0);
					if ($_list->RecordCount != 0)   {
						$_template  = $_list->Read();
						$_template_id = $_template["template_id"];
					}
				}
			}
		}
		return $_template_id;
	}

	/**
	* Method add template parameter to library definition
	* @param  int     $i      Field number
	* @param  array   $data   Parameter data array
	* @access   private
	**/
	function AddParameter($i,&$data){
		$this->listSettings->AddSection("FIELD_".$i);
		$field_name =  "param_".$data["tp_id"];
		$this->listSettings->SetItem("FIELD_".$i,"DBFIELD_NAME","param_".$data["tp_id"]);

		// if miltilanguage field
		if($data["is_multilang"]){
			$this->listSettings->SetItem("FIELD_".$i,"IS_MULTILANG", 1);
			$field_name .= "_%s";
			$_Language=$this->Kernel->Settings->GetItem("LANGUAGE", "_Language");
			$_LangShortName=$this->Kernel->Settings->GetItem("LANGUAGE", "_LangShortName");

			if (is_array($_Language)){
				$short_lang = array();
				foreach($_Language as $c => $key){
					$short_lang[$key] = $_LangShortName[$c];
				}
			}else{
				$short_lang = array($_Language=>$_LangShortName);
			}

			foreach($this->Kernel->Languages as $language){
				$lang_field_name = sprintf($field_name, $language);
				// adding field title
				$this->Kernel->Localization->SetItem($this->library_ID, $lang_field_name, $data["title_specific"]." (".$short_lang[$language].".)");
			}
			$this->listSettings->SetItem("FIELD_".$i,"DBFIELD_NAME", $field_name);
		}
		if(($data["is_caption"]) && ($this->custom_caption_field == "")){
			$this->custom_caption_field=$field_name;
		}

		// setting up fields
		$this->listSettings->SetItem("FIELD_".$i,"FIELD_NAME", $field_name);
		$this->Kernel->Localization->SetItem($this->library_ID, "param_".$data["tp_id"], ($data["title_specific"]!=""?$data["title_specific"]:$data["param_title"]));
		$this->listSettings->SetItem("FIELD_".$i,"GROUP","PARAMS");
		$this->listSettings->SetItem("FIELD_".$i,"IN_LIST","0");
		$this->listSettings->SetItem("FIELD_".$i,"DBFIELD_NOTNULL",(int)$data["is_not_null"]);
		//add parameter types characteristic
		switch ($data["system_name"]){
			case "text":
				$this->listSettings->SetItem("FIELD_".$i,"EDIT_CONTROL","text");
				$this->listSettings->SetItem("FIELD_".$i,"LENGTH",($data["max_length"]!=''? (int)$data["max_length"] : "255" ));
				$this->listSettings->SetItem("FIELD_".$i,"DBFIELD_DTYPE","string");
				break;

			case "date":
				$this->listSettings->SetItem("FIELD_".$i,"EDIT_CONTROL","date");
				$this->listSettings->SetItem("FIELD_".$i,"EDIT_FULLDATE", ($data["cut_to_length"]==0 ? "1":"0"));
				$this->listSettings->SetItem("FIELD_".$i,"DBFIELD_DTYPE","string");
				if($this->custom_date_field == ""){
					$this->custom_date_field=$field_name;
				}
				break;

			case "picture":
				$this->listSettings->SetItem("FIELD_".$i,"EDIT_CONTROL","file");
				$this->listSettings->SetItem("FIELD_".$i,"DIRECTORY","");
				break;

			case "textarea":
				$this->listSettings->SetItem("FIELD_".$i,"EDIT_CONTROL","textarea");
				break;

			case "spaweditor":
				$this->listSettings->SetItem("FIELD_".$i,"EDIT_CONTROL","spaweditor");
				$this->listSettings->SetItem("FIELD_".$i,"DIRECTORY","");
				break;

			case "file":
				$this->listSettings->SetItem("FIELD_".$i,"EDIT_CONTROL","file");
				$this->listSettings->SetItem("FIELD_".$i,"DIRECTORY","");
				break;
			case "email":
				$this->listSettings->SetItem("FIELD_".$i,"EDIT_CONTROL","text");
				$this->listSettings->SetItem("FIELD_".$i,"LENGTH","255");
				$this->listSettings->SetItem("FIELD_".$i,"DBFIELD_DTYPE","email");
				break;
			case "url":
				$this->listSettings->SetItem("FIELD_".$i,"EDIT_CONTROL","text");
				$this->listSettings->SetItem("FIELD_".$i,"LENGTH","255");
				$this->listSettings->SetItem("FIELD_".$i,"DBFIELD_DTYPE","string");
				break;

			default:
				$this->listSettings->SetItem("FIELD_".$i,"EDIT_CONTROL","text");
				break;
		}
	}

	function AddTagsParameter($i)    {
		$section="FIELD_".$i;
		$this->listSettings->AddSection($section);
		$this->listSettings->SetItem($section,"FIELD_NAME","tags_%s");
		$this->listSettings->SetItem($section,"CONTROL",null);
		$this->listSettings->SetItem($section,"EDIT_CONTROL","autocomplete");
		$this->listSettings->SetItem($section,"FIELD_TABLE","TagsTable");
		$this->listSettings->SetItem($section,"FIELD_ITEM_TYPE","publication");

		//$this->listSettings->SetItem($section,"AUTOCOMPLETE_METHOD","GetAutocompleteWords");
		$this->listSettings->SetItem($section,"ENABLE_CREATE_NEW_ITEMS",1);
		//$this->listSettings->SetItem($section,"FIELD_RELATION_NAME","publication_id");
		//$this->listSettings->SetItem($section,"WORDS_DELIMETER","|");
		$this->listSettings->SetItem($section,"FIELD_WORDS_NAME","tag_%s");
		$this->listSettings->SetItem($section,"IN_LIST",0);
		$this->listSettings->SetItem($section,"IS_MULTILANG",1);
		$this->listSettings->SetItem($section,"MULTIPLE",1);
	}

	function AddSEOParameters($i)    {
		$section="FIELD_".$i;
		$this->listSettings->AddSection($section);
		$this->listSettings->SetItem($section,"FIELD_NAME","meta_title_%s");
		$this->listSettings->SetItem($section,"CONTROL",null);
		$this->listSettings->SetItem($section,"EDIT_CONTROL","text");
		$this->listSettings->SetItem($section,"IS_MULTILANG",1);

		$section="FIELD_".($i+1);
		$this->listSettings->AddSection($section);

		$this->listSettings->SetItem($section,"FIELD_NAME","meta_keywords_%s");
		$this->listSettings->SetItem($section,"CONTROL",null);
		$this->listSettings->SetItem($section,"EDIT_CONTROL","textarea");
		$this->listSettings->SetItem($section,"IS_MULTILANG",1);

		$section="FIELD_".($i+2);
		$this->listSettings->AddSection($section);

		$this->listSettings->SetItem($section,"FIELD_NAME","meta_description_%s");
		$this->listSettings->SetItem($section,"CONTROL",null);
		$this->listSettings->SetItem($section,"EDIT_CONTROL","textarea");
		$this->listSettings->SetItem($section,"IS_MULTILANG",1);
	}

	/**
	* Method called before create ItemsEditControl control
	* @access   private
	**/
	function OnBeforeCreateEditControl()    {
		$_template_id = $this->getTemplateId();
		//--get current record parameters values
		$pp_Storage = DataFactory::GetStorage($this, "PublicationParamsTable");
		//set aliases hint for spaweditor
		$_list = $pp_Storage->GetPublicationParameters($_template_id,$this->item_id);
		//--set parameters data to form
		if ($_list->RecordCount != 0){
			while ($param  = $_list->Read()){
				$this->parameterValueToForm($param);
			}
		}
	}

	/**
	* Method set parameter value to edit data array
	* @param  array   $param  parameter data array
	* @access   private
	**/
	function parameterValueToForm($param){
		//--if  start add item
		if (intval($this->Request->Value("template_id"))==0) {
			if (intval($this->item_id)==0){
				if($param["is_multilang"]==1){
					foreach($this->Kernel->Languages as $language){
						if($language == $param["language"]){
							$this->_data["param_".$param["tp_id"]."_".$language] = $param["_default"];
						}
					}
				}else{
					$this->_data["param_".$param["tp_id"]] = $param["_default"];
				}
			}else{
				if($param["is_multilang"]==1){
					foreach($this->Kernel->Languages as $language){
						if($language == $param["language"]){
							$this->_data["param_".$param["tp_id"]."_".$language] = $param["cur_value"];
						}
					}
				} else{
					$this->_data["param_".$param["tp_id"]] = $param["cur_value"];
				}
			}
		}
	}

	/**
	* Method called after copied record (copy parameters for new item)
	* @param  int $original_id        ID of original item
	* @param  int $copy_id            ID of copied item
	* @access   private
	**/
	function OnAfterCopy($original_id,$copy_id)  {
		if(strpos($this->saved_library_ID, "publications") !== false){
			$pp_Storage = DataFactory::GetStorage($this, "PublicationParamsTable");
			$_list = $pp_Storage->GetList(array("product_id" => $original_id));
			//--set parameters data to form
			if ($_list->RecordCount != 0)   {
				while ($param  = $_list->Read()){
					$param["product_id"]  = $copy_id;
					$pp_Storage->Insert($param);
				}
			}
		}
	}

	/**
	* Method handles BeforeApply action
	* @access public
	**/
	function OnBeforeApply(){
		if((strpos($this->saved_library_ID, "publications_modified") !== false)){
			if($this->UserIsManager()){
				$approve = $this->Request->Value("approve", REQUEST_ALL, false);
				$decline = $this->Request->Value("decline", REQUEST_ALL, false);

				if(is_array($approve) && (!empty($approve))){
					foreach($approve as $id){
						$this->Storage->ApprovePublication($id);
					}
				}

				if(is_array($decline) && (!empty($decline))){
					foreach($decline as $id){
						$this->Storage->DeclinePublication($id, "DECLINED BY ".$this->Auth->UserLogin);
					}
				}
			}
		}

		if((strpos($this->saved_library_ID, "publications") !== false)){

		}
	}

    function OnAfterApply(){
    	parent::OnAfterApply();
    	if(strpos($this->saved_library_ID, "publications") !== false && $this->apply_deleted==1 && count($this->delete_items)){
            if ($this->UseTags){
	            $data = array("publication_id" => $this->delete_items);
	            $storage=DataFactory::GetStorage($this, "TagsTable");
	            $storage->DeleteByKey($data);
	            unset($storage);
            }
        }

        /*if($this->saved_library_ID=="mapping" && count($this->delete_items)){
            if ($this->UseTags)
	            $this->UpdatePublicationsTagsInformation();
        } */
    }

    function OnAfterMegaDelete($nodes_id){
    	parent::OnAfterMegaDelete($nodes_id);
    	if(strpos($this->saved_library_ID, "publications") !== false){
            if (is_array($nodes_id) && !empty($nodes_id)){
            	if ($this->UseTags){
		            $storage=DataFactory::GetStorage($this, "TagsTable");
		            $data = array("publication_id" => $nodes_id);
	            	$storage->DeleteByKey($data);
	            	unset($storage);
            	}
            }
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
	}

	function UpdateSystem(){
    	$title=$this->_data["caption"];
    	$system=$this->_data["system"];
        if ($title!="" && $system==""){
        	$this->_data["system"]=DataManipulator::TranslitToUrl($title);
        }
    }

} //--end of class

?>