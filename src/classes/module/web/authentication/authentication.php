<?php

/**
 * Authentication basic class
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @modified Alexandr Degtiar <adegtiar@activemedia.com.ua>
 * @version 1.0
 * @package Framework
 * @subpackage classes.module.web.authentication
 * @access public
 * @abstract
 **/

class Authentication
{

    var $ClassName = "Authentication";
    /**
     * Page object
     *@var ModulePage    $Page
     **/
    var $Page = null;

    /**
     * User roles array
     *@var array    $userRoles
     **/
    var $userRoles = array();

    /**
     * User information data
     *@var array    $userData
     **/
    var $userData = array();

    /**
     * User ID
     * @var int    $UserId
     **/
    var $UserId;

    /**
     * User group ID
     * @var int    $UserGroupId
     **/
    var $UserGroupId;

    /**
     * User login
     * @var string  $UserLogin
     **/
    var $UserLogin;

    /**
     * User password
     * @var string  $UserPassword
     **/
    var $UserPassword;

    /**
     * User ID field
     * @var string  $User
     **/
    var $UserIdField;

    /**
     * Users table class name
     * @var string  $tableClass
     **/
    var $tableClass;

    /**
     * Users table class package
     * @var string  $tablePackage
     **/
    var $tablePackage = "";

    /**
     * Constructor
     * @param  ModulePage  $page   Page object
     **/
    function Authentication(&$page)
    {
        $this->Page = &$page;
    }

    /**
     * Method imports classes definitions for Users table instance
     * @access   private
     **/
    function ImportUserTableClass()
    {
        // get users table class name
        if ($this->Page->Kernel->Package->Settings->HasItem("authorization", "AuthorizeTableClass")) {
            $this->tableClass = $this->Page->Kernel->Package->Settings->GetItem("authorization", "AuthorizeTableClass");
        }
        else {
            if ($this->Page->Kernel->Settings->HasItem("authorization", "AuthorizeTableClass")) {
                $this->tableClass = $this->Page->Kernel->Settings->GetItem("authorization", "AuthorizeTableClass");
            }
            else {
                $this->tableClass = "UsersTable";
            }
        }
        //get users table package
        if ($this->Page->Kernel->Package->Settings->HasItem("authorization", "AuthorizeTablePackage")) {
            $this->tablePackage = $this->Page->Kernel->Package->Settings->GetItem("authorization", "AuthorizeTablePackage");
        }
        if (Engine::isPackageExists($this->Page->Kernel, "system")) {
            $this->Page->Kernel->ImportClass("data." . strtolower($this->tableClass), $this->tableClass, "system");
        }
        else {

            $this->Page->Kernel->ImportClass("data." . strtolower($this->tableClass), $this->tableClass, $this->tablePackage);
        }

    }

    /**
     * Method creates an instance of Users table
     * @access   private
     **/
    function CreateUserTableInstance()
    {
        $this->Page->UsersTable = new $this->tableClass($this->Page->Kernel->Connection, $this->Page->Kernel->Settings->GetItem("Authorization", "AuthorizeTable"));
    }

    /**
     * Method authenticates a user
     * @access public
     **/
    function Authenticate()
    {
        $this->ImportUserTableClass();
        $this->CreateUserTableInstance();

        $this->Page->Kernel->ImportClass('module.web.session', 'ControlSession');
        $this->Page->Session = new ControlSession($this->Page, null);

        $login = $this->Page->Session->Get($this->Page->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Login"));
        $password = $this->Page->Session->Get($this->Page->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Password")); //Uncomment for user auth
        $user_id = $this->Page->Session->Get($this->Page->Kernel->Settings->GetItem("Authorization", "FLD_user_id"));

        // Getting user account from DB
        if (strlen($login) != 0) {
            $data = $this->Page->UsersTable->GetByFields(array(
                $this->Page->Kernel->Settings->GetItem("Authorization", "FLD_login") => $login
            ));
        }
        // Checking up user password
        if ($this->Page->Kernel->Settings->GetItem("Authorization", "FLG_MD5_PASSWORD")) {
            $_pass = $data[$this->Page->Kernel->Settings->GetItem("Authorization", "FLD_password")]; //Uncomment for user auth
        }
        else {
            $_pass = md5($data[$this->Page->Kernel->Settings->GetItem("Authorization", "FLD_password")]);
        }
        // Calling user state handlers
        if (! count($data) || ($_pass != $password)) {
            //--retrieve page access variables from global scopes
            $this->retrievePageAccess();
            $this->isNotLogged($data);
        }
        else {
            $this->userData = $data;
            if ($this->Page->Kernel->Settings->HasItem("Authorization", "FLG_USE_COOKIES", 1)) {
                $_cookie_login_name = $this->Page->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Login");
                setcookie($_cookie_login_name, $login, null, "/");
                $_cookie_password_name = $this->Page->Kernel->Settings->GetItem("Authorization", "SESSION_Var_Password");
                setcookie($_cookie_password_name, $_pass, null, "/");
                $_cookie_userid_name = $this->Page->Kernel->Settings->GetItem("Authorization", "SESSION_Var_UserId");
                setcookie($_cookie_userid_name, $data[$this->Page->Kernel->Settings->GetItem("Authorization", "FLD_user_id")], null, "/");
            }

            //--set internal class variables (user info)
            $this->setObjectData($data);
            //--get user group types
            if (Engine::isPackageExists($this->Page->Kernel, "system")) {
                $this->userRoles = $this->getUserRoles();
                //--add admin role to
            }
            //-- process logged event
            $this->isLogged($data);
        }
    }

    /**
     * Method retriveve page access variables (access_id,access_user_id,access_role_id) from GLOBAL scope
     * and set it as Page variables (properties)
     * @access private
     **/
    function retrievePageAccess()
    {
        global $_access_id, $_access_user_id, $_access_role_id;
        if (isset($_access_id) && count($this->Page->access_id) == 0)
            $this->Page->access_id = $_access_id;
        if (isset($_access_user_id) && count($this->Page->access_user_id) == 0)
            $this->Page->access_user_id = $_access_user_id;
        if (isset($_access_role_id) && count($this->Page->access_role_id) == 0)
            $this->Page->access_role_id = $_access_role_id;
    }

    /**
     * Method set object variables as UserId,UserGroupId etc. using data about user from database
     * @param  array   $data   User data
     * @access private
     **/
    function setObjectData($data)
    {
        $this->UserIdField = $this->Page->Kernel->Settings->GetItem("Authorization", "FLD_user_id");
        $this->UserId = $data[$this->UserIdField];
        $this->UserGroupId = $data[$this->Page->Kernel->Settings->GetItem("Authorization", "FLD_user_group")];
        $this->UserLogin = $data[$this->Page->Kernel->Settings->GetItem("Authorization", "FLD_login")];
        $this->UserPassword = $data[$this->Page->Kernel->Settings->GetItem("Authorization", "FLD_password")];

    }

    /**
     * Set variables when a user logged to system (prototype)
     * @access private
     * @abstract
     **/
    function isNotLogged()
    {

    }

    /**
     * Set variables when a user logged to system (prototype)
     * @access private
     **/
    function isLogged(){
        if (! $this->CheckPageAccess()) {
            $this->AccessDeniedRedirect();
        }
    }

    /**
     *  Method checks if user has right to access a page
     *  @access private
     *  @return    boolean     true - access granted, false - access denied
     **/
    function CheckPageAccess(){
        // if page have access_id
        if (! empty($this->Page->access_id)) {
            if (! in_array($this->UserGroupId, $this->Page->access_id)) {
                return 0;
            }
        }
        //--if user dont have a  roles  for this authentication type
        if (! array_key_exists(strtoupper($this->Page->PageMode), $this->userRoles)) {
            return 0;
        }
        else {

        }

        //--if defined roles for this page
        if (count($this->Page->access_role_id)) {
            if (! $this->isRoleExists(implode(",", $this->Page->access_role_id))) {
                return 0;
            }
        }

        //--if defined user access id
        if (count($this->Page->access_user_id)) {
            if (! in_array($this->UserId, $this->Page->access_user_id))
                return 0;
        }
        return 1;

    }

    /**
     * Method redirects user to a page, if there's an attempt of access data that dont belong to him (Backend page)
     * @access private
     **/
    function WrongUser(){
        $this->AccessDeniedRedirect();
    }

    /**
     * Method redirect to access denied page of current package (Backend page)
     * @access private
     **/
    function AccessDeniedRedirect(){
        if ($this->Page->Kernel->Package->Settings->HasItem("authorization", $this->Page->PageMode . "_HREF_Access_Denied")) {
            $redirect_url = $this->Page->Kernel->Package->Settings->GetItem("authorization", $this->Page->PageMode . "_HREF_Access_Denied");
        }
        else {
            $redirect_url = $this->Page->Kernel->Settings->GetItem("authorization", $this->Page->PageMode . "_HREF_Access_Denied_project");
        }
        $this->SmartRedirect($redirect_url, $this->Page->Kernel->Settings->GetItem("Authorization", "FLG_EVAL_HREF_Not_Logged"), $_SERVER["QUERY_STRING"]);
    }

    /**
     * Method redirect to access after logon
     * @param   string  $authtype       Authentication type (PageMode)
     * @access private
     **/
    function DefaultRedirect($authtype){
        if (strlen($authtype) == 0)
            $authtype = $this->Page->PageMode;

        if ($this->Page->Kernel->Package->Settings->HasItem("authorization", $authtype . "_HREF_Default_Redirect"))
            $redirect_url = str_replace("%s", $this->Page->Kernel->Language, $this->Page->Kernel->Package->Settings->GetItem("authorization", $authtype . "_HREF_Default_Redirect"));
        else
            $redirect_url = str_replace("%s", $this->Page->Kernel->Language, $this->Page->Kernel->Settings->GetItem("authorization", $authtype . "_HREF_Default_Redirect_project"));

        $this->SmartRedirect($redirect_url, $this->Page->Kernel->Settings->GetItem("Authorization", "FLG_EVAL_HREF_Not_Logged"), $_SERVER["QUERY_STRING"]);
    }

    /**
     * Method redirects user to specified URI regarding on redirect flags
     * @param       string   $redirect_URI       Where to redirect
     * @param       int      $eval_flag         Eval or not URI as part of PHP-code
     * @param       string   $query           Saved query from previous page to restore after redirect
     * @access       public
     */
    function SmartRedirect($redirect_URI, $eval_flag = 0, $query = ""){
        if ($eval_flag) {
            $eval_str = '$redirect=' . $redirect_URI . ';';
            eval($eval_str);
        } else {
            $redirect = $redirect_URI;
        }
        (strlen($this->Page->packagefrom) == 0 ? $packagefrom = $this->Page->Kernel->Package->PackageName : $packagefrom = $this->Page->packagefrom);
        (strlen($this->Page->pagefrom) == 0 ? $pagefrom = $this->Page->Kernel->PageName : $pagefrom = $this->Page->pagefrom);
        if ($packagefrom == "/")
            $packagefrom = "";
        $redirect .= "&FROMPAGE=" . $pagefrom . "&FROMPACKAGE=" . $packagefrom . "&FORMER_QUERY=" . base64_encode($query);
        //set language
        $redirect = sprintf($redirect, $this->Page->Kernel->Language);
        ?>
<script language="JavaScript">
      if (parent.frames.length!=0)  {
         parent.location.href='?package=extranet&page=extranetlogon';
       }  else  {
         location.href='<?=$redirect?>';
       }
      </script>
<?php
        die();
    }

    /**
     * Method get user roles for current user
     * @return array                     user roles array
     * @access public
     **/
    function getUserRoles(){
        $roles = array();
        $storage = DataFactory::GetStorage($this->Page, "UserRolesTable", "", true, "system");
        //get user_roles from configuration file
        $role_list = $this->Page->Kernel->Settings->GetSection("roles");
        //--get user roles from database
        $list = $storage->GetList(array(
            $this->UserIdField => $this->UserId
        ));
        if ($list->RecordCount != 0) {
            while ($role = $list->Read()) {
                $role_names = array_keys($role_list);
                $pos = array_search($role["role_name"], $role_names);
                //--if role found in roles
                if ($pos !== false) {
                    list ($_tmp, $authType) = preg_split("/[|]/", $role_list[$role_names[$pos]]);
                    $role_auth = explode(",", $authType);
                    foreach ($role_auth as $i => $auth) {
                        $roles[strtoupper($auth)][] = $role["role_name"];
                    }
                }

            }
        }
        return $roles;
    }

    /**
     * Method add role to user
     * @param  string  $role       role name
     * @param  string  $authtype   Authentication type (= Page->PageMode)
     * @access public
     **/
    function AddRole($role, $authtype = ""){
        if (strlen($authtype) == 0)
            $authtype = $this->Page->PageMode;
        $this->userRoles[strtoupper($authtype)][] = $role;
    }

    /**
     * Method check if role(s) exists in userRoles array
     * @param  string  $role       role(s), comma separated. Examples: ADMIN,CONTENT_MANAGER
     * @param  string  $authtype   Authentication type (= Page->PageMode)
     * @param  boolean $reduction  If is true then search only this roles, otherwise add ADMIN (superuser) role
     * @return boolean             True if role(s) exists in user roles,otherwise - false
     * @access public
     **/
    function isRoleExists($roles, $authtype = "", $reduction = false){
        if (isset($this->userRoles["BACKEND"])) {
            if (! $reduction && in_array("ADMIN", $this->userRoles["BACKEND"])) {
                return true;
            }
        }
        if (strlen($authtype) == 0) {
            $authtype = $this->Page->PageMode;
        }
        $role_arr = explode(",", $roles);
        if (! is_array($this->userRoles[strtoupper($authtype)])) {
            return false;
        }
        for ($i = 0; $i < count($role_arr); $i ++) {
            if (in_array($role_arr[$i], $this->userRoles[strtoupper($authtype)])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Method check if user is superuser (ADMIN)
     * @return boolean      if  superuser - true, otherwise - false;
     **/
    function isSuperUser(){
        if ($this->isRoleExists("ADMIN", "Backend")) {
            return true;
        }
        return false;
    }
} //--end of class
?>