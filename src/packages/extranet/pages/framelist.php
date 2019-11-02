<?php

 $this->ImportClass("module.web.modulepage", "ModulePage");

 /** Backend framelist Page class
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package  Extranet
	 * @subpackage pages
	 * @access public
	 */
 class FramelistPage extends ModulePage{
		var $ClassName  = "FrameListPage";
		var $Version    = "1.0";

	function XmlControlOnRender (&$xmlWriter){
		$argv=$_SERVER["argv"][0];
        if (substr($argv, 0, 8)=="context?")
			$xmlWriter->WriteElementString ("content_url", str_replace(":", "&", substr($argv, 8, strlen($argv)-8)));

   		parent::XmlControlOnRender($xmlWriter);
   	}
 }

?>