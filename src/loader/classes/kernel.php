<?php
/** Kernel standart class
* @author Sergey Grishko <sgrishko@reaktivate.com>
* @modified Konstantin Matsebora <kmatsebora@activemedia.com.ua>
* @version 2.0
* @package Loader
* @subpackage classes
* @access public
*/

class Kernel extends Package{
	/**
	* Class name
	* @var    string  $ClassName
	**/
	var $ClassName = "Kernel";
	/**
	* Class version
	* @var    string  $Version
	**/
	var $Version = "1.2";
	/**
	* Component  root directory
	* @var    string  $ComponentRoot
	**/
	var $ComponentRoot="";
	/**
	* Module  root directory
	* @var string $ModuleRoot
	**/
	var $ModuleRoot="";
	/**
	* Component name
	* @var    string      $ComponentName
	**/
	var $ComponentName="Backend";
	/**
	*  Database connection object
	*  @var    IConnection $Connection
	**/
	var $Connection;

	/**
	* Current page name
	* @var    string  $PageName
	**/
	var $PageName;

	/**
	*  Module languages array
	* @var  array  $Languages
	**/
	var $Languages=array();

	/**
	*  Languages  short names array
	* @var  array  $LangShortNames
	**/
	var $LangShortNames=array();

	/**
	*  Languages  names array
	* @var  array  $LangLongNames
	**/
	var $LangLongNames=array();

	/**
	* Current Language  prefix
	* @var    string  $Language
	**/
	var $Language;
	/**
	* Cache root
	* @var  string  $CacheRoot;
	**/
	var $CacheRoot;
	/**
	* Write classes log flag
	* @var  int  $writeLogs;
	**/
	var $WriteLogs=false;
	/**
	* Log file descriptor
	* @var  int  $LogFile;
	**/
	var $LogFile;
	var $LogFileName;

	/**
	* Show debug flag
	* @var    boolean $ShowDebug
	**/
	var $ShowDebug=false;


	/**
	* Use cache flag
	* @var    boolean $UseCache
	**/
	var $UseCache=false;

	/**
	* Default class extension
	* @var  string  $classExt
	**/
	var $classExt=".php";
	/**
	* Default page extension
	* @var  string  $pageExt
	**/
	var $pageExt=".php";
	/**
	* Default template extension
	* @var    string  $templateExt
	**/
	var $templateExt=".xsl";

	/**   Default max node level that can be in system
	*  @var    int     $DEFAULT_MAX_NODE_LEVEL_EVER
	**/
	var $DEFAULT_MAX_NODE_LEVEL_EVER=100;

	/**   Default package name
	*   @var    int     $DefaultPackage
	**/
	var $DefaultPackage="libraries";

	/**
	*   Using database flag
	*   @var boolean   $useDB
	**/
	var  $useDB = true;

	/**
	*   Uploaded files permissions, octal value like 0777
	*   @var string    $FileMode
	**/
	var  $FileMode = 0777;


	/**
	*   Created by scripts dirs permissions, octal value like 0777
	*   @var string    $DirMode
	**/
	var  $DirMode = 0777;

	/**
	*   Use authentication every request process flag
	*   @var boolean  $useDB
	**/
	var  $useAuthentication = true;

	/**
	*   Debug object
	*   @var Debug  $Debug
	**/
	var     $Debug;

	var    $MultiLanguage=false;

	/**
	* Method checks if file containing specified class or page exists
	* @param           string $Name Class or Page name
	* @param           int    type of existing ,enum (0=>class,1=>page)
	* @return          bool True if exists, False otherwise
	* @access          public
	**/
    function &Exists($Name,$existType=0) {
        if ($existType==0) {
			return file_exists(Path::buildPathString($Name,$this->ClassesDirs,$this->ClassExt));
        } else {
			list($this->PageName,$_pagePath) = Path::buildPageString(
				$this->PageName,$this->Package->DefaultPage,
				$this->DefaultPage,$this->PagesDirs,
				$this->pageExt);
			return file_exists($_pagePath);
        }
    }

	/**
	* Method imports specified class
	* @param           string $classname Class name
	* @param                     string $package     Package name
	* @access          public
	**/
    function &Import ($className, $package = ""){
		if ((!defined("NO_ENGINE_CACHE") || (NO_ENGINE_CACHE == 0)) && $this->IncludeCachedClass($className, $package)){
			return true;
		}

        $start_time = microtime();
        // if defined package
        if (strlen($package) != 0) {
            if ($package != $this->Package->PackageName) {
                $_curPackage = Engine::GetPackage($this, $package);
                $_curPackage->setDirs();
                $this->ClassesDirs = array_merge($this->ClassesDirs, $_curPackage->ClassesDirs);
            }
        }
        if ($this->Exists($className, 0)) {
            $_path = Path::buildPathString($className, $_curPackage->ClassesDirs, $this->ClassExt);
            if (! file_exists($_path)){
                $_path = Path::buildPathString($className, $this->ClassesDirs, $this->ClassExt);
			}

            if ($this->WriteLogs){
                $this->log_indent .= "+";
                $this->Write_Log("[IMPORT CLASS]");
                $this->Write_Log("PATH", $_path, false);
            }
            if ( (!defined("NO_ENGINE_CACHE") || (NO_ENGINE_CACHE == 0))){
				EngineCache::SaveLoadedClasses($className, $package, $_path);
			}

            $res = include_once($_path);
            //add debug info
            $classPath = explode(".", $className);
            $class = array_pop($classPath);
            global $php_errormsg;
            $end_time = microtime();
            $this->Debug->AddDebugItem("classes", array("status" => $res ? "Ok" : "Error" , "name" => $className , "error" => $php_errormsg , "description" => $_path , "time" => $this->Get_Interval($start_time, $end_time, 5)));
            //write classes file
            if (! $res && $this->WriteLogs) {
                $this->Write_Log("STATUS", "FAILED");
                $this->Write_Log("ERROR", $php_errormsg);
                $this->Write_Log("[/IMPORT_CLASS]");
            } else {
                if ($this->WriteLogs) {
                    $this->Write_Log("STATUS", "OK");
                }
            }
        } else {
            user_error(sprintf("Class %s not found <br>(<b>%s</b>) <br>", $className, $_path), E_USER_ERROR);
        }
    }

	/**
	* Method include specified file
	* @param           string   $fileName File name (relative path from project or package (if $package variable defined) directory, separator - .)
	* @param           string   $package  Package name
	* @access          public
	**/
	function IncludeFile($fileName,$package = ""){
		Engine::IncludeFile($this,$fileName,$package);
	}

	/**
	*Method get variable value using GLOBAL,GET and POST data
	*@param   string    $varname    variable name
	*@return  mixed                 variable value
	*@access public
	**/
	function &getVariable($varname) {
		return Engine::getVariable($varname);
	}

	/**
	* Method gets a class name frpm class path
	* @param  string  $classPath   full class name (consists of class location and class name separated by fullstops)
	* @return string               class name (in PHP namespace)
	* @access public
	**/
	function getClassName($classPath) {
		return Engine::getClassName($classPath);
	}

	/**
	* Method Raises an error (prototype)
	* @param           string $err Error message
	* @access          public
	**/
	function RaiseError($err) {
	}

	/**
	* Constructor of class (method where defined main module variables)
	* @param    string        Path to Ini File
	* @param       string                 Component name
	* @param       string                 Ini filename
	**/
	function Kernel($iniFileRoot,$ComponentName,$IniFile="project.ini.php"){
		self::$Instance=&$this;
	    //Component name
	    Engine::setSessionVars($this);

		if (EngineCache::CheckKernelCached($this)){

		    //get config variables
		    $this->Settings  = &ConfigFile::GetInstance("siteIni",$iniFileRoot.$IniFile);

		    //Add component path to config reference
	    	$this->Settings->SetItem("module","ComponentPath",$this->ComponentRoot);

	    	//Add component path to config reference
	    	$this->Settings->SetItem("module","ComponentName",$this->ComponentName);

	    	//Set Language version variable
	    	Engine::initLanguages($this);

	    	//parse again with component root
			$this->Settings->reParse();

			//--merge database anf roles section from package to kernel settings
			//get all packages
			$packages = $this->Settings->GetSection("packages");
			foreach($packages as $name => $path)    {
				$tmp_package = $this->getPackageSettings($name);

				//-- merge database section
                if (isset($tmp_package->Sections["database"])){
                    $this->Settings->mergeSection($tmp_package->Sections["database"],"database","a+");
                }

				//-- merge roles section
                if (isset($tmp_package->Sections["roles"])){
                    $this->Settings->mergeSection($tmp_package->Sections["roles"],"roles","a+");
                }

				//-- merge common section
                if (isset($tmp_package->Sections["common"])){
                    $this->Settings->mergeSection($tmp_package->Sections["common"],"common","a+");
                }
				//-- merge authorization section from package system
				if ($name == "system")
					$this->Settings->mergeSection($tmp_package->Sections["authorization"],"authorization","a+");

				$this->Settings->reParse();
			}

			//create debug object
			$this->Debug=new Debug(	$this->Settings->GetItem("module","ModulePath")."debug/",
									$this->Settings->GetItem("module","ModuleURL")."debug/",
									$this->Settings->GetItem("DEFAULT","ShowDebug"));

			//Resource root directory for all module
			$this->ResourcesRoot  =  $this->Settings->GetItem("module","ResourcePath");

			//create database connection
			$this->ClassesDirs = $this->Settings->GetItem("Path","ClassPath");

			//Module root variable
		    $this->ModuleRoot   =  $this->Settings->GetItem("module","ModulePath");

		    //get filesystem settings
			$this->getFileSystemSettings();

			EngineCache::CacheKernel($this);
  	    }

	    Engine::SetErrorLogging($this);

		//set kernel variables from default section
		$this->Settings->fromSectionToVariables($this,"default");

		//create database connection
		$this->createDBConnection($this);

		$this->GetAdminSettings();

		//get page definition
		if (!$GLOBALS["_use_point_file"] && Engine::isPackageExists($this,"content") ){
			$package = $this->getPageDefinition();
		}

		//get package
		if (Engine::getVariable("page")=="framelist"){
			$package=$this->DefaultPackage;
		}

		if (EngineCache::CheckKernelPackageCached($this, $package)){
			$this->Package    =    Engine::getPackage($this,$package);

		    //initialize errors object
		    $this->Errors = &ConfigFile::GetInstance("errorMessages",$this->Settings->GetItem("module","FrameworkPath")."data/resources/errors.php");

		    //Initializing error object
		    Engine::initLocalization($this);

		    //set useAuthenitcation flag from package config
		    $this->useAuthentication = $this->Package->Settings->GetItem("main","useAuthentication");

		    EngineCache::CacheKernelPackage($this, $package);
	    }

	    //redefine authorization section
		if ($this->Package->Settings->HasSection("authorization"))
			$this->Settings->mergeSection($this->Package->Settings->Sections["authorization"],"authorization","a+");

	    $this->Settings->reParse();

	    //set directories
		$this->setDirs();
  	}

	static function Instance(){
		return self::$Instance;
	}

  	function createDBConnection (){
        if ($this->useDB) {
            $this->Import("system.data.datafactory");
            $this->Connection = DataFactory::GetConnection($this->Settings->GetItem("Database", "ConnectionString"), $this);
            $Loader = &$GLOBALS["Loader"];
            $Loader->Connection=&$this->Connection;
        }
        //open write log files
        if ($this->WriteLogs) {
            $this->Open_Log($this->ModuleRoot . "debug/", "debuger.log");
        }
    }

	function getPage() {
		//get page name
		$this->PageName = Engine::getVariable("page");
		//create path to page file
		list($this->PageName,$_pagePath) = Path::buildPageString(	$this->PageName, $this->Package->DefaultPage,
																	$this->DefaultPage, $this->PagesDirs,
																	$this->pageExt);
		//include page class file
		$res = require_once($_pagePath);
		//create Page object
		$_ClassName=Engine::getClassName($this->PageName."Page");
		$Page= new $_ClassName ($_ClassName,"content",$this->PageName,$this);
		return $Page;
	}

	/**
	* Method get page definition from database (if site without page generation)
	*
	**/
	function getPageDefinition() {
		if ($this->useDB){
			$storage = DataFactory::GetStorage($this,"ContentTable", "", false, "content");
			$page = $storage->getPage();
		}
		//if page not found
		if (!$page) {
			$url = sprintf($this->Settings->GetItem("AUTHORIZATION","Frontend_HREF_PageNotFound_Redirect_project"),$this->Language);
			header("Location:".$url);
		}

		//if page found
		$_GET["page"] = $page["point_page"];
		$_GET["package"] = $page["point_package"];
		$_GET["template"] = $page["point_template"];

		if (strlen($page["point_php_code"]) != 0) eval($page["point_php_code"]);
	}

	function getPackageSettings($package = "", $clear_instance = false)  {
		return Engine::getPackageSettings($this,$package,$clear_instance);
	}

    /**
      * Method set templates,classes and pages directories
      * @access public
      **/
	function setDirs()  {
		Package::setDirs();
		$dirNames = array("PagesDirs","ClassesDirs","TemplateDirs");
		foreach($dirNames as $i => $dir)  {
			$this->$dir = array_merge($this->Package->$dir,$this->$dir);
		}
	}

     /**
       *Method get current language version and set Language variable
       *@access public
       **/
	function getLanguage()  {
		Engine::getLanguage($this);
	}

    function dummy_error_handler(){
        return true;
    }

     /**
     *  ����� ��������� ���� � ������ ����������.
     * @param string $log_dir �������, � ������� �������� log-file
     * @param $log_file �������� �����
     * @access private
     **/
    function Open_Log($log_dir,$log_file)   {
        global $suppress_errors;
        $this->LogFileName = $log_dir.$log_file;
        $this->LogFile = @fopen($this->LogFileName,"w");
        $old_state = $suppress_errors;
        $suppress_errors = true;
        @chmod($this->LogFileName, 0777);
        $suppress_errors = $old_state;
        if (!$this->LogFile) $this->WriteLogs = false;
    }

   /**
     * Function close log-file
     *@access private
     **/
    function Close_Log () {
        global $suppress_errors;
        @fclose($this->LogFile);
        $old_state = $suppress_errors;
        $suppress_errors = true;
        @chmod($this->LogFileName, 0777);
        $suppress_errors = $old_state;
    }

   /**
     * Function write to log-file
     * @param   string   $message   message string
     * @param   string   $details   details string
     * @access private
     **/
	function Write_Log($message = "", $details = "", $node_status = 0) {
		if(is_resource($this->LogFile)){
			if ($node_status == 1) {
				@fwrite($this->LogFile,"<item>".chr(10));
			}
			if(strlen($message)){
				@fwrite($this->LogFile,$message);
			}
			if(strlen($details)){
				@fwrite($this->LogFile,":".$details);
			}
			@fwrite($this->LogFile,chr(10));
			if ($node_status == 2)   {
				@fwrite($this->LogFile,"</item>".chr(10));
			}
		}
	}

  	/**
    * Method include class , if it does not included
    * @param    string      $path       Class path
    * @parm     string      $name       Class name
    **/
	function &ImportClass($path,$name,$package=""){
		if (!class_exists($name)){
			$this->Import($path,$package);
		}
	}

	/**
	* Method returns specified packge class (backward compatibility issue)
	* @param  $package            string      Package name
	* @param  $clear_instance     boolean     Clear instance (Remove from global variables), flag
	* @access public
	* @return Package   Package object
	**/
	function getPackage($package,$clear_instance = false){
		return Engine::GetPackage($this,$package, $clear_instance);
	}


	/**
	* Method returns relative to the SiteURL value path of currently runnig page
	* if there is prepended language dir, ie en/file.php, en/ will be translated into %s/
	* @return     string      Relative Page path
	* @access     public
	**/
	function GetPagePath(){
		return Engine::GetPagePath($this);
	}

/**
	* Method get filesystem settings
	* @access     public
	**/
	function getFileSystemSettings()  {
		if ($this->Settings->HasItem("SETTINGS","FileMode")){
			$this->FileMode = $this->Settings->GetItem("SETTINGS","FileMode");
		}
		if ($this->Settings->HasItem("SETTINGS","DirMode")){
			$this->DirMode = $this->Settings->GetItem("SETTINGS","DirMode");
		}
	}

	/**
	* Method prepare content for display on the site (set URL variables)
	* @param    mixed   $content    initial content (string or array)
	* @return   string  $content    result content
	* @access   public
	**/
	function prepareContent(&$content) {
		$URL = $this->Settings->GetItem("MODULE","SiteURL");
		$FilesURL = $this->Settings->GetItem("Settings","FileStorageURL");
		if (!is_array($content)) {
			$content = str_replace("http://{files_url}",$FilesURL,str_replace("{language}",$this->Language,str_replace("{url}",$URL,str_replace("http://{url}",$URL,$content))));
		} else {
			foreach ($content as $key => $value){
				$content[$key] = str_replace("http://{files_url}",$FilesURL,str_replace("{language}",$this->Language,str_replace("{url}",$URL,str_replace("http://{url}",$URL,$value))));
			}
		}
		return $content;
	}

	function GetAdminSettings(){
		$settingsStorage=DataFactory::GetStorage($this,"SettingsTable","",true,"system");
		$this->AdminSettings=$settingsStorage->Get(array());
	}

	function IncludeCachedClass($className, $package){
		$start_time = microtime();
		$path=EngineCache::CheckCachedClass($className, $package);
		$res=false;
		if ($path!=''){
			$r = include($path);
			if($this->Debug->ShowDebug==1){
				$end_time = microtime();
				$this->Debug->AddDebugItem('classes', array('status' => $r ? 'Ok' : 'Error' , 'name' => $className , 'error' => $php_errormsg , 'description' => $path , 'time' => $this->Get_Interval($start_time, $end_time, 5)));
			}
			$res=true;
		}
		return $res;
	}

	//end of class
}

function Kernel(){
	return Kernel::Instance();
}

function Connection(){
	return Kernel::Instance()->Connection;
}

?>