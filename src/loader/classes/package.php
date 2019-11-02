<?php
/** Package class
* @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
* @version 1.0
* @package  Loader
* @subpackage classes
* @access public
*/

class Package extends Component  {
	/**
	* Class name
	* @var  string  $ClassName
	**/
	var $ClassName = "Package";

	/**
	* Class version
	* @var  string  $Version
	**/
	var $Version = "1.0";
	
	/**
	* Package configuration   object
	* @var	ConfigFile	$Settings
	**/
	var $Settings;

	/**
	* resources root directory of project package
	* @var	string	$ResourcesRoot
	**/
	var $ResourcesRoot;

	/**
	* Cache directory
	* @var	string	$CacheRoot
	**/
	var $CacheRoot = "";

	/**
	* Resources root directories array of  package (project and framework package)
	* @var	string	$ResourcesRoot
	**/
	var $ResourceDirs = array();

	/**
	* Template directories array
	* @var	array	$TemplatesDirs
	**/
	var $TemplateDirs=array();

	/**
	* Class directories array
	* @var	array	$ClassesDirs
	**/
	var $ClassesDirs=array();

	/**
	*	Pages directories array
	* @var	array	 $PagesDirs
	**/
	var $PagesDirs=array();
	
	/**
	* Package path
	* @var	string	$PackageRoot
	**/	
	var $PackageRoot="";
	
	/**
	* Package title
	* @var	string	$PackageTitle
	**/	
	var $PackageTitle="";
	
	/**
	* Package name
	* @var	string	$PackageURL
	**/
	
	var $PackageName="";
	/**
	* Package URL
	* @var string		$PackageURL
	**/
	
	var $PackageURL="";
	/**
	* Default page name
	* @var	string	$DefaultPage
	**/
	
	var $DefaultPage="default";

	/**
	* Class constructor
	* @param  ConfigFile  $settings     package configuration
	*/
	function Package($settings)	{
		$this->Settings = $settings;

		//get resources directories
		$this->ResourceDirs  =  $this->Settings->GetItem("package","ResourcePath");

		//set  directories
		$this->setDirs();

		//set variables
		$this->setVariables();
		//set kernel variables from default section
		if ($this->Settings->HasSection("default")){
			$this->Settings->fromSectionToVariables($this,"default");
		}
	}

	/**
	* Method set directories   pathes
	* @access private
	*/
	function setDirs(){
		if (!is_array($this->ResourceDirs)){
			$this->ResourceDirs = array($this->ResourceDirs);
		}

		//get resources root
		$this->ResourcesRoot = $this->ResourceDirs[0];

		//Set template directories array
		$this->TemplateDirs  =  (is_array($this->Settings->GetItem("path","TemplatePath"))?$this->Settings->GetItem("path","TemplatePath"):array($this->Settings->GetItem("path","TemplatePath")));

		//Set classes directories array
		$this->ClassesDirs  =  (is_array($this->Settings->GetItem("path","ClassPath"))?$this->Settings->GetItem("path","ClassPath"):array($this->Settings->GetItem("path","ClassPath")));

		//Set pages directories array
		$this->PagesDirs  =  (is_array($this->Settings->GetItem("path","PagePath"))?$this->Settings->GetItem("path","PagePath"):array($this->Settings->GetItem("path","PagePath")));
	}
	
	/**
	* Method set class variables
	* @access private
	**/
	function setVariables()	{
		$this->PackageRoot  = $this->Settings->GetItem("package", "PackagePath");
		$this->PackageURL   = $this->Settings->GetItem("package", "PackageURL");
		$this->PackageTitle = $this->Settings->GetItem("package", "PackageTitle");
		$this->PackageName  = $this->Settings->GetItem("package", "PackageName");
		if ($this->Settings->HasItem("package","DefaultPage")){
			$this->DefaultPage  =  $this->Settings->GetItem("package", $this->Settings->GetItem("package", "ComponentName")."_DefaultPage");
		}
		$this->CacheRoot = $this->Settings->GetItem("package","ModulePath")."/cache/".$this->PackageName."/";
	}

	/**
	* Method render "package" node
	* @param    object $xmlWriter    Instance ow xmlWriter
	* @access private
	**/
	function renderObjectNode($xmlWriter){
		$xmlWriter->WriteStartElement("package");
		$xmlWriter->WriteAttributeString("url",$this->PackageURL);
		$xmlWriter->WriteAttributeString("path",$this->PackageRoot);
		$xmlWriter->WriteAttributeString("name",$this->PackageName);
		$xmlWriter->WriteAttributeString("title",$this->PackageTitle);
		$xmlWriter->WriteEndElement("package");
	}

	function setDefaultPage(){
	}
} //--end of class
?>