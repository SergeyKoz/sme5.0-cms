<?php
 $this->ImportClass("module.web.modulepage", "ModulePage");
 $this->ImportClass("module.web.backendpage", "BackendPage");

 /**Extranet frame Page class
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package  Extranet
	 * @subpackage classes.web
	 * @access public
	 */
 class FramePage extends BackendPage
 {
		var $ClassName = "FramePage";
		var $Version   = "1.0";

		/**
		* Method logs off user
		* @access	public
		*/
		function OnLogOff()    {
                 session_start();
                 session_destroy();
                 $this->Auth->SmartRedirect("?package=extranet&page=logon");
        }
// class
 }

?>