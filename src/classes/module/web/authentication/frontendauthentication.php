<?php
/**
  * Frontend authentication  class
  * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
  * @version 1.0
  * @package Framework
  * @subpackage classes.module.web.authentication
  * @access public
  * @abstract
  **/


class FrontendAuthentication extends Authentication {

    /**
      * Page object
      *@var ModulePage    $Page
      **/
    var $Page = null;

    var $ClassName = "FrontendAuthentication";

   /**
     * Set variables when a user logged to system (prototype)
     * @access private
     **/
    function isLogged() {
        //--add registered user role
        //$this->AddRole("REGISTERED_USER");
        parent::isLogged();
    }

    /**
    * Set variables when a user logged to system
    * @access private
    **/
    function isNotLogged(){
        if    (!$this->CheckPageAccess()) $this->AccessDeniedRedirect();
    }

    /**
      *  Method checks if user has right to access a page
      * @param  int   $user_group_id  user group id
      * @access private
      **/
    function CheckPageAccess()  {
       //add anonymous role
       $this->AddRole("ANONYMOUS","frontend");
       return parent::CheckPageAccess($user_group_id);
    }
  /**
     * Method redirect to access denied page of current package (Backend page)
     * @access private
     **/
    function AccessDeniedRedirect() {

         if ($this->Page->Kernel->Package->Settings->HasItem("authorization",$this->Page->PageMode."_HREF_Access_Denied"))     {
          $redirect_url =  sprintf($this->Page->Kernel->Package->Settings->GetItem("authorization",$this->Page->PageMode."_HREF_Access_Denied"),$this->Page->Kernel->Language);
      } else    {
          $redirect_url =  sprintf($this->Page->Kernel->Settings->GetItem("authorization",$this->Page->PageMode."_HREF_Access_Denied_project"),$this->Page->Kernel->Language);
      }

      $request_arr = PageHelper::CreateRequestURI(     $this,
                                                       $this->Page->Kernel->Settings->GetItem("module","SiteURL"),
                                                       $this->Page->Kernel->Settings->GetItem("module","Host"),
                                                       count($this->Page->Kernel->Languages),
                                                       $this->Page->Kernel->Language
                                                      );
      $redirect_url .= "&camefrom=".rawurlencode($request_arr[2]);
      $this->Page->Response->Redirect($redirect_url);
    }

} //--end of class