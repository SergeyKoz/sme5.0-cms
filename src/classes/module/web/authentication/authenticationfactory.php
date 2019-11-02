<?php
$this->ImportClass("module.web.authentication.authentication", 'Authentication');
/**
  * Authentication factory class
  * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
  * @version 1.0
  * @package Framework
  * @subpackage classes.module.web.authentication
  * @access public
  * @abstract
  **/


class AuthenticationFactory {

    /**
      * Method get authentication object
      * @param  ModulePage  $page   Page object
      * @return Authentication      Authentication object (or nested)
      * @access public
      **/
    static function getAuthentication(&$page) {
        //--check if file exists
        $classname = strtolower($page->PageMode."Authentication");
		//--build package classpath
        $classpath = strtolower(Path::buildPathString("web.authentication.".$classname,
                                   $page->Kernel->Package->ClassesDirs,
                                   $page->Kernel->classExt,
                                   $page->Kernel->Language));
        $ipath = "web.authentication.".$classname;

        if (!file_exists($classpath))  {
          //--build framework classpath
          $classpath = strtolower(Path::buildPathString("module.web.authentication.".$classname,
                                   $page->Kernel->ClassesDirs,
                                   $page->Kernel->classExt,
                                   $page->Kernel->Language));
        $ipath = "module.web.authentication.".$classname;
        }
       if (file_exists($classpath))  {
          $page->Kernel->ImportClass($ipath, $classname);
          $object = new $classname($page);
          return $object;
        }   else    {
          $object = new Authentication($page);
          return $object;
        }
    }

} //--end of class