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
	class FileDlgPage extends BackendPage {
        var $ClassName = "FileDlgPage";
        var $Version = "1.0";
        var $PageType = "PopUp";
        var $thumbs_folder = ".thumbs";
        var $files_list = array();
        var $folders_list = array();
        var $rel_path = '';
        var $storage_root = '';
        var $dialog_id = '';


		function ControlOnLoad() {
            parent::ControlOnLoad();
			$this->storage_root = $this->Kernel->Settings->GetItem("settings","FileStoragePath");
			$this->dialog_id = trim($this->Request->ToString("id", "", 32));

			$this->dialog_id = '123';
            if (!isset($_SESSION['FILE_DIALOGS'][$this->dialog_id]))
            {
                $_SESSION['FILE_DIALOGS'][$this->dialog_id] = array();
                $this->dialog_id = md5(uniqid(rand(), true));
    			$this->dialog_id = '123';
            }
            $_SESSION['FILE_DIALOGS'][$this->dialog_id]['last_accessed'] = time();

            $folder_id = $this->Request->ToNumber("f", -1);
			$this->rel_path = $_SESSION['FILE_DIALOGS'][$this->dialog_id]['files'][$folder_id];
			// теряется путь с вложенностью > 1
//            prn($_SESSION['FILE_DIALOGS'][$this->dialog_id]);

            return;

			$directory = $this->Request->ToString("directory", "", 1);
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

		}

		function OnFilesList()
		{

            $this->XslTemplate = "filedlg_fileslist";
            if ($this->storage_root == '')
            {
                return ;
            }

            $abs_path = $this->storage_root . $this->rel_path;
			clearstatcache();
            $dh = opendir($abs_path);
            $list = array();
            while ($item = readdir($dh))
            {
                $list[] = $item;
            }

            setlocale(LC_ALL, 'CP1251');
            sort($list);
            $id = 1;
            $_SESSION['FILE_DIALOGS'][$this->dialog_id]['files'] = array();
            foreach ($list as $item)
            {
                if (($item != '.') && ($item != '..') &&
                    !(($this->rel_path == '') && ($item == $this->thumbs_folder)))
                {
                    if (is_dir($abs_path . $item))
                    {
                    	$this->folders_list[] = array(
                    	   'name' => $item,
                    	   'id' => $id,
                    	   'date' => date ("d.m.Y H:i:s", filemtime($abs_path . $item))
                        );
                        $_SESSION['FILE_DIALOGS'][$this->dialog_id]['files'][$id] = "$item/";
                        $id++;
                    } else {
                        $data = stat($abs_path . $item);
                        if ($data['size'] > 1048576) // mb
                        {
                            $file_size = number_format($data['size']/1048576, 2, ',', 3) . " Mb";
                        } else
                        if ($data['size'] > 1024) // kb
                        {
                            $file_size = number_format($data['size']/1024, 2, ',', 3) . " Kb";
                        } else {
                            $file_size = number_format($data['size'], 0, ',', 3) . " B";
                        }
                        $tmp = pathinfo($item);
                    	$this->files_list[] = array(
                    	   'name' => $item,
                    	   'date' => date ("d.m.Y H:i:s", $data['mtime']),
                    	   'size' => $file_size,
                    	   'ext' => strtolower($tmp['extension'])
                        );
                    }
                }
            }
            closedir($dh);
		}


		function XmlControlOnRender(&$xmlWriter)
		{
            $xmlWriter->WriteStartElement("file_dialog");
                $xmlWriter->WriteElementString("id", $this->dialog_id);
                $xmlWriter->WriteStartElement("path");
                foreach (explode('/', $this->rel_path) as $item)
                {
                    $xmlWriter->WriteElementString("item", $item);
                }
                $xmlWriter->WriteEndElement();

                $xmlWriter->WriteStartElement("folders");
                foreach ($this->folders_list as $item)
                {
                    $xmlWriter->WriteStartElement("item");
                    $xmlWriter->WriteElementString("id", $item['id']);
                    $xmlWriter->WriteElementString("name", $item['name']);
                    $xmlWriter->WriteElementString("date", $item['date']);
                    $xmlWriter->WriteEndElement();
                }
                $xmlWriter->WriteEndElement();

                $xmlWriter->WriteStartElement("files");
                foreach ($this->files_list as $item)
                {
                    $xmlWriter->WriteStartElement("item");
                    $xmlWriter->WriteElementString("name", $item['name']);
                    $xmlWriter->WriteElementString("date", $item['date']);
                    $xmlWriter->WriteElementString("size", $item['size']);
                    $xmlWriter->WriteElementString("ext", $item['ext']);
                    $xmlWriter->WriteEndElement();
                }
                $xmlWriter->WriteEndElement();
            $xmlWriter->WriteEndElement();
        }

        function RegisterNewDialogData()
        {

        }

        function UpdateDialogData()
        {

        }

        function CleanupDialogsData()
        {

        }
    }
?>