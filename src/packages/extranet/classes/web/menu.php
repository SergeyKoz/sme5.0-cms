<?php
$this->ImportClass("web.frame", "FramePage", "extranet");
$this->ImportClass("web.configmenu", "ConfigMenuControl", "extranet");
/** Extranet Menu Page class
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package  Extranet
 * @subpackage classes.web
 * @access public
 */
class MenuPage extends FramePage
{
    var $ClassName = "MenuPage";
    var $Version = "1.0";
    /**
     *  Ini-file variable name in section Main of package INI-file
     * @var  string    $iniFile
     **/
    var $iniFile = "Menu_IniFile";
    /**
     *  Menu configuration object
     * @var  ConfigFile    $Menu
     **/
    var $Menu;
    /**
     * OnLoad event handler method
     **/
    function ControlOnLoad (){
        parent::ControlOnLoad();
        $this->Menu = &ConfigFile::GetInstance($this->iniFile, $this->Kernel->Package->Settings->GetItem("MAIN", $this->iniFile));
        if (!is_object($this->Menu)) {
            $this->Menu = new ConfigFile();
        }
    }

    function GetPackagesMenu($filename){
     	ConfigMenuControl::GetPackagesMenu($this, $this->Menu, $filename);
    }

    /**
     *  Method builds rows of a list
     * @param  XMLWriter   $xmlWriter  instance of XMLWriter
     * @access private
     **/

    function XmlControlOnRender (&$xmlWriter){
    	ConfigMenuControl::RenderPackagesMenu($this->Kernel, $this->Menu, $this->Auth, $xmlWriter);
    	parent::XmlControlOnRender($xmlWriter);
    }

    // class
}
?>