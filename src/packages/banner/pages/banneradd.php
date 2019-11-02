<?php
	$this->ImportClass("web.editpage", "EditPage");
	/**
	 * Banner edit page
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package	Banner
	 * @subpackage pages
	 * @access public
	 **/
	class BannerAddPage extends EditPage {

		// Class name
		var $ClassName = "BannerAddPage";

		// Class version
		var $Version = "1.0";

		/** Handler  page
		* @var string   $handler
		*/
		var $handler="banneradd";
		/** ListHandler  page
		* @var string   $handler
		*/
		var $listHandler="banneradd";
       /**    XSL template name
		* @var     string     $XslTemplate
		*/
		var $XslTemplate = "itemsedit";

	  /**  Access to this page roles
		* @var     array     $access_role_id
		**/
		var $access_role_id = array("BANNER_ADMINISTRATOR",
		                            "BANNER_PUBLISHER");

		function ControlOnLoad(){
	        parent::ControlOnLoad();
	        $place_id=$this->Request->ToNumber("place_id", 0);
	        if (empty($this->Request->Form) && $place_id>0)
	        	$this->Request->Form["place_id"]=$place_id;
        }

 } //--end of class


?>