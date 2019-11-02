<?php

  $this->ImportClass("system.web.controls.textarea","textareacontrol");

/** FCKEditor WYSIWYG  control
   * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
   * @version 1.0
   * @package  Framework
   * @subpackage classes.system.web.controls
   * @access public
   */
  class FCKEditorControl extends TextAreaControl {
    var $ClassName = "FCKEditorControl";
    var $Version = "1.0";
    var $xmlTag="fckeditor";
        /**
          * Initialization data array
          * structure:
          *           <ul>
          *           <li> <b>name</b>           - control name
          *           <li> <b>content</b>        - field content
          *           <li> <b>maxlength</b>      - field max length
          *           <li> <b>caption</b>        - field caption
          *           <li> <b>directory</b>      - relative path to current directory
          *           </ul>
          * @var    array   $data
          **/
          var $data = array();

    function InitControl($data=array()) {
      parent::InitControl($data);

      //set session variables
      $this->AddSettingsToSession(array("FileStoragePath" => $this->Page->Kernel->Settings->GetItem("Settings","FileStoragePath")),
                                  $this->data["name"]);

      //generate editor content
      $this->data["editor_content"] = "";

      // start buffering
       ob_start();
       ob_clean();
      //--create control
       $editor_path = $this->Page->Kernel->Settings->GetItem("FCKEditor","EditorPath");
       $base_path =  $this->Page->Kernel->Settings->GetItem("FCKEditor","BasePath");

       $file_path = $this->Page->Kernel->Settings->GetItem("FCKEditor","FilePath").$this->data["directory"];
       include_once($editor_path."fckeditor.php") ;
       $oFCKeditor = new FCKeditor($this->data["name"]) ;
       $oFCKeditor->BasePath	= $base_path ;
       $oFCKeditor->Value = $this->data["content"];
       $oFCKeditor->Width = $this->Page->Kernel->Settings->GetItem("FCKEditor","Width");
       $oFCKeditor->Height = $this->Page->Kernel->Settings->GetItem("FCKEditor","Height");
       $oFCKeditor->Config["ImageBrowserURL"] = $base_path."editor/filemanager/browser/default/browser.php?Type=Image&Connector=connectors/php/connector.php&ServerPath=".$file_path."&editor=".$this->data["name"]."&PHPSESSID=".$this->Page->Session->SessionID();
       $oFCKeditor->Config["LinkBrowserURL"] = $base_path."editor/filemanager/browser/default/browser.php?Connector=connectors/php/connector.php&ServerPath=".$file_path."&editor=".$this->data["name"]."&PHPSESSID=".$this->Page->Session->SessionID();
       $oFCKeditor->Config["StylesXmlPath"]	= $this->Page->Kernel->Settings->GetItem("FCKEditor","StylesXmlPath");
       $oFCKeditor->Config["StylesXmlPath"]	= $this->Page->Kernel->Settings->GetItem("FCKEditor","StylesXmlPath");
       $oFCKeditor->Config["EditorAreaCSS"]	= $this->Page->Kernel->Settings->GetItem("FCKEditor","EditorAreaCSS");
       $oFCKeditor->Create() ;
       $this->data["editor_content"]=ob_get_contents();
       // end buffering
       ob_end_clean();
    }




  /**
    * Method add spaw settings to session
    * @param  array       $config_array   configuration array
    * @param  array       $name          spaw name
    **/
    function AddSettingsToSession($config_array,$name) {
            if (count($config_array))   {
                    $this->Page->Session->Set("FCKEDITOR_".$name, $config_array);
            }
    }


  /**
    *  Method Draws XML-content of a control
    *  @param XMLWriter    $xmlWriter  instance of XMLWriter
    *  @access private
    **/
        function XmlControlOnRender(&$xmlWriter) {

         $xmlWriter->WriteStartElement($this->xmlTag);
         $this->WriteLanguageVersion($xmlWriter);
         $this->XmlGetErrorFields($xmlWriter);
         $_keys = array_keys($this->data);
            for($i=0; $i<sizeof($_keys); $i++)
               {

                $xmlWriter->WriteStartElement($_keys[$i]);
                   if($_keys[$i] == "editor_content" || $_keys[$i] == "content"){
                          $xmlWriter->WriteCData($this->data[$_keys[$i]]);

                 } else {
                          $xmlWriter->WriteString($this->data[$_keys[$i]]);
                 }
               $xmlWriter->WriteEndElement();

               }
         $xmlWriter->WriteEndElement();
   }



 } // class


?>