<?php

	$this->ImportClass("system.io.filestorage", "FileStorage");
	$this->ImportClass("module.web.backendpage", "BackendPage");
	/**
	* Class handles file upload procedure
	* @version 1.0
	* @package	Framework
	* @subpackage pages
	* @access	public
	**/
	class UploadDlgPage extends BackendPage {
		var $ClassName = "UploadDlgPage";
		var $Version = "1.0";

		var $PageType = "PopUp";

		var $_fileStorage;

		var $fileUploaded = false;
		/**
		* Method executes onpage load
		* @access	public
		*/
		function ControlOnLoad() {
			BackendPage::ControlOnLoad();
			@$this->_fileStorage = &new FileStorage($this->Kernel->Settings->GetItem("settings","FileStoragePath"),
				$this->Request->ToString("directory", "", 1));
		}
		/**
		* Method handles  UploadFile event
		* @access	public
		*/
		function OnUploadFile() {
			$uploadedFile = $this->Request->Value("uploadedFile", REQUEST_FILES);
			if (!is_array($uploadedFile) || !is_uploaded_file($uploadedFile["tmp_name"]))
				return;

				echo pr($uploadedFile);
				die();

			$fileName = $uploadedFile["name"];
			move_uploaded_file($uploadedFile["tmp_name"], $this->_fileStorage->fullPath . $fileName);
            @chmod($this->_fileStorage->fullPath . $fileName, "0744");
			$this->fileUploaded = true;
		}
		/**
		* MEthod draws XML-content of a page.
		*  @param	XMLWriter    $xmlWriter		Writer object
		*  @access	public
		*/
		function XmlControlOnRender(&$xmlWriter) {
            //echo "111";
			if ($this->fileUploaded)
			$xmlWriter->WriteElementString("auto-close", "");
			$localPath = $this->_fileStorage->GetLocalPath("/");
			$xmlWriter->WriteElementString("current-path", $localPath);
			$xmlWriter->WriteElementString("target-form",$this->Request->ToString("form", "", 1));
		    $xmlWriter->WriteElementString("target-element",$this->Request->ToString("element", "", 1));
		}
	}
?>