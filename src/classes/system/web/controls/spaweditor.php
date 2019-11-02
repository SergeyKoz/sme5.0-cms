<?php

  $this->ImportClass("system.web.controls.textarea","textareacontrol");

/** SpawEditorControl control
   * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
   * @version 1.0
   * @package  Framework
   * @subpackage classes.system.web.controls
   * @access public
   */
  class SpawEditorControl extends TextAreaControl {
    var $ClassName = "SpawEditorControl";
    var $Version = "1.0";
    var $xmlTag="extrahtmleditor";
        /**
          * Initialization data array
          * structure:
          *           <ul>
          *           <li> <b>name</b>           - control name
          *           <li> <b>content</b>        - field content
          *           <li> <b>maxlength</b>      - field max length
          *           <li> <b>caption</b>        - field caption
          *           <li> <b>rows</b>           -  textarea rows number
          *           <li> <b>cols</b>           -  textarea columns number
          *           <li> <b>width</b>          -  editor width
          *           <li> <b>height</b>         -  editor height
          *           </ul>
          * @var    array   $data
          **/
          var $data = array();

    function InitControl($data=array()) {
      //set sesstions
      parent::InitControl($data);

      $Settings = $this->Page->Kernel->Settings;
      $RootPath="";

      $RootPath=$Settings->GetItem("Settings","FileStoragePath");
      $_SESSION["TINY"]["filesystem.rootpath"]=$RootPath;
      $_SESSION["TINY"]["filesystem.path"]=$RootPath;
      $_SESSION["TINY"]["preview.urlprefix"]=$Settings->GetItem("Settings","FileStorageURL");
      $_SESSION["TINY"]["preview.wwwroot"]=$RootPath;

      $_SESSION["isLoggedInSME"]=$this->Page->Auth->UserId>0;
    }


  /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
        function XmlControlOnRender(&$xmlWriter) {

         $tinymce_settings=$this->Page->Kernel->Settings->GetSection("TINYMCE");

         //URL to editor root
         $this->data["editor_url"]=$tinymce_settings["Dir"];

         $this->Page->IncludeScript($this->data["editor_url"]."tiny_mce.js");

         if($this->data["cols"]=="")    {
             if($this->Page->Kernel->Settings->HasItem($this->Page->ClassName, "Textarea_cols_".$this->data["name"])){
                $this->data["cols"] = $this->Page->Kernel->Settings->GetItem($this->Page->ClassName, "Textarea_cols_".$this->data["name"]);
             } else {
                $this->data["cols"] = $this->Page->Kernel->Settings->GetItem("MAIN", "Textarea_cols");
             }
         }

         if($this->data["rows"]==""){
             if($this->Page->Kernel->Settings->HasItem($this->Page->ClassName, "Textarea_rows_".$this->data["name"])){
                $this->data["rows"] = $this->Page->Kernel->Settings->GetItem($this->Page->ClassName, "Textarea_rows_".$this->data["name"]);
             } else {
                $this->data["rows"] = $this->Page->Kernel->Settings->GetItem("MAIN", "Textarea_rows");
             }
         }

		 if($this->data["theme"]==""){
	         if ($tinymce_settings["Theme"])  {
	           $this->data["theme"] = $tinymce_settings["Theme"];
	         } else {
	           $this->data["theme"] = "advanced";
	         }
         }

	         if ($tinymce_settings["Skin"])  {
	           $this->data["skin"] = $tinymce_settings["Skin"];
	         } else {
	           $this->data["skin"] = "default";
	         }



		$xmlWriter->WriteStartElement($this->xmlTag);
		  $this->WriteLanguageVersion($xmlWriter);
			 $this->XmlGetErrorFields($xmlWriter);
			$_keys = array_keys($this->data);
			for($i=0; $i<sizeof($_keys); $i++)
			   {
				  $xmlWriter->WriteStartElement($_keys[$i]);
					   $xmlWriter->WriteString($this->data[$_keys[$i]]);
				  $xmlWriter->WriteEndElement();
			   }

		 $xmlWriter->WriteEndElement();

   }



 } // class


?>