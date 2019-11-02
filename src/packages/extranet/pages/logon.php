<?php
 $this->ImportClass("module.web.backendpage", "BackendPage");
 $this->ImportClass("module.web.session", "ControlSession");
 $this->ImportClass("data.userstable", "UsersTable");

 /** Extranet Logon Page class
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @version 1.0
   * @package  Extranet
   * @subpackage pages
   * @access public
   **/
 class LogonPage extends BackendPage
 {
    var $ClassName = "LogonPage";
    var $Version = "1.0";

  /**  User login
    * @var  string  $login
    **/
    var $login;

  /**  User password
    * @var  string  $password
    **/
    var $password;

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
     $_SESSION = array();
     $this->login = $this->Request->ToString("login", "", 1, 32);
     $this->password = $this->Request->ToString("password", "", 1, 32);
     $this->camefrom = $this->Request->ToString("camefrom", "");
     $this->packagefrom = $this->Request->ToString("frompackage", "");
     $this->former_query = $this->Request->ToString("query", "");

     $UsersTable = new UsersTable($this->Kernel->Connection, $this->Kernel->Settings->GetItem("Authorization", "AuthorizeTable"));
     $data = $UsersTable->GetByFields(array($this->Kernel->Settings->GetItem("Authorization", "FLD_login") => $this->login));
      if (!count($data) || $data["active"]==0) {

        $this->AddErrorMessage("LogonPage", "INVALID_LOGIN");
        return;
      }
      $_pass = $data[$this->Kernel->Settings->GetItem("Authorization", "FLD_password")];

      if($_pass != $this->password){
        $this->AddErrorMessage("LogonPage", "INVALID_PASSWORD");
        return;
      }

     $this->Session = new ControlSession($this, $CookieName);
     $this->Session->Set($this->Kernel->Settings->GetItem("Authorization", "FLD_user_id"), $data[$this->Kernel->Settings->GetItem("Authorization", "FLD_user_id")]);
     session_start();
     $login_var = $this->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Login");
     $password_var = $this->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Password");

     global $$login_var;
     global $$password_var;
     $$login_var= $this->login;
     $$password_var=$this->password;

     if($this->Kernel->Settings->GetItem("Authorization", "FLG_MD5_PASSWORD"))  {
            $$password_var = md5($this->password);
     } else {
          $$password_var = $this->password;
     }

     $_SESSION[$this->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Login")] = $$login_var;
     $_SESSION[$this->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Password")] = $$password_var;
     if(strlen($this->camefrom)){
       $this->Response->Redirect("?page=".$this->camefrom."&package=".$this->packagefrom."&".$this->former_query);
     }  else {
       $this->Auth->SmartRedirect($this->Kernel->Package->Settings->GetItem("Authorization", "HREF_Default_Redirect"),
       $this->Kernel->Package->Settings->GetItem("Authorization", "FLG_EVAL_HREF_Default_Redirect"));
     }
   }
  /**
    * Method overrides inherited Authenticate method to allow notauthorized users to see this page
    *  @access  public
    **/
    function Authenticate() {
    }

  /**
    *  Method draws xml-content of page
    *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
    *  @access  public
    **/
   function XmlControlOnRender(&$xmlWriter) {
     if(strlen($this->camefrom)){
      $xmlWriter->WriteElementString("camefrom", $this->camefrom);
      $xmlWriter->WriteElementString("query", $this->former_query);
     }
   }

}// class

?>