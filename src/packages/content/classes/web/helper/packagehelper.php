<?php

	/**
	 * Content package pages helper class
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package	Content
	 * @subpackage classes.helper
	 * @static
	 * @access public

	 **/

	 class PackageHelper   {
	     /**
	      *  Method get all project elements using name
	      * @param     PagesEditPage   $object       page instance
	      * @param     string          $name         name of elements (can be "Page" or "Template"
	      * return     array               elements array
	      *	 @access private
	      **/
	   static function GetProjectElements(&$object,$name)  {
	       $packages = $object->Kernel->Settings->GetSection("PACKAGES");
	       $pages_arr = array();
	       $pagepathes_arr = array();
           $object->max_pagename_length = 0;
           //get pages for  project
           $pathes = $object->Kernel->Settings->GetItem("Path",$name."Path");
	           if (!is_array($pathes)) $pathes = array($pathes);
	           PackageHelper::getPackageElements($object,"project",
	                                           $pathes,$pagepathes_arr,$pages_arr,$name);
	       //--get pages for all packages
	       foreach ($packages as $pname => $path) {
	           $settings = $object->Kernel->getPackageSettings($pname);
	           $pathes = $settings->GetItem("path",$name."Path");
	           PackageHelper::getPackageElements($object,$pname,$pathes,$pagepathes_arr,$pages_arr,$name);
	       }

            return $pages_arr;
	   }

        /**
	      *  MMethod get all package elements using name
	      * @param     PagesEditPage       page instance
	      * @param     string      $pname               package name
	      * @param     array       $pathes             package page location pathes
	      * @param     array       $pagepathes_arr     common array of page pathes
	      * @param     array       $pages_arr          common array of page names
	      * @param     string      $name               name of elements (can be "Page" or "Template"
	      *	@access    private
	      **/
	   static function getPackageElements(&$object,$pname,$pathes,&$pagepathes_arr,&$pages_arr,$name)  {
	       if (!is_array($pathes))
	       {
	           $pathes = array($pathes);
	       }
	       foreach ($pathes as $i => $pagepath)    {
	               //--get page files
	               if (is_dir($pagepath))  {
	                 if ($dh = @opendir($pagepath)) {
                       while (($file = @readdir($dh)) !== false) {
                           //--if is a file
                         if (is_file($pagepath.$file) && $file !="." && $file != "..")   {
                             $filepart_arr = explode(".",$file);
                             $ext = array_pop($filepart_arr);
                             //--if this is a page class
                              $extname = $name."Ext";

                             if (".".$ext == $object->Kernel->$extname) {
                                 if (!in_array($pagepath.$file,$pagepathes_arr))    {
                                    $pagepathes_arr[] = $pagepath.$file;
                                    $pagefile =  implode(".", $filepart_arr);
                                    if (strlen($pagefile) > $object->max_pagename_length)
                                        $object->max_pagename_length = strlen($pagefile);
                                    $pages_arr[$pname][] = $pagefile;
                                 }
                             }
                         }
                       }
                       closedir($dh);
                     }
	              }
	       }
	   }


	   static function setClassesSelect(&$object){
        //get project clsses
        $package = "project";
        $pathes_arr=array();
        $pathes = $object->Kernel->Settings->GetItem("Path","PagePath");
        PackageHelper::getPackageElements($object,"project",
        $pathes,$pathes_arr,
        $pages_arr,"Page");

        $packages = array_keys($object->Kernel->Settings->GetSection("PACKAGES"));

        foreach ($packages as $i => $package) {
            $settings = $object->Kernel->getPackageSettings($package);
            $pathes = $settings->GetItem("Path","PagePath");
            PackageHelper::getPackageElements($object,$package,
            $pathes,$pathes_arr,
            $pages_arr,"Page");
		}

        $options=array();
        foreach ($pages_arr as $package => $pages){
            $options[]=array("caption"=>$package.($package=="project" ? " (Default)" : ""), "value"=>"", "class"=>"category_class");
            foreach ($pages as $page){
                $options[]=array("caption"=>"&nbsp;&nbsp;&nbsp;".$page, "value"=>$package."|".$page, "class"=>"entry_class");
            }
        }
        $object->form_fields["ADDITIONAL_FUNCTIONS"][1]["options"]=$options;
        if  (!($object->_data["point_page"]!="") ) $object->_data["point_page"]=-1;

    }

    static function CheckPageName($name){
        $f=true;
        //				   check email							check url							   check name
        if (!preg_match('/(^[a-zA-Z]+:.*?@[a-zA-Z0-9-_.]+(\?|$)|^[a-zA-Z]+:\/\/[a-zA-Z0-9-_.\/]*(\?|$)|^[a-zA-Z0-9-_.]*(\/\?|\?|$))/', $name))
        	$f=false;
    	return $f;
    }

    static function CheckUrl($name){
        $f=true;
        //				   check email							check url
        if (!preg_match('/(^[a-zA-Z]+:.*?@[a-zA-Z0-9-_.]+(\?|$)|^[a-zA-Z]+:\/\/[a-zA-Z0-9-_.\/]*(\?|$))/', $name))
        	$f=false;
    	return $f;
    }

    static function CheckName($name){
        $f=true;
	    if (!preg_match('/^[a-zA-Z0-9-_.]*(\/\?|\?|$)/', $name))
        	$f=false;
    	return $f;
    }



   } //  end of class


?>