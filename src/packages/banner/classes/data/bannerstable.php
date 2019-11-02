<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

/** Banners storage class
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package Banner
 * @subpackage classes.data
 * @access public
 */
class BannersTable extends ProjectTable   {
  var $ClassName = " BannersTable";
  var $Version = "1.0";

/**
  * Class constructor
  * @param  MySqlConnection   $Connection Connection object
  * @param  string	$TableName	Table name
  * @access	public
  **/
function BannersTable(&$Connection, $TableName) {
	ProjectTable::ProjectTable($Connection, $TableName);
}


 function prepareColumns() {

  $this->columns[] = array("name" => "banner_id",      "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
  $this->columns[] = array("name" => "group_id",   	   "type" => DB_COLUMN_NUMERIC);
  $this->columns[] = array("name" => "banner_title",   "type" => DB_COLUMN_STRING,   "length"=>255,      "notnull"=>1);
  $this->columns[] = array("name" => "banner_alt", 	   "type" => DB_COLUMN_STRING,   "length"=>1000,      "notnull"=>0);
  $this->columns[] = array("name" => "banner_file",    "type" => DB_COLUMN_STRING,   "length"=>255,      "notnull"=>0);
  $this->columns[] = array("name" => "banner_url", 	   "type" => DB_COLUMN_STRING,   "length"=>1000,     "notnull"=>0);
  $this->columns[] = array("name" => "banner_text",    "type" => DB_COLUMN_STRING,   "length"=>10000,     "notnull"=>0);
  $this->columns[] = array("name" => "banner_type",    "type" => DB_COLUMN_NUMERIC,  "dtype"=>"int",    "notnull"=>0,"length"=>1);
  $this->columns[] = array("name" => "target",         "type" => DB_COLUMN_NUMERIC,  "dtype"=>"int",    "notnull"=>0,"length"=>1);
  $this->columns[] = array("name" => "height",         "type" => DB_COLUMN_NUMERIC,  "dtype"=>"int",    "notnull"=>0,"length"=>10);
  $this->columns[] = array("name" => "width",          "type" => DB_COLUMN_NUMERIC,  "dtype"=>"int",    "notnull"=>0,"length"=>10);

  parent::prepareColumns();
  //$this->columns[] = array("name" => "banner_language",    "type" => DB_COLUMN_STRING,   "length"=>2,      "notnull"=>0);
}

/**
* Method returns set of banners for current page
* grouped by banner placeholders limited to sertain
* placeholder max banner qty
* @return array     Array of banners
* @access   public
**/
 /*function GetBanners($page_id, $_place_id, $_limit, $_seed){
    $_page = $this->Connection->Kernel->GetPagePath();
    $Kernel =& $this->Connection->Kernel;
    $SQL = sprintf("SELECT b.*
                    FROM %s as bpages,  %s as b, %s as bplaces, %s as bg, %s as bl
                    WHERE bpages.page_id = %d
                      AND bpages.banner_id = b.banner_id
                      AND bplaces.banner_id = bpages.banner_id
                      AND bplaces.place_id = %d
                      AND b.group_id = bg.group_id
                      AND b.banner_id = bl.banner_id
                      AND bl.language = '%s'
                      AND bg.active = 1
                      AND b.active = 1
                    ORDER BY %s
                    %s
                   ",
                   $this->GetTable("BannerPagesTable"),
                   $this->defaultTableName,
                   $this->GetTable("BannerPlacesRelationTable"),
                   $this->GetTable("BannerGroupsTable"),
                   $this->GetTable("BannerLanguagesTable"),
                   $page_id, $_place_id,
                   $this->Connection->Kernel->Language,
                   ($_seed ? sprintf($this->Connection->Syntax["RANDOMIZE"],"") : "_priority "),
                   sprintf($this->Connection->Syntax["LIMIT"],0,$_limit)
                  );
    return $this->Connection->ExecuteReader($SQL);

 }   */

 function GetBanners($page_id){
    $Kernel =&$this->Connection->Kernel;
    $SQL = sprintf("SELECT b.*, bplaces.place_id
                    FROM %s as bpages,  %s as b, %s as bplaces, %s as bg%s
                    WHERE bpages.page_id = %d
                      AND bpages.banner_id = b.banner_id
                      AND bplaces.banner_id = bpages.banner_id
                      %s
                      AND b.group_id = bg.group_id
                      AND bg.active = 1
                      AND b.active = 1
                    ORDER BY _priority",
                   $this->GetTable("BannerPagesTable"),
                   $this->defaultTableName,
                   $this->GetTable("BannerPlacesRelationTable"),
                   $this->GetTable("BannerGroupsTable"),
                   ($Kernel->MultiLanguage ? sprintf(", (SELECT banner_id FROM %s WHERE language='%s') AS bl", $this->GetTable("BannerLanguagesTable"), $Kernel->Language) : ""),
                   $page_id,
                   ($Kernel->MultiLanguage ? "AND b.banner_id = bl.banner_id" : "")
                   );
    return $this->Connection->ExecuteReader($SQL);

 }



} //--end of class

?>