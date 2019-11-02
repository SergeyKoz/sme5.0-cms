<?php
$this->ImportClass("data.projecttable", "ProjectTable");
//$this->ImportClass("data.publicationstable", "PublicationsTable");

/** Publications storage class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package Publications
 * @subpackage classes.data
 * @access public
 */
class PublicationsHelperTable extends ProjectTable {//PublicationsTable {
    var $ClassName = "PublicationsHelperTable";
    var $Version = "1.0";
    var $sphere_template_id = 12;

    /**
     * Class constructor
     * @param  MySqlConnection   $Connection Connection object
     * @param  string    $TableName  Table name
     * @access   public
     */
    function PublicationsHelperTable(&$Connection, $TableName){
        ProjectTable::ProjectTable($Connection, $TableName);
    }

    function prepareColumns (){
        $this->columns[] = array( "name" => "publication_id" , "type" => DB_COLUMN_NUMERIC , "key" => true , "incremental" => true );
        //parent::prepareColumns();
    }

    function GetIERPublicationsCount($data){
    	$l=$this->Connection->Kernel->Language;
    	$tags=$data["tags"];
        if (count($tags)) $join_tags_condition=sprintf(" JOIN (SELECT tg.publication_id, tg.tag_%s FROM %s AS tg JOIN (%s) ttg ON (ttg.tag_%s=tg.tag_%s) WHERE %s AND tg.publication_id>0 GROUP BY tg.publication_id ) AS tg ON (p.publication_id=tg.publication_id)", $l, $this->GetTable("TagsTable"), "SELECT '".implode("' AS tag_".$l." UNION SELECT '", $tags)."' AS tag_".$l, $l, $l, ($data["tag"]!="" ? "tg.tag_".$l."='".$data["tag"]."'" : "tg.tag_".$l."!=''"));

        $templates=$data["templates"];
        if (is_array($templates) && count($templates))
        	$join_templates_condition="JOIN (SELECT ".implode(" AS template_id UNION SELECT ", $templates)." AS template_id) AS t ON (p.template_id=t.template_id)";
        if (!is_array($templates) && $templates>0)
        	$and_templates_condition="AND p.template_id=".$templates;


        $categories=$data["category_id"];
        if (is_array($categories) && count($categories))
        	$join_category_condition="JOIN (SELECT ".implode(" AS parent_id UNION SELECT ", $categories)." AS parent_id) AS c ON (p.parent_id=c.parent_id)";
        if (!is_array($categories) && $categories>0)
        	$and_category_condition="AND p.parent_id=".$categories;

        $this->CountSQL = sprintf("SELECT count(*) as counter
                        FROM %s as p
                        ".$join_tags_condition."
                        ".$join_templates_condition."
                        ".$join_category_condition."
                        WHERE p.active_%s=1
                          ".$and_templates_condition."
                          ".$and_category_condition."
                          AND p.is_modified = 0
                          AND p.copy_of_id = 0
                          %s", $this->GetTable("PublicationsTable"), $l,
        				($data["priveledged_only"] == 1 ? " AND p.is_priveledged = 1" : ""));
        $record = $this->Connection->ExecuteScalar($this->CountSQL);
        $cnt=$record["counter"];

        if ($data["start_index"]>0) $cnt-=$data["start_index"];
        if ($data["end_index"] < $cnt && $data["end_index"]>0) $cnt = $data["end_index"];
        if ($cnt<0) $cnt=0;

        return $cnt;
    }

    function GetIERPublicationsList($data){
        $l=$this->Connection->Kernel->Language;
    	$select="p.publication_id, p.parent_id, p._sort_caption_".$l." AS caption, p._sort_date AS publication_date, p.target_entry_point, p.disable_comments";
        $this->ListSQL=str_replace("count(*) as counter", $select, $this->CountSQL);
        $this->ListSQL.="ORDER BY ".$data["orders"].
        				" LIMIT ".$data["offset"].", ".$data["count"];
        $reader=$this->Connection->ExecuteReader($this->ListSQL);
       /* $list=;
        for ($i=0; $i<$reader->RecordCount; $i++){
        	$record=$reader->read();
        	$list[]=array();
        }*/


         /*
        Array
(
    [publication_id] => 1216
    [parent_id] => 1175
    [template_id] => 51
    [_sort_caption_ru] =>
    [_sort_caption_ua] => ������ ���������� ����������������� ����������
    [_sort_caption_en] => ������ ���������� ����������������� ����������
    [_sort_date] => 2010-03-26 14:42:31

    [target_entry_point] => 0
    [disable_comments] => 0

*/



        return $reader;
    }

    function GetBlockSheresList($data = null, $orders = null, $limitCount = null, $limitOffset = null, $ids = null,  $table_alias="", $raw_sql=array()){
        $SQL=sprintf("	SELECT p.publication_id, p.parent_id, CONCAT(p._sort_caption_%s, '|', p.target_entry_point) AS sphere_caption FROM %s AS p
        				WHERE p.template_id=%d
						ORDER BY p._priority DESC",
						$this->Connection->Kernel->Language,
						$this->GetTable("PublicationsTable"), $this->sphere_template_id);
        $reader = $this->Connection->ExecuteReader($SQL);
        return $reader;
    }

    function GetSheresList($data = null, $orders = null, $limitCount = null, $limitOffset = null, $ids = null,  $table_alias="", $raw_sql=array()){
        $SQL=sprintf("	SELECT p.publication_id, p.parent_id, p._sort_caption_%s AS sphere_caption FROM %s AS p
        				WHERE p.template_id=%d
						ORDER BY p._priority DESC",
						$this->Connection->Kernel->Language,
						$this->GetTable("PublicationsTable"), $this->sphere_template_id);

        $reader = $this->Connection->ExecuteReader($SQL);

        return $reader;
    }

} //--end of class
?>