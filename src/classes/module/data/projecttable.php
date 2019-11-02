<?php
$this->ImportClass("system.data.abstracttable", "AbstractTable");
$this->ImportClass("system.data.datamanipulator", "DataManipulator");

/** Project (module) table
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package Framework
 * @subpackage  classes.module.data
 * @access public
 */
class ProjectTable extends AbstractTable
{
    /**
     * Class name
     * @var string $ClassName
     **/
    var $ClassName = "ProjectTable";

    /**
     * Class version
     * @var string $Version
     **/
    var $Version = "1.0";

    /**
     * Class constructor
     * @param  MySqlConnection   $Connection Connection object
     * @param  string    $TableName  Table name
     * @access   public
     */
    function ProjectTable(&$Connection, $TableName){
        parent::AbstractTable($Connection, $TableName);
        $this->UsersStack=DataDispatcher::Get("UsersStack");
    }

    /**
     * Method prepare column definitions
     * @access    private
     **/
    function prepareColumns()
    {
        $this->columns[] = array(
            "name" => "_modified_by",
            "type" => DB_COLUMN_NUMERIC
        );
        $this->columns[] = array(
            "name" => "_created_by",
            "type" => DB_COLUMN_NUMERIC
        );
        $this->columns[] = array(
            "name" => "_priority",
            "type" => DB_COLUMN_NUMERIC
        );
        $this->columns[] = array(
            "name" => "active",
            "type" => DB_COLUMN_NUMERIC,
            "notnull" => 0,
            "dtype" => "int"
        );
        DataManipulator::prepareMultilangColumns($this->columns, $this->Connection->Kernel->Languages);
    }

    /**
     * Method executes some actions before insert (prototype)
     * @param       array      $data   Data to process
     * @access      public
     **/
    function OnBeforeInsert(&$data){
    	$data["_created_by"] = Page()->Auth->UserId;
        $data["_modified_by"] = Page()->Auth->UserId;
    }

    /**
     * Method executes some actions before update (prototype)
     * @param       array      $data   Data to process
     * @access      public
     **/
    function OnBeforeUpdate(&$data){
        $Kernel = $this->Connection->Kernel;
        //$data["_lastmodified"] = date("YmdHis", time());
        $data["_modified_by"] = Page()->Auth->UserId;
    }

    /**
     * Method executes some actions after getting data from DB (prototype)
     * @param       array      $data   Data to process
     * @access      public
     **/
    function OnAfterGet(&$data, &$result){

        $Kernel = &$this->Connection->Kernel;

        if (class_exists("ControlPage")){
        	$Auth=Page()->Auth;
        }

        if (empty($result) || !isset($Auth)){
        	return;
        }
        $usersStorage = DataFactory::GetStorage($Kernel->Page, $Auth->tableClass, "", false, $Auth->tablePackage);

        $user_keyfield = $Kernel->Settings->GetItem("authorization", "FLD_user_id");
        $login_keyfield = $Kernel->Settings->GetItem("authorization", "FLD_login");

        //--get user record (owner)
        if ($this->UsersStack[$result["_modified_by"]]!=""){
            $result["_ownername"] = $this->UsersStack[$result["_modified_by"]];
        } else {
	        if ($Auth->UserId==$result["_modified_by"]){
	            $result["_ownername"]=$Auth->userData[$login_keyfield];
	            $this->UsersStack[$Auth->UserId]=$result["_ownername"];
	            DataDispatcher::Set("UsersStack", $this->UsersStack);
	        }else{
		        $list = $usersStorage->GetList(array($user_keyfield => intval($result["_modified_by"])));
		        if (! $list->EOF) {
		            $data = $list->Read();
		            if ($data){
		                $result["_ownername"] = $data[$login_keyfield];
		                $this->UsersStack[$result["_modified_by"]]=$result["_ownername"];
		                DataDispatcher::Set("UsersStack", $this->UsersStack);
		            }else{
		                $result["_ownername"] = "unknown";
		          	}
		        }
	        }
        }

        //--get user record (creator)
        if ($this->UsersStack[$result["_created_by"]]!=""){
            $result["_creatername"] = $this->UsersStack[$result["_created_by"]];
            $this->UsersStack[$Auth->UserId]=$result["_creatername"];
        } else {
	        if ($Auth->UserId==$result["_created_by"]){
	            $result["_creatername"]=$Auth->userData[$login_keyfield];
	            $this->UsersStack[$Auth->UserId]=$result["_creatername"];
	            DataDispatcher::Set("UsersStack", $this->UsersStack);
	        }else{
		        $list = $usersStorage->GetList(array($user_keyfield => intval($result["_created_by"])));
		        if (! $list->EOF) {
		            $data = $list->Read();
		            if ($data){
		                $result["_creatername"] = $data[$login_keyfield];
		                $this->UsersStack[$result["_created_by"]]=$result["_creatername"];
		                DataDispatcher::Set("UsersStack", $this->UsersStack);
		            } else {
		                $result["_creatername"] = "unknown";
		          	}
		        }
	        }
	    }
        //set date
        $result["_lastmodified"] = $this->dateconv($result["_lastmodified"], 1);
    }

    function GetCreatedByUser($user_id){
    	$res="";
    	if ($user_id>0){
    		if ($this->UsersStack[$user_id]!=""){
                $res=$this->UsersStack[$user_id];
    		} else {
                $SQL=sprintf("SELECT user_login AS u FROM %s WHERE user_id=%d", $this->GetTable("UsersTable"), $user_id);
                $record=$this->Connection->ExecuteScalar($SQL);
                if ($record["u"]!=""){
                	$res=$record["u"];
                	$this->UsersStack[$user_id]=$record["u"];
		            DataDispatcher::Set("UsersStack", $this->UsersStack);
                }
    		}
        }
        return $res;
    }

//end of class
}

?>