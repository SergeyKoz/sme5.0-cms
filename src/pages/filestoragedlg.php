<?php
    $this->ImportClass("system.io.filestorage", "FileStorage");
    $this->ImportClass("module.web.backendpage", "BackendPage");
    $this->ImportClass("system.web.controls.directorypathcontrol", "DirectoryPathControl");
    $this->ImportClass("system.web.controls.directorieslistcontrol", "DirectoriesListControl");
    $this->ImportClass("system.web.controls.fileslistcontrol", "FilesListControl");



	/**
	* Class handles file storage dialog procedure
	* @version 1.0
	* @package	Framework
	* @access	public
	* @subpackage pages
	**/
    class FileStorageDlgPage extends BackendPage {
        var $ClassName = "FileStorageDlgPage";
        var $Version = "1.0";

        var $PageType = "PopUp";

        var $_fileStorage;
		/**
		* Method creates child controls
		* @access	public
		*/
        function CreateChildControls() {
            $this->AddControl(new DirectoryPathControl("path", "path"));
            $this->AddControl(new DirectoriesListControl("folders", "folders"));
            $this->AddControl(new FilesListControl("files", "files"));

        }
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
		* MEthod draws XML-content of a page.
		*  @param	XMLWriter    $xmlWriter		Writer object
		*  @access	public
		*/
        function XmlControlOnRender(&$xmlWriter) {
            $localPath = $this->_fileStorage->GetLocalPath("/");
            $xmlWriter->WriteElementString("current-path", $localPath);
            $xmlWriter->WriteElementString("target-form",$this->Request->ToString("form", "", 1));
            $xmlWriter->WriteElementString("target-element",$this->Request->ToString("element", "", 1));
        }
    }
?>