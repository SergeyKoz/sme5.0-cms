<?php
/** Engine standart class (factory for Page, Package objects)
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 2.0
 * @package Loader
 * @subpackage classes
 * @access public
 */
class Engine{

    /**
     * Method get Package object
     * @param   Kernel      $this                Kernel instance
     * @param   string      $package             Package name
     * @param   boolean     $clear_instance      Clear instance (Remove from global variables), flag
     * @return  Package                          Package instance
     * @access private
     **/
    static function getPackage (&$object, $package = "", $clear_instance = false){
        if (strlen($package) == 0) {
            $cpackage = Engine::GetPackageName();
            if (strlen($cpackage) == 0) {
                $cpackage = $object->DefaultPackage;
            }
        } else { //-- set package name from parameter
            $cpackage = $package;
        }
        //--get package settings
        $settings = Engine::getPackageSettings($object, $cpackage, $clear_instance);
        $package = new Package($settings);
        return $package;
    }
    /**
     * Method get Package settings object (ini-file definition)
     * @param   Kernel      $this                Kernel instance
     * @param   string      $package             Package name
     * @param   boolean     $clear_instance      Clear instance (Remove from global variables), flag
     * @return  ConfigFile                       Package settings instance
     * @access public
     **/
    static function getPackageSettings (&$object, $package = "", $clear_instance = false){
        //--search package ini-file in GLOBALS
        $inifile = $object->Settings->GetItem("packages", $package);

        if (strlen($inifile) == 0) {
            user_error("Can't find a path to <b>$package</b> package  ini-file", E_USER_ERROR);
            die();
        } else {
            $settings = &ConfigFile::GetInstance($package . "packageIni", $inifile);
            // set package settings
            if ($settings == null) {
                user_error("Can't find a  <b>$inifile</b> ini-file for <b>$package</b> package", E_USER_ERROR);
            } else {
                Engine::setPackageModuleSettings($object->Settings, $settings);
                return $settings;
            }
        }
    }
    /**
     * Method set main module settings to package settings object
     * @param   ConfigFile      $appsettings        Module settings object
     * @param   ConfigFile      $settings           package settings object
     * @access public
     **/
    static function setPackageModuleSettings (&$appsettings, &$settings){
        $settings->SetItem("package", "FrameworkPath", $appsettings->GetItem("module", "FrameworkPath"));
        $settings->SetItem("package", "FrameworkURL", $appsettings->GetItem("module", "FrameworkURL"));
        $settings->SetItem("package", "ModulePath", $appsettings->GetItem("module", "ModulePath"));
        $settings->SetItem("package", "ModuleURL", $appsettings->GetItem("module", "ModuleURL"));
        $settings->SetItem("package", "SitePath", $appsettings->GetItem("module", "SitePath"));
        $settings->SetItem("package", "SiteURL", $appsettings->GetItem("module", "SiteURL"));
        $settings->SetItem("package", "Language", $appsettings->GetItem("module", "Language"));
        $settings->SetItem("package", "ComponentName", $appsettings->GetItem("module", "ComponentName"));
        $settings->reParse();
        $settings->reParse();
    }
    /**
     * Method returns package from session
     * @param    $component  Component name
     * @return   string      Package name
     * @access   public
     **/
    static function GetPackageName (){
        if (isset($GLOBALS["package"])) {
            return $GLOBALS["package"];
        } elseif (isset($_GET["package"])) {
            return $_GET["package"];
        } elseif (isset($_POST["package"])) {
            return $_POST["package"];
        } else {
            return $_SESSION["session_package"];
        }
    }
    /**
     * Method sets error logging and showing level
     * @param    Kernel  $this       Kernel object
     * @access public
     **/
    static function SetErrorLogging (&$object){
        global $logfile_path, $email_to, $email_from, $project_url, $show_errors, $suppress_errors;
        $Settings=&$object->Settings;
        if ($Settings->HasSection("ERRORS")) {
            if ($Settings->HasItem("ERRORS", "SuppressErrors")) {
                $suppress_errors = $Settings->GetItem("ERRORS", "SuppressErrors");
            }
            if ($Settings->HasItem("ERRORS", "ShowErrors")) {
                $show_errors = $Settings->GetItem("ERRORS", "ShowErrors");
            } else {
                $show_errors = 0;
            }
            if ($Settings->HasItem("ERRORS", "LogErrors")) {
                $log_errors = $Settings->GetItem("ERRORS", "LogErrors");
            } else {
                $log_errors = 0;
            }
            if (! $suppress_errors) {
                error_reporting(E_ERROR | E_WARNING | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING | E_USER_ERROR | E_USER_WARNING);
            } else {
                error_reporting(0);
            }
            if ($log_errors || $show_errors)
                set_error_handler("ErrorLogger");
            if ($log_errors) {
                $logfile_path = $object->ModuleRoot . "debug/errors.log";
                if ($Settings->HasItem("ERRORS", "EmailErrors")) {
                    $emailErrors = $Settings->GetItem("ERRORS", "EmailErrors");
                } else {
                    $emailErrors = 0;
                }
                if ($emailErrors) {
                    if ($Settings->HasItem("ERRORS", "MAILBOX")) {
                        $email_to = ($Settings->GetItem("ERRORS", "MAILBOX"));
                    } else {
                        $email_to = "";
                    }
                } else {
                    $email_to = "";
                }
                $email_from = $Settings->GetItem("EMAIL", "FROM");
                $project_url = $Settings->GetItem("MODULE", "Host");
            }
        }
    }
    /**
     *Method get current language version and set Language variable
     * @param Kernel  $this       Kernel object
     * @access public
     **/
    static function getLanguage (&$object){
        $language = Engine::getVariable("language");
        if (is_string($language))
	        if (strlen($language) == 0)
	            $language = $object->Languages[0];
        if (in_array($language, $object->Languages)) {
            return $language;
        } else {
            return $object->Languages[0];
        }
    }
    /**
     * Method set session system variable (like package)
     * @param  Kernel  $this       Kernel object
     * @access public
     * @static
     **/
    static function setSessionVars (&$object){
        //add package name to session
        $language = Engine::getVariable("language");
        if (is_string($language))
	        if (strlen($language))
	            $_SESSION["language"] = $language;

        $package = Engine::getVariable("package");
        if (strlen($package))
            $_SESSION["session_package"] = $package;
    }
    /**
     *Method get variable value using GLOBAL,GET and POST data
     *@param   string    $varname    variable name
     *@return  mixed                 variable value
     *@access public
     **/
    static function &getVariable ($varname){        
        if (isset($_GET[$varname])) {
            $variable=$_GET[$varname];
        } elseif (isset($_POST[$varname])) {
            $variable=$_POST[$varname];
        } elseif (isset($_SESSION[$varname])) {
            $variable=$_SESSION[$varname];
        } elseif (isset($GLOBALS[$varname])) {
            $variable=$GLOBALS[$varname];
        }        
        return $variable;
    }
    /**
     * Method initialize Localization and Errors objects of Kernel
     * @param  Kernel  $this       Kernel object
     * @access public
     * @static
     **/
    static function initLocalization (&$object){
        //Initializing error object
        if (strlen($object->ResourcesRoot) != 0) {
            //set errors object
            $module_errors = &ConfigFile::GetInstance("ModuleErrorMessages", $object->ResourcesRoot . "errors." . $object->Language . ".php");
            $object->Errors->MergeSections($module_errors);
            $object->Localization = &ConfigFile::GetInstance("ModuleLocalization", $object->ResourcesRoot . "localization." . $object->Language . ".php");
            if (! $object->Localization) {
                print "Can't load module localization '" . $object->ResourcesRoot . "localization." . $object->Language . ".php'";
                die();
            }
            //-- get package error messages and localization messages
            for ($i = sizeof($object->Package->ResourceDirs) - 1; $i >= 0; $i --) {
                $package_errors = &ConfigFile::GetInstance("PackageErrorMessages", $object->Package->ResourceDirs[$i] . "errors." . $object->Language . ".php");
                $package_Localization = &ConfigFile::GetInstance("PackageLocalization", $object->Package->ResourceDirs[$i] . "localization." . $object->Language . ".php");
                $object->Errors->MergeSections($package_errors);
                $object->Localization->MergeSections($package_Localization);
                ConfigFile::emptyInstance("PackageErrorMessages");
                ConfigFile::emptyInstance("PackageLocalization");
            }
        }
    }
    /**
     * Method initialize project language settings
     * @param  Kernel  $this       Kernel object
     * @access public
     * @static
     **/
    static function initLanguages (&$object){
        $Settings=$object->Settings;

        //Set Language version variable
        $object->Languages = $Settings->GetItem("language", "_Language");
        if (! is_array($object->Languages))
            $object->Languages = array($object->Languages);
        $object->LangShortNames = $Settings->GetItem("language", "_LangShortName");
        if (! is_array($object->LangShortNames))
            $object->LangShortNames = array($object->LangShortNames);
        $object->LangLongNames = $Settings->GetItem("language", "_LangLongName");
        if (! is_array($object->LangLongNames))
            $object->LangLongNames = array($object->LangLongNames);

        //Set current Language
        $object->Language = Engine::getLanguage($object);
        $Settings->SetItem("module", "Language", $object->Language);
        $Settings->GetItem("language", "_Language");
        if ($Settings->HasItem("DEFAULT", "MultiLanguage"))
        	$object->MultiLanguage=($Settings->GetItem("DEFAULT", "MultiLanguage")==1 ? true : false);
    }
    
    /**
     * Method gets a class name frpm class path
     * @param  string  $classPath   full class name (consists of class location and class name separated by fullstops)
     * @return string               class name (in PHP namespace)
     * @access public
     **/
    static function getClassName ($classPath){
        $nameChunks = explode(".", $classPath);
        return $nameChunks[sizeof($nameChunks) - 1];
    }
    /**
     * Method get library configuration object
     * @param    Kernel  $this           Kernel object
     * @param    string  $library        Library name (without ".ini.php")
     * @param    string  $instance_name  Global object instance name
     * @param    boolean $show_error     Generate E_USER_ERROR when library not found, flag
     * @param    string  $package        Package name (if library exists in another package)
     * @return   mixed                   If library not found null, if found - library(configfile) object
     * @access   public
     * @static
     **/
    static function getLibrary (&$object, $library, $instance_name = "dummyInstance", $show_error = true, $package = ""){
        $start_time = microtime();
        $path = Path::getLibraryPath($object, $library, $package);
        if ($path !== null) {
            $lib = ConfigFile::GetInstance($instance_name, $path);
            $end_time = microtime();
            $object->Debug->AddDebugItem("libraries", array("status" => "Ok" , "name" => $library , "error" => "" , "description" => $path , "time" => $object->Get_Interval($start_time, $end_time, 5)));
            return $lib;
        } else {
            if ($show_error)
                user_error("Can't find library <b>$library</b> config file <b>$path</b>", E_USER_ERROR);
            return null;
        }
    }

    /**
     * Method include specified file
     * @param    Kernel $this    Kernel object
     * @param           string   $fileName File name (relative path from project or package (if $package variable defined) directory, separator - .)
     * @param           string   $package  Package name
     * @access          public
     **/
    static function IncludeFile (&$object, $fileName, $package = ""){
        $start_time = microtime();
        if (strlen($package) == 0 || $package == $object->Package->PackageName) {
            $fileRoot = $object->Package->PackageRoot;
        } else {
            $package_obj = $object->getPackage($package);
            $fileRoot = $package_obj->PackageRoot;
        }
        $fileFullPath = $fileRoot . implode("/", explode(".", $fileName)) . $object->classExt;
        //--if file not found
        if (! file_exists($fileFullPath)) {
            $fileFullPath = $object->ModuleRoot . implode("/", explode(".", $fileName)) . $object->classExt;
            if (! file_exists($fileFullPath)) {
                user_error("Can't include file <b>$fileFullPath</b>", E_USER_ERROR);
                return;
            }
        }
        include ($fileFullPath);
        $object->Debug->AddDebugItem("include", array("status" => "Ok" , "name" => $fileName , "error" => "" , "description" => $fileFullPath , "time" => $object->Get_Interval($start_time, $end_time, 5)));
    }
    /**
     * Method returns relative to the SiteURL value path of currently runnig page
     * if there is prepended language dir, ie en/file.php, en/ will be translated into %s/
     * @param      Kernel  $Kernel    Kernel object
     * @return     string             Relative Page path
     * @access     public
     **/
    static function GetPagePath (&$Kernel){
        $_site_url = $Kernel->Settings->GetItem("Module", "SiteURL");
        $_relative_site_url = substr($_site_url, strpos($_site_url, "/", 8));
        list ($_url, $_tmp) = explode("?", $_SERVER["REQUEST_URI"], 2);
        if (strpos($_url, $_relative_site_url) == 0) {
            $_page_path = substr($_url, strlen($_relative_site_url) - 1);
        } else {
            $_page_path = $_url;
        }
        $_page_path = preg_replace('[\'"]', '', $_page_path);
        return $_page_path;
    }
    /**
     * Method check included package in this site or not
     * @param      Kernel      $Kernel    Kernel object
     * @param      string      $name      Package name
     * @return     boolean
     * @access     public
     **/
    static function isPackageExists (&$Kernel, $name){
        $packages = $Kernel->Settings->GetSection("PACKAGES");
        $packagenames = array_keys($packages);
        if (in_array($name, $packagenames)) {
            return true;
        } else {
            return false;
        }
    }
} //--end of class
?>