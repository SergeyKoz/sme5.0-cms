<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** Magazine Subscribers storage class
 * @author Sergey Kozin <skozin@activemedia.com.ua>
 * @version 2.0
 * @package  Subscribe
 * @access public
 */
class SubscribeContentTable extends ProjectTable
{
  var $ClassName = "subscribecontenttable";
  var $Version = "1.0";
/**
* Class constructor
* @param  MySqlConnection   $Connection Connection object
* @param  string    $TableName    Table name
* @access    public
*/
function SubscribeContentTable(&$Connection, $TableName) {
    ProjectTable::ProjectTable($Connection, $TableName);

}

 function prepareColumns() {
   $this->columns[] = array("name" => "content_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
   $this->columns[] = array("name" => "theme_id", "type" => DB_COLUMN_NUMERIC);
   $this->columns[] = array("name" => "parent_id", "type" => DB_COLUMN_NUMERIC);
   $this->columns[] = array("name" => "content_title", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1);
   $this->columns[] = array("name" => "content", "type" => DB_COLUMN_STRING, "notnull"=>1);
   $this->columns[] = array("name" => "history", "type" => DB_COLUMN_STRING, "dtype"=>"int","notnull"=>0, "length"=>1);
   $this->columns[] = array("name" => "lang_ver", "type" => DB_COLUMN_STRING, "length"=>2);
   $this->columns[] = array("name" => "is_test", "type" => DB_COLUMN_NUMERIC, "length"=>1,"notnull"=>0);
   $this->columns[] = array("name" => "activity", "type" => DB_COLUMN_NUMERIC, "length"=>1,"notnull"=>0);
   $this->columns[] = array("name" => "state", "type" => DB_COLUMN_NUMERIC, "length"=>1,"notnull"=>0);


   parent::prepareColumns();
 }

 function GetMailContent($id, $test){
 		$MultiLanguage=$this->Connection->Kernel->MultiLanguage;

        $SQL =  sprintf("SELECT content_id, theme_id, is_test, content_title, content, lang_ver  FROM %s WHERE
                        active = 1 AND content_id = %s",
                        $this->defaultTableName, $id);
        $content_data=$this->Connection->ExecuteScalar($SQL);

        $lng=(!$MultiLanguage ? $content_data["lang_ver"] : $this->Connection->Kernel->Language);

        $SQL =  sprintf("SELECT theme_title_%s AS theme_title FROM %s WHERE theme_id=%d AND active=1", $lng,
                        $this->GetTable("SubscribeThemesTable"), $content_data["theme_id"]);
        $theme=$this->Connection->ExecuteScalar($SQL);
        if ($test){
        	$SQL =  sprintf("SELECT '' AS uni_id, u.user_id, u.email, u.is_tester FROM %s AS u
							WHERE u.active=1 AND u.is_tester=1",
                        	$this->GetTable("SubscribeUserTable"));
 		}else{
 			$SQL =  sprintf("SELECT r.uni_id, u.user_id, u.email, u.is_tester FROM
							%s AS r JOIN %s AS u ON (r.user_id=u.user_id)
							WHERE r.theme_id=%d
                            %s
							AND r.active=1
							AND u.active=1",
                        	$this->GetTable("SubscribeRelationTable"),
                        	$this->GetTable("SubscribeUserTable"),
                        	$content_data["theme_id"], ($MultiLanguage ? "AND r.lang_ver='".$lng."'" : ""));
 		}
        $reader=$this->Connection->ExecuteReader($SQL);

		$ret=array();
        for ($i=0; $i<$reader->RecordCount; $i++){
			$record=$reader->read();

			$item_data=array("theme_id"=>$content_data["theme_id"],
							"uni_id"=>$record["uni_id"],
							"user_id"=>$record["user_id"],
							"email"=>$record["email"],
							"date"=>date("d.m.Y H:i:s", time()),
							"theme_title"=>$theme["theme_title"],
							"content_title"=>$content_data["content_title"],
							"content"=>$content_data["content"],
							"lang_ver"=> $lng);
			$ret[]=$item_data;
        }
        return $ret;
 }

}

?>