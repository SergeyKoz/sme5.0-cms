<?php

define('SME_VERSION', '5.0');
define("LOADER_STATE_NULL", 0);
define("LOADER_STATE_PAGE_LOADED", 2);

/** Loader  class (factory Page classes and Kernel)
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package Loader
 * @subpackage classes
 * @access public
 **/

class Loader {

    /**
     *  Kernel instance
     * @var    Kernel  $Kernel
     **/
    var $Kernel = null;

    /**
     *  Page instance
     * @var    Page  $Kernel
     **/
    var $Page = null;

    /**
     *  Start engine process time
     * @var    string  $start_time
     **/
    var $start_time;

    /**
     *  End engine process time
     * @var    string  $end_time
     **/
    var $send_time;

    /**
     *  Request uri (full url with parameters)
     * @var    string  $uri
     **/
    var $uri = "";

    /**
     *  Loader state
     * @var    int  $state
     **/
    var $state = LOADER_STATE_NULL;

    /**
     * Initialize engine (include files)
     * @param    string    $type   Engine type
     * @access    public
     * @static
     **/
    function Init(){
        // preliminary session start
        if(isset($_GET["auth_sid"])){
            $auth_sid = $_GET["auth_sid"];
            session_id($auth_sid);
        } 
        
        session_start();
        $this->start_time = microtime();

        if (get_magic_quotes_gpc()) {
            $_GET = $this->stripslashes_r($_GET);
            $_POST = $this->stripslashes_r($_POST);
            $_COOKIE = $this->stripslashes_r($_COOKIE);
        }

	    include_once (LOADER_ROOT . "classes/enginecache.php");

		if (EngineCache::CheckCachedInit()){

	        //include global functions
	        include_once (LOADER_ROOT . "modules/functions.php");

	        //include error class
	        if (! class_exists("Error")){
	            include_once (LOADER_ROOT . "classes/error.php");
			}

	        //include component class
	        if (! class_exists("Component")){
	            include_once (LOADER_ROOT . "classes/component.php");
			}

	        //include configfile helper class
	        if (! class_exists("ConfigFileHelper")){
	            include_once (LOADER_ROOT . "classes/configfilehelper.php");
			}

	        //include configfile reader class
	        if (! class_exists("ConfigFile")){
	            include_once (LOADER_ROOT . "classes/configfile.php");
			}

	        //include data dispatcher class
	        include_once (LOADER_ROOT . "classes/datadispatcher.php");

	        //include path class
	        include_once (LOADER_ROOT . "classes/path.php");
        }
        DataDispatcher::Init();

    }

    function stripslashes_r($value){
        $value = is_array($value) ? array_map(array(&$this, 'stripslashes_r'), $value) : stripslashes($value);
        return $value;
    }

    /**
     * Method include engine and kernel object using engine type
     * @param    string    $type       Engine type
     * @param    string    $component  Project component
     * @access   public
     * @static
     **/
    function Load($type = "default", $component = ""){
		if (EngineCache::CheckCachedInit(true)){
	        //include debug class
	        include_once (LOADER_ROOT . "classes/debug.php");

	        //include package class
	        include_once (LOADER_ROOT . "classes/package.php");

	        //include kernel class
	        include_once (LOADER_ROOT . "classes/kernel.php");

	        //include engine class
	        include_once (LOADER_ROOT . "classes/engine.php");
        }
        $this->Kernel = new Kernel(INIFILE_ROOT, $component);

        //Get Page  object
        $this->Page = $this->Kernel->getPage();

        //--Set pointer to Kernel
        $this->Page->setObjectVariable("Kernel", $this->Kernel);

        $this->state = LOADER_STATE_PAGE_LOADED;
    }

    function Run(){
        //Process request
        $this->Page->ProcessRequest();
        $this->end_time = microtime();
    }

    function UnLoad(){
        if ($this->Kernel->WriteLogs)
            $this->Kernel->Close_Log();

//        echo "<!-- Total processing time: " . Component::Get_Interval($this->start_time, $this->end_time) . " sec -->\n";
//        echo "<!-- Use SMEngine v2.4.2, (c) Activemedia LLC. 2005  -->\n";
        unset($this->Page);
        unset($this->Kernel);
    }

} //--end of class


?>