<?php
 $this->ImportClass("web.menu", "MenuPage", "extranet");

 /** Extranet left menu Page class
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package  Extranet
	 * @subpackage pages
	 * @access public
	 */
 class LeftmenuPage extends MenuPage
 {
		var $ClassName = "LeftmenuPage";

		var $Version = "1.0";

		var $iniFile="LeftMenu_IniFile";

	function ControlOnLoad()   {
	    parent::ControlOnLoad();
	    //get packages left menu definition
	    $this->GetPackagesMenu("extranet.leftmenu.ini.php");
	}
	// class
 }

?>