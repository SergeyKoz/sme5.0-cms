<?php

    $this->ImportClass("system.io.filestorage", "FileStorage");
    $this->ImportClass("module.web.backendpage", "BackendPage");
    $this->ImportClass("system.web.controls.directorypathcontrol", "DirectoryPathControl");
    $this->ImportClass("system.web.controls.directorieslistcontrol", "DirectoriesListControl");
    $this->ImportClass("system.web.controls.fileslistcontrol", "FilesListControl");



    /**
     * FileStorageDlgPage class .
     * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
     * @version 1.0
     * @package Libraries
     * @subpackage pages
     * @access public
     **/
	class FileStorageDlgPage extends BackendPage {
        var $ClassName = "FileStorageDlgPage";
        var $Version = "1.0";
        /**  Page type ID
        * @var      string      $PageType
        */
        var $PageType = "PopUp";
		/**  FileStorage object
		* @var      object      $_fileStorage
		*/
		var $_fileStorage;
		/**  IS dir should be private
		* @var      bool      $private_dir
		*/
		var $private_dir=false;
        /**
        * Method executes after control load. Loads child controls
        * @access       public
        */
        function CreateChildControls() {
			$this->AddControl(new DirectoryPathControl("path", "path"));
			$this->AddControl(new DirectoriesListControl("folders", "folders"));
			$this->AddControl(new FilesListControl("files", "files"));

        }
		/**
        * Method executes on control load to the parent
        * @access   public
        */
		function ControlOnLoad() {
            BackendPage::ControlOnLoad();
			$directory = $this->Request->ToString("directory", "", 1);
			$root = $this->Kernel->Settings->GetItem("settings","FileStoragePath");
			$full_path = $root.$directory;
			if(!file_exists($full_path)){
			   mkdir($full_path,octdec($this->Kernel->DirMode));
			   chmod($full_path,octdec($this->Kernel->DirMode));
			}

			$library_ID = $this->Session->Get("library_ID");
			$package = $this->Session->Get("parent_package");
			$private_dir = 0;

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
					if($listSettings->HasItem("FIELD_".$i, "IS_PRIVATE_DIRECTORY")){
					   $private_dir = $listSettings->GetItem("FIELD_".$i, "IS_PRIVATE_DIRECTORY");
					} else {
					   $private_dir = 0;
					}
                    if($listSettings->HasItem("FIELD_".$i, "IS_CREATE_DIR_DISABLED")){
                        $create_dir_disabled = $listSettings->GetItem("FIELD_".$i, "IS_CREATE_DIR_DISABLED");
                    } else {
                        if($this->Kernel->Settings->HasItem("SETTINGS", "IS_CREATE_DIR_DISABLED")){
                            $create_dir_disabled = $this->Kernel->Settings->GetItem("SETTINGS", "IS_CREATE_DIR_DISABLED");
                        } else {
                            $create_dir_disabled = 1;
                        }
                    }

				 }
			   }
			}
		   }
			if($private_dir){
				$this->private_dir = true;
				$this->true_local_path = $directory;
				$root = $full_path;
				$directory = "";
			}
			@$this->_fileStorage = new FileStorage($root, $directory);
            $this->create_dir_disabled = $create_dir_disabled;

		}

        /**
        * Function returns current path
        * @access public
        * @return string Current path
        **/
        function GetCurrentPath(){
            if(!$this->private_dir){
               $localPath = $this->_fileStorage->GetLocalPath("/");
            } else {
               $localPath = $this->true_local_path;
            }
            return $localPath;
        }

        /**
        * Method handles Create folder routines
        **/
        function OnCreate(){
           $message = "";
           $form = $this->Request->ToString("form", "");
           $element = $this->Request->ToString("element", "");
           $directory = $this->Request->ToString("directory", "");
           $tag_id = $this->Request->ToString("tag_id", "");

           if(!$this->create_dir_disabled){
               $folder = $this->Request->ToString("folder", "", 1);
               $localPath = $this->GetCurrentPath();
               $root = $this->Kernel->Settings->GetItem("settings","FileStoragePath");
               if(!file_exists($root.$localPath.$folder)){
                   @mkdir($root.$localPath.$folder,octdec($this->Kernel->DirMode));
                  $message="MESSAGE[]=DIR_CREATED";
               } else {
                 $message="MESSAGE[]=NAME_ALREADY_EXISTS";
               }
           } else {
              $message="MESSAGE[]=CREATE_DIRS_DISABLED";
           }
          $this->Response->Redirect("?page=filestoragedlg&isOpen=1&form=".$form."&element=".$element."&directory=".$directory."&tag_id=".$tag_id."&".$message);
        }

        /**
        * Method handles Delete file routines
        **/
        function OnDeleteFile(){
           $message = "";
           $form = $this->Request->ToString("form", "");
           $element = $this->Request->ToString("element", "");
           $directory = $this->Request->ToString("directory", "");
           $tag_id = $this->Request->ToString("tag_id", "");
           $file = $this->Request->ToString("fileList", "");

               $root = $this->Kernel->Settings->GetItem("settings","FileStoragePath");
               $filepath = $root.$file;
               if(file_exists($filepath)){
                  if(is_writable($filepath)){
                     @unlink($filepath);
                     $message="MESSAGE[]=FILE_DELETED";
                  } else {
                     $message="MESSAGE[]=FILE_DELETE_ACCESS_DENIED";
                  }
               } else {
                 $message="MESSAGE[]=FILE_NOT_FOUND";
               }
          $this->Response->Redirect("?page=filestoragedlg&isOpen=1&form=".$form."&element=".$element."&directory=".$directory."&tag_id=".$tag_id."&".$message);
        }


		/**
        *  Method draws xml-content of control
		*  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
		*  @access  public
		*/
		function XmlControlOnRender(&$xmlWriter) {
            $tag_id = $this->Request->ToNumber("tag_id", 0);
            $xmlWriter->WriteElementString("tag-id", $tag_id);
            $xmlWriter->WriteElementString("create-dir-disabled", $this->create_dir_disabled);

            $localPath = $this->GetCurrentPath();

			//$localPath = $this->_fileStorage->GetLocalPath("/");
			if($this->private_dir){
			   $xmlWriter->WriteElementString("private-directory", "yes");
			} else {
			   $xmlWriter->WriteElementString("private-directory", "no");
			}
			$xmlWriter->WriteElementString("current-path", $localPath);
			$xmlWriter->WriteElementString("target-form",$this->Request->ToString("form", "", 1));
			$xmlWriter->WriteElementString("target-element",$this->Request->ToString("element", "", 1));
        }
    }
?>