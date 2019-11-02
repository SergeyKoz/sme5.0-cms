<?php
  $this->ImportClass("system.web.controls.form","FormControl");
  $this->ImportClass("system.web.controls.dbtext","DBTextControl");
  $this->ImportClass("system.web.controls.langversioncontrol","LangVersionControl");
  $this->ImportClass("web.editcontroldrawer","EditControlDrawer");
  $this->ImportClass("system.web.controls.select", "SelectControl");
  $this->ImportClass("system.web.controls.hidden", "HiddenControl");


   /** List control
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Libraries
     * @subpackage classes.web.controls
     * @access public
     */
    class ItemsEditControl extends FormControl {
        var $ClassName = "ItemsEditControl";
        var $Version = "1.0";
        /**    Data storage
        * @var   Object     $Storage
        */
        var $Storage;
        /**    Sorting order
        * @var   string     $order
        */
        var $fields;
        /**    Navigator url
        * @var   string     $navigator_url
        */
        /** Item ID to edit
        * @var int  $item_id
        */
        var $item_id;
        /** Key field name
        * @var string   $key_field
        */
        var $key_field;
        /** Record data
        * @var array   $_data
        */
        var $_data;
        /** Event
        * @var string  $event
        */
        var $event;
        /** Handler  page
        * @var string   $handler
        */
        var $handler;
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
        /** Library string ID
        * @var string   $library_ID
        */
        var $library_ID;
      /** Library package name
        * @var string  $libraryPackage
        **/
        var $libraryPackage;
        /** Host Library ID
        * @var string  $host_library_ID
        */
        var $host_library_ID;
        /**   Value of custom variable passed to editor
        * @var  int   $custom_val
        */
        var $custom_val;
        /**   Name of custom variable passed to editor
        * @var  string   $custom_var
        */
        var $custom_var;
   /**
     * Field group names
     * @access public
     **/
    var $group_names=array();
   /**
     * Field group titles
     * @access public
     **/
    var $group_titles=array();
    /**
     * Flag defines if form have additional hiddens (defined in library file)
     * @var boolean $additionalhiddens
     **/
    var $additionalhiddens=false;

        /** Constructor. Initializes a new instance of the Control class.
        * @param     string    $name   Name of  control
        * @param     string    $xmlTag  NAme of XML Tag
        * @param     object    $storage  Storage object
        * @access    public
        */
        function ItemsEditControl($name, $xmlTag, &$storage)    {
          parent::FormControl($name, $xmlTag);
          @$this->Storage = &$storage;

        }


        /**
        * Method  initialize data for control
        *  @param   array   $data   Initial data
        * @access   public
        */
        function InitControl($data=array()){

      $this->LibrariesRoot= $this->Page->Kernel->Package->Settings->GetItem("main","LibrariesRoot");
          $this->fields = $data["form_fields"];
          $this->item_id = $data["item_id"];
          $this->key_field = $data["key_field"];
          $this->event = $data["event"];
          $this->handler = $data["handler"];
          $this->Package = $data["package"];
          $this->_data = $data["data"];
          $this->start = $data["start"];
          $this->order_by = $data["order_by"];
          $this->library_ID=$data["library"];
          $this->host_library_ID=$data["host_library_ID"];

          $this->restore = $data["restore"];
          $this->parent_id = $data["parent_id"];
          $this->sectionname = strtoupper($data["library"]);

          $this->custom_var = $data["custom_var"];
          $this->custom_val = $data["custom_val"];
      $this->group_names = (isset($data["group_names"]) ? $data["group_names"] : array());
      $this->group_titles = $data["group_titles"];

        $this->allfields=$this->fields;


      //--for in language versions
          $_LangShortNames=$this->Page->Kernel->Settings->GetItem("language","_LangShortName");
          $_LangLongNames=$this->Page->Kernel->Settings->GetItem("language","_LangLongName");
            if (!is_array($_LangShortNames))    {
                    $_LangShortNames=array($_LangShortNames);
                    $_LangLongNames=array($_LangLongNames);
            }
      //Set page title
          if (!$this->Page->Kernel->Localization->HasItem($this->Page->ClassName,"_PageTitle"))   {
               if ($this->Page->Kernel->Localization->HasItem($this->library_ID,"_EDIT_TITLE")) {
                   $title = $this->Page->Kernel->Localization->GetItem($this->library_ID,"_EDIT_TITLE");
                   $this->Page->Kernel->Localization->SetItem($this->Page->ClassName,"_PageTitle",$title);
               }
          }
      //--process main section
      $this->GetLibraryData();

      //-- if edit page use custom edit caption
       if($this->use_custom_edit_caption) {
        if ($this->custom_edit_http_var) {
           $captionFieldValue = $this->Page->Request->ToNumber($this->custom_edit_http_var, 0);
        } else {
        	$captionFieldValue = $this->_data[$this->custom_edit_captionid_field];
        }
        $this->AddControl(new DbTextControl("custom_caption","custom_caption"));
        $this->Controls["custom_caption"]->InitControl(array(
                  "name"          => "custom_caption",
                  "table"         => $this->custom_edit_caption_table,
                  "caption_field" => sprintf($this->custom_edit_caption, $this->Page->Kernel->Language),
                  "query_data"    => array($this->custom_edit_captionid_field => $captionFieldValue)
        ));
       }

          //-- create main section control
          $this->AddControl(new LangVersionControl("main","langversion"));
          $this->Controls["main"]->InitControl(
                                                      array("prefix"       =>    $_lang,
                                                            "shortname"        =>    $this->Page->Kernel->Localization->GetItem("Main","_MainSectionShortName"),
                                                            "longname"         =>    ($this->Page->Kernel->Localization->HasItem($this->Page->ClassName,"_MainSectionLongName")?
                                                                                      $this->Page->Kernel->Localization->GetItem($this->Page->ClassName,"_MainSectionLongName"):
                                                                                      $this->Page->Kernel->Localization->GetItem("Main","_MainSectionLongName"))
                                                       )
               );

          foreach($this->allfields as $_lang=>$this->fields)    {
            //create language section control
        //get language position
        $_sitelanguages=$this->Page->Kernel->Settings->GetItem("language","_Language");
        if (!is_array($_sitelanguages)) $_sitelanguages=array($_sitelanguages);
        //search in languages
        $_langpos=array_search($_lang,$_sitelanguages);

        //--if not found in languages search in field groups
        if ($_langpos===false)  {
            $_langpos=array_search($_lang,$this->group_names);
            $_shortname=$this->group_titles[$_langpos];
            $_longname=$_shortname;
        } else  {
            $_shortname=$_LangShortNames[$_langpos];
            $_longname=$_LangLongNames[$_langpos];
        }
        //--if section exists
              if ($_langpos!==false)    {
                    $this->AddControl(new LangVersionControl($_lang,"langversion"));
          //set control fields
                  $this->Controls[$_lang]->InitControl(
                                                                        array("prefix"       => $_lang,
                                                                                  "shortname"   =>  $_shortname,
                                                                                  "longname"    =>   $_longname
                                                      )
                                                  );
              }

          for($i=0; $i<sizeof($this->fields); $i++){
        //get field caption
        if ($this->Page->Kernel->Localization->HasItem($this->sectionname, $this->fields[$i]["field_name"]))  {
            $_caption=$this->Page->Kernel->Localization->GetItem($this->sectionname, $this->fields[$i]["field_name"]);
        }   else    {
            $_caption=$this->Page->Kernel->Localization->GetItem("main", $this->fields[$i]["field_name"]);
        }
      if($this->Page->Kernel->Localization->HasItem($this->sectionname, $this->fields[$i]["field_name"]."_hint")){
          $_hint = implode(" ", $this->Page->Kernel->Localization->GetItem($this->sectionname, $this->fields[$i]["field_name"]."_hint", false, true));
      } else {
          $_hint = "";
      }
      //Draw controls

			switch ($this->fields[$i]["control"]){
				case "file":
					EditControlDrawer::DrawFile($_lang, $i, $_caption,$this);
					break;
				case "file2":
					EditControlDrawer::DrawFile2($_lang, $i, $_caption,$this);
					break;
				case "fileslistbox":
					EditControlDrawer::DrawFilesListBox($_lang, $i, $_caption,$this);
					break;
				case "caption":
					EditControlDrawer::DrawCaption($_lang, $i, $_caption,$this);
					break;
				case "checkboxgroup":
					EditControlDrawer::DrawCheckboxGroup($_lang, $i, $_caption,$this);
					break;
				case "combobox":
					EditControlDrawer::DrawComboBox($_lang, $i, $_caption,$this);
					break;
				case "dbcombobox":
					EditControlDrawer::DrawDBComboBox($_lang, $i, $_caption,$this);
					break;
				//case "checkboxgroup":
				case "dbcheckboxgroup":
					EditControlDrawer::DrawDBCheckboxGroup($_lang, $i, $_caption,$this);
					break;
				case "dbeditblock2":
					EditControlDrawer::DrawDBEditBlock($_lang, $i, $_caption,$this);
					break;
				case "dbtreecombobox":
					EditControlDrawer::DrawDBTreeComboBox($_lang, $i, $_caption,$this);
					break;
				case "dbtreetext":
					EditControlDrawer::DrawDBTreeText($_lang, $i, $_caption,$this);
					break;
				case "dbtreepath":
					EditControlDrawer::DrawDBTreePath($_lang, $i, $_caption,$this);
					break;
				case "dbradiogroup":
					EditControlDrawer::DrawDBRadioGroup($_lang, $i, $_caption,$this);
					break;
				case "radiogroup":
					EditControlDrawer::DrawRadioGroup($_lang, $i, $_caption,$this);
					break;
				case "dbtext":
					EditControlDrawer::DrawDBText($_lang, $i, $_caption,$this);
					break;
				case "dbstatictext":
					EditControlDrawer::DrawDBStaticText($_lang, $i, $_caption,$this);
					break;
				case "text":
					EditControlDrawer::DrawText($_lang, $i, $_caption, $_hint,$this);
					break;
				case "statictext":
					EditControlDrawer::DrawStaticText($_lang, $i, $_caption,$this);
					break;
				case "checkbox":
					EditControlDrawer::DrawCheckbox($_lang, $i, $_caption,$this);
					break;
				case "date":
					EditControlDrawer::DrawDate($_lang, $i, $_caption,$this);
					break;
				case "textarea":
					EditControlDrawer::DrawTextArea($_lang, $i, $_caption, $_hint, $this);
					break;
				case "htmleditor":
					EditControlDrawer::DrawHtmlEditor($_lang, $i, $_caption,$this);
					break;
				case "machtmleditor":
					EditControlDrawer::DrawMacHtmlEditor($_lang, $i, $_caption,$this);
					break;
				case "extrahtmleditor":
					EditControlDrawer::DrawExtraHtmlEditor($_lang, $i, $_caption,$this);
					break;
				case "spaweditor":
					EditControlDrawer::DrawSpawEditor($_lang, $i,$_caption,$this);
					break;
				case "fckeditor":
					EditControlDrawer::DrawFCKEditor($_lang, $i,$_caption,$this);
					break;
				case "password":
					EditControlDrawer::DrawPassword($_lang, $i, $_caption, $_hint ,$this);
					break;
				case "hidden":
					EditControlDrawer::DrawHidden($_lang, $i, $_caption, $this);
					break;
				case "securecode":
					EditControlDrawer::DrawSecureCode($_lang, $i, $_caption, $this);
					break;
				case "autocomplete":
					EditControlDrawer::DrawAutocomplete($_lang, $i, $_caption, $this);
					break;

				default:
					$this->Page->DrawCustomField($_lang, $i, $_caption, $this);
					break;

			}//switch
          } // for i
     }//foreach



  }

     /**
     * Method  Executes on control load to the parent
   * @abstart
     * @access  private
     **/
        function ControlOnLoad() {
    }


    /**
        *  Method draws xml-content of control
        *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
        *  @access  public
        **/
        function XmlControlOnRender(&$xmlWriter) {
            $xmlWriter->WriteElementString("tab_id", Request::StaticValue($this, "tab_id"));
           $this->AddControl(new HiddenControl("page", "hiddens"));
           $this->Controls["page"]->InitControl(array(
                                              "name" => "page",
                                              "value" => $this->handler
           ));

           if ($this->Package!=""){
	           $this->AddControl(new HiddenControl("package", "hiddens"));
	           $this->Controls["package"]->InitControl(array(
	                                              "name" => "package",
	                                              "value" => $this->Package
	           ));
	       }

           $this->AddControl(new HiddenControl("event", "hiddens"));
           $this->Controls["event"]->InitControl(array(
                                              "name" => "event",
                                              "value" => "Do".$this->event
           ));

           $this->AddControl(new HiddenControl("item_id", "hiddens"));
           $this->Controls["item_id"]->InitControl(array(
                                              "name" => "item_id",
                                              "value" => $this->item_id
           ));

           $this->AddControl(new HiddenControl("start", "hiddens"));
           $this->Controls["start"]->InitControl(array(
                                              "name" => $this->library_ID."_start",
                                              "value" => $this->start
           ));

           $this->AddControl(new HiddenControl("order_by", "hiddens"));
           $this->Controls["order_by"]->InitControl(array(
                                              "name" => $this->library_ID."_order_by",
                                              "value" => $this->order_by
           ));

           $this->AddControl(new HiddenControl("library", "hiddens"));
           $this->Controls["library"]->InitControl(array(
                                              "name" => "library",
                                              "value" => $this->library_ID
           ));
           $this->AddControl(new HiddenControl("restore", "hiddens"));
           $this->Controls["restore"]->InitControl(array(
                                              "name" => "restore",
                                              "value" => $this->restore
           ));
           $this->AddControl(new HiddenControl("parent_id", "hiddens"));
           $this->Controls["parent_id"]->InitControl(array(
                                              "name" => $this->library_ID."_parent_id",
                                              "value" => $this->parent_id
           ));

           if ($this->Page->is_context_frame){
	           $this->AddControl(new HiddenControl("contextframe", "hiddens"));
	           $this->Controls["contextframe"]->InitControl(array(
	                                              "name" => "contextframe",
	                                              "value" => 1
	           ));
           }
           if(strlen($this->custom_var) && strlen($this->custom_val)){
               $this->AddControl(new HiddenControl("custom_var", "hiddens"));
               $this->Controls["custom_var"]->InitControl(array(
                                                  "name" => "custom_var",
                                                  "value" => $this->custom_var
               ));
               $this->AddControl(new HiddenControl("custom_val", "hiddens"));
               $this->Controls["custom_val"]->InitControl(array(
                                                  "name" => "custom_val",
                                                  "value" => $this->custom_val
               ));
           }// if
           if(strlen($this->host_library_ID)){
               $this->AddControl(new HiddenControl("host_library_ID", "hiddens"));
               $this->Controls["host_library_ID"]->InitControl(array(
                                                  "name" => "host_library_ID",
                                                  "value" => $this->host_library_ID
               ));


          }//if

            //write principal (system) data tags
      $this->writePrincipalData($xmlWriter);
        }


    /**
        * Method write principal (system, marked _, like _createrid etc.) data to tag "principal".
      * @param  xmlWriter   $xmlWriter  xmlWriter object
      * @access public
      **/
    function writePrincipalData(&$xmlWriter)    {
         $_principalvalues=array();
       if (count($this->_data)) {
        foreach( $this->_data as $_key=>$_value)    {
            if (substr($_key,0,1)=="_")  $_principalvalues[$_key]=$_value;
        }
       }
       if (count($_principalvalues))    {
        $xmlWriter->WriteStartElement("principal");
        foreach ($_principalvalues as $key => $value)
            $xmlWriter->WriteElementString($key,$value);
                $xmlWriter->WriteEndElement();
        }
    }


/**
  * Method processes MAIN section of library config
  * @access  public
  */
  function ProcessMainSection(){
    $this->ProcessCustomEditCaptionSettings();

  }


  /**
  * Method processes custom edit caption settings
  * @access  public
  */
  function ProcessCustomEditCaptionSettings(){
      if($this->editSettings->HasItem("MAIN","USE_CUSTOM_EDIT_CAPTION")){
        $this->use_custom_edit_caption = $this->editSettings->GetItem("MAIN","USE_CUSTOM_EDIT_CAPTION");
        if($this->use_custom_edit_caption){
          if($this->editSettings->HasItem("MAIN","CUSTOM_EDIT_CAPTION_TABLE")){
            $this->custom_edit_caption_table = $this->editSettings->GetItem("MAIN","CUSTOM_EDIT_CAPTION_TABLE");
          } else {
            $this->AddEditErrorMessage("EMPTY_CUSTOM_EDIT_CAPTION_SETTINGS");
          }

          if($this->editSettings->HasItem("MAIN","CUSTOM_EDIT_CAPTIONID_FIELD")){
            $this->custom_edit_captionid_field = $this->editSettings->GetItem("MAIN","CUSTOM_EDIT_CAPTIONID_FIELD");
          } else {
            $this->AddEditErrorMessage("EMPTY_CUSTOM_TREE_PATH_SETTINGS");
          }
          if($this->editSettings->HasItem("MAIN","CUSTOM_EDIT_CAPTION")){
            $this->custom_edit_caption = $this->editSettings->GetItem("MAIN","CUSTOM_EDIT_CAPTION");
          } else {
            $this->AddEditErrorMessage("EMPTY_CUSTOM_EDIT_CAPTION_SETTINGS");
          }

          if($this->editSettings->HasItem("MAIN","CUSTOM_EDIT_HTTPVAR")){
            $this->custom_edit_http_var = $this->editSettings->GetItem("MAIN","CUSTOM_EDIT_HTTPVAR");
          }
        }
      } else {
        $this->use_custom_edit_caption = 0;
      }

  }


  /** Method Gets data from library file
  * @access public
  */
  function GetLibraryData(){

	if(!strlen($this->library_ID)){
		$this->library_ID=$this->Page->Kernel->Package->Settings->GetItem("main","LibraryName");
		if (strlen($this->library_ID)==0)
			$this->AddEditErrorMessage("EMPTY_LIBRARY_ID");
	}

     if(!$this->error){
       $this->editSettings = Engine::getLibrary($this->Page->Kernel,$this->library_ID,"EditSettings_".$this->library_ID,true,$this->libraryPackage);
     }  else  {
       $this->AddEditErrorMessage("LIBRARY_ERROR");
     }
     if($this->editSettings->GetCount()){
     if(!$this->error){
     //check if class-table exists
       $this->ProcessMainSection();
     }// !error
    } else {
      $this->AddEditErrorMessage("EMPTY_LIBRARY_SETTINGS");
    }
  }

    /**
      * Method adds error messages
      * @param      string      $item_id    Error ID
      * @param      array       $data       Additional data for error description
      * @access     public
    */
    function AddEditErrorMessage($item_id, $data=array()){
           $message = $this->Page->AddErrorMessage("LIBRARY", $item_id, array_merge(array($this->library_ID),$data),false,true);
           user_error($message,E_USER_ERROR);
           //$this->error++;
      }
} // class

?>