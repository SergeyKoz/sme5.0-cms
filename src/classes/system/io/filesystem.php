<?php
define ("MIME_TYPE_APPLICATION","application/octet-stream");
define ("MIME_TYPE_CSV","application/csv");
/**
  * FileSystem class
  * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
  * @version 1.0
  * @package Framework
  * @subpackage classes.system.io
  * @access public
  **/
 class FileSystem {
     /**
       * File system root path
       * @var   string  $rootPath
       **/
     var $rootPath = "";

    /**
      * Class constructor
      * @param  string $root File system root path
      * @access public
      **/
    function FileSystem($root)   {
     $this->rootPath = $root;
    }

    /**
      * Method return file content as application/ocet-stream to output (used for download file)
      * @param   string $file   relative or absolute path to file
      * @param   string $output name of output file
      * @param   string $path   path to file (if empty used rootPath, but if method called as static must be defined)
      * @param   string $mime_type  mime type of output file
      * @access  public
      * @static
      **/
    function outputFile($file,
                        $output = "file.bin",
                        $path = null,
                        $mime_type = MIME_TYPE_APPLICATION)    {

        if ($path == null)  $path = $this->rootPath;
        $filepath = $path."/".$file;
        $fp = @fopen($filepath,"r");
        if (!$fp)   {
            user_error("FileSystem::outputFile() -  file $filepath not found in system",E_USER_ERROR);
            return false;
        }    else   {
            $content = fread($fp,filesize($filepath));
            FileSystem::outputContent($content,$output,$mime_type);
        }
    }
    /**
      * Method return content as application/ocet-stream to output (used for download file)
      * @param   string $content   output content
      * @param   string $output name of output file
      * @param   string $mime_type  mime type of output file
      * @access  public
      * @static
      **/
    function outputContent($content,
                           $output = "file.bin",
                           $mime_type = MIME_TYPE_APPLICATION)   {

        header('Content-Type: ' . $mime_type);
        header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        // lem9 & loic1: IE need specific headers
        if (PMA_USR_BROWSER_AGENT == 'IE') {
            header('Content-Disposition: inline; filename="' . $output . '"');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        } else {
            header('Pragma: no-cache');
        }
        print ($content);
    }

    /**
      * Method make directories tree using relative path like dir1/dir2/dir3
      * @param  string  $path       Absolute path to first level directory
      * @param  string  $directory  Relaitve path, used for making
      * @param  string  $mode       Filesystem mode for all nodes of tree (all directories)
      * @param  boolean $rollback   Remove all maked dirs if one of it not maked (flag)
      * @param  boolean $silent     Silent mode (error reporting = 0)
      * @return boolean             Make directories status
      **/
    static function makeDir($path,$directory,$mode = 0777,$rollback = false, $silent = true)    {

        $error_mode = error_reporting();
        if ($silent) error_reporting(0);
        $directories = explode("/",$directory);
        $rollback_arr = array();
        $dirpath = $path;
        foreach ($directories as $i => $dir)  {
            $dirpath .= "/".$dir;
            $dirpath = preg_replace("/\/+/", "/", $dirpath);
            if (file_exists($dirpath))   {  //--if directory already exists
                if (is_dir($dirpath))   {

                  // @chmod($dirpath,octdec($mode));
                }   else {
                   FileSystem::removeDirectories($rollback_arr);
                   error_reporting($error_mode);
                   return false;
                }
            } else  {  //--if directory not exists

                if (@mkdir($dirpath,octdec($mode)))  { //--if directory created
                    @chmod ($dirpath,octdec($mode));
                    $rollback_arr[] = $dirpath;
                }   else    {
                   FileSystem::removeDirectories($rollback_arr);
                   error_reporting($error_mode);
                   return false;
                }
            }
        }
        error_reporting($error_mode);
        return true;
    }

    /**
      *  Method save content to file
      *  @param     string  $filepath       Full file path
      *  @param     string  $content        File content
      *  @param     string  $mode           File open mode (default  - w)
      *  @param     string  $permissions    File permissions (not set if variable not defined)
      *  @param     boolean $silent         Silent mode (error reporting = 0)
      *  @return    boolean                 Content save status
      *  @access    public
      **/
    function SaveFile($filepath,$content,$mode = w,$permissions = 0777,$silent = true)     {
         $error_mode = error_reporting();
         if ($silent) error_reporting(0);
         $fp = @fopen($filepath,$mode);
         if (!$fp) {
             error_reporting($error_mode);
             return false;
         }  else {
             @fwrite($fp,$content,strlen($content));
             fclose($fp);
             @chmod ($filepath,octdec($permissions));
             error_reporting($error_mode);
             return true;
         }
    }

    /**
      * Method remove directories using directories array
      * @param      array   $dirs           full pathes directories array
      * @param      boolean $silent         Silent mode (error reporting = 0)
      * @access public
      **/
    static function removeDirectories($dirs,$silent  = true)    {
        $error_mode = error_reporting();
        if ($silent) error_reporting(0);
        if (count($dirs))   {
           for ($i = 0; $i<count($dirs);$i++)   @unlink ($dirs[$i]);
        }
        error_reporting($error_mode);
    }

    /**
      * Method remove directories from path to base_path if is empty
      * @param  array   $basepath   relative path to  dir
      * @param  array   $basepath   path to base dir
      * @param  boolean $silent     Silent mode (error reporting = 0)
      * @access public
      **/
    static function recursiveRemoveDirs($path,$basepath,$silent = true){
        $error_mode = error_reporting();

        if ($silent) {
            error_reporting(0);
        }
        $path_arr = explode("/",$path);
        $fullpath = $basepath.$path;
        krsort($path_arr);
        foreach($path_arr as $i => $dir)    {
            if (strlen($dir))   {
                $cpath = substr($fullpath,0,strpos($fullpath,$dir)+strlen($dir));
                $is_deletable = true;
                if (is_dir($cpath))  {
                    $d = dir($cpath);
                    while (false !== ($entry = $d->read())) {
                        if(($entry != ".") && ($entry != "..")){
                            $is_deletable = false;
                        }
                    }
                  if ($is_deletable) @rmdir ($cpath);
                }
            }
        }
      error_reporting($error_mode);
    }

   /**
    * Method gets list of all directories below specified
    * @param    string   $path    PAth to get all dirs from
    * @param    array   $list   Array with dirs path
    * @access   public
    **/
    static function GetRecursiveDirsList($data, $recursive_path, &$list){
         $parent = $data["path"];
         if(is_dir($data["path"])){
             $d = dir($data["path"]);
             while (false !== ($entry = $d->read())) {
              if(($entry != ".") && ($entry != "..")){
                    $path =  $d->path."/".$entry;
                    if(is_dir($path)){
                        if($data["dirs_filter"] != ''){
                            $dir_passed = 0;
                            if(preg_match($data["dirs_filter"], $entry)){
                               $dir_passed = 1;
                            }
                        } else {
                           $dir_passed = 1;
                        }
                        if($dir_passed){
                            $file = $recursive_path.($recursive_path=="" ? "" : "/").$entry;
                            $_array = array("path" => $path, "value" => $file, "caption" => $entry ,"parent" => $parent, "type"=>0);
                            $list[] = $_array;
                            $data["path"] = $path;
                            FileSystem::GetRecursiveDirsList($data, $file, $list);
                        }
                    } elseif(is_file($path)){
                        if($data["files_filter"] != ''){
                            $file_passed = 0;
                            if(preg_match($data["files_filter"], $entry)){
                               $file_passed = 1;
                            }
                        } else {
                           $file_passed = 1;
                        }
                        if($file_passed){
                            $file = $recursive_path.($recursive_path=="" ? "" : "/").$entry;
                            $_array = array("path" => $path, "value" => $file, "caption" => $entry, "parent" => $parent, "type"=>1);
                            $list[] = $_array;
                        }
                    }
                }
             }
             $d->close();

          }

    }

    static function recursiveRemoveFiles($path, $silent = true){
        $error_mode = error_reporting();

        if ($silent)
            error_reporting(0);

        $dirs=array();
        if ($dh = opendir($path)){
			while (($file = readdir($dh)) !== false) {
                if ($file!='..' && $file!='.'){
	                $file=$path.$file;
					if (is_file($file) && is_writable($file)) unlink($file);
					if (is_dir($file) && $file!='..' && $file!='.') $dirs[]=$file."/";
				}
			}
			closedir($dh);
        }

        for ($i=0; $i<count($dirs); $i++)
        	FileSystem::recursiveRemoveFiles($dirs[$i], $silent);
		error_reporting($error_mode);
    }

 } //--end of class

?>