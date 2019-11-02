<?php
	$this->ImportClass('module.web.modulepage', 'ModulePage');
	/**
	 * Base class for all backend pages.
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.module.web
	 * @access public
	 **/
	class BackendPage extends ModulePage {
		// Class name
		var $ClassName = "BackendPage";
		// Class version
		var $Version = "1.0";
		// Array for forms validation
		var $formData = array();
		// list of user_id's who are alowed to access page
		var $access_id = array();
        /**
          * Page mode variable
          * @var string    $PageMode
          **/
        var $PageMode="Backend";

//end of class
}

?>