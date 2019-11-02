<?php
 $this->ImportClass("project", "ProjectPage");

 /** Project logoff  page class
   * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
   * @version 1.0
   * @package  Framework
   * @subpackage pages
   * @access public
   **/
    class UserLogoffPage extends ProjectPage  {

        var $ClassName="UserLogoffPage";
        var $Version="1.0";

    function ControlOnLoad()    {
        parent::ControlOnLoad();
        $this->Session->Destroy();
        if($this->Kernel->Settings->HasItem("Authorization", "FLG_USE_COOKIES", 1)){
           $_cookie_login_name = $this->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Login");
           setcookie($_cookie_login_name, "", -3600, "/");
           $_cookie_password_name = $this->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Password");
           setcookie($_cookie_password_name, "", -3600, "/");
           $_cookie_userid_name = $this->Kernel->Settings->GetItem("Authorization", "SESSION_Var_UserId");
           setcookie($_cookie_userid_name, 0, -3600, "/");
        }

        $this->Response->Redirect(sprintf($this->Kernel->Settings->GetItem("AUTHORIZATION","Frontend_HREF_Default_Redirect_project"),$this->Kernel->Language));
    }



}
?>