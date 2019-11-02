<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

class GuestbookMessagesTable extends ProjectTable
{
  var $ClassName = "GuestbookMessagesTable";
  var $Version = "1.0";

/**
 * Class constructor
 * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
 * @param  MySqlConnection   $Connection Connection object
 * @param  string    $TableName    Table name
 * @access public
 */
	function GuestbookMessagesTable(&$Connection, $TableName) {
	    ProjectTable::ProjectTable($Connection, $TableName);
	}

	function prepareColumns()
	{
		$this->columns[] = array("name" => "message_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
		$this->columns[] = array("name" => "message", "type" => DB_COLUMN_STRING,"length"=>4096,"notnull"=>0,"dtype"=>"string");
		$this->columns[] = array("name" => "email", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0,"dtype"=>"string");
		$this->columns[] = array("name" => "signature", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0,"dtype"=>"string");
		$this->columns[] = array("name" => "comment", "type" => DB_COLUMN_STRING,"length"=>4096,"notnull"=>0,"dtype"=>"string");
		$this->columns[] = array("name" => "language", "type" => DB_COLUMN_STRING,"length"=>2,"notnull"=>1,"dtype"=>"string");
		$this->columns[] = array("name" => "posted_date", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0,"dtype"=>"string");
		$this->columns[] = array("name" => "_lastmodified", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0,"dtype"=>"string");
		parent::prepareColumns();
	}


	/**
	 * Return reader with messages limited to $msg_start, $msg_count
	 *
	 * @param int $msg_start First message number
	 * @param int $msg_count Count of messages to get
	 * @return DataReader
	 */
	function GetMessagesList($msg_start, $msg_count)
	{
		$SQL = sprintf("SELECT message_id,
		  				signature AS signature, message AS message,
		  				email AS email, comment AS comment,
		  				posted_date AS posted_date
						FROM `%s`
						WHERE active=1 AND language='%s'
						ORDER BY posted_date DESC
						LIMIT $msg_start , $msg_count",
			$this->getTable("GuestbookMessagesTable"),
			$this->Connection->Kernel->Language
		);
		return $this->Connection->ExecuteReader($SQL);
	}

	/**
	 * Enter Returns messages count
	 *
	 * @return int Messages count
	 */
	function GetMessagesCount()
	{
		$SQL = sprintf("SELECT COUNT(message_id) AS counter
						FROM `%s`
						WHERE active=1 AND language='%s'",
			$this->getTable("GuestbookMessagesTable"),
			$this->Connection->Kernel->Language
		);
	    $_tmp = $this->Connection->ExecuteScalar($SQL);
	    return $_tmp["counter"];
	}
}

?>