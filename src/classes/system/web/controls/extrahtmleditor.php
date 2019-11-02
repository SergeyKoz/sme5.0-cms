<?php

  $this->ImportClass("system.web.controls.textarea","textareacontrol");

/** ExtraHtmlEditorControl control
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @version 1.0
   * @package  Framework
   * @subpackage classes.system.web.controls
   * @access public
   */
  class ExtraHtmlEditorControl extends TextAreaControl {
    var $ClassName = "ExtraHtmlEditorControl";
    var $Version = "1.0";
    var	$xmlTag="extrahtmleditor";

    function InitControl($data=array())	{
			parent::InitControl($data);
      $Settings=$this->Page->Kernel->Settings;
      //get editor URL and Path
			if (!$Settings->HasItem("MAIN","ExtraEdit_Path"))	{
      	$this->Page->AddErrorMessage("MAIN","EXTRAEDIT_PATH_NOTDEFINED");
      }	else	{
      	$this->data["path"]=$Settings->GetItem("MAIN","ExtraEdit_Path");
      }
      if (!$Settings->HasItem("MAIN","ExtraEdit_URL"))  {
        $this->Page->AddErrorMessage("MAIN","EXTRAEDIT_URL_NOTDEFINED");
      }  else  {
        $this->data["url"]=$Settings->GetItem("MAIN","ExtraEdit_URL");
      }
      //generate editor content
      if ($this->data["url"] && $this->data["path"])	{
      	include_once($this->data["path"]."/class.devedit.php");
        //open  buffer
        ob_start("handler_output");
        SetDevEditPath($this->data["path"],$this->data["url"]);
        $myDE1 = new DevEdit;
        $myDE1->SetName($this->data["name"]);
        if (strlen($this->data["content"])!=0)	{
            $myDE1->SetValue($myDE1->GetValue(false,$this->data["content"]));
        }
        $myDE1->EnableGuidelines();
        $myDE1->ShowControl("100%", "100%", $Settings->GetItem("settings","FileStoragePath"),$Settings->GetItem("settings","FileStorageURL"));
        $this->data["editor_content"]=ob_get_contents();
			  ob_clean();
        ob_end_flush();
      }
    }
   }// class
?>