<?php
 $this->ImportClass("module.web.modulepage", 'ModulePage');
 $this->ImportClass("module.web.session", 'ControlSession');

 /** Module Logon Page class
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @version 1.0
   * @package  Framework
   * @subpackage classes.module.web
   * @access public
   **/
 class LogonPage extends ModulePage
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

   /**
     * Page mode variable
     * @var string    $PageMode
     **/
//    var $PageMode="USBackend";

     function ControlOnLoad(){
     	parent::ControlOnLoad();

     }

  /**
    * Method handles Process event
    * @access public
    **/
   function OnProcess() {
     $_SESSION = array();
     $this->login = $this->Request->ToString("login", "", 1, 32);
     $this->password = $this->Request->ToString("password", "", 1, 32);
     $this->packagefrom = $this->Request->ToString("FROMPACKAGE", "");
	 $this->pagefrom = $this->Request->ToString("FROMPAGE", "");
     $this->former_query = $this->Request->ToString("FORMER_QUERY", "");
     if (Engine::isPackageExists($Kernel,"system")) $package = "system";
     $UsersTable  = DataFactory::GetStorage($Kernel->Page,"UsersTable","",false,$package);
     $data = $UsersTable->GetByFields(array($this->Kernel->Settings->GetItem("Authorization", "FLD_login") => $this->login));
      if (!count($data) || $data["active"]==0) {

        $this->AddErrorMessage($this->ClassName, "INVALID_LOGIN");
        return;
      }
      $_pass = $data[$this->Kernel->Settings->GetItem("Authorization", "FLD_password")];

      if($_pass != $this->password){
        $this->AddErrorMessage($this->ClassName, "INVALID_PASSWORD");
        return;
      }

     $this->Session = new ControlSession($this, $CookieName);
     $this->Session->Set($this->Kernel->Settings->GetItem("Authorization", "FLD_user_id"), $data[$this->Kernel->Settings->GetItem("Authorization", "FLD_user_id")]);
     session_start();
     $login_var = $this->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Login");
     $password_var = $this->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Password");


	 $GLOBALS[$login_var] = $this->login;
     $GLOBALS[$password_var] = $this->password;
     //$eval_str = '$'.$password_var.'=$this->password;';
     //eval($eval_str);

     if($this->Kernel->Settings->GetItem("Authorization", "FLG_MD5_PASSWORD"))  {
      //$eval_str = '$'.$password_var.'=md5($this->password);';
			$GLOBALS[$password_var] = md5($this->password);
     } else {
		  $GLOBALS[$password_var] = $this->password;
      //$eval_str = '$'.$password_var.'=$this->password;';
     }
     //eval($eval_str);
     session_register($this->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Login"));
     session_register($this->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Password"));
     //after logon
     $this->OnAfterLogon($data);

     $this->AfterlogonRedirect();
   }

 /**
 * Method handles redirect logic after logon
 * @access  public
 **/
 function AfterlogonRedirect(){
     if(strlen($this->pagefrom)){
      if ($this->Kernel->ComponentName=="Frontend")    {
               $this->Response->Redirect($this->Kernel->Settings->GetItem("module","SiteURL").$this->Kernel->Language."/".$this->packagefrom."/".$this->pagefrom.".php?".base64_decode($this->former_query));
      }    else    {
           $this->Response->Redirect("?page=".$this->pagefrom."&package=".$this->packagefrom."&".base64_decode($this->former_query));
      }
     }  else {
       $this->SmartRedirect($this->Kernel->Package->Settings->GetItem("Authorization", "HREF_Default_Redirect"),
       $this->Kernel->Package->Settings->GetItem("Authorization", "FLG_EVAL_HREF_Default_Redirect"));
     }
 }


  /**
  	* After logon event handler (prototype)
    * @param		array		User data array
    * @access private
    **/
  function OnAfterLogon($data)	{
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