<?php
  /**  Path control and configuration class
     * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
     * @version 1.0
     * @static
     * @package Loader
     * @subpackage classes
     * @access public
     */
   class Path  {

      /**
        * Method returns the absolute path of the file (search in directories)
        * @param           string $path         relative path of file
        * @param           array  $directories  array of directories where can be found this file
        * @param           string $ext          file extension
        * @param           string $language     current language
        * @return          string File path
        * @access          public
        **/
    static function &buildPathString($path,&$directories,$ext,$language = "") {
            $_fileName = str_replace(".", "/", $path);
            $count =  count($directories);

            for ($i = 0; $i < $count ; $i++) {
                    $_FileDir =  $directories[$i];
                    if ($language!="")  {
                        $_FileRoot = $_FileDir.$_fileName ."." .$language . $ext;
                        if (file_exists($_FileRoot))   break;
                    }
                    $_FileRoot = $_FileDir.$_fileName . $ext;

                    if (file_exists($_FileRoot))   break;
            }
            return $_FileRoot;
    }


     /**
    * Method returns the path to the file that contains specified page
    * @param           string $page          Page name
    * @param           string $pdefault      Package default Page name
    * @param           string $kdefault      Kernel default Page name
    * @param           array  $directories   array of directories where can be found this page
    * @param           string $ext           page extension
    * @return          array                 array (page name,page path)
    * @access          public
    **/
    static function &buildPageString($page,$pdefault,$kdefault,&$directories,$ext)   {
      $_pages=array($page,$pdefault,$kdefault);
      //try to find this page
      foreach ($_pages as $i=>$_page)   {
        reset($directories);
        $__page = str_replace(".", "/", $_page);
        foreach ($directories as $tmp => $_PageDir)  {
            $_tmpPageRoot=$_PageDir. $__page . $ext;
            if (is_file($_tmpPageRoot)) {
                        $PageName=$_page;
                        return array($_page,$_tmpPageRoot);
          }
       }
      }
      return array($kdefault,$_tmpPageRoot);
    }

    /**
      * Method get library path using name of library and resourses pathes
      * @param     Kernel   $object     Kernel object
      * @param     string   $library    Library name
      * @return    mixed                Null if library not found and path string if found
      * @access    public
      **/
    static function getLibraryPath(&$object,$library,$package = "")  {

     if (strlen($package) == 0)    {
         $settings = $object->Package->Settings;
     }   else  {
         $settings = $object->getPackageSettings($package);
     }

     $dirs = $settings->GetItem("PACKAGE","ResourcePath");

     if (!is_array($dirs)) $dirs = array($dirs);

     if ($object->Settings->HasItem("MODULE","ResourcePath")){
		$projectDirs = $object->Settings->GetItem("MODULE","ResourcePath");
		if (!is_array($projectDirs)) $projectDirs = array($projectDirs);
		$dirs=array_merge($dirs, $projectDirs);
     }


      for ($i = sizeof($dirs)-1;$i >= 0;$i--)  {
          $path_array = explode("/",$dirs[$i]);
          $path_part  = array_pop($path_array);
          if (strlen($path_part)==0)    array_pop($path_array);
          $path = implode("/",$path_array)."/";
          $path = $path."libraries/".$library.".ini.php";
          if (file_exists($path))  {
              return $path;
          }
      }
      $path = $dirs[0] ."../libraries/".$library.".ini.php";
      if (file_exists($path))  return $path;
      return null;
    }

  }  //--end of class
?>