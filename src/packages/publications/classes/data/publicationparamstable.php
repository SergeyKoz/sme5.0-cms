<?php
$this->ImportClass("system.data.abstracttable", "AbstractTable");

/** Publication parameters storage class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package Publications
 * @subpackage classes.data
 * @access public
 */
class PublicationParamsTable extends AbstractTable
{
  var $ClassName = "PublicationParamsTable";
  var $Version = "1.0";


 function prepareColumns() {
  parent::prepareColumns();
  $this->columns[] = array("name" => "pp_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
  $this->columns[] = array("name" => "publication_id", "type" => DB_COLUMN_NUMERIC, "key" => true);
  $this->columns[] = array("name" => "param_id", "type" => DB_COLUMN_NUMERIC);
  $this->columns[] = array("name" => "param_value", "type" => DB_COLUMN_STRING,"length"=>1000000,"notnull"=>0);
  $this->columns[] = array("name" => "param_value_tmp", "type" => DB_COLUMN_STRING,"length"=>1000000,"notnull"=>0);
  $this->columns[] = array("name" => "language", "type" => DB_COLUMN_STRING,"length"=>2,"notnull"=>0);

 }

 /**
 * Method returns publication parameters
 * @param    int           $template_id      Template ID
 * @param    int           $item_id          Publication ID
 * @param    string        $language         Language
 * @param    bool          $activity_filter  Check or not for active parameters
 * @param    bool          $in_list          Select mode
 * @return  MySQLReader    Reader object
 * @access  public
 **/
 function GetPublicationParameters($template_id, $item_id, $language=null, $activity_filter=false, $in_publication=null)   {

     $SQL = sprintf("SELECT tp.*, tp.param_name as param_name, pp.param_value as cur_value,
                            pp.language as language ,
                            pp.publication_id as publication_id,
                            tp.param_type AS system_name
                     FROM %s AS tp
                      LEFT JOIN %s AS pp ON (pp.param_id=tp.tp_id AND pp.publication_id=%d),

                      %s as t,
                      %s as pub
                      WHERE pub.publication_id = %d
                      AND tp.template_id=pub.template_id
                      AND t.template_id = tp.template_id
                      %s
                      %s
                      %s
                      %s
                      ORDER BY tp._priority
                    ",$this->GetTable("TemplateParamsTable"),
                    $this->defaultTableName,$item_id,
                    $this->GetTable("TemplatesTable"),
                    $this->GetTable("PublicationsTable"),$item_id,
                    (is_null($in_publication) ? "" : sprintf("AND tp.is_in_publication = %d", $in_publication)),
                    (is_null($language) ? "" : sprintf("AND ((pp.language = '%s') or (pp.language = ''))",$language)),
                    (!$activity_filter ? "" : "AND tp.active = 1"),
                    ($language!='' ? "AND pub.active_".$language."=1" : "")

                    );
     if ($language!=""){
     	$meta_SQL = sprintf("SELECT p.meta_title_%s AS t, p.meta_keywords_%s AS k, p.meta_description_%s AS d FROM %s AS p WHERE p.publication_id=%d
     						AND (SELECT count(*) FROM %s AS tp WHERE tp.template_id=p.template_id AND tp.enable_seo_params=1)=1",
     				$language, $language, $language, $this->GetTable("PublicationsTable"), $item_id, $this->GetTable("TemplatesTable"));
     	$record=$this->Connection->ExecuteScalar($meta_SQL);
     	if ($record["t"]!="") DataDispatcher::Set("meta_title", $record["t"]);
     	if ($record["k"]!="") DataDispatcher::Set("meta_keywords", $record["k"]);
     	if ($record["d"]!="") DataDispatcher::Set("meta_description", $record["d"]);
     }

    return $this->Connection->ExecuteReader($SQL);
 }

 /**
 * Method returns publication parameters
 * @param    int           $template_id      Template ID
 * @param    int           $item_id          Publication ID
 * @param    string        $language         Language
 * @param    bool          $activity_filter  Check or not for active parameters
 * @param    bool          $in_list          Select mode
 * @return  MySQLReader    Reader object
 * @access  public
 **/
 function GetPublicationListParameters($item_ids, $language=null, $activity_filter=false, $in_list=1)   {
     $SQL = sprintf("SELECT tp.*, tp.param_name as param_name,pp.param_value as cur_value, pp.pp_id as pp_id,
                            pp.language as language ,
                            pp.publication_id as publication_id,
                            tp.param_type AS system_name
                     FROM %s AS tp
                      LEFT JOIN %s AS pp ON (pp.param_id=tp.tp_id AND pp.publication_id IN (%s)), %s as pub
                      WHERE pub.publication_id = pp.publication_id
                        AND tp.template_id=pub.template_id
                      %s
                      %s
                      %s
                    ORDER BY pp.publication_id, tp._priority
                    ",$this->GetTable("TemplateParamsTable"),
                    $this->defaultTableName,
                    implode(",",$item_ids),
                    $this->GetTable("PublicationsTable"),

                    (($in_list!=1) ? "AND tp.is_in_publication = 1" : "AND tp.is_in_list = 1"),
                    (is_null($language) ? "" : sprintf("AND ((pp.language = '%s') or (pp.language = ''))",$language)),
                    (!$activity_filter ? "" : "AND tp.active = 1")
                    );

    return $this->Connection->ExecuteReader($SQL);
 }


 /**
 * Method gets published values for specified publication
 * @param   int     $publication_id    Publication ID
 * @return array    Array with published values
 * @access public
 **/
 function GetPreviousPublishedValues($publication_id){
    // echo pr($publication_id);
    $_reader = $this->GetList(array("publication_id" => $publication_id));
    $_values = array();
    for($i=0; $i < $_reader->RecordCount; $i++){
        $_tmp = $_reader->Read();
        if(strlen($_tmp["language"]) > 0){
            $_values[$_tmp["param_id"]][$_tmp["language"]]  = $_tmp["param_value"];
        } else {
            $_values[$_tmp["param_id"]] = $_tmp["param_value"];
        }
    }
    return $_values;

 }

} //--end of class

?>