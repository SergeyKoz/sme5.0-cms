<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** Banner groups storage class
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package Comments
 * @subpackage classes.data
 * @access public
 */
class CommentsTable extends ProjectTable   {
  var $ClassName = "CommentsTable";
  var $Version = "1.0";

/**
  * Class constructor
  * @param  MySqlConnection   $Connection Connection object
  * @param  string  $TableName  Table name
  * @access public
  **/
function CommentsTable(&$Connection, $TableName) {
    ProjectTable::ProjectTable($Connection, $TableName);
}


function prepareColumns() {
  parent::prepareColumns();
  $this->columns[] = array("name" => "comment_id",  "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
  $this->columns[] = array("name" => "group_id",  "type" => DB_COLUMN_STRING);

  $this->columns[] = array("name" => "parent_id",  "type" => DB_COLUMN_NUMERIC);
  $this->columns[] = array("name" => "_parent_id",  "type" => DB_COLUMN_NUMERIC);
  $this->columns[] = array("name" => "level",  "type" => DB_COLUMN_NUMERIC);

  $this->columns[] = array("name" => "comment",      "type" => DB_COLUMN_STRING,   "length"=>65535,     "notnull"=>1);

  $this->columns[] = array("name" => "user_id",  "type" => DB_COLUMN_NUMERIC);
  $this->columns[] = array("name" => "author_name", "type" => DB_COLUMN_STRING,   "length"=>255);
  $this->columns[] = array("name" => "author_email", "type" => DB_COLUMN_STRING,   "length"=>255);
  $this->columns[] = array("name" => "module", "type" => DB_COLUMN_STRING,   "length"=>255);

  $this->columns[] = array("name" => "article_id",  "type" => DB_COLUMN_NUMERIC);
  $this->columns[] = array("name" => "article_title",  "type" => DB_COLUMN_STRING, "length"=>255);
  $this->columns[] = array("name" => "article_url",  "type" => DB_COLUMN_STRING, "length"=>255);

  $this->columns[] = array("name" => "published", "type" => DB_COLUMN_NUMERIC,  "dtype"=>"int");
  $this->columns[] = array("name" => "posted",        "type" => DB_COLUMN_STRING);
  $this->columns[] = array("name" => "uni_id",        "type" => DB_COLUMN_STRING);
}

 	function &GetCommentsAdminList($data = null, $orders = null, $limitCount = null, $limitOffset = null, $ids = null, $table_alias = "", $raw_sql = array()){
        $table_alias="c.";
        $l=$this->Connection->Kernel->Language;

        $group_article="CONCAT ('<b>', (SELECT g.group_name_".$l." FROM ".$this->getTable("CommentGroupsTable")." AS g WHERE g.group_id=c.group_id) , '</b><br/>', c.article_title) AS article";

        $author="IF (c.user_id>0,
        			CONCAT('<b>', (SELECT u.user_login FROM ".$this->getTable("UsersTable")." AS u WHERE u.user_id=c.user_id), '</b>'),
        			CONCAT(c.author_name, '<br/><i>', c.author_email, '</i>')) AS author";

        $comment="CONCAT('<div style=\"margin-left:', c.level*20, 'px\">' , c.comment, '</div>') as comment";

        $rating="(SELECT SUM(vote) FROM ".$this->getTable("CommentsVotesTable")." AS v WHERE v.comment_id=c.comment_id) as rating";
        $raw_sql["select"]="c.*, ".$group_article.", ".$author.", ".$comment.", ".$rating;
        unset($data["parent_id"]);
		return parent::GetList($data, $orders, $limitCount, $limitOffset, $ids, $table_alias, $raw_sql);
    }

    function GetCountCommentsAdminList($data = null, $table_alias = "", $raw_sql = array()){
        unset($data["parent_id"]);
        return parent::GetCount($data, $table_alias, $raw_sql);
    }

	function GetRecursivePriorityItems(&$tree, &$priority){
        if (is_array($tree)){
            foreach ($tree as $i=>$node){
            	$priority[$node["_priority"]]=$node["_priority"];
	          	if (!empty($node["_children"])){
	            	$this->GetRecursivePriorityItems($node["_children"], $priority);
            	}
            }
        }
    }


	function UpdatePriority($comment_id, $parent_id, $data){
        $table=$this->defaultTableName;

        $tree=$this->GetTreeData($data, "parent_id");

        $priority=array();
        $this->GetRecursivePriorityItems($tree[$parent_id]["_children"], $priority);
        unset($priority[$comment_id]);

        $priority=array_values($priority);
        rsort($priority);

        $sql=sprintf("	SELECT comment_id, _priority FROM %s
       					WHERE comment_id!=%d AND parent_id=%d
       					AND article_id=%d AND group_id='%s'
       					ORDER BY _priority
       					LIMIT 0, 1",
        				$table, $comment_id, $parent_id, $data["article_id"], $data["group_id"]);
        $record=$this->Connection->ExecuteScalar($sql);
        $after=$record["_priority"];

        if (empty($record)){
        	$record=$this->Get(array("comment_id"=>$parent_id));
        	$after=$record["_priority"];
        }else{
        	$after=$priority[0];
        }

        $sql=sprintf("
        	UPDATE %s SET _priority=_priority+1 WHERE _priority>%s",
			$table, $after);
        $this->Connection->ExecuteNonQuery($sql);

        $sql=sprintf(	"UPDATE %s SET _priority=%d WHERE comment_id=%d", $table, $after+1, $comment_id);
        $this->Connection->ExecuteNonQuery($sql);
	}

	function GetLastComments($count, $length){
        $comments=array();
        if ($count>0){
        	$SQL=sprintf("SELECT c.comment_id, c.posted, c.module, c.comment, c.author_name, c.user_id, c.article_title, c.article_url, c.article_id
        				FROM %s AS c WHERE c.published=1 ORDER BY c.posted DESC LIMIT 0, %d", $this->defaultTableName, $count);
            $reader=$this->Connection->ExecuteReader($SQL);
        	for ($i=0; $i<$reader->RecordCount; $i++){
	        	$record=$reader->read();
	        	$comment=strip_tags($record["comment"]);

                if ($length){
		        	$comment=substr($comment, 0, $length);
					$pos = strrpos($comment, " ");
					if ($pos!==false)$comment=rtrim(substr($comment, 0, $pos))."...";
				}

                $record["comment"]=$comment;
	        	$record["posted"]=Component::dateconv($record["posted"], false);
	        	$record["author"]=$this->GetCreatedByUser($record["user_id"]);

	        	$comments[]=$record;
	        }
        }
        return $comments;
	}

} //--end of class

?>