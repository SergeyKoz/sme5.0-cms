<?php
    $this->ImportClass("module.web.logon", "LogonPage");

 /** Extranet Logon Page class
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @version 1.0
   * @package  Extranet
   * @subpackage pages
   * @access public
   **/
 class ExtranetLogonPage extends LogonPage
 {
    var $ClassName = "ExtranetLogonPage";
    var $Version = "1.0";

  /**  User login
    * @var  string  $login
    **/
    var $login;

  /**  User password
    * @var  string  $password
    **/
    var $password;

  /**
    * Access groups array
    * @var  array   $access_groups
    **/
    var $access_groups = array();


   /** Method executes on page load
     * @access public
     **/
     function ControlOnLoad(){
       $this->camefrom = $this->Request->ToString("FROMPAGE", "");
       $this->packagefrom = $this->Request->ToString("FROMPACKAGE", "");
       $this->former_query = $this->Request->ToString("FORMER_QUERY", "");
     }

  /**
    * Method handles Process event
    * @access public
    **/
   function OnProcess() {
     $this->login = $this->Request->ToString("login", "", 1, 32);
     $this->password = $this->Request->ToString("password", "", 1, 32);
     $this->camefrom = $this->Request->ToString("camefrom", "");
     $this->packagefrom = $this->Request->ToString("frompackage", "");
     $this->former_query = $this->Request->ToString("query", "");

     $UsersTable = new UsersTable($this->Kernel->Connection, $this->Kernel->Settings->GetItem("Authorization", "AuthorizeTable"));
     //die(pr($UsersTable));
     $data = $UsersTable->GetByFields(array($this->Kernel->Settings->GetItem("Authorization", "FLD_login") => $this->login));

      if (!count($data) || $data["active"]==0) {
        $this->AddErrorMessage("LogonPage", "INVALID_LOGIN");
        return;
      }

      $_pass = $data[$this->Kernel->Settings->GetItem("Authorization", "FLD_password")];
      if($this->Kernel->Settings->GetItem("Authorization", "FLG_MD5_PASSWORD"))  {
            $this->password = md5($this->password);
      }

      if($_pass != $this->password){
        $this->AddErrorMessage("LogonPage", "INVALID_PASSWORD");
        return;
      }

      if(!$this->Kernel->Settings->GetItem("Authorization", "FLG_MD5_PASSWORD"))  {
            $this->password = md5($this->password);
      }

     $this->Session = new ControlSession($this, $CookieName);
     session_start();
     $login_var = $this->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Login");
     $password_var = $this->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Password");

     $GLOBALS[$login_var] = $this->login;
     $GLOBALS[$password_var] = $this->password;

     $this->Session->Set($this->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Login"), $this->login);
     $this->Session->Set($this->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Password"), $this->password);
     $this->Session->Set($this->Kernel->Settings->GetItem("Authorization", "SESSION_Var_UserId"), $data[$this->Kernel->Settings->GetItem("Authorization", "FLD_user_id")]);


     if(strlen($this->camefrom)){
       $this->Response->Redirect("?page=".$this->camefrom."&package=".$this->packagefrom."&".$this->former_query);
     }  else {

                $this->Auth->DefaultRedirect("Backend");
                //die();
                $this->Auth->SmartRedirect($this->Kernel->Settings->GetItem("Authorization", "_HREF_Default_Redirect"),
                $this->Kernel->Settings->GetItem("Authorization", "FLG_EVAL_HREF_Default_Redirect"));
     }
   }


  /**
    *  Method draws xml-content of page
    *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
    *  @access  public
    **/
   function XmlControlOnRender(&$xmlWriter) {
   }

   function isNotLogged()  {
   }

}// class

?>