<?php
 $this->ImportClass("module.web.modulepage", "ModulePage");

 /** Default  page class
   * @author  Konstantin Matsebora <kmatsebora@activemedia.com.ua>
   * @version 1.0
   * @package  Frameworik
   * @subpackage pages
   * @access public
   **/
    class DefaultPage extends ModulePage  {

        var $ClassName="DefaultPage";
        var $Version="1.0";
        var $id = 0;
				var $PageMode = "Backend";
		}
?>