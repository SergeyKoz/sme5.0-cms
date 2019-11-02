<?php
/**
  * Backend authentication  class
  * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
  * @version 1.0
  * @package Framework
  * @subpackage classes.module.web.authentication
  * @access public
  * @abstract
  **/


class BackendAuthentication extends Authentication {

    /**
      * Page object
      *@var ModulePage    $Page
      **/
    var $Page = null;

    var $ClassName = "BackendAuthentication";

  /**
    * Set variables when a user logged to system
    * @access private
    **/
    function isNotLogged()  {
          global $HTTP_SERVER_VARS;
          if ($this->Page->Kernel->Package->Settings->HasItem("AUTHORIZATION", $this->Page->PageMode."_HREF_Not_Logged"))   {
              $redirect_url = $this->Page->Kernel->Package->Settings->GetItem("AUTHORIZATION", $this->Page->PageMode."_HREF_Not_Logged");
          }  else   {
              $redirect_url = $this->Page->Kernel->Settings->GetItem("AUTHORIZATION", $this->Page->PageMode."_HREF_Not_Logged_project");
          }
          $this->SmartRedirect($redirect_url, $this->Page->Kernel->Settings->GetItem("Authorization", "FLG_EVAL_HREF_Not_Logged"),
                               $_SERVER["QUERY_STRING"]);
    }

  /**
    * Set variables when a user logged to system (prototype)
    * @access private
    **/
    function isLogged() {
        parent::isLogged();
    }

    /**
      *  Method checks if user has right to access a page
      * @param  int   $user_group_id  user group id
      * @access private
      **/
    function CheckPageAccess()  {
      return parent::CheckPageAccess();
    }

} //--end of class