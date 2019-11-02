<?php
/** ItemsEditControl controls drawer class
  * Provides routines to manipulate data and draw controls for itemseditcontrol classes
  * Draw edit controls
  * @author Konstantin  Matsebora <kmatsebora@activemedia.com.ua>
  * @version 1.0
  * @package  Libraries
  * @subpackage classes.web
  * @access public
  **/

  class EditControlDrawer  extends Component{
    /**
      * Method draws dbcombobox-control for edit form
      * @param  string    $_lang    Language version
      * @param  int       $i        Control number
      * @param  string    $_caption Control caption
      * @param  ItemsEditControl    $control  ItemsEditControl object
      * @access  public
      */
  static function DrawDBComboBox($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.dbcombobox","dbcomboboxcontrol");
   $control->Controls[$_lang]->AddControl(new DBComboBoxControl($control->fields[$i]["field_name"],"control"));
   $array=array(
             "name"          =>    $control->fields[$i]["field_name"],
             "selected_value"=>    $control->_data[$control->fields[$i]["field_name"]],
             "table"         =>    $control->fields[$i]["field_table"],
             "caption_field" =>    $control->fields[$i]["fieldvalue_caption"],
             "method"        =>    $control->fields[$i]["get_method"],
             "query_data"    =>    $control->fields[$i]["get_data"],
             "orders"        =>    $control->fields[$i]["get_orders"],
             "caption"       =>    $_caption,
             "multiple"      =>    $control->fields[$i]["multiple"],
             "number"        =>    $control->fields[$i]["number"],
             "use_root_caption" => $control->fields[$i]["use_root_caption"],
             "event"         =>    $control->fields[$i]["field_event"],
             "size"          =>    $control->fields[$i]["size"]
   );
   $tablefield = $control->Page->Storage->GetField($control->fields[$i]["field_name"]);
   if($tablefield["notnull"]){
      $array["notnull"] = 1;
   }
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
  }

/**
* Method draws dbcheckboxgroup-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawDBCheckboxGroup($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.dbcheckboxgroup","dbcheckboxgroupcontrol");
   $control->Controls[$_lang]->AddControl(new DBCheckboxGroupControl($control->fields[$i]["field_name"],"control"));

   $selected_value= $control->_data[$control->fields[$i]["field_name"]];
   //--if this checkbox group
   if ($control->fields[$i]["control"]=="checkboxgroup")  {
      if ($control->Page->Event=="EditItem" ||  $control->Page->Event=="AddItem")
         $selected_value=explode(",",$selected_value);
   }
   $array=array(
           "name"          =>   $control->fields[$i]["field_name"],
           "selected_value"=>   $selected_value,
           "table"         =>   $control->fields[$i]["field_table"],
           "caption_field" =>   $control->fields[$i]["fieldvalue_caption"],
           "method"        =>   $control->fields[$i]["get_method"],
           "query_data"    =>   $control->fields[$i]["get_data"],
           "orders"        =>   $control->fields[$i]["get_orders"],
           "caption"       =>   $_caption,
           "multiple"      =>   $control->fields[$i]["multiple"],
           "number"        =>   $control->fields[$i]["number"],
           "only_selected" =>   $control->fields[$i]["only_selected"]
   );
   $tablefield = $control->Page->Storage->GetField($control->fields[$i]["field_name"]);
   if($tablefield["notnull"]){
      $array["notnull"] = 1;
   }
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
}

/**
* Method draws dbcheckboxgroup-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawCheckboxGroup($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.checkboxgroup","checkboxgroupcontrol");
   $control->Controls[$_lang]->AddControl(new CheckboxGroupControl($control->fields[$i]["field_name"],"control"));
   $selected_value= $control->_data[$control->fields[$i]["field_name"]];
   //--if this checkbox group
   if ($control->fields[$i]["control"]=="checkboxgroup")  {
      if ($control->Page->Event=="EditItem" ||  $control->Page->Event=="AddItem")
         $selected_value=explode(",",$selected_value);
   }
   $array=array(
           "name"          =>   $control->fields[$i]["field_name"],
           "selected_value"=>   $selected_value,
           //"table"         =>   $control->fields[$i]["field_table"],
           //"caption_field" =>   $control->fields[$i]["fieldvalue_caption"],
           //"method"        =>   $control->fields[$i]["get_method"],
           //"query_data"    =>   $control->fields[$i]["get_data"],
           //"orders"        =>   $control->fields[$i]["get_orders"],
           "caption"       =>   $_caption,
           "multiple"      =>   $control->fields[$i]["multiple"],
           "number"        =>   $control->fields[$i]["number"],
           "only_selected" =>   $control->fields[$i]["only_selected"],
           "options"       =>   $control->fields[$i]["options"],
   );
   $tablefield = $control->Page->Storage->GetField($control->fields[$i]["field_name"]);
   if($tablefield["notnull"]){
      $array["notnull"] = 1;
   }
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
}


/**
* Method draws dbtreecombobox-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawDBTreeComboBox($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.dbtreecombobox","dbtreecomboboxcontrol");
   $control->Controls[$_lang]->AddControl(new DBTreeComboBoxControl($control->fields[$i]["field_name"],"control"));
   $array=EditControlDrawer::setDbTreeControlArray($control->fields[$i],$_caption,$control);
   $tablefield = $control->Page->Storage->GetField($control->fields[$i]["field_name"]);
   if($tablefield["notnull"]){
      $array["notnull"] = 1;
   }
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
}

/**
* Method draws dbtreetext-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawDBTreeText($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.dbtreetext","dbtreetextcontrol");
   $control->Controls[$_lang]->AddControl(new DBTreeTextControl($control->fields[$i]["field_name"],"control"));
   $array=EditControlDrawer::setDbTreeControlArray($control->fields[$i],$_caption,$control);
   $array["node"]=$control->fields[$i]["field_node"];
   $array["render_root"]=$control->fields[$i]["field_node"];
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
}

/**
* Method draws dbtreepath-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawDBTreePath($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.dbtreepath","dbtreepathcontrol");
   $control->Controls[$_lang]->AddControl(new DBTreePathControl($control->fields[$i]["field_name"],"control"));
   $array = array( "table" =>  $control->fields[$i]["field_table"],
                   "caption_field" => sprintf($control->fields[$i]["fieldvalue_caption"], $control->Page->Kernel->Language),
                   "parent_field" => sprintf($control->fields[$i]["fieldvalue_parent"], $control->Page->Kernel->Language),
                   "category_value" => $control->_data[$control->fields[$i]["field_name"]],
                   "caption" => $_caption
   );

   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
}

/**
* Method draws dbradiogroup-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawDBRadioGroup($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.dbradiogroup","DbRadioGroupControl");
   $control->Controls[$_lang]->AddControl(new DBRadioGroupControl($control->fields[$i]["field_name"],"control"));
   $array=array(
           "name"          =>   $control->fields[$i]["field_name"],
           "selected_value"=>   $control->_data[$control->fields[$i]["field_name"]],
           "table"         =>   $control->fields[$i]["field_table"],
           "caption_field" =>   $control->fields[$i]["fieldvalue_caption"],
           "method"        =>   $control->fields[$i]["get_method"],
           "query_data"    =>   $control->fields[$i]["get_data"],
           "orders"        =>   $control->fields[$i]["get_orders"],
           "caption"       =>   $_caption,
           "multiple"      =>   $control->fields[$i]["multiple"],
           "number"        =>   $control->fields[$i]["number"]
   );
   $tablefield = $control->Page->Storage->GetField($control->fields[$i]["field_name"]);
   if($tablefield["notnull"]){
      $array["notnull"] = 1;
   }
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
}

/**
* Method draws radiogroup-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawRadioGroup($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.radiogroup","radiogroupcontrol");
   $control->Controls[$_lang]->AddControl(new RadioGroupControl($control->fields[$i]["field_name"],"control"));
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl(array(
         "name"=>$control->fields[$i]["field_name"],
         "value"=>$control->_data[$control->fields[$i]["field_name"]],
         "selected_value"=>   $control->_data[$control->fields[$i]["field_name"]],
         "options"=>$control->fields[$i]["options"],
         "caption" => $_caption
  ));
}

/**
* Method draws radiogroup-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawDBText($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.dbtext","dbtextcontrol");
   $control->Controls[$_lang]->AddControl(new DbTextControl($control->fields[$i]["field_name"],"control"));
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl(array(
           "name"          =>   $control->fields[$i]["field_name"],
           "table"         =>   $control->fields[$i]["field_table"],
           "caption_field" =>   $control->fields[$i]["fieldvalue_caption"],
           "orders"        =>   $control->fields[$i]["get_method"],
           "query_data"    =>   $control->fields[$i]["get_data"],
   ));
}

/**
* Method draws radiogroup-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawDBStaticText($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.dbstatictext","dbstatictextcontrol");
   $control->Controls[$_lang]->AddControl(new DBStaticTextControl($control->fields[$i]["field_name"],"control"));
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl(array(
           "name"          =>   $control->fields[$i]["field_name"],
           "table"         =>   $control->fields[$i]["field_table"],
           "caption_field" =>   $control->fields[$i]["fieldvalue_caption"],
           "orders"        =>   $control->fields[$i]["get_method"],
           "query_data"    =>   array($control->fields[$i]["fieldvalue_name"] =>$control->_data[$control->fields[$i]["linkfield_name"]]),
           "caption"       =>   $_caption
   ));
}

/**
* Method draws text-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param    string        $_hint        Control hint
* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawText($_lang, $i, $_caption, $_hint="",&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.text","textcontrol");
   $control->Controls[$_lang]->AddControl(new TextControl($control->fields[$i]["field_name"],"control"));
   $tablefield = $control->Storage->GetField($control->fields[$i]["field_name"]);
   $array = array(
           "name"=>$control->fields[$i]["field_name"],
           "value"=>$control->_data[$control->fields[$i]["field_name"]],
           "maxlength"=>$control->fields[$i]["length"],
           "caption"=>$_caption,
           "size"=>$control->fields[$i]["size"],
                   "hint"=>$_hint
   );
   if($tablefield["notnull"] || $control->fields[$i]["field_notnull"]){
      $array["notnull"] = 1;
   }
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
}


/**
* Method draws statictext-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawStaticText($_lang, $i, $_caption,&$control)
{
  $control->Page->Kernel->ImportClass("system.web.controls.statictext","statictextcontrol");
  if (strlen($control->_data[$control->fields[$i]["field_name"]])!=0)  {
   $control->Controls[$_lang]->AddControl(new StaticTextControl($control->fields[$i]["field_name"],"control"));
   if (isset($control->fields[$i]["text_value"])) {
       $content = $control->fields[$i]["text_value"];
   }    else    {
       $content = $control->_data[$control->fields[$i]["field_name"]];
   }

   $array = array(
           "value"     => $control->_data[$control->fields[$i]["field_name"]],
           "caption"   => $_caption,
           "content"   => $content,
           "disabled"  => 1,
           "name"      => $control->fields[$i]["field_name"]
         );
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
  }
}

/**
* Method draws checkbox-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawCheckbox($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.checkbox","checkboxcontrol");
   $control->Controls[$_lang]->AddControl(new CheckboxControl($control->fields[$i]["field_name"],"control"));
	$array = array( "name"=>$control->fields[$i]["field_name"],
           "value"=>$control->fields[$i]["checkOn"],
           "caption"=>$_caption);

   if($control->_data[$control->fields[$i]["field_name"]] == $control->fields[$i]["checkOn"]){
        $array["checked"] = "yes";
   }
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
}

/**
* Method draws date-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawDate($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.datetime","datetimecontrol");
   $control->Controls[$_lang]->AddControl(new DateTimeControl($control->fields[$i]["field_name"],"control"));
   $array = array( "name"=>$control->fields[$i]["field_name"],
           "caption"=>$_caption,
      );
   if($control->fields[$i]["is_unix_timestamp"] == 0){
       $array["value"] = null;
       if($control->fields[$i]["fulldate"]==0){
           if ($control->_data[$control->fields[$i]["field_name"]]) {
               list($array["value"]) = explode(" ", $control->_data[$control->fields[$i]["field_name"]]);
           }

       } else {
           if ($control->_data[$control->fields[$i]["field_name"]]) {
               $array["value"] = $control->_data[$control->fields[$i]["field_name"]];
           }

           $array["fulldate"] = 1;
       }
   } else {
       $pattern = "Y-m-d";
       if($control->fields[$i]["fulldate"]==1){
           $array["fulldate"] = 1;
           $pattern .= " H:i:s";
       }
       if ($control->_data[$control->fields[$i]["field_name"]]) {
           $array["value"] = date($pattern,$control->_data[$control->fields[$i]["field_name"]]);
       }

   }
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
}


/**
* Method draws combobox-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawComboBox($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.select","selectcontrol");
   $control->Controls[$_lang]->AddControl(new SelectControl($control->fields[$i]["field_name"],"control"));
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl(array(
               "name"          => $control->fields[$i]["field_name"],
               "value"         => $control->_data[$control->fields[$i]["field_name"]],
               "selected_value"=> $control->_data[$control->fields[$i]["field_name"]],
               "options"       => $control->fields[$i]["options"],
               "caption"       => $_caption,
               "event"         => $control->fields[$i]["field_event"],
            	"size"          =>    $control->fields[$i]["size"],
   				"multiple"      => $control->fields[$i]["multiple"]
   ));
}


/**
* Method draws file-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawFile($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.file","filecontrol");
   $append_dir = ($control->fields[$i]["private_directory"] ? $control->Page->Auth->UserId."/" : "");
   $tablefield = $control->Page->Storage->GetField($control->fields[$i]["field_name"]);
   $array = array(
               "name"=>$control->fields[$i]["field_name"],
               "value"=>$control->_data[$control->fields[$i]["field_name"]],
               "directory"=>$control->fields[$i]["file_directory"].$append_dir,
               "caption" => $_caption,
  );
   if($tablefield["notnull"]){
      $array["notnull"] = 1;
   }
   $control->Controls[$_lang]->AddControl(new FileControl($control->fields[$i]["field_name"],"control"));
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);

}

static function DrawFile2($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.file2","file2control");
   $append_dir = ($control->fields[$i]["private_directory"] ? "/".$control->Page->Auth->UserId : "");
   $tablefield = $control->Page->Storage->GetField($control->fields[$i]["field_name"]);
   $array = array(
               "name"=>$control->fields[$i]["field_name"],
               "value"=>$control->_data[$control->fields[$i]["field_name"]],
               "directory"=>$control->fields[$i]["file_directory"].$append_dir,
               "caption" => $_caption,
  );
   if($tablefield["notnull"]){
      $array["notnull"] = 1;
   }
   $control->Controls[$_lang]->AddControl(new File2Control($control->fields[$i]["field_name"],"control"));
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);

}

/**
* Method draws file-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawFilesListBox($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.fileslistbox","FilesListBoxControl");
   //$append_dir = ($control->fields[$i]["private_directory"] ? "/".$control->Page->Auth->UserId : "");
   $tablefield = $control->Page->Storage->GetField($control->fields[$i]["field_name"]);
   $array = array(
               "name"=>$control->fields[$i]["field_name"],
               "value"=>$control->_data[$control->fields[$i]["field_name"]],
               "directory"=>$control->fields[$i]["root_path"],
               "show_files"=>$control->fields[$i]["show_files"],
               "files_filter"=>$control->fields[$i]["files_filter"],
               "dirs_filter"=>$control->fields[$i]["dirs_filter"],
               "dirs_select"=>$control->fields[$i]["dirs_select"],
               "number" => $i,
               "use_root_caption"=>$control->fields[$i]["use_root_caption"],
               "multiple" => $control->fields[$i]["multiple"],
               "caption" => $_caption,
  );
   if($tablefield["notnull"]){
      $array["notnull"] = 1;
   }
   $control->Controls[$_lang]->AddControl(new FilesLIstBoxControl($control->fields[$i]["field_name"],"control"));
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);

}


/**
* Method draws TextArea-control for edit form
* @param  string    $_lang      Language version
* @param  int        $i          Control number
* @param  string    $_caption    Control caption
* @param    string        $_hint        Control hint

* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawTextArea($_lang, $i, $_caption, $_hint="", &$control){
   $control->Page->Kernel->ImportClass("system.web.controls.textarea","textareacontrol");
   $control->Controls[$_lang]->AddControl(new TextAreaControl($control->fields[$i]["field_name"],"control"));
   $tablefield = $control->Page->Storage->GetField($control->fields[$i]["field_name"]);
   $array = array(
           "name"=>$control->fields[$i]["field_name"],
           "content"=>$control->_data[$control->fields[$i]["field_name"]],
           "maxlength"=>$control->fields[$i]["length"],
           "caption"=>$_caption,
           "cols"=>$control->fields[$i]["cols"],
           "rows"=>$control->fields[$i]["rows"],
           "hint" => $_hint
         );
   if($tablefield["notnull"]){
      $array["notnull"] = 1;
   }
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
}

/**
* Method draws htmleditor-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl    $control  ItemsEditControl object
* @access  public
*/
static function DrawHtmlEditor($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.htmleditor","htmleditorcontrol");
   $control->Controls[$_lang]->AddControl(new HtmlEditorControl($control->fields[$i]["field_name"],"control"));
   $tablefield = $control->Page->Storage->GetField($control->fields[$i]["field_name"]);
   $array = array(
           "name"=>$control->fields[$i]["field_name"],
           "content"=>$control->_data[$control->fields[$i]["field_name"]],
           "maxlength"=>$control->fields[$i]["length"],
           "caption"=>$_caption,
           "cols"=>$control->fields[$i]["cols"],
           "rows"=>$control->fields[$i]["rows"]
         );
   if($tablefield["notnull"]){
      $array["notnull"] = 1;
   }
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
}


/**
* Method draws machtmleditor-control for edit form
* @param    string      $_lang        Language version
* @param    int         $i            Control number
* @param    string      $_caption     Control caption
* @param  ItemsEditControl        $control      ItemsEditControl object
* @access    public
*/
static function DrawMacHtmlEditor($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.machtmleditor","machtmleditorcontrol");
     $control->Controls[$_lang]->AddControl(new MacHtmlEditorControl($control->fields[$i]["field_name"],"control"));
     $tablefield = $control->Page->Storage->GetField($control->fields[$i]["field_name"]);
     $append_dir = ($control->fields[$i]["private_directory"] ? "/".$control->Page->Auth->UserId : "");

     $array = array(
                   "name"=>$control->fields[$i]["field_name"],
                   "content"=>$control->_data[$control->fields[$i]["field_name"]],
                   "maxlength"=>$control->fields[$i]["length"],
                   "caption"=>$_caption,
                   "directory"=>$control->fields[$i]["file_directory"].$append_dir,
                   "cols"=>$control->fields[$i]["cols"],
                   "rows"=>$control->fields[$i]["rows"]
                 );
     if($tablefield["notnull"]){
          $array["notnull"] = 1;
     }
     $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
}


/**
* Method draws extrahtmleditor-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl        $control      ItemsEditControl object
* @access  public
*/
static function DrawExtraHtmlEditor($_lang, $i, $_caption,&$control){
  $control->Page->Kernel->ImportClass("system.web.controls.extrahtmleditor","extrahtmleditorcontrol");
  $control->Controls[$_lang]->AddControl(new ExtraHtmlEditorControl($control->fields[$i]["field_name"],"control"));
  $tablefield = $control->Page->Storage->GetField($control->fields[$i]["field_name"]);
  $array = array(
         "name"=>$control->fields[$i]["field_name"],
         "content"=>$control->_data[$control->fields[$i]["field_name"]],
         "maxlength"=>$control->fields[$i]["length"],
         "caption"=>$_caption,
         "cols"=>$control->fields[$i]["cols"],
         "rows"=>$control->fields[$i]["rows"],
         "directory"=>$control->fields[$i]["file_directory"]
   );
  if($tablefield["notnull"]){
  $array["notnull"] = 1;
  }
  $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
}

/**
* Method draws spaweditor-control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl        $control      ItemsEditControl object
* @access  public
*/
static function DrawSpawEditor($_lang, $i, $_caption,&$control){
  $control->Page->Kernel->ImportClass("system.web.controls.spaweditor","spaweditorcontrol");
  $control->Controls[$_lang]->AddControl(new SpawEditorControl($control->fields[$i]["field_name"],"control"));
  $tablefield = $control->Page->Storage->GetField($control->fields[$i]["field_name"]);
  $array = array(
         "name"=>$control->fields[$i]["field_name"],
         "content"=>$control->_data[$control->fields[$i]["field_name"]],
         "maxlength"=>$control->fields[$i]["length"],
         "caption"=>$_caption,
         "cols"=>$control->fields[$i]["cols"],
         "rows"=>$control->fields[$i]["rows"],
         "directory"=>$control->fields[$i]["file_directory"],
         "width"=>$control->fields[$i]["width"],
         "height"=>$control->fields[$i]["height"]

   );
  if($tablefield["notnull"]){
    $array["notnull"] = 1;
  }
  $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
}


/**
* Method draws FCKEditor control for edit form
* @param  string    $_lang    Language version
* @param  int    $i    Control number
* @param  string    $_caption    Control caption
* @param  ItemsEditControl        $control      ItemsEditControl object
* @access  public
*/
static function DrawFCKEditor($_lang, $i, $_caption,&$control){
  $control->Page->Kernel->ImportClass("system.web.controls.fckeditorcontrol","fckeditorcontrol");
  $control->Controls[$_lang]->AddControl(new FCKEditorControl($control->fields[$i]["field_name"],"control"));
  $tablefield = $control->Page->Storage->GetField($control->fields[$i]["field_name"]);
  $array = array(
         "name"=>$control->fields[$i]["field_name"],
         "content"=>$control->_data[$control->fields[$i]["field_name"]],
         "maxlength"=>$control->fields[$i]["length"],
         "caption"=>$_caption,
         "directory"=>$control->fields[$i]["file_directory"],
   );
  if($tablefield["notnull"]){
    $array["notnull"] = 1;
  }
  $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
}

/**
* Method draws password-control for edit form
* @param  string    $_lang      Language version
* @param  int       $i          Control number
* @param  string    $_caption   Control caption
* @param  ItemsEditControl    $control    ItemsEditControl object
* @access  public
*/
static function DrawPassword($_lang, $i, $_caption, $_hint="", &$control){
   $control->Page->Kernel->ImportClass("system.web.controls.password","passwordcontrol");
   $farray=array("name"       =>  $control->fields[$i]["field_name"],
           "value"      =>  $control->_data[$control->fields[$i]["field_name"]],
           "maxlength"  =>  $control->fields[$i]["length"],
           "caption"    =>  $_caption,
           "size"       =>  $control->fields[$i]["size"],
           "hint" => $_hint
   );
   if($control->Page->Request->Value("event")=="EditItem" & substr($control->fields[$i]["field_name"],strlen($control->fields[$i]["field_name"])-2,2)=="_2") {
      $farray["value"]= $control->_data[$control->fields[$i-1]["field_name"]];
   }
   $tablefield = $control->Page->Storage->GetField($control->fields[$i]["field_name"]);
   $field=$control->fields[$i];
   $prevfield=$control->fields[$i-1];
   if($tablefield["notnull"] || ($prevfield["field_name"]."_2"==$field["field_name"] && $prevfield["notnull"])){
      $farray["notnull"] = 1;
      $control->fields[$i]["notnull"]=1;
   }

   $control->Controls[$_lang]->AddControl(new PasswordControl($control->fields[$i]["field_name"],"control"));
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($farray);
}

/**
  * Method draws hidden-control for edit form
  * @param  string    $_lang    Language version
  * @param  int    $i    Control number
  * @param  string    $_caption    Control caption
  * @param  ItemsEditControl    $control    ItemsEditControl object
  * @access  public
  **/
static function DrawHidden($_lang, $i, $_caption,&$control){
  $control->AddControl(new HiddenControl($control->fields[$i]["field_name"], "hiddens"));
  if (strlen($control->fields[$i]["field_value"])!=0)
  $control->_data[$control->fields[$i]["field_name"]] = $control->fields[$i]["field_value"];
  $control->Controls[$control->fields[$i]["field_name"]]->InitControl(array(
      "name" => $control->fields[$i]["field_name"],
      "value" => $control->_data[$control->fields[$i]["field_name"]]
  ));
}
/**
    * Method draws Secure code-control for edit form
    * @param    string        $_lang        Language version
    * @param    int        $i        Control number
    * @param    string        $_caption        Control caption
    * @param  ItemsEditControl    $control    ItemsEditControl object
    * @access    public
    **/
static function DrawSecureCode($_lang, $i, $_caption,&$control){
     $control->Page->Kernel->ImportClass("system.web.controls.securecode","securecodecontrol");
     $control->Controls[$_lang]->AddControl(new SecureCodeControl($control->fields[$i]["field_name"],"control"));
     //$tablefield = $control->Page->Storage->GetField($control->fields[$i]["field_name"]);
     $array = array(
                   "name"=>$control->fields[$i]["field_name"],
                   "value"=>$control->_data[$control->fields[$i]["field_name"]],
                   "maxlength"=>$control->fields[$i]["length"],
                   "caption"=>$_caption,
                   "size"=>$control->fields[$i]["size"]
     );
     //if($tablefield["notnull"] || $control->fields[$i]["field_notnull"]){
     //     $array["notnull"] = 1;
     //}
     $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
}


/**
  * Method draws caption-control for edit form
  * @param  string    $_lang    Language version
  * @param  int    $i    Control number
  * @param  string    $_caption    Control caption
  * @param  ItemsEditControl    $control    ItemsEditControl object
  * @access  public
  **/
  static function DrawCaption($_lang,$i,$_caption,&$control) {
      $value = $control->_data[$control->fields[$i]["field_name"]];
      foreach ($control->fields[$i]["options"] as $j  =>  $option)  {
        if ($option["value"] == $value)  {
            $control->fields[$i]["text_value"] = $option["caption"];
            $control->_data[$control->fields[$i]["field_name"]] = $option["value"];
        }
      }
      EditControlDrawer::DrawStaticText($_lang,$i,$_caption,$control);
  }
/**
   * Method set basic arrays for dbtreecombobox and dbtreetext controls
   * @param   array    $field    field data array
   * @param    string  $caption  caption string
   * @return  array  $array    control data array
   * @param  ItemsEditControl    $control    ItemsEditControl object
   * @access private
   **/
   static function setDbTreeControlArray($field,$caption="",&$control)  {
         $array=array(
                               "name"          =>   $field["field_name"],
                               "selected_value"=>   $control->_data[$field["field_name"]],
                               "table"         =>   $field["field_table"],
                               "parent"        =>   $field["parent"],
                               "caption_field" =>   $field["fieldvalue_caption"],
                               "method"        =>   $field["get_method"],
                               "query_data"    =>   $field["get_data"],
                               "orders"        =>   $field["get_orders"],
                               "size"        =>   $field["size"],
                               "caption"       =>   $caption,
                               "number"        =>   $field["number"],
                               "multiple"         =>  $field["multiple"],
                               "use_root_caption" =>  $field["use_root_caption"],
                               "use_entries"      =>  $field["use_entries"],
                               "entries_table"         =>   $field["entries_table"],
                               "entriesvalue_name"     =>   $field["entriesvalue_name"],
                               "entriesvalue_caption"  =>   $field["entriesvalue_caption"],
                               "entries_orders"  =>   $field["entries_orders"],
                               "allow_category_select" =>   $field["allow_category_select"],
                               "get_method"             =>   $field["get_method"],
                               "entries_get_method"     =>   $field["entries_get_method"],
                               "get_from"         =>   $field["get_from"],
                               "render_root"         =>   $field["render_root"],
                               "parsed_fields"       =>    $field["field_parsedfields"],
                               "event"               =>    $field["field_event"]


           );

		if ($array["get_from"]) {
			if (strlen($field["item_id"])==0) {
				$array["item_id"]=$control->Page->item_id;
			}else{
				if (intval($field["item_id"])==0) {
					$array["item_id"]=intval($control->_data[$field["item_id"]]);
				} else {
					$array["item_id"] = $field["item_id"];
				}
			}
		}
      return $array;
   }

  static function DrawDBEditBlock($_lang, $i, $_caption,&$control){
   $control->Page->Kernel->ImportClass("system.web.controls.dbeditblock2","dbeditblockcolntrol2");
   $control->Controls[$_lang]->AddControl(new DbEditBlockControl2($control->fields[$i]["field_name"],"control"));
   $array=array(
             "name"          =>    $control->fields[$i]["field_name"],
             "table"         =>    $control->fields[$i]["field_table"],
             "value_field"   =>    $control->fields[$i]["value_field"],
             "caption_field" =>    $control->fields[$i]["caption_field"],
             "link_to_value" =>    $control->fields[$i]["link_to_value"],
             "get_method"    =>    $control->fields[$i]["get_method"],
             "caption"       =>    $_caption,
             "size"          =>    $control->fields[$i]["size"]
   );
   $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
  }

  static function DrawAutocomplete($_lang, $i, $_caption,&$control){
  	$field=$control->fields[$i];
	$control->Page->Kernel->ImportClass("system.web.controls.autocompletecontrol","AutocompleteControl");
    $control->Controls[$_lang]->AddControl(new AutocompleteControl($field["field_name"],"control"));

      $array = array(
                   "name"=>$field["field_name"],
                   "value"=>$control->_data[$field["field_name"]],
                   "caption"=>$_caption,
                   "field_table"=>$field["field_table"],
                   "get_method"=>$field["get_method"],
                   "field_relation_name"=>$field["field_relation_name"],
                   "field_words_name"=>sprintf($field["field_words_name"], $_lang),
                   "create_new_items"=>$field["create_new_items"],
                   "autocomplete_method"=>$field["autocomplete_method"],
                   "words_delimeter"=>$field["words_delimeter"],
                   "item_type"=>$field["field_item_type"],
                   "multiple"=>$field["multiple"]
     );

     $control->Controls[$_lang]->Controls[$control->fields[$i]["field_name"]]->InitControl($array);
      return $array;
   }


} //--end of class
