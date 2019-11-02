<?php

 $this->ImportClass("web.menu", "MenuPage", "extranet");



 /** Extranet Top menu Page class
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package  Extranet
	 * @subpackage pages
	 * @access public
	 **/

 class TopmenuPage extends MenuPage {

		var $ClassName = "TopmenuPage";

		var $Version = "1.0";

        var $iniFile="TopMenu_IniFile";


    function ControlOnLoad()   {
	    parent::ControlOnLoad();
	    //get packages top menu definition
	    $this->GetPackagesMenu("extranet.topmenu.ini.php");

	}

 } //-- end of class



?>