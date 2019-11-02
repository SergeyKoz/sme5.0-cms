<?php
 $this->ImportClass("module.web.backendpage", "BackendPage");
 /** Session timeout page
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package  Extranet
	 * @subpackage pages
	 * @access public
	 */

 class SessionTimeoutPage extends BackendPage
 {
		var $ClassName = "SessionTimeoutPage";
		var $Version = "1.0";

	/**
	  * Method called when user is not logged to extranet
	  */
   	function isNotLogged()	{
   	}
   /**
    *  Method draws xml-content of control
    *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
    *  @access  public
    */
    function XmlControlOnRender(&$xmlWriter) {
    }

}// class

?>