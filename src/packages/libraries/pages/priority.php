<?php
	$this->ImportClass("module.web.backendpage", "BackendPage");
	/**
	 * Page  add to all tables of database priority field and set it values eq key field values
	 * manipulate priorities
	 * @author Konstantin Matsebora
	 * @version 1.0
	 * @package	Libraries
	 * @subpackage pages
	 * @access public
	 **/
	class PriorityPage extends BackendPage {
		// Class name
		var $ClassName = "PriorityPage";
		// Class version
		var $Version = "1.0";
		  /** Priority field name
			* @var     string     $priorty_field
			**/
		var $priority_field = "_priority";

		/** Project tables prefix
			* @var     string     $tables_prefix
			**/
		var $tables_prefix = "";

		/**
			* Method add priority field to all tables, event handler
			* @access private
			**/
		function OnAddPriorityField()	{

			//--get all table names
			$tables = $this->GetAllTables();

			if ($tables !== false)   {
			    //-- add column definition
			   for ($i=0; $i<count($tables); $i++)   {
			       $SQL = sprintf("ALTER TABLE `%s` ADD `%s` INT DEFAULT '0' NOT NULL",
			                      $tables[$i],$this->priority_field);
			       $this->Kernel->Connection->ExecuteNonQuery($SQL);
			   }
			}
		}

		  /**
			* Method set priority field values eq key field values
			* @access private
			**/
		function OnSetPriorityField() {
		    //--get all table names
			$tables = $this->GetAllTables();
			if ($tables !== false)   {

			   for ($i=0; $i<count($tables); $i++)   {
			       $SQL = sprintf("DESCRIBE %s", $tables[$i]);
	               $reader = $this->Kernel->Connection->ExecuteReader($SQL);
	               //--search for auto-increment field
	               while ($field = $reader->Read())    {
	                   if ($field["Extra"] == "auto_increment")    {
	                       $key_field = $field["Field"];
	                       $reader->Close();

	                   }
	               }

	               //--update priority
	               $SQL = sprintf(" UPDATE %s SET %s = %s",$tables[$i],$this->priority_field,$key_field);
	               $this->Kernel->Connection->ExecuteNonQuery($SQL);
			   }
			}
		}

	 /**
	   * Method delete all priority fields from all tables of project, event handler
	   * @access private
	   **/
        function OnDeletePriorityField()    {
            //--get all table names
			$tables = $this->GetAllTables();
			if ($tables !== false)   {
			    for ($i = 0; $i < count($tables); $i++)  {
			     $SQL =  sprintf(" ALTER TABLE %s DROP `%s`",$tables[$i],$this->priority_field);
			     $this->Kernel->Connection->ExecuteNonQuery($SQL);
                }
			}
        }

        /**
          * Method get all table names of project
          * @return mixed           array of tables, or false if not anyone tables exists
          * @access private
          **/
		function GetAllTables()	{
		    //--get table prefix
		    if ($this->Kernel->Settings->HasItem("Database","TablesPrefix"))  {
		        $this->tables_prefix =  $this->Kernel->Settings->GetItem("Database","TablesPrefix");
		    }

		    $tables = array();
 			$SQL = " SHOW TABLES ";
			$list = $this->Kernel->Connection->ExecuteReader($SQL);
			if ($list->RecordCount != 0)    {
			    while ($table = $list->Read())   {
			      $field = array_pop($table);
			      if (strlen($this->tables_prefix) == 0 || strpos($field,$this->tables_prefix) !==false)
			         $tables[] = $field;
			    }
			}    else {
			     return false;
			}
			return $tables;
		}

}
?>
