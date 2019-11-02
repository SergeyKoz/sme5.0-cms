<?php
$this->ImportClass("module.web.backendpage", "BackendPage");
$this->ImportClass("system.web.validate", "Validate");
$this->ImportClass("web.editpagehelper", "EditPageHelper", "libraries");
$this->ImportClass("system.data.abstracttable", "AbstractTable");

/**
 * Base class for all edit pages.
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package Libraries
 * @subpackage classes.web
 * @access public
 **/
class EditPage extends BackendPage{
    // Class name
    var $ClassName = "EditPage";
    // Class version
    var $Version = "1.0";
    /** Data storage
     * @var AbstractTable   $Storage
     **/
    var $Storage;
    /** Table class name
     * @var string   $Table
     */
    var $Table;
    /** Item ID to edit
     * @var int  $item_id
     */
    var $item_id;
    /** Event
     * @var string  $event
     */
    var $event;
    /** Key field name
     * @var string   $key_field
     */
    var $key_field;
    /** Fields array for list
     * @var array   $form_fields
     */
    var $form_fields=array();
    /** Form validator object
     * @var  Validate   $validator
     */
    var $validator;
    /** List handler page
     * @var string   $listHandler
     */
    var $listHandler;
    /** Start list offset
     * @var int  $start
     */
    var $start;
    /** Sorting order
     * @var string  $order_by
     */
    var $order_by;
    /** Restore string
     * @var string  $restore
     */
    var $restore;
    /**  List settings object
     * @var ConfigFile  $listSettings
     */
    var $listSettings;
    /** Library string ID
     * @var string   $library_ID
     */
    var $Package;

    var $library_ID;
    /** Error flag count
     * @var int   $error
     */
    var $error;
    /**   Multilevel flag
     * @var   bool   $multilevel
     */
    var $multilevel;
    /**   Name of field with parent index
     * @var  string   $parent_field
     */
    var $parent_field;
    /**   Value of parent ID
     * @var  int   $parent_id
     */
    var $parent_id;
    /**   Value of custom variable passed to editor
     * @var  int   $custom_val
     */
    var $custom_val;
    /**   Name of custom variable passed to editor
     * @var  string   $custom_var
     */
    var $custom_var;
    /**   Flag defines if sub-categories is in use
     * @var  int   $use_sub_categories
     */
    var $use_sub_categories;
    /**   Number of subcategories
     * @var  int   $sub_categories_count
     */
    var $sub_categories_count;
    /**   Array with list of assosiated subcategories
     * @var  array   $sub_categories
     */
    var $sub_categories;
    /**   Flag defines if mega delete of all nodes enabled
     * @var  int   $mega_delete
     */
    var $mega_delete;
    /**   Flag defines if move of selected nodes enabled
     * @var  int   $node_move
     */
    var $node_move;
    /**   Flag defines if delete of selected records enabled
     * @var  int   $disabled_delete
     */
    var $disabled_delete;
    /**   Flag defines if edit of selected records enabled
     * @var  int   $disabled_edit
     */
    var $disabled_edit;
    /**   Flag defines if add of selected records enabled
     * @var  int   $disabled_add
     */
    var $disabled_add;
    /**   Flag defines if copy of selected records enabled
     * @var  int   $disabled_copy
     */
    var $disabled_copy;
    /**   Flag defines readonly state for library
     * @var  int   $read_only
     **/

    /**   Flag defines if move of selected records enabled
     *   @var  int   $disabled_copy
     **/
    var $disabled_move;

    /**  Field used for move records
     *   @var  string    $move_field
     **/
    var $move_field = "";

    var $read_only;
    /**   Debug flag
     * @var  boolean   $debug_mode
     **/
    var $debug_mode = false;

    /**   Is child class set error flag
     * @var  boolean   $child_error
     **/
    var $child_error = FALSE;
    /**
     * Flag defines non ordinary form (form have a multicombobox as example)
     * @var boolean $nonordinary
     **/
    var $nonordinary = FALSE;

    /**
     * Edit control class name
     * @access public
     **/
    var $editcontrol = "itemseditcontrol";
    /**
     * Library icon file
     * @access public
     **/
    var $icon_file = "";

    /**
     * Field group names
     * @access public
     **/
    var $field_group_names = array();

    /**
     * Field group titles
     * @access public
     **/
    var $field_group_titles = array();

    var $is_context_frame;

    var $GetItemMethod="Get";

    /**
     * Method executes on page load
     * @access public
     **/
    function ControlOnLoad(){
        if ($this->debug_mode)
            echo $this->ClassName . "::ControlOnLoad();" . "<HR>";
        parent::ControlOnLoad();
        $this->Kernel->ImportClass("web.controls." . $this->editcontrol, $this->editcontrol);
        $this->error = 0;
        $this->library_ID = $this->Request->ToString("library", "");
        if (! strlen($this->library_ID)) {
            $this->library_ID = $this->Kernel->Package->Settings->GetItem("main", "LibraryName");
        }

        //$_library_path = $this->Page->Kernel->Package->Settings->GetItem("MAIN", "LibrariesRoot");
        $this->listSettings = Engine::getLibrary($this->Kernel, $this->library_ID, "ListSettings");
        $this->listSettings->reParse();
        $this->Package=Engine::GetPackageName();
        $this->item_id = $this->Request->ToString("item_id", "0");
        $this->is_context_frame = $this->Request->ToNumber("contextframe", "0");

		$this->event = $this->Request->Value("event");
		if (substr($this->event, 0,4)=="DoDo"){
            $this->event=$this->Event=substr($this->event, 2, strlen($this->event)-2);
            $this->Request->SetValue("event", $this->event);
		}

        $this->start = $this->Request->ToNumber($this->library_ID . "_start", 0);
        $this->order_by = $this->Request->Value($this->library_ID . "_order_by");
        $this->restore = $this->Request->Value("restore");

        $this->parent_id = $this->Request->ToNumber($this->library_ID . "_parent_id", 0);
        $this->custom_val = $this->Request->Value("custom_val");
        $this->custom_var = $this->Request->Value("custom_var");
        $this->host_library_ID = $this->Request->Value("host_library_ID");
        $this->LibrariesRoot = $this->Kernel->Package->Settings->GetItem("main", "LibrariesRoot");
        $this->checkLibraryAccess();
    }
    /**
     * Method adds error messages
     * @param      string               $item_id   Error ID
     * @param        array      $data       Additional data for error description
     * @param      boolean  $user_error E_USER_ERROR message type (method only return message)
     * @access       public
     */
    function AddEditErrorMessage($item_id, $data = array(), $user_error = false){
        $message = $this->AddErrorMessage("LIBRARY", $item_id, array_merge(array(
        $this->library_ID), $data), false, $user_error);
        if (! $user_error)
            $this->error ++;
        else
            user_error($message, E_USER_ERROR);
    }

    /** Method creates child controls
     * @access public
     */
    function CreateChildControls()
    {
        if ($this->debug_mode)
            echo $this->ClassName . "::CreateChildControls();" . "<HR>";
        if ($this->listSettings->GetCount()) {
            if ($this->listSettings->HasItem("MAIN", "TABLE")) {
                $this->Table = $this->listSettings->GetItem("MAIN", "TABLE");
            }
            else {
                $this->AddEditErrorMessage("EMPTY_TABLE_SETTINGS", array(), true);
            }
            if (! $this->error) {

                //parse library file
            	$this->InitLibraryData();
            	//reinitilize database columns definitions
                $this->ReInitTableColumns();
                //create validator
                $this->validator = new Validate($this, $this->Storage->columns, $this->library_ID);
                $this->Kernel->ImportClass("web.controls." . $this->editcontrol, $this->editcontrol);
                $_editControl = new $this->editcontrol("ItemsEdit", "edit", $this->Storage);
                $this->AddControl($_editControl);
            }
        } // if
        else {
            $this->AddEditErrorMessage("EMPTY_LIBRARY_SETTINGS", array(), true);
        }
    }

    /**
     * Method set table columns parameters if is exists in form fields definitions
     * @access private
     **/
    function ReInitTableColumns()
    {
        if ($this->debug_mode)
            echo $this->ClassName . "::ReInitTableColumns();" . "<HR>";
        foreach ($this->form_fields as $prefix => $form) {
            foreach ($form as $i => $field) {
                foreach ($field as $param => $value) {
                    //if found database parameters
                    if (strpos($param, "dbfield_") !== false) {
                        $columnparam = substr($param, strlen("dbfield_"), strlen($param));
                        $this->Storage->setColumnParameter($field["field_name"], trim($columnparam), $value);
                    }
                }
            }
        }
    }

    /**
     * Method processes library permissions
     * @access   public
     */
    function ProcessLibraryPermissions()
    {
        if ($this->debug_mode)
            echo $this->ClassName . "::ProcessLibraryPermissions();" . "<HR>";
        if ($this->listSettings->HasItem("MAIN", "DISABLED_DELETE")) {
            $this->disabled_delete = $this->listSettings->GetItem("MAIN", "DISABLED_DELETE");
        }
        else {
            $this->disabled_delete = 0;
        }
        if ($this->listSettings->HasItem("MAIN", "DISABLED_EDIT")) {
            $this->disabled_edit = $this->listSettings->GetItem("MAIN", "DISABLED_EDIT");
        }
        else {
            $this->disabled_edit = 0;
        }
        if ($this->listSettings->HasItem("MAIN", "DISABLED_ADD")) {
            $this->disabled_add = $this->listSettings->GetItem("MAIN", "DISABLED_ADD");
        }
        else {
            $this->disabled_add = 0;
        }
        if ($this->listSettings->HasItem("MAIN", "DISABLED_APPLY")) {
            $this->disabled_apply = $this->listSettings->GetItem("MAIN", "DISABLED_APPLY");
        }
        else {
            $this->disabled_apply = 0;
        }
        if ($this->listSettings->HasItem("MAIN", "DISABLED_COPY")) {
            $this->disabled_copy = $this->listSettings->GetItem("MAIN", "DISABLED_COPY");
        }
        else {
            $this->disabled_copy = 0;
        }

        if ($this->listSettings->HasItem("MAIN", "DISABLED_MOVE")) {
            $this->disabled_move = $this->listSettings->GetItem("MAIN", "DISABLED_MOVE");
        }
        else {
            $this->disabled_move = 1;
        }

        if (! $this->disabled_move) {
            if ($this->listSettings->HasItem("MAIN", "MOVE_FIELD")) {
                $this->move_field = $this->listSettings->GetItem("MAIN", "MOVE_FIELD");
            }
            else {
                if ($this->Storage->HasColumn("_priority") !== false) {
                    $this->move_field = "_priority";
                }
                else {
                    $_inc_column = $this->Storage->GetIncrementalColumn();
                    $this->move_field = $_inc_column["name"];
                }
            }
        }

        if ($this->listSettings->HasItem("MAIN", "IS_READONLY")) {
            $this->read_only = $this->listSettings->GetItem("MAIN", "IS_READONLY");
            if ($this->read_only) {
                $this->disabled_delete = 1;
                $this->disabled_edit = 1;
                $this->disabled_add = 1;
                $this->disabled_move = 1;
            }
        }
        else {
            $this->read_only = 0;
        }

    } //-- end of method


    /**
     * Method processes multilevel sub-categories settings
     * @access   public
     */
    function ProcessMultilevelSubCategories()
    {
        if ($this->debug_mode)
            echo $this->ClassName . "ProcessMultilevelSubCategories();" . "<HR>";
        if ($this->listSettings->HasItem("MAIN", "SUB_CATEGORIES_COUNT")) {
            $this->sub_categories_count = $this->listSettings->GetItem("MAIN", "SUB_CATEGORIES_COUNT");
            for ($i = 0; $i < $this->sub_categories_count; $i ++) {
                $sub_category = array();
                if ($this->listSettings->HasItem("SUB_CATEGORY_" . $i, "APPLY_LIBRARY")) {
                    $sub_category["library"] = $this->listSettings->GetItem("SUB_CATEGORY_" . $i, "APPLY_LIBRARY");
                }
                else {
                    $this->AddEditErrorMessage("EMPTY_SUB_CATEGORY_LIBRARY", array(
                    $i), true);
                }
                if ($this->listSettings->HasItem("SUB_CATEGORY_" . $i, "LINK_FIELD")) {
                    $sub_category["link_field"] = $this->listSettings->GetItem("SUB_CATEGORY_" . $i, "LINK_FIELD");
                }
                else {
                    $this->AddEditErrorMessage("EMPTY_SUB_CATEGORY_LINK_FIELD", array(
                    $i), true);
                }
                $this->sub_categories[] = $sub_category;
            }

        }
        else {
            $this->AddEditErrorMessage("EMPTY_SUB_CATEGORIES_COUNT", array(), true);
        }

    }

    /**
     * Method processes Multilevel settings of library config
     * @access   public
     */
    function ProcessMultilevel()
    {
        if ($this->debug_mode)
            echo $this->ClassName . "::ProcessMultilevel();" . "<HR>";
        if ($this->listSettings->HasItem("MAIN", "PARENT_FIELD")) {
            $this->parent_field = $this->listSettings->GetItem("MAIN", "PARENT_FIELD");
        }
        else {
            $this->AddEditErrorMessage("EMPTY_PARENTFIELD_SETTINGS", array(), true);
        }
        if ($this->listSettings->HasItem("MAIN", "USE_SUB_CATEGORIES")) {
            $this->use_sub_categories = $this->listSettings->GetItem("MAIN", "USE_SUB_CATEGORIES");
        }
        else {
            $this->use_sub_categories = 0;
        }
        if ($this->use_sub_categories) {
            $this->ProcessMultilevelSubCategories();
        }
        if ($this->listSettings->HasItem("MAIN", "ENABLE_MEGA_DELETE")) {
            $this->mega_delete = $this->listSettings->GetItem("MAIN", "ENABLE_MEGA_DELETE");
        }
        else {
            $this->mega_delete = 0;
        }
        if ($this->listSettings->HasItem("MAIN", "ENABLE_NODE_MOVE")) {
            $this->node_move = $this->listSettings->GetItem("MAIN", "ENABLE_NODE_MOVE");
        }
        else {
            $this->node_move = 0;
        }

    }

    /**
     * Method processes MAIN section of library config
     * @access   public
     */
    function ProcessMainSection()
    {
        if ($this->debug_mode)
            echo $this->ClassName . "::ProcessMainSection();" . "<HR>";
        if ($this->listSettings->HasItem("MAIN", "KEY_FIELD")) {
            $this->key_field = $this->listSettings->GetItem("MAIN", "KEY_FIELD");
        }
        else {
            $this->AddEditErrorMessage("EMPTY_KEYFIELD_SETTINGS", array(), true);
        }

        //get icon file
        if ($this->listSettings->HasItem("MAIN", "ICON_FILE")) {
            $this->icon_file = $this->listSettings->GetItem("MAIN", "ICON_FILE");
        }

        if ($this->listSettings->HasItem("MAIN", "EDIT_GET_METHOD")) {
            $this->GetItemMethod = $this->listSettings->GetItem("MAIN", "EDIT_GET_METHOD");
        }

        $this->ProcessLibraryPermissions();
        //--process multilevel library
        if ($this->listSettings->HasItem("MAIN", "IS_MULTILEVEL")) {
            $this->multilevel = $this->listSettings->GetItem("MAIN", "IS_MULTILEVEL");
            if ($this->multilevel) {
                $this->ProcessMultilevel();
            }
        }
        else {
            $this->multilevel = 0;
        }
        //--process field groups
        if ($this->listSettings->HasItem("MAIN", "GROUP_NAME")) {
            //--get field groups
            $this->field_group_names = $this->listSettings->GetItem("MAIN", "GROUP_NAME");
            if (! is_array($this->field_group_names))
                $this->field_group_names = array(
                $this->field_group_names);

            array_walk($this->field_group_names, array(
            $this , "_ToUpper"));
            //--get field group names
            if ($this->listSettings->HasItem("MAIN", "GROUP_TITLE_" . strtoupper($this->Kernel->Language))) {
                $this->field_group_titles = $this->listSettings->GetItem("MAIN", "GROUP_TITLE_" . strtoupper($this->Kernel->Language));
            }
            else {
                $this->field_group_titles = $this->listSettings->GetItem("MAIN", "GROUP_TITLE");
            }
            if (! is_array($this->field_group_titles))
                $this->field_group_titles = array(
                $this->field_group_titles);
        }

    }
    //end of method


    /**
     *  Internal function strtoupper for array_walk use
     *  @param  mixed   $item     value of  array element
     *  @param  mixed   $key      key of array element
     *  @acess  private
     **/
    function _ToUpper(&$item, $key){
        $item = strtoupper($item);
    }

    /**
     * Method returns  field settings for each field
     * @param        int         Index of field
     * @return       array       Array with mandatory settings
     * @access       public
     */
    function GetFieldSettings($i){
        if ($this->debug_mode)
            echo $this->ClassName . "::GetFieldSettings($i);" . "<HR>";
        $_field = array();
        $_field["number"] = $i;
        if ($this->listSettings->HasItem("FIELD_" . $i, "FIELD_NAME")) {
            $_field["field_name"] = $this->listSettings->GetItem("FIELD_" . $i, "FIELD_NAME");
        }
        else {
            $this->AddEditErrorMessage("EMPTY_FIELDNAME_SETTINGS", array(
            $i), true);
        }
        //set database column parameters
        for ($k = 0; $k < sizeof($this->Storage->columnparameters); $k ++)
            if ($this->listSettings->HasItem("FIELD_" . $i, "DBFIELD_" . strtoupper($this->Storage->columnparameters[$k]))) {
                $_field["dbfield_" . strtolower($this->Storage->columnparameters[$k])] = $this->listSettings->GetItem("FIELD_" . $i, "DBFIELD_" . strtoupper($this->Storage->columnparameters[$k]));
            }
        if ($this->listSettings->HasItem("FIELD_" . $i, "EDIT_CONTROL")) {
            $_field["control"] = $this->listSettings->GetItem("FIELD_" . $i, "EDIT_CONTROL");
        }
        else {
            $this->AddEditErrorMessage("EMPTY_EDIT_CONTROL_SETTINGS", array($i), true);
        }
        if ($this->listSettings->HasItem("FIELD_" . $i, "LENGTH")) {
            $_field["length"] = $this->listSettings->GetItem("FIELD_" . $i, "LENGTH");
        }
        else {
            $_field["length"] = "";
        }

        if ($this->listSettings->HasItem("FIELD_" . $i, "FIELD_DUBLICATE")) {
            $_field["field_dublicate"] = $this->listSettings->GetItem("FIELD_" . $i, "FIELD_DUBLICATE");
        }
        else {
            $_field["field_dublicate"] = false;
        }

        //--check if have additional events
        if ($this->listSettings->HasItem("FIELD_" . $i, "FIELD_EVENT")) {
            $_field["field_event"] = $this->listSettings->GetItem("FIELD_" . $i, "FIELD_EVENT");
        }

        //-- if field belong of any additional groups
        if ($this->listSettings->HasItem("FIELD_" . $i, "GROUP")) {
            $_field["group"] = strtoupper($this->listSettings->GetItem("FIELD_" . $i, "GROUP"));
        }
        switch ($_field["control"]) {
            case "date":
                EditPageHelper::GetDateSettings($i, $_field, $this);
                break;
            case "text":
            case "password":
                EditPageHelper::GetTextSettings($i, $_field, $this);
                break;

            case "textarea":
                EditPageHelper::GetTextAreaSettings($i, $_field, $this);
                break;
            case "machtmleditor":
                EditPageHelper::GetMacHtmlEditorSettings($i, $_field, $this);
                break;

            case "checkbox":
            case "radio":
                EditPageHelper::GetCheckboxSettings($i, $_field, $this);
                break;

            case "radiogroup":
            case "checkboxgroup":
            case "caption":
            case "combobox":
                EditPageHelper::GetComboSettings($i, $_field, $this);
                break; //select


            case "dbtext":
            case "dbstatictext":
                EditPageHelper::GetDbTextSettings($i, $_field, $this);

            case "dbcombobox":
            case "dbtreecombobox":
            case "dbtreetext":
            case "dbradiogroup":
            case "dbcheckboxgroup":
                //case "checkboxgroup":
                EditPageHelper::GetDbComplexSettings($i, $_field, $this);
                break;
            case "dbeditblock2":
                EditPageHelper::GetDbEditBlockSettings($i, $_field, $this);
                break;

            case "dbtreepath":
                EditPageHelper::GetDbTreePathSettings($i, $_field, $this);
                break;

            case "file":
                EditPageHelper::GetFileSettings($i, $_field, $this);
                break;
            case "file2":
                EditPageHelper::GetFile2Settings($i, $_field, $this);
                break;

            case "fileslistbox":
                EditPageHelper::GetFilesListBoxSettings($i, $_field, $this);
                break;

            case "hidden":
                EditPageHelper::GetHiddenSettings($i, $_field, $this);
                break;
            case "spaweditor":
            case "extrahtmleditor":
                EditPageHelper::GetExtraHtmlEditorSettings($i, $_field, $this);
                break;

            case "autocomplete":
                EditPageHelper::GetAutocompleteSettings($i, $_field, $this);
                break;

            default: $this->GetCustomFieldSettings($i, $_field); break;
        } // switch
        //Get
        //if this is multilanguage field
        if ($this->listSettings->HasItem("FIELD_" . $i, "IS_MULTILANG") && $this->listSettings->GetItem("FIELD_" . $i, "IS_MULTILANG")) {
            for ($j = 0; $j < sizeof($this->Kernel->Languages); $j ++) {
                $_field1 = $_field;
                $_field1["field_name"] = sprintf($_field1["field_name"], $this->Kernel->Languages[$j]);
                $_field1["lang_version"] = $this->Kernel->Languages[$j];
                $this->form_fields[$this->Kernel->Languages[$j]][] = $_field1;
            }
        }
        else {
            if (strlen($_field["group"]) == 0) {
                $_group = "main";
            }
            else {
                $_group = $_field["group"];
            }
            $this->form_fields[$_group][] = $_field;
            //if this is password
            if ($_field["control"] == "password") {
                $old_field = $_field;
                $_field["field_name"] = $_field["field_name"] . "_2";
                if ($_field["field_dublicate"]) {
                    $this->Storage->setColumnParameter($old_field["field_name"], "dublicate", 1);
                    $_field["notnull"] = 1;
                    $this->form_fields[$_group][] = $_field;
                }
            }
        }
    }

    function GetCustomFieldSettings($i, &$field){
    }

	function DrawCustomField($lang, $i, $caption,&$control){
	}

    /**
     * Method initialize library data
     * @access private
     **/
    function InitLibraryData()
    {
        if ($this->debug_mode)
            echo $this->ClassName . "::InitLibraryData();" . "<HR>";
        if ($this->listSettings->HasItem("MAIN", "DB_USE_ABSTRACTTABLE"))
            $this->use_abstracttable = $this->listSettings->GetItem("MAIN", "DB_USE_ABSTRACTTABLE");

        $use_db_columns = false;
        //--check if defined flag use database columns definition
        if ($this->listSettings->HasItem("MAIN", "DB_USE_COLUMNDEFINITION"))
            $use_db_columns = $this->listSettings->GetItem("MAIN", "DB_USE_COLUMNDEFINITION");

            if (! $this->use_abstracttable) { //--if dont use abstracttable class (use storage class)
            $this->Kernel->ImportClass("data." . strtolower($this->Table), $this->Table);
            if (! class_exists($this->Table)) { //check if class-table exists
                user_error("Can't find table class <b>$this->Table</b> for library $this->library_ID", E_USER_ERROR);
                die();
            }
            else {
                $this->Storage = new $this->Table($this->Kernel->Connection, $this->Kernel->Settings->GetItem("database", $this->Table), $use_db_columns);
            }
        }
        else { //--else (use abstracttable class)
            $this->Storage = new AbstractTable($this->Kernel->Connection, $this->Kernel->Settings->GetItem("database", $this->Table), true);
        }

        //--check if defined flag use database columns definition
        if ($this->listSettings->HasItem("MAIN", "DB_USE_COLUMNDEFINITION"))
            $use_db_columns = $this->listSettings->GetItem("MAIN", "DB_USE_COLUMNDEFINITION");
        if ($use_db_columns)
            TableHelper::prepareColumnsDB($this->Storage, true, false);

        if ($this->listSettings->HasItem("LIST", "FIELDS_COUNT")) {
            $fields_count = $this->listSettings->GetItem("LIST", "FIELDS_COUNT");
        }
        else {
            $this->AddEditErrorMessage("EMPTY_RECORDCOUNT_SETTINGS", array(), true);
        }
        $this->ProcessMainSection();

        for ($i = 0; $i < $fields_count; $i ++) {
        	if ($this->CheckFieldPackage($i))
            	$this->GetFieldSettings($i);
        } // for


    }

    function CheckFieldPackage($i){
    	$res==false;
		if ($this->listSettings->HasItem("FIELD_".$i, "PACKAGE")){
			$pkg=$this->listSettings->GetItem("FIELD_".$i, "PACKAGE");
			if (Engine::isPackageExists($this->Kernel, $pkg))
				$res=true;
		}else{
			$res=true;
		}
    	return $res;
    }

    /**
     * Method get language fields data
     * @param    string  $lang   language prefix
     * @param    array       $data   data array
     * @access public
     **/
    function GetLangFieldsData($lang, &$data){
        if ($this->debug_mode) echo $this->ClassName . "::GetLangFieldsData($lang, &$data);" . "<HR>";
        for ($i = 0; $i < sizeof($this->form_fields[$lang]); $i ++) {
            $data[$this->form_fields[$lang][$i]["field_name"]] = $this->Request->Value($this->form_fields[$lang][$i]["field_name"]);

        	switch($this->form_fields[$lang][$i]["control"]){
                case "date":
	                if ($this->form_fields[$lang][$i]["is_unix_timestamp"] == 0) {
	                    $data[$this->form_fields[$lang][$i]["field_name"]] = $this->Request->Value($this->form_fields[$lang][$i]["field_name"] . "_year") . "-" . $this->Request->Value($this->form_fields[$lang][$i]["field_name"] . "_month") . "-" . $this->Request->Value($this->form_fields[$lang][$i]["field_name"] . "_day") . "";
	                    if ($this->form_fields[$lang][$i]["fulldate"] == 1) {
	                        $data[$this->form_fields[$lang][$i]["field_name"]] .= " " . $this->Request->Value($this->form_fields[$lang][$i]["field_name"] . "_hour") . ":" . $this->Request->Value($this->form_fields[$lang][$i]["field_name"] . "_minute") . ":" . $this->Request->Value($this->form_fields[$lang][$i]["field_name"] . "_second") . "";
	                    } // fulldate
	                }
	                else { // is_unix_timestamp
	                    $data[$this->form_fields[$lang][$i]["field_name"]] = mktime($this->Request->Value($this->form_fields[$lang][$i]["field_name"] . "_hour"), $this->Request->Value($this->form_fields[$lang][$i]["field_name"] . "_minute"), $this->Request->Value($this->form_fields[$lang][$i]["field_name"] . "_second"), $this->Request->Value($this->form_fields[$lang][$i]["field_name"] . "_month"), $this->Request->Value($this->form_fields[$lang][$i]["field_name"] . "_day"), $this->Request->Value($this->form_fields[$lang][$i]["field_name"] . "_year"));
	                }
	                break;
	            case "autocomptete":
		            $items=$this->Page->Request->Value($this->form_fields[$lang][$i]["field_name"]."_Item", REQUEST_ALL, false);
	            	if (!is_array($items))$items=array($items);
	            	$data[$this->form_fields[$lang][$i]["field_name"]]=implode($this->form_fields[$lang][$i]["words_delimeter"], array_unique($items));
	          		break;

	         	case "checkbox":
                    if ($data[$this->form_fields[$lang][$i]["field_name"]] != $this->form_fields[$lang][$i]["checkOn"]){
	                    $data[$this->form_fields[$lang][$i]["field_name"]] = $this->form_fields[$lang][$i]["checkOff"];
	                }
	                break;
	         	default:
	                break;
        	}

        	$this->GetCustomFieldsData($this->form_fields[$lang][$i], $data);
        }
    }

    function GetCustomFieldsData(&$field, &$data){
    }

    /**
     * Method returns assembled data after form submittal
     * @return array  Array with data
     * @access public
     */
    function GetFieldsData()
    {
        if ($this->debug_mode)
            echo $this->ClassName . "::GetFieldsData();" . "<HR>";
        $this->GetLangFieldsData("main", $data);
        for ($j = 0; $j < sizeof($this->Kernel->Languages); $j ++) {
            $this->GetLangFieldsData($this->Kernel->Languages[$j], $data);
        } // for lang


        if (count($this->field_group_names)) {
            for ($j = 0; $j < sizeof($this->field_group_names); $j ++)
                $this->GetLangFieldsData($this->field_group_names[$j], $data);
        } //--for additional groups


        if ($this->multilevel) {
            $data[$this->parent_field] = $this->parent_id;
        }
        if (strlen($this->custom_val) && strlen($this->custom_var)) {
            $data[$this->custom_var] = $this->custom_val;
        }
        return $data;
    }

    function InitItemsEditControl(){
    	$init=array(
            "form_fields" => $this->form_fields ,
            "item_id" => $this->item_id ,
            "key_field" => $this->key_field ,
            "event" => $this->Request->Value("event") ,
            "handler" => $this->handler ,
            "package" => $this->Package ,
            "data" => $this->_data ,
            "start" => $this->start ,
            "order_by" => $this->order_by ,
            "library" => $this->library_ID ,
            "restore" => $this->restore ,
            "parent_id" => $this->parent_id ,
            "custom_var" => $this->custom_var ,
            "custom_val" => $this->custom_val ,
            "host_library_ID" => $this->host_library_ID ,
            "group_names" => $this->field_group_names ,
            "group_titles" => $this->field_group_titles);
    	$this->Controls["ItemsEdit"]->InitControl($init);
    }

    /** Method handles EditItem event
     * @access public
     */
    function OnEditItem(){
        if (! $this->error) {
            if ($this->disabled_edit) {
            }
            if ($this->item_id != 0) {

                $this->_data = $this->Storage->{$this->GetItemMethod}(array(
                $this->key_field => $this->item_id));
                $form_data = $this->Request->Form;
                $this->_data = array_merge($this->_data, $this->Request->Form);
                if ($this->multilevel) {
                    $this->parent_id = $this->_data[$this->parent_field];
                }
            }
            $this->OnBeforeCreateEditControl();
            $this->InitItemsEditControl();
        } //!error
    }

    /**
     *  BeforeCreateEditControl event handler (prototype)
     *  @access private
     **/
    function OnBeforeCreateEditControl(){
    }

    /**
     * Method set record system fields (ownername,creatername,createddate)
     * @param      array       $data       record data after submit
     * @param      array       $item       record data from DB
     * @access     private
     **/
    function setItemSystemFields($data, $item){
        if ($this->debug_mode)
            echo $this->ClassName . "setItemSystemFields();" . "<HR>";
        foreach ($item as $key => $value) {
        	if($key == '_lastmodified'){
        		continue;
        	}
            if ((substr($key, 0, 1) == "_") && (! isset($data[$key]))) {
                $data[$key] = $value;
            }
        }
        if (isset($data['_lastmodified'])) {
        	unset ($data['_lastmodified']);
        }
    }

    /**
     * Method updates radio fields if any
     * @access private
     **/
    function UpdateRadioFields(){
        $_tabs = array_keys($this->form_fields);
        foreach ($_tabs as $_tab) {
            $sizeof = sizeof($this->form_fields[$_tab]);
            for ($j = 0; $j < $sizeof; $j ++) {
                if ($this->form_fields[$_tab][$j]["control"] == "checkbox") {
                    $valueOn = $this->form_fields[$_tab][$j]["checkOn"];
                    $valueOff = $this->form_fields[$_tab][$j]["checkOff"];
                    $isRadio = $this->form_fields[$_tab][$j]["is_radio"];
                    if ($isRadio) {
                        if ($this->_data[$this->form_fields[$_tab][$j]["field_name"]] == $valueOn) {
                            $this->Storage->GroupUpdate($this->custom_var, array(
                            $this->custom_val), array(
                            $this->form_fields[$_tab][$j]["field_name"] => $valueOff));
                        }
                    }
                }
            }
        } // foreach
    }

    /** Method handles DoEditItem event
     * @access public
     */
    function OnDoEditItem(){
        if (! $this->error) {
            $this->_data = $this->GetFieldsData();
            $this->_data[$this->key_field] = $this->item_id;

            $this->ValidateBeforeAdd();

            $item = $this->Storage->{$this->GetItemMethod}(array(
            $this->key_field => $this->item_id));
            //set system fields
            $this->setItemSystemFields($this->_data, $item);

            //check for unique fields
            if ($this->listSettings->HasItem("MAIN", "UNIQUE_FIELDS")) {
                $this->checkForDuplicateUnique();
            }

            if ($this->disabled_edit) {
                if (strlen($this->host_library_ID)) {
                    $this->library_ID = $this->host_library_ID;
                }
                $this->AfterSubmitRedirect("?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "&MESSAGE[]=LIBRARY_DISABLED_EDIT" . "&" . $this->restore);
            }
            if (empty($this->validator->formerr_arr) && ! $this->child_error) {
                if (strlen($this->host_library_ID)) {
                    $this->library_ID = $this->host_library_ID;
                    $this->parent_id = $this->Request->ToNumber("custom_val", 0);
                }
                //before edit event handler call
                $this->OnBeforeEdit();
                $this->UpdateRadioFields();
                $_result = $this->Storage->Update($this->_data);
                if ($_result){
                    $this->InsertNotOrdinaryFields($this->_data);
                    //after edit event handler call
                    $this->OnAfterEdit();
                    if ($this->is_context_frame)
                    	$url = "?package=context&page=contextframe&event=refresh&MESSAGE[]=EDIT_ITEM_SAVED";
                    else
                    	$url = "?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "&MESSAGE[]=EDIT_ITEM_SAVED"  . "&" . $this->restore;

                    $this->AfterSubmitRedirect($url);
                }
            }
            else {
                $this->event = "EditItem";
            }
            $this->OnBeforeCreateEditControl();
            $this->InitItemsEditControl();
        }
    }

    function OnDoApplyItem(){
        if (! $this->error) {
            $this->_data = $this->GetFieldsData();
            $this->_data[$this->key_field] = $this->item_id;
            $this->ValidateBeforeAdd();
            $item = $this->Storage->Get(array($this->key_field => $this->item_id));
            //set system fields
            $this->setItemSystemFields($this->_data, $item);
            //check for unique fields
            if ($this->listSettings->HasItem("MAIN", "UNIQUE_FIELDS"))
                $this->checkForDuplicateUnique();

            if ($this->disabled_edit) {
                if (strlen($this->host_library_ID))
                    $this->library_ID = $this->host_library_ID;
                $this->AfterSubmitRedirect("?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "&MESSAGE[]=LIBRARY_DISABLED_EDIT" . "&" . $this->restore);
            }
            if (empty($this->validator->formerr_arr) && ! $this->child_error) {
            	$library_ID = $this->library_ID;
                if (strlen($this->host_library_ID)) {
                    $this->library_ID = $this->host_library_ID;
                    $this->parent_id = $this->Request->ToNumber("custom_val", 0);
                }
                //before edit event handler call
                $this->OnBeforeEdit();
                $this->UpdateRadioFields();
                $_result = $this->Storage->Update($this->_data);
                if ($_result){
                    $this->InsertNotOrdinaryFields($this->_data);
                    //after edit event handler call
                    $this->OnAfterEdit();
                    $url = "?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=".$this->handler."&library=".$library_ID."&host_library_ID=".$this->host_library_ID."&event=EditItem"."&item_id=".$this->item_id."&start=".$this->start."&order_by=".$this->order_by."&".$this->library_ID."_parent_id=".$this->parent_id."&MESSAGE[]=EDIT_ITEM_APPLIED"."&restore=".str_replace("&amp;", "&", rawurlencode($this->restore)).($this->custom_var!="" ? "&custom_var=".$this->custom_var : "").($this->custom_val!="" ? "&custom_val=".$this->custom_val : "");

                    $this->AfterSubmitRedirect($url);
                }
            }
            else {
                $this->event = "EditItem";
            }
            $this->OnBeforeCreateEditControl();
            $this->InitItemsEditControl();
        }
    }

    /**
     * BeforeEdit event handler (prototype)
     * @access       private
     **/
    function OnBeforeEdit(){
    }

    /**
     * AfterEdit event handler (prototype)
     * @access       private
     **/
    function OnAfterEdit(){
    }

    /** Method check if fields are unique
     * @access   private
     **/
    function checkForDuplicateUnique(){
        $_ufields_arr = explode(",", $this->listSettings->GetItem("MAIN", "UNIQUE_FIELDS"));
        $check_fields = true;
        for ($i = 0; $i < sizeof($_ufields_arr); $i ++) {
            list ($_field[$i], $_value[$i]) = explode("=", $_ufields_arr[$i]);
            if (strlen($_value[$i])) {
                $check_fields = false;
                $_query_arr[$_field[$i]] = $_value[$i];
                if ($this->_data[$_field[$i]] == $_value[$i]) {
                    $check_fields = true;
                }
            }
            else {
                $_query_arr[$_field[$i]] = $this->_data[$_field[$i]];
            }
        }
        if ($check_fields) {
            $_data = $this->Storage->GetByFields($_query_arr, null);
        }
        else {
            $_data = array();
        }
        if (! empty($_data)) {
            if (($this->item_id != $_data[$this->key_field])) {
                if ($this->Kernel->Errors->HasItem($this->library_ID, "RECORD_EXISTS")) {
                    $_error_section = $this->library_ID;
                }
                else {
                    $_error_section = "GlobalErrors";
                }
                $this->validator->SetCustomError($_ufields_arr, "RECORD_EXISTS", $_error_section);
            }
        }
    }
    /** Method handles AddItem event
     * @access public
     */
    function OnAddItem(){
        $this->_data = $this->Request->Form;
        $this->OnBeforeCreateEditControl();
        if (! $this->error) {
        	$this->InitItemsEditControl();
            if ($this->disabled_add) {
                if (strlen($this->host_library_ID)) {
                    $this->library_ID = $this->host_library_ID;
                }
                /**
                 * @todo fix here (recursion)
                 */
                $this->AfterSubmitRedirect("?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "&MESSAGE[]=LIBRARY_DISABLED_ADD" . "&" . $this->restore);
            }

        }
    }
    /** Method handles GoBack event
     * @access public
     */
    function OnGoBack(){
        if (strlen($this->host_library_ID))
            $this->library_ID = $this->host_library_ID;

        if ($this->is_context_frame)
			$url = "?package=context&page=contextframe&event=close";
		else
			$url ="?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "&" . $this->restore;

        $this->AfterSubmitRedirect($url);
    }

    /**
     * Method validate form before add item
     * @access private
     **/
    function ValidateBeforeAdd(){
        $this->validator->ValidateForm($this->_data, true);
    }

    /** Method handles DoAddItem event
     * @access public
     */
    function OnDoAddItem(){
        if (! $this->error) {
            $this->_data = $this->GetFieldsData();
            //validate form
            $this->ValidateBeforeAdd();

            if ($this->listSettings->HasItem("MAIN", "UNIQUE_FIELDS")) {
                $this->checkForDuplicateUnique();
            }

            if ($this->disabled_add) {
                if (strlen($this->host_library_ID)) {
                    $this->library_ID = $this->host_library_ID;
                }
                $this->AfterSubmitRedirect("?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "&MESSAGE[]=LIBRARY_DISABLED_ADD" . "&" . $this->restore);
            }
            if (empty($this->validator->formerr_arr)) {
                if (strlen($this->host_library_ID)) {
                    $this->library_ID = $this->host_library_ID;
                }
                //do method before add
                $this->OnBeforeAdd();
                //if not set custom error
                if (! $this->custom_error) {
                    $this->UpdateRadioFields();
                    $_status = $this->Storage->Insert($this->_data);
                    //$_status = 1;
                    if ($_status) {
                        //--update _priority field, if defined
                        if (! $this->disabled_move) {
                            if ($this->key_field != $this->move_field) {
                                $data = array(
                                $this->key_field => $this->Storage->getInsertId() ,
                                $this->move_field => $this->Storage->getInsertId());
                            }
                            if (! $this->_data['_priority']) {
                                $this->Storage->Update($data);
                            }
                        }
                        $this->InsertNotOrdinaryFields($this->_data);

                        //do method after add
                        $this->OnAfterAdd($this->_data);

                        if ($this->is_context_frame)
							$url = "?package=context&page=contextframe&event=refresh&MESSAGE[]=EDIT_ITEM_CREATED";
						else
							$url = "?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "&" . $this->restore;

                        //redirect after add
                        $this->AfterSubmitRedirect($url);
                    }
                }
            }
            else {
                $this->event = "AddItem";
            }
            if (is_object($this->Controls["ItemsEdit"])) {
                $this->OnBeforeCreateEditControl();
                $this->InitItemsEditControl();
            }
        }
    }

    /**
     * Method redirect after add or edit item
     * @param      string      $url        Redirect URL
     **/
    function AfterSubmitRedirect($url){
    	if ($this->is_context_frame)$url.="&contextframe=1";
        $this->Response->Redirect($url);
    }

    /**
     * Event handler before record added to library
     *
     */
    function OnBeforeAdd(){
    }

    /**
     * Event handler after record added to library, but before run redirect to list page
     * @access private
     */
    function OnAfterAdd(){
        //get keyfield value
        if (intval($this->item_id) == 0)
            $data = $this->Storage->GetRecord(null, array(
            $this->key_field => ""));
        $this->item_id = $data[$this->key_field];
    }

    /**
     * Method insert data for non-ordinary fields (dbcombobox multiple)
     * @param array  $data    input data
     * @access       public
     **/
    function InsertNotOrdinaryFields($data){
        if ($this->nonordinary) {
            foreach ($this->form_fields as $sectionname => $section) {
                foreach ($section as $number => $field) {
                    switch ($field["control"]) {
                        case "dbcombobox":
                        case "dbcheckboxgroup":
                        case "dbtreecombobox":
                        case "checkboxgroup":
                            if ($field["multiple"])
                            EditPageHelper::InsertDBMultipleField($field, $this);
                            break;
                        case "autocomplete":
                        	if ($field["field_table"]!="")
                              EditPageHelper::InsertAutocompleteField($field,$this, $data[$this->key_field]);break;
                        default:
                            $this->InsertCustomNotOrdinaryField($field);
                        	break;

                    }
                }
            }
        }
    }

    function InsertCustomNotOrdinaryField(&$field){
    }

    /**
     * Method deletes data for non-ordinary fields (dbcombobox multiple, dbtreecombobox)
     * @param array  $data    input data
     * @access       public
     */
    function DeleteNotOrdinaryFields($fields = array()){
        if ($this->nonordinary) {
            foreach ($this->form_fields as $sectionname => $section) {
                foreach ($section as $number => $field) {
                    switch ($field["control"]) {
                        case "dbcombobox":
                        case "dbcheckboxgroup":
                        case "checkboxgroup":
                        case "dbtreecombobox":
                            if ($field["multiple"])
                                EditPageHelper::DeleteDBMultipleField($field, $fields, $this);
                            break;
                        case "autocomplete":
                        	if ($field["field_table"]!="")
                              EditPageHelper::DeleteAutocompleteField($field, $fields, $this);break;
                        default:
                        	$this->DeleteCustomNotOrdinaryField($field, $fields);
                            break;
                    }

                }
            }
        }
    }

    function DeleteCustomNotOrdinaryField(&$field, &$fields){

    }

    /**
     * Method checks if selected record has assosiated children
     * @param      array       $id     array of ID of record to check
     * @return     mixed      Error messages string on has, false on doesnt
     * @access     public
     */
    function HasChildNodes($id){
        $error = 0;
        if ($this->parent_field == "null") {
            return false;
        }
        for ($j = 0; $j < sizeof($id); $j ++) {
            if ($this->multilevel) {
                $nodes_count = $this->Storage->GetCount(array(
                $this->parent_field => $id[$j]));

                if ($nodes_count > 0) {
                    $error = 1;
                    $message .= "&MESSAGE[]=NOT_EMPTY_NODE{ ¹" . $id[$j] . " }";
                }
                if ($this->use_sub_categories) {
                    for ($i = 0; $i < sizeof($this->sub_categories); $i ++) {
                        $sub_listSettings = Engine::getLibrary($this->Kernel, $this->sub_categories[$i]["library"], "sub_ListSettings_" . $this->sub_categories[$i]["library"]);
                        $sub_table = $sub_listSettings->GetItem("MAIN", "TABLE");
                        $this->Kernel->ImportClass("data." . strtolower($sub_table), $sub_table);
                        $sub_Storage = new $sub_table($this->Kernel->Connection, $this->Kernel->Settings->GetItem("database", $sub_table));
                        $categories_count = $sub_Storage->GetCount(array(
                        $this->sub_categories[$i]["link_field"] => $id[$j]));
                        if ($this->Kernel->Errors->HasItem("MESSAGES", "NOT_EMPTY_SUB_CATEGORY_" . strtoupper($this->sub_categories[$i]["library"]))) {
                            $error_message_name = "NOT_EMPTY_SUB_CATEGORY_" . strtoupper($this->sub_categories[$i]["library"]);
                        }
                        else {
                            $error_message_name = "NOT_EMPTY_SUB_CATEGORY";
                        }

                        if ($categories_count > 0) {
                            $error = 1;
                            $message .= "&MESSAGE[]=" . $error_message_name . "{¹" . $id[$j] . "," . $this->sub_categories[$i]["library"] . "}";
                        }
                    } // for
                } // use_sub_cat
            }
            else {
                $error = 0;
            }
        }

        return ($error ? $message : false);
    }

    /** Method handles DeleteItem event
     * @access public
     */
    function OnDeleteItem(){
        if (! $this->error) {
            $data = array($this->key_field => $this->item_id);
            if (strlen($this->host_library_ID)) {
                $this->library_ID = $this->host_library_ID;
            }

            if ($this->disabled_delete) {
                $this->OnAfterError();
                $this->AfterSubmitRedirect("?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "&MESSAGE[]=LIBRARY_DISABLED_DELETE" . "&" . $this->restore);
            }
            $errors = $this->HasChildNodes(array($this->item_id));
            if (! strlen($errors)) {
                $this->OnBeforeDeleteItem();
                $this->Storage->Delete($data);
                $this->DeleteNotOrdinaryFields();
                $this->OnAfterDeleteItem();
                $this->AfterSubmitRedirect("?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "&MESSAGE=MSG_ITEM_DELETED" . "&" . $this->restore);
            }
            else {
                $this->OnAfterError();
                $this->AfterSubmitRedirect("?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "" . $errors . "" . "&" . $this->restore);
            }
        }
    }
    /**
     * Copy item event handler
     * @access   private
     **/
    function OnCopyItem(){
        if (! $this->error) {
            $data = array($this->item_id);
            if (strlen($this->host_library_ID)) {
                $this->library_ID = $this->host_library_ID;
            }
            if ($this->disabled_copy) {
                $this->OnAfterError();
                $this->AfterSubmitRedirect("?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "&MESSAGE[]=LIBRARY_DISABLED_COPY" . "&" . $this->restore);
            }

            if (! strlen($errors)) {
                $this->Copy($data);
                $this->AfterSubmitRedirect("?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "&MESSAGE=MSG_ITEM_COPIED" . "&" . $this->restore);
            }
            else {
                $this->OnAfterError();
                $this->AfterSubmitRedirect("?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "" . $errors . "" . "&" . $this->restore);
            }
        }
    }

    /**
     * Method copy  items (include sub categories linked records)
     * @param    array   $data       array of keyfields values
     * @access   private
     **/
    function Copy(&$data){
        // -- get storage
        $storageName = $this->listSettings->GetItem("MAIN", "TABLE");
        $this->Kernel->ImportClass("data." . $storageName, $storageName);
        $Storage = new $storageName($this->Kernel->Connection, $this->Kernel->Settings->GetItem("database", $storageName));

        //return;
        //-- get copy field name
        if ($this->listSettings->HasItem("MAIN", "COPY_NAME_FIELD")) {
            $_name_field = $this->listSettings->GetItem("MAIN", "COPY_NAME_FIELD");
        }
        else {
            $_name_field = TableHelper::GetFirstNotKeyColumn($Storage);
        }

        $this->copy_Storage = $Storage;
        // insert loop
        foreach ($data as $i => $item_id) {
            //get record
            $record = $Storage->Get(array(
            $this->key_field => $item_id));
            //get copy records count
            $_count = $Storage->GetCount(array(
            $_name_field => $record[$_name_field] . " (%)"));

            $_count ++;
            $record[$_name_field] = $record[$_name_field] . " ($_count)";
            //insert record


            $Storage->Insert($record);

            // get ID of inserted record
            $insert_id = $Storage->getInsertId();
            // get priority column
            if ($this->listSettings->HasItem("Main", "COPY_NAME_FIELD")) {
                $priority_column = $this->listSettings->GetItem("Main", "COPY_NAME_FIELD");
            }
            elseif ($Storage->HasColumn("_priority")) {
                $priority_column = "_priority";
            }

            if (strlen($priority_column)) { // if priority column exists
                $priority_data = array(
                $this->key_field => $insert_id ,
                $priority_column => $insert_id);
                if (count($unique_fields)) { // if unique fields is found
                    foreach ($unique_fields as $i => $ufield) {
                        if ($ufield != $_name_field)
                            $priority_data[$ufield] = $record[$ufield] . " (" . $insert_id . ")";
                    }
                }
                // update priority and unique field
                $Storage->Update($priority_data);
            }

            if ($this->listSettings->HasItem("MAIN", "USE_SUB_CATEGORIES")) {
                $use_sub_categories = $this->listSettings->GetItem("MAIN", "USE_SUB_CATEGORIES");
            }
            else {
                $use_sub_categories = false;
            }

            //--if library use subcategories
            if ($use_sub_categories) {
                $message = "";
                $sub_categories_count = $this->listSettings->GetItem("MAIN", "SUB_CATEGORIES_COUNT");
                // subcategories loop
                for ($i = 0; $i < sizeof($sub_categories_count); $i ++) {
                    // get library settings
                    $library = $this->listSettings->GetItem("sub_category_" . $i, "APPLY_LIBRARY");
                    $link_field = $this->listSettings->GetItem("sub_category_" . $i, "LINK_FIELD");
                    // get subcategory library config
                    $sub_listSettings = Engine::getLibrary($this->Kernel, $library, "sub_ListSettings_" . $library);

                    //-- get subcategory storage
                    $sub_table = $sub_listSettings->GetItem("MAIN", "TABLE");
                    $this->Kernel->ImportClass("data." . strtolower($sub_table), $sub_table);
                    $sub_Storage = new $sub_table($this->Kernel->Connection, $this->Kernel->Settings->GetItem("database", $sub_table));

                    //--get subcategory items
                    $list = $sub_Storage->GetList(array(
                    $link_field => $item_id));

                    //-- get priority column
                    $priority_column = "";
                    if ($sub_listSettings->HasItem("Main", "COPY_NAME_FIELD")) {
                        $priority_column = $sub_listSettings->GetItem("Main", "COPY_NAME_FIELD");
                    }
                    elseif ($sub_Storage->HasColumn("_priority")) {
                        $priority_column = "_priority";
                    }
                    //--get unique columns
                    $unique_fields = array();
                    if ($sub_listSettings->HasItem("MAIN", "UNIQUE_FIELDS")) {
                        $unique_fields = explode(",", $sub_listSettings->GetItem("MAIN", "UNIQUE_FIELDS"));
                    }
                    // get subcategory key field
                    $sub_keyfields = $sub_Storage->getKeyColumns();
                    $sub_keyfield = $sub_keyfields[0]["name"];

                    if ($list->RecordCount != 0) {
                        while ($sub_item = $list->Read()) {
                            $sub_item[$link_field] = $insert_id;

                            // insert subcategory
                            $sub_Storage->Insert($sub_item);

                            //get inserted subcategory ID
                            $sub_list = $sub_Storage->GetList(array(), array(
                            $sub_keyfield => 0), 1, 0);
                            $sub_item = $sub_list->Read();
                            $sub_insert_id = $sub_item[$sub_keyfield];
                            if (strlen($priority_column)) { // if priority column exists
                                $priority_data = array(
                                $sub_keyfield => $sub_insert_id ,
                                $priority_column => $sub_insert_id);
                                if (count($unique_fields)) { // if unique fields is found
                                    foreach ($unique_fields as $i => $ufield) {
                                        if ($ufield != $_name_field)
                                            $priority_data[$ufield] = $sub_item[$ufield] . " (" . $sub_insert_id . ")";
                                    }
                                }
                                // update priority and unique fields
                                $sub_Storage->Update($priority_data);
                            }
                        }
                    }
                } // for
            }
            $this->OnAfterCopy($item_id, $insert_id);
        }
    }

    /**
     * After copy one item event hanlder
     * @param    int $original_id     Original item ID
     * @param    int $copy_id         Copy item ID
     * @access   private
     **/
    function OnAfterCopy($original_id, $copy_id){
    }
    /**
     * Before item delete event handler (prototype)
     * @access private
     **/
    function OnBeforeDeleteItem(){
    }

    /**
     * After item delete event handler (prototype)
     * @access private
     **/
    function OnAfterDeleteItem(){
    }

    /**
     * After error event handler (prototype)
     * @access private
     **/
    function OnAfterError(){
    }

    /**
     * Before apply event handler (prototype)
     * @access private
     **/
    function OnBeforeApply(){
    }

    /** Method handles Apply event
     * @access public
     */
    function OnApply(){
        $this->OnBeforeApply();
        if (! $this->error) {

            $custom_vars = $this->Request->Value("custom_vars");
            $edit_custom_vars = $this->Request->Value("edit_custom_vars");
            $items = $this->Request->Value("items");
            $delete_item = $this->Request->Value("delete_item");
            $copy_item = $this->Request->Value("copy_item");

            if (strlen($this->host_library_ID)) {
                $this->library_ID = $this->host_library_ID;
            }

            for ($i = 0; $i < sizeof($custom_vars); $i ++) {
                $custom_items[$custom_vars[$i]] = $this->Request->Value($custom_vars[$i]);

                $_tabs = array_keys($this->form_fields);
                foreach ($_tabs as $_tab) {

                    for ($j = 0; $j < sizeof($this->form_fields[$_tab]); $j ++) {
                        if (($this->form_fields[$_tab][$j]["field_name"] == $custom_vars[$i]) && (($this->form_fields[$_tab][$j]["control"] == "checkbox") || ($this->form_fields[$_tab][$j]["control"] == "radio"))) {
                            $valueOn = $this->form_fields[$_tab][$j]["checkOn"];
                            $valueOff = $this->form_fields[$_tab][$j]["checkOff"];
                            $isRadio = $this->form_fields[$_tab][$j]["is_radio"];
                        }
                    }
                } // -- apply changes to records
                reset($this->Kernel->Languages);
                if (! empty($custom_items[$custom_vars[$i]])) {
                    if (! $this->disabled_apply) {
                        $this->Storage->GroupUpdate($this->key_field, array_values($custom_items[$custom_vars[$i]]), array(
                        $custom_vars[$i] => $valueOn));
                        $message = "&MESSAGE[]=MSG_CHANGES_APPLIED";
                    }
                    else {
                        $message = "&MESSAGE[]=LIBRARY_DISABLED_APPLY";
                    }
                }

                $_tmp_items = array_values(array_diff($items, (is_array($custom_items[$custom_vars[$i]]) ? $custom_items[$custom_vars[$i]] : array())));
                if (! empty($_tmp_items)) {
                    if (! $this->disabled_apply) {
                        $this->Storage->GroupUpdate($this->key_field, $_tmp_items, array(
                        $custom_vars[$i] => $valueOff));
                        if (! strlen($message))
                            $message = "&MESSAGE[]=MSG_CHANGES_APPLIED";
                    }
                    else {
                        $message .= "&MESSAGE[]=LIBRARY_DISABLED_EDIT";
                    }
                }

            } //for

            for ($i = 0; $i < sizeof($edit_custom_vars); $i ++) {
                $update_field_name = $edit_custom_vars[$i];
                $edit_custom_items = $this->Request->Value($edit_custom_vars[$i], REQUEST_ALL, false);
                if (is_array($edit_custom_items) && ! empty($edit_custom_items)) {
                    foreach ($edit_custom_items as $item_id => $value) {
                        $data = array(
                        $this->key_field => $item_id ,
                        $update_field_name => $value);
                        $this->Storage->Update($data);
                    }
                }
            }

            //--delete records
            $this->apply_deleted = 0;
            if (is_array($delete_item) && ! empty($delete_item)) {
                $this->delete_items = array_values($delete_item);
                $errors = $this->HasChildNodes(array_values($delete_item));
                if ($errors === false) {
                    if (! $this->disabled_delete) {
                        $this->Storage->Groupdelete($this->key_field, array_values($delete_item));
                        $this->DeleteNotOrdinaryFields(array_values($delete_item));
                        $this->apply_deleted = 1;
                        $message .= "&MESSAGE[]=MSG_ITEMS_DELETED";
                    }
                    else {
                        $message .= "&MESSAGE[]=LIBRARY_DISABLED_DELETE";
                    }
                }
            }
            //--copy records
            if (! empty($copy_item) && ! $this->disabled_copy) {
                $this->Copy($copy_item);
                $message .= "&MESSAGE[]=MSG_ITEMS_COPIED";
            }

            if (strlen($errors) != 0)
                $message .= $errors;
            $this->OnAfterApply();
            list ($tmp, $requestString) = preg_split("/[?]/", $_SERVER["REQUEST_URI"]);
            $this->AfterSubmitRedirect("?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "" . $message . "" . (($errors === false) || strlen($message) ? "" : $errors) . "" . "&" . str_replace("&amp;", "&", rawurldecode($this->restore)) . "&" . $requestString);
        }
    }

    /**
     * After apply event handler (prototype)
     * @access private
     **/
    function OnAfterApply(){
    }

    /**
     * MEthod deletes all nodes and associated categories data at once. Is a response on MegaDelete event
     * @access public
     */
    function OnMegaDelete(){
        if (! $this->error && $this->mega_delete) {

            if ($this->disabled_delete) {
                if (strlen($this->host_library_ID)) {
                    $this->library_ID = $this->host_library_ID;
                }
                $this->AfterSubmitRedirect("?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "&MESSAGE[]=LIBRARY_DISABLED_DELETE" . "&" . $this->restore);
            }
            $items = $this->Request->Value("items");
            $delete_item = $this->Request->Value("delete_item");
            if (! empty($delete_item)) {
                $nodes = $nodes_id = array();
                for ($i = 0; $i < sizeof($delete_item); $i ++) {
                    $nodes_id = array_merge($nodes_id, array($delete_item[$i]));
                	$DeleteItemTree=$this->Storage->GetTreeData(null, $this->parent_field);
                    $this->GetChildNodes($DeleteItemTree[$delete_item[$i]]["_children"], $nodes_id);
                }
                $this->OnBeforeMegaDelete(array_values($nodes_id));
                $this->Storage->Groupdelete($this->key_field, array_values($nodes_id));
                $this->DeleteNotOrdinaryFields(array_values($nodes_id));
                if ($this->use_sub_categories) {
                    $message = "";
                    for ($i = 0; $i < sizeof($this->sub_categories); $i ++) {
                        $sub_listSettings = Engine::getLibrary($this->Kernel, $this->sub_categories[$i]["library"], "sub_ListSettings_" . $this->sub_categories[$i]["library"]);
                        $sub_table = $sub_listSettings->GetItem("MAIN", "TABLE");
                        $this->Kernel->ImportClass("data." . strtolower($sub_table), $sub_table);
                        $sub_Storage = new $sub_table($this->Kernel->Connection, $this->Kernel->Settings->GetItem("database", $sub_table));
                        $this->deleted_nodes_id = array_values($nodes_id);
                        $this->current_sub_category = $this->sub_categories[$i];
                        $this->OnBeforeSubMegaDelete($sub_Storage);
                        $sub_Storage->Groupdelete($this->sub_categories[$i]["link_field"], array_values($nodes_id));
                        $this->DeleteNotOrdinaryFields(array_values($nodes_id));
                        $message .= "&MESSAGE[]=MEGA_DELETE_SUB_CATEGORY_APPLIED{" . $this->sub_categories[$i]["library"] . "}";
                    } // for
                } // use_sub_cat
                $this->OnAfterMegaDelete(array_values($nodes_id));
            } //!empty


            if (strlen($this->host_library_ID)) {
                $this->library_ID = $this->host_library_ID;
            }
            $this->AfterSubmitRedirect("?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "&MESSAGE[]=MSG_MEGA_DELETE_APPLIED" . $message . "" . "&" . str_replace("&amp;", "&", rawurldecode($this->restore)));
        }
    }

    function GetChildNodes(&$tree, &$nodes_id){
		if (is_array($tree)){
			foreach($tree as $i=>$node){
				$nodes_id[]=$i;
				if (!empty($node["_children"])){
					$this->GetChildNodes($node["_children"], $nodes_id);
				}
			}
		}
    }

    /**
     * method executes before deleting sub-categories when mega-delete is in action (prototype)
     * @param   AbstractTable $sub_Storage Subcategory table object
     * @access   public
     **/
    function OnBeforeSubMegaDelete(&$sub_Storage){
    }

    function OnBeforeMegaDelete($nodes_id){
    }

    function OnAfterMegaDelete($nodes_id){
    }

    function OnMove()
    {
        set_time_limit(0);
        if (strlen($this->host_library_ID)) {
            //$_library_path = $this->Page->Kernel->Package->Settings->GetItem("main", "LibrariesRoot");
            $listSettings = Engine::getLibrary($this->Kernel, $this->library_ID, "ListSettings_parent");
            $listSettings->reParse();
            if ($listSettings->HasItem("MAIN", "ENABLE_NODE_MOVE")) {
                $this->parent_node_move = $listSettings->GetItem("MAIN", "ENABLE_NODE_MOVE");
            }
            else {
                $this->parent_node_move = 1;
            }
        }

        if (! $this->error && ($this->node_move || $this->parent_node_move)) {
            $self_nested = array();
            $new_parent = $this->Request->ToNumber("destination", 0);
            $items = $this->Request->Value("item");

            for ($i = 0; $i < sizeof($items); $i ++) {
                if ($this->multilevel) {
                    $nested_keys = $this->Storage->GetNestedIDs($items[$i], $this->parent_field);
                    if ($new_parent == $items[$i]) {
                        $self_nested[] = $items[$i];
                        $message .= "&MESSAGE[]=SELF_NESTED_NODE_CONFLICT{¹" . $items[$i] . "}";
                    }

                }
                else {
                    $nested_keys = array();
                }
                for ($j = 0, $size = sizeof($nested_keys); $j < $size; $j ++) {
                    if ($new_parent == $nested_keys[$j]) {
                        $self_nested[] = $items[$i];
                        $message .= "&MESSAGE[]=SELF_NESTED_NODE_CONFLICT{¹" . $nested_keys[$j] . "}";
                    }

                }
            }
            if (! empty($self_nested)) {
                $items = array_values(array_diff($items, $self_nested));
            }
            if (! empty($items)) {
                if (strlen($this->host_library_ID) && strlen($this->custom_var)) {
                    $this->parent_field = $this->custom_var;
                }
                if ($this->OnBeforeMove(array_values($items), $new_parent)) {
                    $this->Storage->GroupUpdate($this->key_field, array_values($items), array(
                    $this->parent_field => $new_parent));
                    $this->OnAfterMove(array_values($items), $this->parent_field, $new_parent);
                    $message .= "&MESSAGE[]=MOVE_NODES_APPLIED{ ¹" . $new_parent . " }";
                }
                else {
                }
            } // !empty
            else {
                $message .= "&MESSAGE[]=EMPTY_MOVE_LIST";
            }

            if (strlen($this->host_library_ID)) {
                $this->library_ID = $this->host_library_ID;
            }

        }
        $this->AfterSubmitRedirect("?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "" . $message . "" . "&" . str_replace("&amp;", "&", rawurldecode($this->restore)));
    }

    function OnBeforeMove($ids, $new_parent){
        return true;
    }

    function OnAfterMove($ids, $new_parent){
        return true;
    }
    /**
     * Method redirects user to selected branch of tree
     * @access   public
     */
    function OnJump(){
        if (! $this->error) {
            $new_parent = $this->Request->ToNumber("destination", 0);
            if (strlen($this->host_library_ID)) {
                $this->library_ID = $this->host_library_ID;
            }
            $this->AfterSubmitRedirect("?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $new_parent . "" . $message);
        }
    }

    /**
     *  Method draws xml-content of control
     *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
     *  @access  public
     */
    function XmlControlOnRender(&$xmlWriter){
        if ($this->debug_mode) echo $this->ClassName . '::XmlControlOnRender(&$xmlWriter);' . "<HR>";

        $xmlWriter->WriteElementString("_PageTitle", $this->Kernel->Localization->GetItem(strtoupper($this->library_ID), "_EDIT_TITLE"));
        $xmlWriter->WriteElementString("list_handler", $this->listHandler);
        if ($this->disabled_delete)
        	$xmlWriter->WriteElementString("disabled_delete", "yes");
        else
            $xmlWriter->WriteElementString("disabled_delete", "no");

        if ($this->disabled_edit)
            $xmlWriter->WriteElementString("disabled_edit", "yes");
        else
            $xmlWriter->WriteElementString("disabled_edit", "no");

        if ($this->disabled_add)
            $xmlWriter->WriteElementString("disabled_add", "yes");
        else
            $xmlWriter->WriteElementString("disabled_add", "no");

        if ($this->disabled_copy)
            $xmlWriter->WriteElementString("disabled_copy", "yes");
        else
            $xmlWriter->WriteElementString("disabled_copy", "no");

        if (strlen($this->icon_file))
            $xmlWriter->WriteElementString("icon_file", $this->icon_file);

        if ((($this->event == "AddItem") || ($this->event == "DoAddItem")) && $this->disabled_add) {
            $xmlWriter->WriteElementString("disabled_button", "yes");
        } else {
            if ((($this->event == "EditItem") || ($this->event == "DoEditItem")) && $this->disabled_edit)
                $xmlWriter->WriteElementString("disabled_button", "yes");
            else
                $xmlWriter->WriteElementString("disabled_button", "no");
        }
        parent::XmlControlOnRender($xmlWriter);
    }

    /**
     * Method set field parameter
     * @param  string  $fieldname    field name
     * @param  string  $parameter    parameter name
     * @param  mixed    $value        parameter value
     **/
    function SetFieldParameter($fieldname, $parameter, $value){
        foreach ($this->form_fields as $prefix => $form) {
            for ($i = 0; $i < sizeof($form); $i ++) {
                if ($form[$i]["field_name"] == $fieldname) {
                    $this->form_fields[$prefix][$i][$parameter] = $value;
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Move one record up, event handler.
     * @access private
     **/
    function OnMoveUp(){
        $this->Move();
        $message = "&MESSAGE=MSG_ITEM_MOVED";
        $this->AfterSubmitRedirect("?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "" . $message . "" . "&" . str_replace("&amp;", "&", rawurldecode($this->restore)));
    }

    /**
     * Move one record down, event handler.
     * @access private
     **/
    function OnMoveDown(){
        $this->Move();
        $message = "&MESSAGE=MSG_ITEM_MOVED";
        $this->AfterSubmitRedirect("?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->listHandler . "&" . $this->library_ID . "_start=" . $this->start . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&library=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->parent_id . "" . $message . "" . "&" . str_replace("&amp;", "&", rawurldecode($this->restore)));
    }

    /**
     * Move one record up or down  method
     * @access private
     **/
    function Move(){
        //--get request values
        $move_library = $this->Request->Value("move_library");
        $item_id = $this->Request->Value("item_id");
        $move_id = $this->Request->Value("move_id");

        if (intval($move_id) == 0)
            return false;
            //--get move config file and move storage object
        $move_config = Engine::getLibrary($this->Kernel, $move_library, "move_library_config_" . $this->move_library);
        $move_Storage = DataFactory::GetStorage($this, $move_config->GetItem("MAIN", "TABLE"));

        //--get move field
        if ($move_config->HasItem("MAIN", "MOVE_FIELD")) {
            $move_field = $move_config->GetItem("MAIN", "MOVE_FIELD");
        }
        else {
            if ($move_Storage->HasColumn("_priority") !== false) {
                $move_field = "_priority";
            }
            else {
                $inc_column = $move_Storage->GetIncrementalColumn();
                $move_field = $inc_column["name"];
            }
        }

        //get key field
        $inc_column = $move_Storage->GetIncrementalColumn();
        $key_field = $inc_column["name"];
        //get current item
        $item = $move_Storage->Get(array(
        $key_field => $item_id));
        $move_item = $move_Storage->Get(array($key_field => $move_id));

        //--if near item not found
        if (intval($move_item[$key_field]) == 0) {
            return false;
        }

        if ($move_field != $key_field) { //-- change records  (if priority field not a key field)
            $upd_array = array(
            $key_field => $item[$key_field] ,
            $move_field => $move_item[$move_field]);

            $move_Storage->Update($upd_array);
            $upd_array = array(
            $key_field => $move_item[$key_field] ,
            $move_field => $item[$move_field]);
            $move_Storage->Update($upd_array);
        }
        else { //-- change records  (if priority field is a key field)
            $move_Storage->exchangeIncrementals($item_id, $move_id);

            //--check if library have a sub-categories
            if ($move_config->HasItem("MAIN", "USE_SUB_CATEGORIES")) {
                $use_sub_categories = $move_config->GetItem("MAIN", "USE_SUB_CATEGORIES");
            }
            else {
                $use_sub_categories = false;
            }

            //--if library use subcategories
            if ($use_sub_categories) {
                $sub_categories_count = $move_config->GetItem("MAIN", "SUB_CATEGORIES_COUNT");
                for ($i = 0; $i < sizeof($sub_categories_count); $i ++) {
                    $library = $move_config->GetItem("sub_category_" . $i, "APPLY_LIBRARY");
                    $link_field = $move_config->GetItem("sub_category_" . $i, "LINK_FIELD");
                    $sub_listSettings = Engine::getLibrary($this->Kernel, $library, "sub_ListSettings_" . $library);
                    $sub_table = $sub_listSettings->GetItem("MAIN", "TABLE");
                    $this->Kernel->ImportClass("data." . strtolower($sub_table), $sub_table);
                    $sub_Storage = new $sub_table($this->Kernel->Connection, $this->Kernel->Settings->GetItem("database", $sub_table));
                    $_sub_column = $sub_Storage->getIncrementalColumn();

                    $upd_array1 = array();
                    $upd_array2 = array();

                    //move first record subitems
                    $_list = $sub_Storage->GetList(array(
                    $key_field => $item_id));
                    if ($_list->RecordCount != 0) {
                        while ($_sub_item = $_list->Read())
                            $upd_array1[] = $_sub_item[$_sub_column["name"]];
                    }

                    //move second record subitems
                    $_list = $sub_Storage->GetList(array(
                    $key_field => $move_id));
                    if ($_list->RecordCount != 0) {
                        while ($_sub_item = $_list->Read())
                            $upd_array2[] = $_sub_item[$_sub_column["name"]];
                    }
                }
                //--move group for second and first record
                if (count($upd_array1))
                    $sub_Storage->GroupUpdate($_sub_column["name"], $upd_array1, array(
                    $key_field => $move_id));
                if (count($upd_array2))
                    $sub_Storage->GroupUpdate($_sub_column["name"], $upd_array2, array(
                    $key_field => $item_id));

            }

            //check if library is multiple
            if ($move_config->HasItem("MAIN", "IS_MULTILEVEL")) {
                $is_multilevel = $move_config->GetItem("MAIN", "IS_MULTILEVEL");
                if ($is_multilevel) {
                    $parent_field = $move_config->GetItem("MAIN", "PARENT_FIELD");
                    $upd_array1 = array();
                    $upd_array2 = array();
                    //move first record childs
                    $_list = $move_Storage->GetList(array(
                    $parent_field => $item_id));
                    if ($_list->RecordCount != 0) {
                        while ($_sub_item = $_list->Read())
                            $upd_array1[] = $_sub_item[$key_field];
                    }

                    //move second record childs
                    $_list = $move_Storage->GetList(array(
                    $parent_field => $move_id));
                    if ($_list->RecordCount != 0) {
                        while ($_sub_item = $_list->Read())
                            $upd_array2[] = $_sub_item[$key_field];
                    }
                    if (count($upd_array1))
                        $move_Storage->GroupUpdate($key_field, $upd_array1, array(
                        $parent_field => $move_id));
                    if (count($upd_array2))
                        $move_Storage->GroupUpdate($key_field, $upd_array2, array(
                        $parent_field => $item_id));
                }
            }
            return true;
        }

    } //--end of function


    /**
     * Method check library access,redefine access variables of page (use a ACCESS section definition) AND redirect WHEN access is denied
     * @access private
     **/
    function CheckLibraryAccess(){
        if ($this->listSettings->HasSection("ACCESS")) {
            if ($this->listSettings->HasItem("ACCESS", "GROUPS")) {
                $this->Page->access_id = explode(",", $this->listSettings->GetItem("ACCESS", "GROUPS"));

            }
            if ($this->listSettings->HasItem("ACCESS", "USERS")) {
                $this->Page->access_user_id = explode(",", $this->listSettings->GetItem("ACCESS", "USERS"));
            }
            if ($this->listSettings->HasItem("ACCESS", "ROLES")) {
                $this->Page->access_role_id = explode(",", $this->listSettings->GetItem("ACCESS", "ROLES"));
            }

            $this->Page->Auth->isLogged();
        }
    }

    function RemoveFieldFromLibrary($field){
    	$fields_count = $this->listSettings->GetItem("LIST","FIELDS_COUNT");
    	for ($i=0; $i<$fields_count; $i++)
    		if ($this->listSettings->GetItem("FIELD_".$i, "FIELD_NAME")==$field )
    			$this->listSettings->SetItem("FIELD_".$i, "EDIT_CONTROL", "null");
    }

} //--end of class
?>