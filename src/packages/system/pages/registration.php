<?php

   $this->ImportClass("web.profile", "ProfilePage");

  /** CatalogPage page class
   * @author Sergey Kozin <skozin@activemedia.com.ua>
   * @version 1.0
   * @package  Main
   * @access public
   **/
   class RegistrationPage extends ProfilePage  {
       var $ClassName="RegistrationPage";
       var $Version="1.0";
       var $XslTemplate="profileedit";
	}
?>