<?php
$this->ImportClass("web.editpage", "EditPage");
/**
 * User and user group edit page
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package	System
 * @subpackage pages
 * @access public
 **/
class UsersEditPage extends EditPage
{
    // Class name
    var $ClassName = "UsersEditPage";
    // Class version
    var $Version = "1.0";
    /** Handler  page
     * @var string   $handler
     */
    var $handler = "usersedit";
    /** ListHandler  page
     * @var string   $handler
     */
    var $listHandler = "userslist";
    /**    XSL template name
     * @var     string     $XslTemplate
     */
    var $XslTemplate = "itemsedit";
    /**  Access to this page roles
     * @var     array     $access_role_id
     **/
    var $access_role_id = array("ADMIN");
    /**
     *  BeforeCreateEditControl event handler
     *	 @access private
     **/
    function OnBeforeCreateEditControl (){
        parent::OnBeforeCreateEditControl();
        if ($this->library_ID == "user_accounts") {
            $this->setRolesSelect();
            if ($this->Kernel->Settings->GetItem("Authorization", "FLG_MD5_PASSWORD")) {
                $this->_data[$this->Page->Kernel->Settings->GetItem("Authorization", "FLD_password")] = "";
            }
        }
    }
    /**
     * Edit event handler
     * access  private
     **/
    function OnEditItem (){
        $this->getUserRoles();
        parent::OnEditItem();
    }
    /**
     * Method get user  roles from database and set select value field
     * @access private
     **/
    function getUserRoles (){
        $roleStorage = DataFactory::GetStorage($this, "UserRolesTable");
        $list = $roleStorage->GetList(array($this->Auth->UserIdField => $this->item_id));
        if ($list->RecordCount != 0) {
            while ($role = $list->Read()) {
                $this->user_roles[] = $role["role_name"];
            }
        }
    }
    /**
     * Method set roles select
     * @access private
     **/
    function setRolesSelect (){
        $roles = $this->Kernel->Settings->GetSection("ROLES");
        if ($roles) {
            $fieldIndex = null;
            foreach ($this->form_fields['main'] as $key => $val) {
                if ($val['field_name'] == 'role_id') {
                    $fieldIndex = $key;
                    break;
                }
            }
            if (!$fieldIndex) {
                return ;
            }
            $this->form_fields["main"][$fieldIndex]["options"] = array();
            foreach ($roles as $role => $description) {
                list ($title, $authtype) = preg_split("/[|]/", $description);
                $this->form_fields["main"][$fieldIndex]["options"][] = array(//"caption" => $title." (".$role.",".$authtype.")",
                "caption" => $role . ", " . $authtype , "value" => $role);
            }
        }
        //--if user edit started
        if (count($this->user_roles)) {
            $this->_data["role_id"] = $this->user_roles;
        }
    }
    /**
     * After edit event handler
     * access  private
     **/
    function OnAfterEdit (){
        $this->updateUserRoles();
    }
    /**
     * After add event handler
     * access  private
     **/
    function OnAfterAdd (){
        $this->updateUserRoles();
    }
    /**
     * Method update user roles in database
     * @access private
     **/
    function updateUserRoles (){
        $role_id = $this->Request->Value("role_id");
        $roleStorage = DataFactory::GetStorage($this, "UserRolesTable");
        //--delete old roles
        $delete_arr = array($this->Auth->UserIdField => $this->_data[$this->Auth->UserIdField]);
        $roleStorage->Delete($delete_arr);
        if (isset($role_id)) { //--insert new roles
            for ($i = 0; $i < count($role_id); $i ++) {
                $insert_arr = array($this->Auth->UserIdField => $this->_data[$this->Auth->UserIdField] , "role_name" => $role_id[$i]);
                $roleStorage->Insert($insert_arr);
            }
        }
    }

    function OnBeforeEdit (){
        parent::OnBeforeEdit();
        $this->updateMD5Password();
    }

    function OnBeforeAdd (){
        parent::OnBeforeAdd();
        $this->updateMD5Password();
    }

    function updateMD5Password (){
        if ($this->Kernel->Settings->GetItem("Authorization", "FLG_MD5_PASSWORD")) {
            $pass_fld = $this->Page->Kernel->Settings->GetItem("Authorization", "FLD_password");
            if ($this->_data[$pass_fld] == "")
                unset($this->_data[$pass_fld]);
            else
                $this->_data[$pass_fld] = md5($this->_data[$pass_fld]);
        }
    }
} //--end of class
?>