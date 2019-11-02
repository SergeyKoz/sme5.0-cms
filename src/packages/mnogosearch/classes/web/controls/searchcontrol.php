<?php
  Kernel::ImportClass("system.web.xmlcontrol", "XMLControl");
  Kernel::ImportClass("system.web.controls.checkbox", "CheckboxControl");
  Kernel::ImportClass("system.web.controls.checkboxgroup", "CheckboxGroupControl");
  Kernel::ImportClass("system.web.controls.select", "SelectControl");
  Kernel::ImportClass("system.web.controls.text", "TextControl");

  $this->ImportClass("web.helper.mnogosearchhelper", "MnogoSearchHelper","mnogosearch");
  /**  Controll class for search page
   * @author Sergey Kozin <skozin@activemedia.com.ua>
   * @version 1.0
   * @package Mnogosearch
   * @access public
   **/
  class SearchControl extends FormControl {

    var $ClassName = "SearchControl";
    var $Version = "1.0";

    //global $QUERY_STRING;

   /**
    * Method executes on page load
    * @access public
   **/
   function ControlOnLoad(){
      global $QUERY_STRING;
      //Get vars
      $this->Get=$_GET;

      $indexer_global=$this->Page->Kernel->Package->Settings->GetSection("indexer_global");
      $indexer_url_control=$this->Page->Kernel->Package->Settings->GetSection("indexer_url_control");
      $indexer_external=$this->Page->Kernel->Package->Settings->GetSection("indexer_external");
      $indexer_aliases=$this->Page->Kernel->Package->Settings->GetSection("indexer_aliases");
      $indexer_servers=$this->Page->Kernel->Package->Settings->GetSection("indexer_servers");
      $search_control=$this->Page->Kernel->Package->Settings->GetSection("search_control");

      $this->conf= array_merge(
                $indexer_global,
                $indexer_url_control,
                $indexer_external,
                $indexer_aliases,
                $indexer_servers,
                $search_control
                );

      if ($this->conf["DBAddr"]==""){
          list($driverName, $con)=DataFactory::GetConnectionProperties($this->Page->Kernel->Settings->GetItem("database", "ConnectionString"));
          $this->conf["DBAddr"] = sprintf("%s://%s%s%s%s/%s/%s",
                                       $driverName,
                                       $con["user"],
                                       ($con["password"]!="" ? ":".$con["password"]:""),
                                       ($con["user"]!="" ? "@":""),
                                       $con["host"],
                                       $con["database"],
                                       $this->conf["dbmode"]
                                  );
      }
      $init_data=array_merge($this->Get, $this->conf);
      $init_data["QUERY_STRING"]=$QUERY_STRING;
      if ($init_data["hlbeg"] == '') {$init_data["hlbeg"]='<font color="000088"><b>';}
      if ($init_data["hlend"] == '') $init_data["hlend"]="</b></font>";
      $init_data["BrowserCharset"]="windows-1251";
      $init_data["trackquery"]=0;
      if ($init_data["ps"]=="") $init_data["ps"]=20;
      if ($init_data["np"]=="") $init_data["np"]=0;
      $this->init_data=$init_data;
   }

   function ValidateForm(){
      $err=false;
      $this->err_searh_field = false;
      if ($this->Get["q"]==""){
           $this->AddErrorMessage("SEARCH","TEXT_IS_EMPTY");
           $this->err_searh_field=true;
           $err=true;
      }

      if (!extension_loaded('mnogosearch')) {
           $this->AddErrorMessage("SEARCH","EXTENSIONS_NOT_LOADED");
           $err=true;
      }
      return $err;
   }

   function OnSearch(){
       if (!$this->ValidateForm()) {
           $this->udm_agent=MnogoSearchHelper::InitSearchAgent($this->init_data);
       }
   }

   /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   **/
   function XmlControlOnRender(&$xmlWriter) {

           //Initialization and render control of search form
           $data=array( "name" => "q", "value" => $this->Get["q"], "caption" => $this->GetLoc("_catption_q"));
           if ($this->err_searh_field) $data["error_field"]="q";
           $this->RenderControl($xmlWriter, $data, 0);

           $sel_data=array(
                //array("value" => "0", "caption" =>"all"),
                array("value" => "10", "caption" =>"10"),
                array("value" => "20", "caption" =>"20"),
                array("value" => "50", "caption" =>"50")
           );
           $data=array("name" => "ps", "multiple" => 0, "options" =>$sel_data, "selected_value" =>(!$this->Get["ps"]? 20: $this->Get["ps"]), "caption" => $this->GetLoc("_catption_ps"));
           $this->RenderControl($xmlWriter, $data, 1);

           $sel_data=array(
                array("value" => "0", "caption" => $this->GetLoc("_o_1")),
                array("value" => "1", "caption" => $this->GetLoc("_o_2")),
                array("value" => "2", "caption" => $this->GetLoc("_o_3")),
           );
           $data=array("name" => "o", "multiple" => 0, "options" =>$sel_data, "selected_value" =>$this->Get["o"], "caption" => $this->GetLoc("_catption_o"));
           $this->RenderControl($xmlWriter, $data, 1);

           $sel_data=array(
                array("value" => "all", "caption" => $this->GetLoc("_m_1")),
                array("value" => "any", "caption" => $this->GetLoc("_m_2")),
                array("value" => "boll", "caption" => $this->GetLoc("_m_3")),
           );
           $data=array("name" => "m", "multiple" => 0, "options" =>$sel_data, "selected_value" =>$this->Get["m"], "caption" => $this->GetLoc("_catption_m"));
           $this->RenderControl($xmlWriter, $data, 1);

           $sel_data=array(
                array("value" => "wrd", "caption" => $this->GetLoc("_wm_1")),
                array("value" => "beg", "caption" => $this->GetLoc("_wm_2")),
                array("value" => "end", "caption" => $this->GetLoc("_wm_3")),
                array("value" => "sub", "caption" => $this->GetLoc("_wm_4"))
           );
           $data=array("name" => "wm", "multiple" => 0, "options" =>$sel_data, "selected_value" =>$this->Get["wm"], "caption" => $this->GetLoc("_catption_wm"));
           $this->RenderControl($xmlWriter, $data, 1);

           $sel_data=array(
                array("value" => "ul", "caption" => $this->GetLoc("_ul_1")),
                array("value" => "/php/", "caption" => $this->GetLoc("_ul_2")),
                array("value" => "/mysql/", "caption" => $this->GetLoc("_ul_3")),
                array("value" => "/apache-manual/", "caption" => $this->GetLoc("_ul_4"))
           );
           $data=array("name" => "ul", "multiple" => 0, "options" =>$sel_data, "selected_value" =>$this->Get["ul"], "caption" => $this->GetLoc("_catption_ul"));
           $this->RenderControl($xmlWriter, $data, 1);

           $sel_data=array();
           $langNames = $this->Page->Kernel->Settings->GetItem("LANGUAGE", "_LangShortName");
           $lang = $this->Page->Kernel->Settings->GetItem("LANGUAGE", "_Language");
           for ($i=0;$i<sizeof($this->Page->Kernel->Languages);$i++) {
                array_push($sel_data, array("value" => $lang[$i], "caption" => $langNames[$i]));
           }
           $data=array("name" => "lang", "options" =>$sel_data, "selected_value" =>$this->Get["lang"], "caption" => $this->GetLoc("_catption_lang"));
           $this->RenderControl($xmlWriter, $data, 3);

           $sel_data=array(
                array("value" => "2221", "caption" => $this->GetLoc("_wf_1")),
                array("value" => "2000", "caption" => $this->GetLoc("_wf_2")),
                array("value" => "0200", "caption" => $this->GetLoc("_wf_3")),
                array("value" => "0020", "caption" => $this->GetLoc("_wf_4")),
                array("value" => "0001", "caption" => $this->GetLoc("_wf_5"))
           );
           $data=array("name" => "wf", "multiple" => 0, "options" =>$sel_data, "selected_value" =>$this->Get["wf"], "caption" => $this->GetLoc("_catption_wf"));
           $this->RenderControl($xmlWriter, $data, 1);

           $sel_data=array(
                array("value" => "", "caption" => $this->GetLoc("_type_1")),
                array("value" => "text/html", "caption" => $this->GetLoc("_type_2")),
                array("value" => "text/plain", "caption" => $this->GetLoc("_type_3")),
           );
           $data=array("name" => "type", "multiple" => 0, "options" =>$sel_data, "selected_value" =>$this->Get["type"], "caption" => $this->GetLoc("_catption_type"));
           $this->RenderControl($xmlWriter, $data, 1);

           $sel_data=array(
                array("value" => "RPD", "caption" => $this->GetLoc("_s_1")),
                array("value" => "DRP", "caption" => $this->GetLoc("_s_2")),
           );
           $data=array("name" => "s", "multiple" => 0, "options" =>$sel_data, "selected_value" =>$this->Get["s"], "caption" => $this->GetLoc("_catption_s"));
           $this->RenderControl($xmlWriter, $data, 1);

           $data=array("name" => "sp", "value" => "", "checked"=> ($this->Get["sp"]==1 ? "yes" : ""), "caption" => $this->GetLoc("_catption_sp"));
           $this->RenderControl($xmlWriter, $data, 2);
           $data=array("name" => "sy", "value" => "", "checked"=> ($this->Get["sy"]==1 ? "yes" : ""), "caption" => $this->GetLoc("_catption_sy"));
           $this->RenderControl($xmlWriter, $data, 2);

           $xmlWriter->WriteStartElement("list");
           if (isset($this->udm_agent)){
               if (MnogoSearchHelper::GetList($this->udm_agent, &$xmlWriter, $this->init_data)){
                   $this->AddErrorMessage("SEARCH","SEARCH_ERROR");
               }
           }
           $xmlWriter->WriteEndElement("list");
   }

   //Function for render control
   function RenderControl(&$xmlWriter, $data, $type){
           $this->data = $data;
           $xmlWriter->WriteStartElement("control");
           switch ($type) {
              case 0: TextControl::XmlControlOnRender($xmlWriter); break;
              case 1: SelectControl::XmlControlOnRender($xmlWriter); break;
              case 2: CheckboxControl::XmlControlOnRender($xmlWriter); break;
              case 3: CheckboxGroupControl::XmlControlOnRender($xmlWriter); break;
           }
           $xmlWriter->WriteEndElement("control");
   }

   //function get localization
   function GetLoc($var){
       return $this->Page->Kernel->Localization->GetItem("SearchControl", $var);
   }

 }// class
?>