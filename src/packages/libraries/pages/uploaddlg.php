<?php
$this->ImportClass("system.io.filestorage", "FileStorage");
$this->ImportClass("module.web.backendpage", "BackendPage");
$this->ImportClass("system.io.thumbnailcreator", "ThumbnailCreator");

/**
         * UploadDlgPage class .
         * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
         * @version 1.0
         * @package        Libraries
         * @subpackage pages
         * @access public
         **/
class UploadDlgPage extends BackendPage {
	var $ClassName = "UploadDlgPage";
	var $Version = "1.0";
	/**  Page type ID
                * @var                string      $PageType
                */
	var $PageType = "PopUp";
	/**  FileStorage object
                * @var                object      $_fileStorage
                */
	var $_fileStorage;
	/**  File uploaded flag
                * @var                bool      $fileUploaded
                */
	var $fileUploaded = false;

	/**
                * Method executes on control load to the parent
                * @access        public
                */
	function ControlOnLoad() {
		BackendPage::ControlOnLoad();
		@$this->_fileStorage = new FileStorage($this->Kernel->Settings->GetItem("settings","FileStoragePath"),
		$this->Request->ToString("directory", "", 1));
	}
	/**
                * Method handles UploadFile event
                * @access        public
                */
	function OnUploadFile() {
		$uploadedFile = $this->Request->Value("uploadedFile", REQUEST_FILES);

		$library_ID = $this->Session->Get("library_ID");
		$package = $this->Session->Get("parent_package");
		$max_size = $this->Kernel->Settings->GetItem("SETTINGS", "MaxFileSize");

		if($library_ID!="" && $package!=""){
			$settings = $this->Page->Kernel->getPackageSettings($package);
			$_library_path=$settings->GetItem("main","LibrariesRoot");
			@$listSettings = &ConfigFile::GetInstance("ListSettings",$_library_path.$library_ID.".ini".".php",$this->Kernel->CacheRoot);
			$listSettings->reParse();
			$fields_count = $listSettings->GetItem("LIST", "FIELDS_COUNT");
			$element = $this->Request->ToString("element", "", 1);
			for($i=0; $i<$fields_count; $i++){
				if($listSettings->HasItem("FIELD_".$i, "FIELD_NAME")){
					$field_name = $listSettings->GetItem("FIELD_".$i, "FIELD_NAME");
					if($element == $field_name){
						if($listSettings->HasItem("FIELD_".$i, "MAX_SIZE")){
							$max_size = $listSettings->GetItem("FIELD_".$i, "MAX_SIZE");
						}
					}
				}
			}
		}
		if (!is_array($uploadedFile) || !is_uploaded_file($uploadedFile["tmp_name"]))
		return;

		if ($this->Kernel->Settings->HasItem("settings","AllowedExtensions")){
			$allowed_extensions =  $this->Kernel->Settings->GetItem("settings","AllowedExtensions");
			$extensions = explode(',',$allowed_extensions);
			$file_ext=strtolower(substr(strrchr($uploadedFile['name'], "."), 1) );
			if(!in_array($file_ext,$extensions)) {
				$this->AddErrorMessage("MESSAGES","FORBIDDEN_TYPE", $file_ext[1]);
				return;
				die();
			}
		}

		$fileName = $uploadedFile["name"];
		if($uploadedFile["size"] > $max_size){
			$this->AddErrorMessage("MESSAGES","FILE_TOO_BIG", array($max_size));
			$this->fileUploaded = false;
		} else {
			$orig_mask = umask(0);
			@chmod($uploadedFile['tmp_name'], 0660);
            if (is_uploaded_file($uploadedFile['tmp_name']) && is_readable($uploadedFile['tmp_name'])){
				move_uploaded_file($uploadedFile["tmp_name"], $this->_fileStorage->fullPath . $fileName);
				@chmod($this->_fileStorage->fullPath . $fileName, octdec($this->Kernel->FileMode));

				//create Thumbnail if set CreateThumbnails
				if ($this->Kernel->Settings->HasItem("MAIN", "CreateThumbnails"))
					if ($this->Kernel->Settings->GetItem("MAIN", "CreateThumbnails")){
						$ThumbHeight=$this->Kernel->Settings->GetItem("MAIN", "ThumbnailHeight");
						$ThumbWidth=$this->Kernel->Settings->GetItem("MAIN", "ThumbnailWidth");
						if ($ThumbHeight!="" && $ThumbWidth!=""){
							$settings=array("width" => $ThumbWidth,
							"height" => $ThumbHeight,
							"filesfolder" => "files",
							"thumbfolder" => "thumbs",
							"self" => &$this);
							ThumbnailCreator::ThumbnailCreate($this->_fileStorage->fullPath.$fileName, $settings);
						}
					}
				$this->fileUploaded = true;
			}else {
				$this->fileUploaded = false;
			}
		}
	}
	/**
                *  Method draws xml-content of control
                *  @param   XMLWriter         $xmlWriter   Instance of XMLWriter
                *  @access        public
                */
	function XmlControlOnRender(&$xmlWriter) {
		$tag_id = $this->Request->ToNumber("tag_id", 0);
		$xmlWriter->WriteElementString("tag-id", $tag_id);
		if ($this->fileUploaded)
		$xmlWriter->WriteElementString("auto-close", "");
		$localPath = $this->_fileStorage->GetLocalPath("/");
		$xmlWriter->WriteElementString("current-path", $localPath);
		$xmlWriter->WriteElementString("target-form",$this->Request->ToString("form", "", 1));
		$xmlWriter->WriteElementString("target-element",$this->Request->ToString("element", "", 1));
	}
}
?>