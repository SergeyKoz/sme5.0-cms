<?php

/** EditPage Helper class
 * Provides routines to manipulate data for editpage classes
 * @author Konstantin  Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package  Libraries
 * @subpackage classes.web
 * @access public
 **/
class EditPageHelper extends Component
{
    // Class name
    var $ClassName = "EditPage";
    // Class version
    var $Version = "1.0";

    /**
     * Method adds field-specific settings for text and password controls
     * @param    int         $i
     * @param    array       $_field          Array with field settings
     * @param    EditPage    $Page            EditPage object
     **/
    static function GetTextSettings($i, &$_field, &$Page)
    {
        if ($Page->listSettings->HasItem("FIELD_" . $i, "SIZE")) {
            $_field["size"] = $Page->listSettings->GetItem("FIELD_" . $i, "SIZE");
        }
        else {
            $_field["size"] = "";
        }
        if ($Page->listSettings->HasItem("FIELD_" . $i, "MAXLENGTH")) {
            $_field["length"] = $Page->listSettings->GetItem("FIELD_" . $i, "MAXLENGTH");
        }
        else {
            $_field["length"] = "";
        }
    }

    /**
     * Method adds field-specific settings for date control
     * @param    int     $i      Field number
     * @param    array  $_field    Array with field settings
     */
    static function GetDateSettings($i, &$_field, &$Page)
    {

        $_field["static"] = (bool)
            $Page->listSettings->hasItem("FIELD_" . $i, "EDIT_STATIC") &&
            $Page->listSettings->getItem("FIELD_" . $i, "EDIT_STATIC");


        if ($Page->listSettings->HasItem("FIELD_" . $i, "IS_UNIX_TIMESTAMP")) {
            $_field["is_unix_timestamp"] = $Page->listSettings->GetItem("FIELD_" . $i, "IS_UNIX_TIMESTAMP");
        }
        else {
            $_field["is_unix_timestamp"] = 0;
        }
        if ($Page->listSettings->HasItem("FIELD_" . $i, "EDIT_FULLDATE")) {
            $_field["fulldate"] = $Page->listSettings->GetItem("FIELD_" . $i, "EDIT_FULLDATE");

        }
        else {
            $Page->AddEditErrorMessage("EMPTY_EDIT_FULLDATE_SETTINGS", array(
                $i
            ), array(), true);
        }
    }

    /**
     * Method adds field-specific settings for textarea controls
     * @param    int     $i      Field number
     * @param    array  $_field    Array with field settings
     * @param    EditPage    $Page            EditPage object
     */
    static function GetTextAreaSettings($i, &$_field, &$Page)
    {
        if ($Page->listSettings->HasItem("FIELD_" . $i, "ROWS")) {
            $_field["rows"] = $Page->listSettings->GetItem("FIELD_" . $i, "ROWS");
        }
        else {
            $_field["rows"] = "";
        }
        if ($Page->listSettings->HasItem("FIELD_" . $i, "COLS")) {
            $_field["cols"] = $Page->listSettings->GetItem("FIELD_" . $i, "COLS");
        }
        else {
            $_field["cols"] = "";
        }

    }

    /**
     * Method adds field-specific settings for textarea controls
     * @param        int     $i            Field number
     * @param        array    $_field        Array with field settings
     * @param    EditPage    $Page            EditPage object
     */
    static function GetMacHtmlEditorSettings($i, &$_field, &$Page)
    {
        if ($Page->listSettings->HasItem("FIELD_" . $i, "ROWS")) {
            $_field["rows"] = $Page->listSettings->GetItem("FIELD_" . $i, "ROWS");
        }
        else {
            $_field["rows"] = "";
        }
        if ($Page->listSettings->HasItem("FIELD_" . $i, "COLS")) {
            $_field["cols"] = $Page->listSettings->GetItem("FIELD_" . $i, "COLS");
        }
        else {
            $_field["cols"] = "";
        }
        if ($Page->listSettings->HasItem("FIELD_" . $i, "DIRECTORY")) {
            $_field["file_directory"] = $Page->listSettings->GetItem("FIELD_" . $i, "DIRECTORY");
        }
        ;
        if ($Page->listSettings->HasItem("FIELD_" . $i, "IS_PRIVATE_DIRECTORY")) {
            $_field["private_directory"] = $Page->listSettings->GetItem("FIELD_" . $i, "IS_PRIVATE_DIRECTORY");
        }
        else {
            $_field["private_directory"] = 0;
        }

        $Page->Session->Set("library_ID", $Page->library_ID);
        $Page->Session->Set("parent_package", $Page->Kernel->Package->PackageName);

    }

    /**
     * Method adds field-specific settings for checkbox controls
     * @param    int         $i              Field number
     * @param    array       $_field         Array with field settings
     * @param    EditPage    $Page           EditPage object
     **/
    static function GetCheckboxSettings($i, &$_field, &$Page)
    {
        if ($Page->listSettings->HasItem("FIELD_" . $i, "CHECKON")) {
            $_field["checkOn"] = $Page->listSettings->GetItem("FIELD_" . $i, "CHECKON");
        }
        else {
            $Page->AddEditErrorMessage("EMPTY_CHECKON_SETTINGS", array(
                $i
            ), array(), true);
        }
        if ($Page->listSettings->HasItem("FIELD_" . $i, "CHECKOFF")) {
            $_field["checkOff"] = $Page->listSettings->GetItem("FIELD_" . $i, "CHECKOFF");
        }
        else {
            $Page->AddEditErrorMessage("EMPTY_CHECKOFF_SETTINGS", array(
                $i
            ), array(), true);
        }
        if ($Page->listSettings->HasItem("FIELD_" . $i, "IS_RADIO")) {
            $_field["is_radio"] = $Page->listSettings->GetItem("FIELD_" . $i, "IS_RADIO");
        }
        else {
            $_field["is_radio"] = 0;
        }
    }

    /**
     * Method adds field-specific settings for Combobox and radiogroup controls
     * @param    int     $i      Field number
     * @param    array  $_field    Array with field settings
     * @param    EditPage    $Page           EditPage object
     */
    static function GetComboSettings($i, &$_field, &$Page)
    {
        $library = strtoupper($Page->library_ID);
        $field = "OPTIONS_" . strtoupper($_field["field_name"]);
        $field_and_lang = $field . "_" . strtoupper($Page->Kernel->Language);
        if ($Page->Page->Kernel->Localization->HasItem($library, $field_and_lang)) {
            $_field["options"] = $Page->FromConfigOptionsToSelect($Page->Page->Kernel->Localization->GetItem($library, $field_and_lang));
        }
        elseif ($Page->Page->Kernel->Localization->HasItem($library, $field)) {
            $_field["options"] = $Page->FromConfigOptionsToSelect($Page->Page->Kernel->Localization->GetItem($library, $field));
        }
        elseif ($Page->listSettings->HasItem("FIELD_" . $i, "OPTIONS")) {
            $_field["options"] = $Page->FromConfigOptionsToSelect($Page->listSettings->GetItem("FIELD_" . $i, "OPTIONS"));
        }
        elseif ($Page->listSettings->HasItem("FIELD_" . $i, "OPTIONS_FROM_INI_SECTION")) {
            $section = $Page->listSettings->GetItem("FIELD_" . $i, "OPTIONS_FROM_INI_SECTION");
            $caption_items = $Page->listSettings->GetItem("FIELD_" . $i, "OPTIONS_FROM_INI_CAPTIONS");
            $value_items = $Page->listSettings->GetItem("FIELD_" . $i, "OPTIONS_FROM_INI_VALUES");

            if ($Page->Page->Kernel->Settings->HasItem($section, $caption_items)) {
                $captions = $Page->Page->Kernel->Settings->GetItem($section, $caption_items, false, true);
                $values = $Page->Page->Kernel->Settings->GetItem($section, $value_items, false, true);
            }
            else {
                $captions = $Page->Page->Kernel->Localization->GetItem($section, $caption_items, false, true);
                $values = $Page->Page->Kernel->Localization->GetItem($section, $value_items, false, true);
            }

            $options = array();
            for ($optionIndex = 0; $optionIndex < sizeof($captions); $optionIndex++) {
                $option["value"] = $values[$optionIndex];
                $option["caption"] = $captions[$optionIndex];
                $options[] = $option;
            }
            $_field["options"] = $options;
        }
        else {
            $Page->AddEditErrorMessage("EMPTY_OPTIONS_SETTINGS", array(
                $i
            ), array(), true);
        }
        if ($Page->listSettings->HasItem("FIELD_" . $i, "MULTIPLE")) {
            $_field["multiple"] = $Page->listSettings->GetItem("FIELD_" . $i, "MULTIPLE");
        }
    }

    /**
     * Method adds field-specific settings for dbtext and dbstatictext controls
     * @param    int     $i      Field number
     * @param    array  $_field    Array with field settings
     * @param    EditPage    $Page           EditPage object
     */
    static function GetDbTextSettings($i, &$_field, &$Page)
    {
        $_field["fieldvalue_name"] = sprintf($Page->listSettings->GetItem("FIELD_" . $i, "FIELDVALUE_NAME"), $Page->Page->Kernel->Language);
        $_field["fieldvalue_caption"] = sprintf($Page->listSettings->GetItem("FIELD_" . $i, "FIELDVALUE_CAPTION"), $Page->Page->Kernel->Language);
        if ($Page->listSettings->HasItem("FIELD_" . $i, "FIELDLINK_NAME")) {
            $_field["linkfield_name"] = sprintf($Page->listSettings->GetItem("FIELD_" . $i, "FIELDLINK_NAME"), $Page->Page->Kernel->Language);
        }
        else {
            $_field["linkfield_name"] = $_field["field_name"];
        }
    }

    /**
     * Method adds field-specific settings for complex controls
     * @param    int     $i      Field number
     * @param    array  $_field    Array with field settings
     * @param    EditPage    $Page           EditPage object
     */
    static function GetDbComplexSettings($i, &$_field, &$Page)
    {
        $_field = EditPageHelper::setDataForDbComboboxControl($i, $_field, $Page);
        if ($_field["control"] == "dbtreecombobox" || $_field["control"] == "dbtreetext") {
            if ($Page->listSettings->HasItem("FIELD_" . $i, "PARENTVALUE_NAME")) {
                $_field["parent"] = $Page->listSettings->GetItem("FIELD_" . $i, "PARENTVALUE_NAME");
            }
            else {
                $Page->AddEditErrorMessage("EMPTY_PARENTVALUE_NAME", array(
                    $i
                ), true);
            }

            if ($_field["control"] == "dbtreetext") {
                //get field node
                if ($Page->listSettings->HasItem("FIELD_" . $i, "FIELD_NODE")) {
                    $_field["field_node"] = $Page->listSettings->GetItem("FIELD_" . $i, "FIELD_NODE");
                }
                else {
                    $_field["field_node"] = 0;
                }
                //get parsed fields
                if ($Page->listSettings->HasItem("FIELD_" . $i, "FIELDS_FORPARSE"))
                    $_field["field_parsedfields"] = $Page->listSettings->GetItem("FIELD_" . $i, "FIELDS_FORPARSE");
            }

            if ($Page->listSettings->HasItem("FIELD_" . $i, "USE_ROOT_CAPTION")) {
                $_field["use_root_caption"] = $Page->listSettings->GetItem("FIELD_" . $i, "USE_ROOT_CAPTION");
            }
            else {
                $_field["use_root_caption"] = 0;
            }

            if ($Page->listSettings->HasItem("FIELD_" . $i, "MULTIPLE")) {
                $_field["multiple"] = $Page->listSettings->GetItem("FIELD_" . $i, "MULTIPLE");
            }
            else {
                $_field["multiple"] = 0;
            }

            //get tree select parameters
            if ($Page->listSettings->HasItem("FIELD_" . $i, "GET_FROM")) {
                $_field["get_from"] = $Page->listSettings->GetItem("FIELD_" . $i, "GET_FROM");
                if ($_field["get_from"]) {
                    if ($Page->listSettings->HasItem("FIELD_" . $i, "ITEM_ID")) {
                        $_field["item_id"] = $Page->listSettings->GetItem("FIELD_" . $i, "ITEM_ID");
                    }
                    if ($Page->listSettings->HasItem("FIELD_" . $i, "RENDER_ROOT")) {
                        $_field["render_root"] = $Page->listSettings->GetItem("FIELD_" . $i, "RENDER_ROOT");
                    }
                    else {
                        $_field["render_root"] = 0;
                    }
                }
            }
            else {
                $_field["get_from"] = 0;
            }

            /*if($Page->listSettings->HasItem("FIELD_".$i,"USE_ENTRIES")){
         $_field["use_entries"] = $Page->listSettings->GetItem("FIELD_".$i,"USE_ENTRIES");
        } else {
        $_field["use_entries"] = 0;
        }
        */

            if ($Page->listSettings->HasItem("FIELD_" . $i, "USE_ENTRIES")) {
                $_field["use_entries"] = $Page->listSettings->GetItem("FIELD_" . $i, "USE_ENTRIES");
            }
            else {
                $_field["use_entries"] = 0;
            }

            if ($_field["use_entries"]) {
                if ($Page->listSettings->HasItem("FIELD_" . $i, "ENTRIES_GET_METHOD")) {
                    $_field["entries_get_method"] = $Page->listSettings->GetItem("FIELD_" . $i, "ENTRIES_GET_METHOD");
                }
                if ($Page->listSettings->HasItem("FIELD_" . $i, "ENTRIES_TABLE")) {
                    $_field["entries_table"] = $Page->listSettings->GetItem("FIELD_" . $i, "ENTRIES_TABLE");
                }
                else {
                    $Page->AddEditErrorMessage("EMPTY_ENTRIES_TABLE", array(
                        $i
                    ), true);
                }
                if ($Page->listSettings->HasItem("FIELD_" . $i, "ENTRIESVALUE_NAME")) {
                    $_field["entriesvalue_name"] = $Page->listSettings->GetItem("FIELD_" . $i, "ENTRIESVALUE_NAME");
                }
                else {
                    $Page->AddEditErrorMessage("EMPTY_ENTRIESVALUE_NAME", array(
                        $i
                    ), true);
                }
                if ($Page->listSettings->HasItem("FIELD_" . $i, "ENTRIESVALUE_CAPTION")) {
                    $_field["entriesvalue_caption"] = $Page->listSettings->GetItem("FIELD_" . $i, "ENTRIESVALUE_CAPTION");
                }
                else {
                    $Page->AddEditErrorMessage("EMPTY_ENTRIESVALUE_CAPTION", array(
                        $i
                    ), true);
                }
                if ($Page->listSettings->HasItem("FIELD_" . $i, "ALLOW_CATEGORY_SELECT")) {
                    $_field["allow_category_select"] = $Page->listSettings->GetItem("FIELD_" . $i, "ALLOW_CATEGORY_SELECT");
                }
                else {
                    $_field["allow_category_select"] = 0;
                }
                if ($Page->listSettings->HasItem("FIELD_" . $i, "ENTRIES_ORDERS")) {
                    $_field["entries_orders"] = $Page->listSettings->GetItem("FIELD_" . $i, "ENTRIES_ORDERS");
                    $_order_fields = $Page->listSettings->GetItem("FIELD_" . $i, "ENTRIES_ORDERS");
		            for ($j = 0; $j < sizeof($_order_fields); $j ++) {
		                list ($_orderfield, $_ordervalue) = preg_split("/ /", $_order_fields);
		                $_get_orders[sprintf($_orderfield, $Page->Page->Kernel->Language)] = sprintf($_ordervalue, $Page->Page->Kernel->Language);
		            }
		            $_field["entries_orders"] = $_get_orders;
                }

            } // using category entries

        }
        if ($_field["control"] != "dbtreetext") {
            $_field["fieldvalue_caption"] = sprintf($Page->listSettings->GetItem("FIELD_" . $i, "FIELDVALUE_CAPTION"), $Page->Page->Kernel->Language);
        }

        if ($Page->listSettings->HasItem("FIELD_" . $i, "SIZE")) {
            $_field["size"] = $Page->listSettings->GetItem("FIELD_" . $i, "SIZE");
        }
        else {
            $_field["size"] = "";
        }

        if ($_field["control"] == "dbcheckboxgroup") {
            $_field["multiple"] = 1;

        }
        if ($_field["control"] == "dbcheckboxgroup" || $_field["control"] == "checkboxgroup") {
            if ($Page->listSettings->HasItem("FIELD_" . $i, "ONLY_SELECTED")) {
                $_field["only_selected"] = $Page->listSettings->GetItem("FIELD_" . $i, "ONLY_SELECTED");
            }
            else {
                $_field["only_selected"] = 0;
            }
        }

        if ($_field["multiple"] || $_field["control"] == "checkboxgroup")
            $Page->nonordinary = 1;
    }

    /**
     * Method adds field-specific settings for file controls
     * @param    int     $i      Field number
     * @param    array  $_field    Array with field settings
     * @param    EditPage    $Page           EditPage object
     */
    static function GetFileSettings($i, &$_field, &$Page)
    {
        if ($Page->listSettings->HasItem("FIELD_" . $i, "DIRECTORY")) {
            $_field["file_directory"] = $Page->listSettings->GetItem("FIELD_" . $i, "DIRECTORY");
        }
        ;
        if ($Page->listSettings->HasItem("FIELD_" . $i, "IS_PRIVATE_DIRECTORY")) {
            $_field["private_directory"] = $Page->listSettings->GetItem("FIELD_" . $i, "IS_PRIVATE_DIRECTORY");
        }
        else {
            $_field["private_directory"] = 0;
        }

        $Page->Session->Set("library_ID", $Page->library_ID);
        $Page->Session->Set("parent_package", $Page->Kernel->Package->PackageName);
    }

    static function GetFile2Settings($i, &$_field, &$Page)
    {
        if ($Page->listSettings->HasItem("FIELD_" . $i, "DIRECTORY")) {
            $_field["file_directory"] = $Page->listSettings->GetItem("FIELD_" . $i, "DIRECTORY");
        }
        ;
        if ($Page->listSettings->HasItem("FIELD_" . $i, "IS_PRIVATE_DIRECTORY")) {
            $_field["private_directory"] = $Page->listSettings->GetItem("FIELD_" . $i, "IS_PRIVATE_DIRECTORY");
        }
        else {
            $_field["private_directory"] = 0;
        }

        $Page->Session->Set("library_ID", $Page->library_ID);
        $Page->Session->Set("parent_package", $Page->Kernel->Package->PackageName);
    }

    /**
     * Method adds field-specific settings for file controls
     * @param    int     $i      Field number
     * @param    array  $_field    Array with field settings
     * @param    EditPage    $Page           EditPage object
     */
    static function GetFilesListBoxSettings($i, &$_field, &$Page)
    {
        if ($Page->listSettings->HasItem("FIELD_" . $i, "DIRECTORY")) {
            $_field["root_path"] = $Page->listSettings->GetItem("FIELD_" . $i, "DIRECTORY");
        }
        if ($Page->listSettings->HasItem("FIELD_" . $i, "SHOW_FILES")) {
            $_field["show_files"] = $Page->listSettings->GetItem("FIELD_" . $i, "SHOW_FILES");

            if ($Page->listSettings->HasItem("FIELD_" . $i, "FILES_FILTER")) {
                $_field["files_filter"] = $Page->listSettings->GetItem("FIELD_" . $i, "FILES_FILTER");
            }
            if ($Page->listSettings->HasItem("FIELD_" . $i, "ALLOW_DIRS_SELECT")) {
                $_field["dirs_select"] = $Page->listSettings->GetItem("FIELD_" . $i, "ALLOW_DIRS_SELECT");
            }

        }
        else {
            $_field["dirs_select"] = 1;

        }
        if ($Page->listSettings->HasItem("FIELD_" . $i, "DIRS_FILTER")) {
            $_field["dirs_filter"] = $Page->listSettings->GetItem("FIELD_" . $i, "DIRS_FILTER");
        }
        if ($Page->listSettings->HasItem("FIELD_" . $i, "USE_ROOT_CAPTION")) {
            $_field["use_root_caption"] = $Page->listSettings->GetItem("FIELD_" . $i, "USE_ROOT_CAPTION");
        }

        if ($Page->listSettings->HasItem("FIELD_" . $i, "MULTIPLE")) {
            $_field["multiple"] = $Page->listSettings->GetItem("FIELD_" . $i, "MULTIPLE");
        }

    }

    /**
     * Method adds field-specific settings for hidden controls
     * @param    int     $i      Field number
     * @param    array  $_field    Array with field settings
     */
    static function GetHiddenSettings($i, &$_field, &$Page)
    {
        if ($Page->listSettings->HasItem("FIELD_" . $i, "VALUE")) {
            $_field["field_value"] = $Page->listSettings->GetItem("FIELD_" . $i, "VALUE");
        }
    }

    /**
     * Method adds field-specific settings for hidden controls
     * @param    int     $i      Field number
     * @param    array  $_field    Array with field settings
     */
    static function GetExtraHtmlEditorSettings($i, &$_field, &$Page)
    {
        if ($Page->listSettings->HasItem("FIELD_" . $i, "DIRECTORY")) {
            $_field["file_directory"] = $Page->listSettings->GetItem("FIELD_" . $i, "DIRECTORY");
            if ($Page->listSettings->HasItem("FIELD_" . $i, "WIDTH")) {
                $_field["width"] = $Page->listSettings->GetItem("FIELD_" . $i, "WIDTH");
            }
            if ($Page->listSettings->HasItem("FIELD_" . $i, "HEIGHT")) {
                $_field["height"] = $Page->listSettings->GetItem("FIELD_" . $i, "HEIGHT");
            }

        }
        ;
    }

    /**
     * Method adds field-specific settings for dbtreepath control
     * @param    int     $i      Field number
     * @param    array  $_field    Array with field settings
     * @param    EditPage    $Page           EditPage object
     */
    static function GetDbTreePathSettings($i, &$_field, &$Page)
    {
        $_field["field_table"] = $Page->listSettings->GetItem("FIELD_" . $i, "FIELD_TABLE");
        $_field["fieldvalue_name"] = sprintf($Page->listSettings->GetItem("FIELD_" . $i, "FIELDVALUE_NAME"), $Page->Page->Kernel->Language);
        $_field["fieldvalue_caption"] = sprintf($Page->listSettings->GetItem("FIELD_" . $i, "FIELDVALUE_CAPTION"), $Page->Page->Kernel->Language);
        $_field["fieldvalue_parent"] = sprintf($Page->listSettings->GetItem("FIELD_" . $i, "FIELDVALUE_PARENT"), $Page->Page->Kernel->Language);
    }

    /**
     * Method set control data for dbcombobox control
     * @param     int     $i      number of field
     * @param     array   $_field  control data array
     * @return    array           control data array
     * @param    EditPage    $Page           EditPage object
     * @access private
     */
    static function setDataForDbComboboxControl($i, $_field, &$Page)
    {
        $_field["field_table"] = $Page->listSettings->GetItem("FIELD_" . $i, "FIELD_TABLE");

        if ($Page->listSettings->HasItem("FIELD_" . $i, "GET_METHOD")) {
            $_field["get_method"] = $Page->listSettings->GetItem("FIELD_" . $i, "GET_METHOD");
        }
        else {
            $_field["get_method"] = "GetList";
        }
        if ($Page->listSettings->HasItem("FIELD_" . $i, "GET_DATA_FIELDS")) {

            $_data_fields = $Page->listSettings->GetItem("FIELD_" . $i, "GET_DATA_FIELDS");
            $_data_fieldvalues = $Page->listSettings->GetItem("FIELD_" . $i, "GET_DATA_FIELDVALUES");
            if (! is_array($_data_fields))
                $_data_fields = array(
                    $_data_fields
                );
            if (! is_array($_data_fieldvalues))
                $_data_fieldvalues = array(
                    $_data_fieldvalues
                );
            for ($j = 0; $j < sizeof($_data_fields); $j ++) {
                if (! isset($_get_data[sprintf($_data_fields[$j], $Page->Page->Kernel->Language)])) {
                    $_get_data[sprintf($_data_fields[$j], $Page->Page->Kernel->Language)] = sprintf($_data_fieldvalues[$j], $Page->Page->Kernel->Language);
                }
                else {
                    if (! is_array($_get_data[sprintf($_data_fields[$j], $Page->Page->Kernel->Language)])) {
                        $_get_data[sprintf($_data_fields[$j], $Page->Page->Kernel->Language)] = array(
                            $_get_data[sprintf($_data_fields[$j], $Page->Page->Kernel->Language)] , sprintf($_data_fieldvalues[$j], $Page->Page->Kernel->Language)
                        );
                    }
                    else {
                        $_get_data[sprintf($_data_fields[$j], $Page->Page->Kernel->Language)][] = sprintf($_data_fieldvalues[$j], $Page->Page->Kernel->Language);
                    }
                }
            }
            $_field["get_data"] = $_get_data;
        }
        else {
            $_field["get_data"] = null;
        }

        if ($Page->listSettings->HasItem("FIELD_" . $i, "USE_ROOT_CAPTION")) {
            $_field["use_root_caption"] = $Page->listSettings->GetItem("FIELD_" . $i, "USE_ROOT_CAPTION");
        }
        else {
            $_field["use_root_caption"] = 0;
        }

        if ($Page->listSettings->HasItem("FIELD_" . $i, "GET_ORDERS")) {
            $_order_fields = $Page->listSettings->GetItem("FIELD_" . $i, "GET_ORDERS");
            for ($j = 0; $j < sizeof($_order_fields); $j ++) {
                list ($_orderfield, $_ordervalue) = preg_split("/ /", $_order_fields);
                $_get_orders[sprintf($_orderfield, $Page->Page->Kernel->Language)] = sprintf($_ordervalue, $Page->Page->Kernel->Language);
            }
            $_field["get_orders"] = $_get_orders;
        }
        else {
            $_field["get_orders"] = array(
                sprintf($_field["fieldvalue_caption"], $Page->Page->Kernel->Language) => "ASC"
            );
        }
        if ($Page->listSettings->HasItem("FIELD_" . $i, "MULTIPLE"))
            $_field["multiple"] = $Page->listSettings->GetItem("FIELD_" . $i, "MULTIPLE");

        return $_field;
    }

    /**
     * Method set field parameter
     * @param  string  $fieldname    field name
     * @param  string  $parameter    parameter name
     * @param  mixed    $value        parameter value
     **/
    static function SetFieldParameter($fieldname, $parameter, $value, &$Page)
    {
        foreach ($Page->form_fields as $prefix => $form) {
            for ($i = 0; $i < sizeof($form); $i ++) {
                if ($form[$i]["field_name"] == $fieldname) {
                    $Page->form_fields[$prefix][$i][$parameter] = $value;
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Method insert data for non-ordinary fields (dbcombobox multiple or dbcheckbox)
     * @param array     $field   field information array
     * @param EditPage  $Page    EditPage object
     * @access           public
     **/
    static function InsertDBMultipleField($field, &$Page)
    {
        $_values_arr = $Page->Request->Value($field["field_name"]);
        $Table = $Page->listSettings->GetItem("FIELD_" . $field["number"], "RELATIONS_TABLE");

        $Page->Kernel->ImportClass("data." . strtolower($Table), $Table);
        $Storage = new $Table($Page->Kernel->Connection, $Page->Kernel->Settings->GetItem("database", $Table));

        $_keyfield = $Page->Request->ToNumber("item_id");

        if (intval($_keyfield) == 0) {
            $last_record = $Page->Storage->GetRecord(null, array(
                $Page->key_field => ""
            ));
            $_keyfield = $last_record[$Page->key_field];
        }
        $_data = array(
            $Page->key_field => $_keyfield
        );
        $Storage->DeleteByKey($_data);
        if (!is_array($_values_arr)) $_values_arr=array($_values_arr);
        for ($i = 0; $i < sizeof($_values_arr); $i ++) {
            $_data[$Page->key_field] = $_keyfield;
            $_data[$field["field_name"]] = $_values_arr[$i];
            $Storage->Insert($_data);
        }
    }

    /**
     * Method delete data for non-ordinary fields (dbcombobox multiple or dbcheckbox)
     * @param array     $field   field information array
     * @param array     $fields  All fields information array
     * @param EditPage  $Page    EditPage object
     * @access           public
     **/
    static function DeleteDBMultipleField($field, $fields, &$Page)
    {
        $_values_arr = $Page->Request->Value($field["field_name"]);
        $Table = $Page->listSettings->GetItem("FIELD_" . $field["number"], "RELATIONS_TABLE");
        $Page->Kernel->ImportClass("data." . strtolower($Table), $Table);
        $Storage = new $Table($Page->Kernel->Connection, $Page->Kernel->Settings->GetItem("database", $Table));
        if (! empty($fields)) {
            $_keyfield = $fields;
        }
        else {
            $_keyfield = $Page->item_id;
        }
        $_data = array(
            $Page->key_field => $_keyfield
        );
        $Storage->DeleteByKey($_data);
    }

    /**
     * Method update data in checkboxgroup control
     * @param array     $field   field information array
     * @param EditPage  $Page    EditPage object
     * @access           public
     **/
    static function UpdateCheckboxGroupField($field, &$Page)
    {

        $_values_arr = $Page->Request->Value($field["field_name"]);
        if (! is_array($_values_arr))
            $_values_arr = array(
                $_values_arr
            );
        $_value = implode(",", $_values_arr);
        $_keyfield = $Page->Request->ToNumber("item_id");
        if (intval($_keyfield) == 0) {
            $last_record = $Page->Storage->GetRecord(null, array(
                $Page->key_field => ""
            ));
            $_keyfield = $last_record[$Page->key_field];
        }
        $_data = array(
            $Page->key_field => $_keyfield , $field["field_name"] => $_value
        );
        $Page->Storage->Update($_data);
    }

    static function GetDBEditBlockSettings($i, &$_field, &$Page)
    {
        $_field["field_table"] = $Page->listSettings->GetItem("FIELD_" . $i, "FIELD_TABLE");
        $_field["get_method"] = $Page->listSettings->GetItem("FIELD_" . $i, "GET_METHOD");
        $_field["value_field"] = $Page->listSettings->GetItem("FIELD_" . $i, "FIELDVALUE_NAME");
        $_field["caption_field"] = $Page->listSettings->GetItem("FIELD_" . $i, "FIELDVALUE_CAPTION");
        $_field["link_to_field"] = $Page->listSettings->GetItem("FIELD_" . $i, "LINK_TO_FIELD");
        $_field["link_to_value"] = $this->item_id;
    }


    static function GetAutocompleteSettings($i, &$_field, &$Page){
    	$SectionSetting=$Page->listSettings->GetSection("FIELD_" . $i);
    	$_field["field_table"]=$SectionSetting["FIELD_TABLE"];
    	$_field["field_relation_name"]=($SectionSetting["FIELD_RELATION_NAME"]!="" ? $SectionSetting["FIELD_RELATION_NAME"] : "item_id");
    	$_field["field_words_name"]=$SectionSetting["FIELD_WORDS_NAME"];
    	$_field["autocomplete_method"]=$SectionSetting["AUTOCOMPLETE_METHOD"];
    	$_field["get_method"]=$SectionSetting["GET_METHOD"];
    	$_field["libraries_insert_method"]=$SectionSetting["LIBRARIES_INSERT_METHOD"];
    	$_field["libraries_delete_method"]=$SectionSetting["LIBRARIES_DELETE_METHOD"];
    	$_field["field_item_type"]=$SectionSetting["FIELD_ITEM_TYPE"];
    	$_field["words_delimeter"]=$SectionSetting["WORDS_DELIMETER"]!="" ? $SectionSetting["WORDS_DELIMETER"] : ",";
    	$_field["create_new_items"]=($SectionSetting["ENABLE_CREATE_NEW_ITEMS"]==1 ? 1 : 0);
        $_field["field_value_caption"]=$_field["field_value_caption"];
        $_field["multiple"]=($SectionSetting["MULTIPLE"]==1 ? 1 : 0);
        if ($SectionSetting["MULTIPLE"]==1 && $_field["field_table"]!="")
        	$Page->nonordinary = 1;
    }

    static function InsertAutocompleteField($field, &$Page, $item_id){
     	$ItemsStorage=DataFactory::GetStorage($Page->Kernel->Connection, $field["field_table"]);

     	$items=$Page->_data[$field["field_name"]];
 		$items=explode($field["words_delimeter"], $items);
 		$_items=array();
 		if (count($items)) foreach ($items as $item) if (trim($item)!="") $_items[]=trim($item);
        $items=$_items;

     	if ($field["libraries_insert_method"]==""){
            //default insert
	     	$words_cleaned=DataDispatcher::Get("words_cleaned_".$field["field_relation_name"]."_".$field["field_words_name"]);

	     	$KeyField=($field["field_relation_name"]!="" ? $field["field_relation_name"] : "item_id");

	     	if ($words_cleaned!=1){
	     		$DeleteData=array($KeyField=>$item_id);
	     		if($field["field_item_type"]!="") $DeleteData["tag_type"]=$field["field_item_type"];
	     		$ItemsStorage->DeleteByKey($DeleteData);
				DataDispatcher::Set("words_cleaned_".$field["field_relation_name"]."_".$field["field_words_name"], 1);
	        }

	        if (count($items)){
	     		$wordField=($field["field_words_name"]!="" ? sprintf($field["field_words_name"], $field["lang_version"]) : $field["field_name"]);

		     	if ($field["create_new_items"]!=1){
		     		$raw_sql["group_by"]="GROUP BY ".$wordField;
		     		$reader=$ItemsStorage->GetList(array($wordField=>$items), null, null, null, null, "", $raw_sql);
		     		$items=array();
		     		for ($i=0; $i<$reader->RecordCount; $i++){
		     			$record=$reader->read();
		     			$items[]=$record[$wordField];
		     		}
		     	}
		     	foreach($items as $item){
			     	$InsertData=array($KeyField=>$item_id, $wordField=>$item);
			     	if($field["field_item_type"]!="") $InsertData["tag_type"]=$field["field_item_type"];
			        $ItemsStorage->Insert($InsertData);
		     	}
	     	}
     	} else {
     		$insert_method=$field["libraries_insert_method"];
     		$ItemsStorage->$insert_method($field, $Page, $item_id, $items);
     	}
    }

    static function DeleteAutocompleteField($field, $fields, &$Page){
    	$words_cleaned=DataDispatcher::Get("words_cleaned_".$field["field_relation_name"]."_".$field["field_words_name"]);
    	if ($words_cleaned!=1){
	    	$ItemsStorage=DataFactory::GetStorage($Page->Kernel->Connection, $field["field_table"]);
	    	if ($field["libraries_delete_method"]==""){
		    	//$KeyField=($field["field_relation_name"]!="" ? $field["field_relation_name"] : ($field["field_item_type"]!="" ? "item_id" : $Page->key_field) );
		    	$KeyField=($field["field_relation_name"]!="" ? $field["field_relation_name"] : "item_id");
		    	if ($KeyField !="item_id") $ItemsStorage->AddRelationColumn($KeyField);
		   		$DeleteData=(!empty($fields) ? array($KeyField=>$fields) : array($KeyField=>$Page->item_id));
		   		if($field["field_item_type"]!="") $DeleteData["tag_type"]=$field["field_item_type"];
		    	$ItemsStorage->DeleteByKey($DeleteData);
			} else{
	    		$delete_method=$field["libraries_delete_method"];
     			$ItemsStorage->$delete_method($field, $fields, $Page);
	    	}
	    	DataDispatcher::Set("words_cleaned_".$field["field_relation_name"]."_".$field["field_words_name"], 1);
    	}
    }

} // --end of class


?>