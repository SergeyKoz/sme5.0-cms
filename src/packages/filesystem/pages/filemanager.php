<?php

	$this->ImportClass("module.web.modulepage", "ModulePage");
	/**
	 * File manager redirect page class.
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package	FileSystem
	 * @subpackage pages
	 * @access public
	 **/
	class FileManagerPage extends ModulePage {
		// Class name
		var $ClassName = "FileManagerPage";
		// Class version
		var $Version = "1.0";

		var $XslTemplate = "filemanager";

		var $PageMode = "Backend";

		/**
		  * Invision File Manager script root url
		  * @var  string      $ScriptURL
		  **/
		var $ScriptURL = "";

		/**
		  * Invision File Manager script root ητεπ
		  * @var  string      $ScriptPath
		  **/
		var $ScriptPath = "";

	    /**
		  * XSL-template mode
		  * @var  string      $Mode
		  **/
		var $Mode = "default";

		function ControlOnLoad() {
		    $this->ScriptPath = $this->Kernel->Package->Settings->GetItem("PACKAGE","FileManagerPath");
		    $this->ScriptURL =  $this->Kernel->Package->Settings->GetItem("PACKAGE","FileManagerURL");
		}

		function OnReInstall()    {
		      $this->Mode = "install";
		      if ($this->Auth->isSuperUser()) {
		         if (file_exists($this->ScriptPath."install.lock"))   { //remove install.lock
		             if (!@unlink($this->ScriptPath."install.lock"))  {
		                 $this->AddErrorMessage("FILEMANAGER","CANT_DELETE_FILE",array($this->ScriptPath."install.lock"));
		                 $error = true;
		             }
		         }
		         if (file_exists($this->ScriptPath."users.cgi"))   {  //remove users.cgi
		             if (!@unlink($this->ScriptPath."settings/users.cgi"))  {
		                 $this->AddErrorMessage("FILEMANAGER","CANT_DELETE_FILE",array($this->ScriptPath."settings/users.cgi"));
		                 $error = true;
		             }
		             $fp = fopen ($this->ScriptPath."settings/users.cgi","w");//create users cgi
		             if (!$fp)    {
		                 $this->AddErrorMessage("FILEMANAGER","CANT_CREATE_FILE",array($this->ScriptPath."settings/users.cgi"));
		                 $error = true;
		             }    else    {
		                 close($fp);
		                 chmod ($this->ScriptPath."settings/users.cgi","0777");
		             }
		         }

		     }
		     if (!$error) $this->OnInstall();
		}

		function OnManage()   {
            $this->Response->Redirect($this->ScriptURL,true);
		}

		function OnInstall()   {
		      $this->Mode = "install";
		      if ($this->Auth->isSuperUser()) {
		        if (!file_exists($this->ScriptPath."install.lock"))   {  //if installation not exists
                    $this->Response->Redirect($this->ScriptURL."install.php",true);
		        }
		      }
		}

		function OnAdministrate()   {
		     $this->Mode = "administrate";
		}


    function XmlControlOnRender(&$xmlWriter)    {
        parent::XmlControlOnRender(&$xmlWriter);
        $xmlWriter->WriteElementString("mode",$this->Mode);
        $xmlWriter->WriteElementString("script_url",$this->ScriptURL);
    }
}
?>
