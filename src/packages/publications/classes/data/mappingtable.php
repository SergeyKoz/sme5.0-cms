<?php
$this->ImportClass("data.projecttable", "ProjectTable");

/** Parameters storage class
* @author Artem MIkhmel <amikhmel@activemedia.com.ua>
* @version 1.0
* @package Publications
* @subpackage classes.data
* @access public
*/
class MappingTable extends ProjectTable
{
    var $ClassName = "MappingTable";
    var $Version = "1.0";
    /**
    * Class constructor
    * @param  MySqlConnection   $Connection Connection object
    * @param  string        $TableName        Table name
    * @access        public
    */
    function MappingTable(&$Connection, $TableName) {
        ProjectTable::ProjectTable($Connection, $TableName);
    }

    function prepareColumns() {
        parent::prepareColumns();
        $this->columns[] = array("name" => "mapping_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
        $this->columns[] = array("name" => "publication_id", "type" => DB_COLUMN_NUMERIC );

        $this->columns[] = array("name" => "page_id",  "type" => DB_COLUMN_NUMERIC,"length"=>10,"notnull"=>0, "dtype"=>"int");

        $this->columns[] = array("name" => "caption", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1,"dtype"=>"string");
        $this->columns[] = array("name" => "system_name", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>1,"dtype"=>"string");
        $this->columns[] = array("name" => "target_entry_point", "type" => DB_COLUMN_NUMERIC,"length"=>255,"notnull"=>1,"dtype"=>"int");


        $this->columns[] = array("name" => "xsl_template", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0,"dtype"=>"string");
        $this->columns[] = array("name" => "include_template", "type" => DB_COLUMN_NUMERIC,"dtype"=>"int","notnull"=>0,"length"=>1);

        $this->columns[] = array("name" => "publication_type", "type" => DB_COLUMN_NUMERIC,"length"=>2,"notnull"=>0);
        $this->columns[] = array("name" => "sort_field", "type" => DB_COLUMN_NUMERIC,"length"=>2,"notnull"=>0);
        $this->columns[] = array("name" => "sort_order", "type" => DB_COLUMN_NUMERIC,"length"=>2,"notnull"=>0);
        $this->columns[] = array("name" => "start_index", "type" => DB_COLUMN_NUMERIC,"length"=>10,"notnull"=>0);
        $this->columns[] = array("name" => "end_index", "type" => DB_COLUMN_NUMERIC,"length"=>10,"notnull"=>0);

        $this->columns[] = array("name" => "header", "type" => DB_COLUMN_STRING,"length"=>10000,"notnull"=>0,"dtype"=>"string");
        $this->columns[] = array("name" => "footer", "type" => DB_COLUMN_STRING,"length"=>10000,"notnull"=>0,"dtype"=>"string");

        $this->columns[] = array("name" => "records_per_page", "type" => DB_COLUMN_NUMERIC,"length"=>10,"notnull"=>0);
        $this->columns[] = array("name" => "pages_per_decade", "type" => DB_COLUMN_NUMERIC,"length"=>10,"notnull"=>0);

        $this->columns[] = array("name" => "priveledged_only", "type" => DB_COLUMN_NUMERIC,"dtype"=>"int","notnull"=>0,"length"=>1);
        $this->columns[] = array("name" => "expose", "type" => DB_COLUMN_NUMERIC,"dtype"=>"int","notnull"=>0,"length"=>1);
        $this->columns[] = array("name" => "always_on_page", "type" => DB_COLUMN_NUMERIC,"dtype"=>"int","notnull"=>0,"length"=>1);
        $this->columns[] = array("name" => "enable_comments", "type" => DB_COLUMN_NUMERIC,"dtype"=>"int","notnull"=>0,"length"=>1);
        $this->columns[] = array("name" => "navigation", "type" => DB_COLUMN_NUMERIC,"dtype"=>"int","notnull"=>0,"length"=>1);
    }

    /**
    * Method gets info about given mapping point for specified page ID
    * @param   int     $_page_id   SYSTEM page ID
    * @return  MYSQLReader    MySQL Reader object
    * @access  public
    **/
    function GetMappingList($_page_id){//, $_host_publication_id=0
    	$SQL = sprintf("SELECT m.*,
                           p.*,
                           t.*,
                           m.target_entry_point as target_entry_point
                    FROM %s as m, %s as p, %s as t
                    WHERE m.page_id IN (0, %d)
                      AND m.publication_id = p.publication_id
                      AND p.template_id = t.template_id
                      AND m.active = 1
                      AND p.active_%s = 1
                      AND p.is_modified = 0
                      AND p.copy_of_id = 0
                      AND t.active = 1"."
                      AND (m.expose = 1)
                      "."
                   ORDER BY m._priority
                   ", $this->defaultTableName,
        $this->GetTable("PublicationsTable"),
        $this->GetTable("TemplatesTable"),
        $_page_id, $this->Connection->Kernel->Language//, $_host_publication_id

        );
        return $this->Connection->ExecuteReader($SQL);

    }

    /**
    * Method gets info about given mapping point for specified page ID
    * @param   int     $_page_id   SYSTEM page ID
    * @return  MYSQLReader    MySQL Reader object
    * @access  public
    **/
    function GetPermanentPageMappings($_page_id){
    	$SQL = sprintf("SELECT m.*,
                           p.*,
                           t.*,
                           m.target_entry_point as target_entry_point
                    FROM %s as m, %s as p, %s as t
                    WHERE m.page_id = %d
                      AND m.always_on_page = 1
                      AND m.publication_id = p.publication_id
                      AND p.template_id = t.template_id
                      AND m.active = 1
                      AND p.active_%s = 1
                      AND p.is_modified = 0
                      AND p.copy_of_id = 0
                      AND t.active = 1"."
                      AND (m.expose = 1)
                      "."
                   ORDER BY m._priority
                   ", $this->defaultTableName,
        $this->GetTable("PublicationsTable"),
        $this->GetTable("TemplatesTable"),
        $_page_id, $this->Connection->Kernel->Language//, $_host_publication_id
        );

        return $this->Connection->ExecuteReader($SQL);

    }



    /**
    * Method gets info about given mapping point for specified page ID
    * @param   int     $_page_id   SYSTEM page ID
    * @return  MYSQLReader    MySQL Reader object
    * @access  public
    **/
    function GetRecursiveMappingList($_page_id, $_publication_id, $_parent=0){
    	$SQL = sprintf("SELECT p.template_id, m.*,
                           p.*,
                           t.*,
                           m.target_entry_point as target_entry_point
                           %s
                    FROM %s as m, %s as p, %s as t
                    WHERE m.publication_id = %d
                      AND m.page_id = %d
                      AND m.page_id>0
                      AND m.publication_id = p.publication_id
                      AND p.template_id = t.template_id
                      AND m.active = 1
                      AND p.active_%s = 1
                      AND p.is_modified = 0
                      AND p.copy_of_id = 0
                      AND t.active = 1
                      AND ((m.publication_id = %d) OR (m.expose = 1))
                   ORDER BY m._priority
                   ", 	($_parent>0 ? ", ".$_parent." AS publication_category" : ""),
                   		$this->defaultTableName,
				        $this->GetTable("PublicationsTable"),
				        $this->GetTable("TemplatesTable"),
				        $_publication_id,
				        $_page_id,
				        $this->Connection->Kernel->Language,
				        $_publication_id

        );
        $_tmp = $this->Connection->ExecuteReader($SQL);

        // if no mapping found
        if($_tmp->RecordCount == 0){
            // getting publication storage
            $_pub_storage = DataFactory::GetStorage($this->Connection->Kernel->Page, "PublicationsTable", "", false, "publications");
            // getting current publication record
            $_rec = $_pub_storage->Get(array("publication_id" => $_publication_id));
            if(empty($_rec)){
                // if empty - possible error - return empty mappings list
                return array();
            } else {
            	if ($_parent==0) $parent=$_rec["parent_id"]; else $parent=$_parent;
                // if not empty - getting parent publication object
                $_rec = $_pub_storage->Get(array("publication_id" => $_rec["parent_id"]));
                // if empty
                if(empty($_rec)){
                    // return empty array
                    return array();
                } else {
                    // calling recursive method to get mapping for parent publication
                    $_tmp = $this->GetRecursiveMappingList($_page_id, $_rec["publication_id"], $parent);
                }
            }

        }
        return $_tmp;
    }

    function GetRecursiveMappingListTags($_publication_id, $_parent=0){
    	$SQL = sprintf("SELECT p.template_id, m.*,
                           p.*,
                           t.*,
                           m.target_entry_point as target_entry_point
                           %s
                    FROM %s as m, %s as p, %s as t
                    WHERE m.publication_id = %d

                      AND m.page_id>0
                      AND m.publication_id = p.publication_id
                      AND p.template_id = t.template_id
                      AND m.active = 1
                      AND p.active_%s = 1
                      AND p.is_modified = 0
                      AND p.copy_of_id = 0
                      AND t.active = 1
                      AND ((m.publication_id = %d) OR (m.expose = 1))
                   ORDER BY m._priority
                   ", 	($_parent>0 ? ", ".$_parent." AS publication_category" : ""),
                   		$this->defaultTableName,
				        $this->GetTable("PublicationsTable"),
				        $this->GetTable("TemplatesTable"),
				        $_publication_id,
				        $this->Connection->Kernel->Language,
				        $_publication_id);

        $_tmp = $this->Connection->ExecuteReader($SQL);
        if($_tmp->RecordCount == 0){
            $_pub_storage = DataFactory::GetStorage($this->Connection->Kernel->Page, "PublicationsTable", "", false, "publications");
            $_rec = $_pub_storage->Get(array("publication_id" => $_publication_id));
            if(empty($_rec)){
                return array();
            } else {
            	if ($_parent==0) $parent=$_rec["parent_id"]; else $parent=$_parent;
                $_rec = $_pub_storage->Get(array("publication_id" => $_rec["parent_id"]));
                if(empty($_rec))
                    return array();
                else
                    $_tmp = $this->GetRecursiveMappingListTags($_rec["publication_id"], $parent);
            }
        }
        return $_tmp;
    }


    function GetMappingsForSelectBaseMapping($data = null, $orders = null, $limitCount = null, $limitOffset = null, $ids = null,  $table_alias="", $raw_sql=array()){
        $raw_sql=array("select"=>"mapping_id, CONCAT(caption, ' (', system_name, ')') AS caption", "where"=>"page_id>0", );
		$Reader=$this->GetList($data, $orders, $limitCount, $limitOffset, $ids, $table_alias, $raw_sql);
		return $Reader;
	}

} //--end of class

?>