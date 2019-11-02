<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** Magazine Polls storage class
* @author Artem Mikhmel <amikhmel@activemedia.com.ua>
* @version 1.0
* @package  Polls
* @access public
*/
class PollsTable extends ProjectTable{
	var $ClassName = "PollsTable";
	var $Version = "1.0";
	/**
	* Class constructor
	* @param  MySqlConnection   $Connection Connection object
	* @param  string    $TableName    Table name
	* @access    public
	*/
	function PollsTable(&$Connection, $TableName) {
	    ProjectTable::ProjectTable($Connection, $TableName);
	}

	function prepareColumns() {
		$this->columns[] = array("name" => "poll_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
		$this->columns[] = array("name" => "parent_id", "type" => DB_COLUMN_NUMERIC,"dtype"=>"int");
		$this->columns[] = array("name" => "caption_%s", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1,"dtype"=>"string");
		$this->columns[] = array("name" => "priority", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0,"dtype"=>"int");
		$this->columns[] = array("name" => "active_%s", "type" => DB_COLUMN_STRING,"length"=>1,"dtype"=>"int");
		$this->columns[] = array("name" => "variants", "type" => DB_COLUMN_STRING,"length"=>1,"dtype"=>"int");
		$this->columns[] = array("name" => "is_index", "type" => DB_COLUMN_STRING,"length"=>1,"dtype"=>"int");
		$this->columns[] = array("name" => "poll_visible", "type" => DB_COLUMN_STRING,"length"=>1,"dtype"=>"int");
		$this->columns[] = array("name" => "res_visible", "type" => DB_COLUMN_STRING,"length"=>1,"dtype"=>"int");
		$this->columns[] = array("name" => "system", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1);
		parent::prepareColumns();
	}

	/**
	* Method resets polls votes
	* @param   int     $poll_id        POll id to reset
	* @access public
	**/
	function ResetPoll($poll_id){
		$record=$this->Get(array("poll_id"=>$poll_id));

		if ($record["parent_id"]==0){
			$SQL = sprintf("UPDATE %s SET votes=0 WHERE poll_id=%d or parent_id=%d",
							$this->defaultTableName, $poll_id, $poll_id);
			$this->Connection->ExecuteNonQuery($SQL);

			$SQL = sprintf("DELETE FROM %s WHERE p_id=%d or q_id=%d",
							$this->GetTable("PollsVariantsTable"), $poll_id, $poll_id);
			$this->Connection->ExecuteNonQuery($SQL);
		} else {
			$SQL = sprintf("UPDATE %s SET votes=0 WHERE poll_id=%d",
							$this->defaultTableName, $poll_id);
			$this->Connection->ExecuteNonQuery($SQL);

			$SQL = sprintf("UPDATE %s SET votes=votes-%d WHERE poll_id=%d",
							$this->defaultTableName, $record["votes"], $record["parent_id"], $poll_id);
			$this->Connection->ExecuteNonQuery($SQL);;

			$SQL = sprintf("DELETE FROM %s WHERE q_id=%d",
							$this->GetTable("PollsVariantsTable"), $poll_id);
			$this->Connection->ExecuteNonQuery($SQL);
		}
	}

	/**
	* Method gets count of active valid polls.
	* @param   int     $archive    Flag specifies select or not archived polls
	* @param   int     $offset     List offset
	* @param   int     $count      List entries limit
	* @access public
	**/
	function GetPollsCount($_cook){
		$cook=""; if (is_array($_cook)) if (!empty($_cook)) $cook=implode(", ", $_cook);
		$l=$this->Connection->Kernel->Language;

		$SQL = sprintf("SELECT count(*) as cnt  FROM %s as p
						WHERE p.active_%s = 1 AND p.parent_id = 0
						%s", $this->defaultTableName, $l,
						($cook!="" 	? "AND (   	(p.poll_visible=1 AND p.res_visible=1 AND p.poll_id NOT IN (".$cook."))
						OR (p.res_visible=1 AND p.poll_id IN (".$cook."))
						OR (p.poll_visible=0 AND p.poll_id NOT IN (".$cook."))  )"
						:"AND (p.poll_visible=0 OR p.res_visible=1)"));

		$record = $this->Connection->ExecuteScalar($SQL);
		return $record["cnt"];
	}

	/**
	* Method gets list of active valid polls.
	* @param   int     $archive    Flag specifies select or not archived polls
	* @param   int     $offset     List offset
	* @param   int     $count      List entries limit     poll_visible
	* @access public
	**/
	function GetPollsList($offset=0, $count=10, $_cook){
		$cook="";
		if (is_array($_cook)){
			if (!empty($_cook)){
				$cook=implode(", ", $_cook);
			}
		}
		$l=$this->Connection->Kernel->Language;

		$SQL = sprintf("SELECT p.poll_id,  p.caption_%s as caption, system, p.votes
						FROM %s AS p
						WHERE p.active_%s = 1
						AND p.parent_id = 0
						%s
						ORDER BY p._priority
						LIMIT %d, %d", $l, $this->defaultTableName, $l,
						($cook!="" 	? "AND (   (p.poll_visible=1 AND p.res_visible=1 AND p.poll_id NOT IN (".$cook."))
						OR (p.res_visible=1 AND p.poll_id IN (".$cook."))
						OR (p.poll_visible=0 AND p.poll_id NOT IN (".$cook."))   )"
						:"AND (p.poll_visible=0 OR p.res_visible=1)"),
						$offset, $count);
		$_reader = $this->Connection->ExecuteReader($SQL);
		$polls = array();
		for($i=0; $i<$_reader->RecordCount; $i++){
			$record = $_reader->Read();
			$polls[$record["poll_id"]] = $record;
		}
		return $polls;
	}


	function GetPoll($PollID, $cookie, $page_id=0){
		$lang=$this->Connection->Kernel->Language;

		if  ($PollID>0){
			$voted=(in_array($PollID, $cookie) ? true : false);

			$SQL = sprintf("SELECT p.poll_id, p.caption_%s AS caption, p.votes, system, %s
							FROM %s as p
							WHERE p.active_%s = 1
							AND p.parent_id = 0
							AND p.poll_id=%s
							%s",
							$lang,
							($voted ? "1 AS voted" : "IF (p.poll_visible=1, 1, 0) AS voted" ),
							$this->defaultTableName,
							$lang, $PollID, ($voted ? "AND res_visible=1" : " AND (p.poll_visible=0 OR res_visible=1)"));
			$record= $this->Connection->ExecuteScalar($SQL);
			if (empty($record)){
				$PollID=0;
			}
		}

		if  ($PollID==0){
			$SQL = sprintf("SELECT p.poll_id, p.caption_%s AS caption, p.votes, p.system
							FROM %s as p
							WHERE p.active_%s = 1
							AND p.parent_id = 0
							AND p.poll_visible=0
							%s
							ORDER BY p._priority",
							$lang, $this->defaultTableName,
							$lang, (count($cookie) ? "AND (p.poll_id!=".implode(" AND p.poll_id!=", $cookie).")" : ""));
			$record= $this->Connection->ExecuteScalar($SQL);

			if (empty($record)){
				$SQL = sprintf("SELECT p.poll_id, p.caption_%s AS caption, p.votes, 1 AS voted, p.system
								FROM %s as p
								WHERE p.active_%s = 1
								AND p.parent_id = 0
								AND p.res_visible=1
								%s
								ORDER BY p._priority",
								$lang, $this->defaultTableName,
								$lang, (count($cookie) ? "AND (p.poll_id=".implode(" OR p.poll_id=", $cookie).")" : ""));
				$record= $this->Connection->ExecuteScalar($SQL);
			}
		}

		return $record;
	}

	function GetAnsvers($poll_id){
		$lang=$this->Connection->Kernel->Language;
		$SQL = sprintf("SELECT poll_id, caption_%s as caption, votes, variants FROM %s
						WHERE
						active=1 AND
						parent_id= %s
						ORDER BY _priority
						", $lang, $this->defaultTableName, $poll_id);
		$reader = $this->Connection->ExecuteReader($SQL);

		$variants=array();
		for($i=0; $i<$reader->RecordCount; $i++){
			$variants[$i] = $reader->Read();
		}
		return  $variants;
	}


	function GetTags(&$list, $type){
		$l=$this->Connection->Kernel->Language;
		$ids=array_keys($list);
		if (count($ids)){
			$SQL=sprintf("	SELECT t.item_id AS id, t.tag_%s AS tag FROM %s AS t JOIN %s AS r ON (t.item_id=r.id)
							WHERE t.tag_%s!='' AND t.tag_type='%s' ORDER BY t.item_id, t.tag_%s",
							$l, $this->GetTable("TagsTable"),
							"(SELECT ".implode(" AS id UNION SELECT ", $ids)." AS id)", $l, $type, $l);

			$reader=$this->Connection->ExecuteReader($SQL);
			for ($i=0; $i<$reader->RecordCount; $i++){
				$record=$reader->read();
				$list[$record["id"]]["tags"][]=array("tag"=>$record["tag"], "tag_decode"=>urlencode($record["tag"]));
			}
		}
	}


	/**
	* Method updates poll state when voted
	* @param      int    poll_id   Poll ID
	* @param      int    answer_id   answer ID
	* @access  public
	* @return  bool Result
	**/
	function UpdatePollState($poll_id, $answer_id){
		$_tmp = $this->Get(array("poll_id" => $answer_id, "parent_id" => $poll_id));

		if(empty($_tmp)){
			return false;
		}

		$SQL = sprintf("UPDATE %s SET
						votes = votes + 1
						WHERE poll_id IN(%d, %d)
						", $this->defaultTableName,
						$poll_id, $answer_id);
		$this->Connection->ExecuteNonQuery($SQL);
		return true;
	}

	function OnAfterDelete(&$data){
		$del_var[0]=$data["poll_id"];
		$this->DeleteVariants($del_var);
		parent::OnAfterDelete ($data);
	}

	function OnAfterGroupDelete($in_field, $in_data){
		$this->DeleteVariants($in_data);
		parent::OnAfterGroupDelete($in_field, $in_data);
	}

	function DeleteVariants($del_poll){
		$del_poll=implode(",", $del_poll);
		$SQL = sprintf("DELETE FROM %s
						WHERE p_id IN (%d) or q_id IN (%d)
						", $this->GetTable("PollsVariantsTable"),
						$del_poll, $del_poll);
		$this->Connection->ExecuteNonQuery($SQL);
	}

}

?>