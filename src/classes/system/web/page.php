<?php
$this->ImportClass("system.web.control", 'Control');
$this->ImportClass("system.web.request", 'Request');
$this->ImportClass("system.web.response", 'Response');
/** Class represents single web page
* @author Sergey Grishko <sgrishko@reaktivate.com>
* @modified Konstantin Matsebora <kmatsebora@activemedia.com.ua>
* @version 1.0
* @package Framework
* @subpackage classes.system.web
* @access public
**/
class ControlPage extends Control {
	// Class information
	var $ClassName = "Page";
	var $Version = "1.1";

	/**
	*  Event handle tag name
	* @var string    $eventTagName
	**/
	var $eventTagName = "event";


	/**
	*  Request object
	* @var Request   $Request
	**/
	var $Request;

	/**
	*  Response object
	* @var Response   $Response
	**/
	var $Response;

	/**
	*  Session object
	* @var ControlSession   $Session
	**/
	var $Session;


	/**
	*  Templates directories array
	* @var array   $TemplatesDir
	**/
	var $TemplatesDir;

	/**
	*  Kernel object
	* @var Kernel   $Kernel
	**/
	var $Kernel;

	/**
	*  Page object
	* @var Page   $Page
	**/
	var $Page;

	/**
	*  Current event
	* @var string   $Event
	**/
	var $Event;

	/** Constructor. Make initialization
	*  @param     string   $name   Name of the control
	*  @access    public
	*/
	function ControlPage($name) {
		Control::Control($name);
		$this->Page = &$this;
		$this->Request = new Request();
		$this->Response = new Response($this);
		$this->Event=$this->Request->Value($this->eventTagName);
		// if no event assigned - assign default event
		if(empty($this->Event)){
			$this->Event = "Default";
		}
		self::$Instance=&$this;
	}

	static function Instance(){
		return self::$Instance;
	}

	/** Method Makes page processing
	*  @param     string   $name   Name of the control
	*  @access    private
	*/
	function processRequest() {
		if($this->Kernel->useAuthentication){
			$this->Auth = AuthenticationFactory::getAuthentication($this);
			$this->Authenticate();
			$this->RewriteSessionVarsFromRequest();
		}
		$this->initRecursive();
		$this->loadRecursive();
		$this->createChildrenRecursive();
		$this->manageEventsRecursive($this->Event);
		$this->Render();
		$this->unloadRecursive();
	}

	/**
	* Method rewrites session variables with values from Request Query, if any exists
	* @access	public
	* @abstract
	**/
	function RewriteSessionVarsFromRequest(){
	}

	/** Method Authenticates user (prototype)
	*  @access    private
	*  @abstract
	*/
	function Authenticate(){
	}

	//end of class
}

function Page(){
	return ControlPage::Instance();
}
?>