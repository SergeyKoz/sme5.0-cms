<?php
 $this->ImportClass("module.web.backendpage", "BackendPage");
 $this->ImportClass("system.io.filesystem", "FileSystem");

 /**Extranet frame Page class
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package  Extranet
	 * @subpackage classes.web
	 * @access public
	 */
 class CleanCachePage extends BackendPage{
	var $ClassName = "CleanCachePage";
	var $Version   = "1.0";

	function ControlOnLoad(){
		FileSystem::recursiveRemoveFiles(CACHE_ROOT);
        die('Cache cleaned');
        parent::ControlOnLoad();
    }

 }

?>