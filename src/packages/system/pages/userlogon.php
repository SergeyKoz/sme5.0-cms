<?php
 $this->ImportClass("project", "ProjectPage");
 /** Project logon  page class
   * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
   * @version 1.0
   * @package  Framework
   * @subpackage pages
   * @access public
   **/
    class UserLogonPage extends ProjectPage  {

        var $ClassName="UserLogonPage";
        var $Version="1.0";
        var $XslTemplate = "project_logon";

    function ControlOnLoad()    {
        parent::ControlOnLoad();
        $this->camefrom = $this->Request->ToString("camefrom", "");

    }
  /**
    * Method handles Process event
    * @access public
    **/
   function OnProcess() {

     $this->login = $this->Request->ToString("login", "", 1, 32);
     $this->password = $this->Request->ToString("password", "", 1, 32);
     $this->packagefrom = $this->Request->ToString("frompackage", "");
     $this->former_query = $this->Request->ToString("query", "");

     $UsersTable = new UsersTable($this->Kernel->Connection, $this->Kernel->Settings->GetItem("Authorization", "AuthorizeTable"));
     //die(pr($UsersTable));
     $data = $UsersTable->GetByFields(array($this->Kernel->Settings->GetItem("Authorization", "FLD_login") => $this->login));

      if (!count($data) || $data["active"]==0) {
        $this->AddErrorMessage("UserLogonPage", "INVALID_LOGIN");
        return;
      }

      $_pass = $data[$this->Kernel->Settings->GetItem("Authorization", "FLD_password")];
      if($this->Kernel->Settings->GetItem("Authorization", "FLG_MD5_PASSWORD"))  {
            $this->password = md5($this->password);
      }

      if($_pass != $this->password){
        $this->AddErrorMessage("UserLogonPage", "INVALID_PASSWORD");
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

     if (strlen($this->camefrom))   {
         $this->Response->Redirect($this->Kernel->Settings->GetItem("MODULE","SiteURL").$this->camefrom);
     }   else   {
         $this->Auth->DefaultRedirect("Frontend");
     }
   }
/**
    *  Method draws xml-content of page
    *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
    *  @access  public
    **/
   function XmlControlOnRender(&$xmlWriter) {
       //render page node
     parent::XmlControlOnRender($xmlWriter);
     if(strlen($this->camefrom)){
              $xmlWriter->WriteElementString("camefrom", $this->camefrom);

     }
   }
}   //end of class


?>