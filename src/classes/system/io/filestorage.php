<?php

	define("DIRECTORY_SEPARATOR_CHAR", "/");
	define("ALT_DIRECTORY_SEPARATOR_CHAR", "\\");
	define("PATH_SEPARATOR", ";");
	define("VOLUME_SEPARATOR", ":");
	define("INVALID_PATH_CHARS", "");

	/**
	  * File storage handling class
	  * @author		Sergey Grishko		<sgrishko@reaktivate.com>
	  * @modified	Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	  * @package	 Framework
	  * @subpackage classes.system.io
	  * @access		public
	  */
	class FileStorage {
		/**
		* Filestorage root path
	  *@var	string	$Root
	  */
		var $Root = "/";
		/**
		*Local path
	  *@var	string	$LocalPath
	  */
		var $LocalPath = "";
		/**
		*Full path
	  *@var	string	$fullPath
	  */
		var $fullPath;
		/**
		  * Constructor of class
		  * @param	string	$rootPath		Root path
		  * @param	string	$localPath		Local path
		  * @access	public
		 */
		function FileStorage($rootPath, $localPath) {
			$this->Root = str_replace(ALT_DIRECTORY_SEPARATOR_CHAR, DIRECTORY_SEPARATOR_CHAR, $rootPath);
			if (strlen($this->Root) && $this->Root[strlen($this->Root) - 1] != DIRECTORY_SEPARATOR_CHAR)
				$this->Root .= DIRECTORY_SEPARATOR_CHAR;
			$this->fullPath = $this->Root;
			if (!is_dir($this->Root))
				return;
			$temp = str_replace(ALT_DIRECTORY_SEPARATOR_CHAR, DIRECTORY_SEPARATOR_CHAR, $localPath);

			$parts = preg_split("~".DIRECTORY_SEPARATOR_CHAR."~", $temp);
			$temp = "";
			$currentPath = $this->fullPath;
			for ($i = 0; $i < count($parts); $i++) {
				$currentPath .= $parts[$i] . DIRECTORY_SEPARATOR_CHAR;
				if (!$this->IsValidDirectory($parts[$i]) || !is_dir($currentPath)) {

					break;
				}
				$temp .= $parts[$i] . DIRECTORY_SEPARATOR_CHAR;
			}
			$this->LocalPath = $temp;
			$this->fullPath = $this->fullPath . $temp;
		}

		/**
		  * Method return local path
		  * @param	string		path separator
		  * @return	string		local path
		  * @access	public
		 */
		function GetLocalPath($separator = null) {
			if (!is_null(strlen($separator)))
				return str_replace(DIRECTORY_SEPARATOR_CHAR, $separator, $this->LocalPath);
			else
				return $this->LocalPath;
		}

		/**
		  *Method check directory name
		  * @param	string	directory name
		  * @return	boolean	if directory name valid - true, otherwise  - false
		  * @access public
		  */
		function IsValidDirectory($dirName) {
			if (is_null($dirName) || !strlen($dirName)) return false;
			if (is_integer(strpos($dirName, ALT_DIRECTORY_SEPARATOR_CHAR)))
				return false;
			if (is_integer(strpos($dirName, DIRECTORY_SEPARATOR_CHAR)))
				return false;
			if (is_integer(strpos($dirName, PATH_SEPARATOR)))
				return false;
			if (is_integer(strpos($dirName, VOLUME_SEPARATOR)))
				return false;
			if (!strlen(str_replace(".", "", $dirName)))
				return false;
			if (strlen(INVALID_PATH_CHARS)) {
				if (count(split(INVALID_PATH_CHARS, $dirName)) > 1)
					return false;
			}
			return true;
		}

		/**
		  * Method get directory contents
		  * @param	string	full directory path
		  * @return	array	array with  directories names
		  * @access public
		 */
		function &getDirsInternal($path) {
			$result = array();
			if (!is_dir($path))
				return $result;
			$list = dir($path);
			while (false !== ($entry = $list->read())) {
				if (is_dir($path . $entry) && $entry != "." && $entry != "..")
					$result[] = $entry;
			}
			$list->close();
			return $result;
		}

		/**
		  *Method get directories from current directory
		  *@return	array	directories array
		  *@access public
		  */
		function &GetDirectories() {
				return FileStorage::getDirsInternal($this->fullPath);
		}

		/**
		  *Method get filenames from directory
		  * @param	string	full path to directory
		  * @return array	filenames array
		  * @access public
		  */
		function &getFilesInternal($path) {
			$result = array();
			if (!is_dir($path))
				return $result;
			$list = dir($path);
			while (false !== ($entry = $list->read())) {
				if (is_file($path . $entry))
					$result[] = $entry;
			}
			$list->close();
			arsort($result);
			return $result;
		}

		/**
		  * Method get filenames from current directory
		  * @return 	array 	filenames array
		  * @access public
		  */
		function &GetFiles() {
				return FileStorage::getFilesInternal($this->fullPath);
		}


		/**
		  *Method create directory in filesystem
		  * @param	string		directory name
		  * @param	boolean		if true - than overwrite directory, otherwise-not.
		  * @return	boolean		succefully creating flag
		  * @access public
		  */
		function CreateDirectory($directory, $autoChange = false) {
			if (!$this->IsValidDirectory($directory))
				return false;
			$dir = $this->fullPath . $directory;
			$result = false;
			if (!is_dir($dir)) {
				mkdir($dir);
			}
			$result = is_dir($dir);
			if ($result && $autoChange) {
				$this->LocalPath .= $directory . DIRECTORY_SEPARATOR_CHAR;
				$this->fullPath .= $directory . DIRECTORY_SEPARATOR_CHAR;
			}
			return $result;
		}

		/**
		  *Method  delete directories recursive
		  * @param	string	directory full path
		  * @access public
		  */
		function deleteDirRecursive($path) {
			if (!is_dir($path))
				return;
			$list = dir($path);
			while (false !== ($entry = $list->read())) {
				$item = $path . $entry;
				if (is_file($item))
					unlink($item);
				else if ($entry != "." && $entry != ".." && is_dir($item)) {
					$this->deleteDirRecursive($item . DIRECTORY_SEPARATOR_CHAR);
				}
			}
			$list->close();
			rmdir($path);
		}

		/**
		  *Method delete current dorectory
		  *@access public
		  *
		  */
		function DeleteDirectory() {
			if (!strlen($this->LocalPath))
				return;
			$temp = substr($this->LocalPath, 0, strlen($this->LocalPath) - 1);
			if (strpos($temp, DIRECTORY_SEPARATOR_CHAR) === false)
				$this->LocalPath = "";
			else
				$this->LocalPath = strpos($temp, 0, strrpos($temp, DIRECTORY_SEPARATOR_CHAR) + 1);
			$temp = $this->fullPath;
			$this->fullPath = $this->Root . $this->LocalPath;
			$this->deleteDirRecursive($temp);
			clearstatcache();
		}

		/**
		  *Method delete file
		  * @param	string	filename
		  * @return	boolean	succefully deleted flag
		  * @access	public
		  */
		function DeleteFile($file) {
			$result = false;
			$filePath = $this->fullPath . $file;
			if (is_file($filePath))
				unlink($filePath);
			$result = !is_file($filePath);
			if ($result)
				clearstatcache();
			return $result;
		}
	//end of class
	}
?>