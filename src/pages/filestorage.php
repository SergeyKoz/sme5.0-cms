<?php
	$this->ImportClass("system.io.filestorage", "FileStorage");
    $this->ImportClass("module.web.backendpage", "BackendPage");
    $this->ImportClass("system.web.controls.directorypathcontrol", "DirectoryPathControl");
    $this->ImportClass("system.web.controls.directorieslistcontrol", "DirectoriesListControl");
    $this->ImportClass("system.web.controls.fileslistcontrol", "FilesListControl");
   /**
	* Class handles file storage  procedure
	* @version 1.0
	* @package	Framework
	* @access	public
	* @subpackage pages
	**/
	class FileStoragePage extends BackendPage {
		var $ClassName = "FileStoragePage";
		var $Version = "1.0";

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
		* Method handles CreateFolder event
		* @access	public
		*/
		function OnCreateFolder() {
			$newDir = $this->Request->ToString("new_folder", "", 1);
			if (FileStorage::IsValidDirectory($newDir)) {
				if (!$this->_fileStorage->CreateDirectory($newDir, false)) {
					$this->AddErrorMessage("FileStorage", "DIRECTORY_NOT_CREATED", array($newDir));
				}
			}
			else {
				$this->AddErrorMessage("FileStorage", "INVALID_DIRECTORY_NAME", array($newDir));
			}
		}
		/**
		* Method handles DeleteFolder event
		* @access	public
		*/
		function OnDeleteFolder() {
			$this->_fileStorage->DeleteDirectory();
		}
		/**
		* Method handles UploadFile event
		* @access	public
		*/
		function OnUploadFile() {
			$uploadedFile = $this->Request->Value("uploadedFile", REQUEST_FILES);
			if (!is_array($uploadedFile) || !is_uploaded_file($uploadedFile["tmp_name"]))
				return;

				//echo pr($uploadedFile);
				//die();

			$fileName = $uploadedFile["name"];
			move_uploaded_file($uploadedFile["tmp_name"], $this->_fileStorage->fullPath . $fileName);
		}
		/**
		* Method handles DeleteFiles event
		* @access	public
		*/
		function OnDeleteFiles() {
			$files = $this->_fileStorage->GetFiles();
			for ($i = 0; $i < count($files); $i++) {
				if ($this->Request->ToNumber("file_" . md5($files[$i]), 0, 0, 1) == 1) {
					$this->_fileStorage->DeleteFile($files[$i]);
				}
			}
		}
		/**
		* MEthod draws XML-content of a page.
		*  @param	XMLWriter    $xmlWriter		Writer object
		*  @access	public
		*/
		function XmlControlOnRender(&$xmlWriter) {
			$localPath = $this->_fileStorage->GetLocalPath("/");
			$xmlWriter->WriteElementString("current-path", $localPath);
		}

//end of clas
	}
?>