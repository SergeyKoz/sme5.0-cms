<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

class FotoContestsTable extends ProjectTable
{
  var $ClassName = "FotoContestsTable";
  var $Version = "1.0";

/**
 * Class constructor
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @param  MySqlConnection   $Connection Connection object
 * @param  string    $TableName    Table name
 * @access public
 */
    function FotoContestsTable(&$Connection, $TableName) {
        ProjectTable::ProjectTable($Connection, $TableName);
    }

    function prepareColumns()
    {
        $this->columns[] = array("name" => "contest_id",          "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
        $this->columns[] = array("name" => "parent_id",          "type" => DB_COLUMN_NUMERIC);
        //$this->columns[] = array("name" => "_priority",           "type" => DB_COLUMN_NUMERIC);

        $this->columns[] = array("name" => "caption_%s",          "type" => DB_COLUMN_STRING,  "length"=>255,    "notnull"=>0, "dtype"=>"string");
        $this->columns[] = array("name" => "description_%s",      "type" => DB_COLUMN_STRING,  "length"=>16000,  "notnull"=>0, "dtype"=>"string");
        $this->columns[] = array("name" => "full_description_%s", "type" => DB_COLUMN_STRING,  "length"=>100000, "notnull"=>0, "dtype"=>"string");
        $this->columns[] = array("name" => "starts_from",         "type" => DB_COLUMN_STRING,  "length"=>255,    "notnull"=>0, "dtype"=>"date");
        $this->columns[] = array("name" => "ends_to",             "type" => DB_COLUMN_STRING,  "length"=>255,    "notnull"=>0, "dtype"=>"string");
        $this->columns[] = array("name" => "results_%s",          "type" => DB_COLUMN_STRING,  "length"=>100000, "notnull"=>0, "dtype"=>"string");
        $this->columns[] = array("name" => "expert_voting",       "type" => DB_COLUMN_NUMERIC, "length"=>1,      "notnull"=>0, "dtype"=>"int");

        $this->columns[] = array("name" => "show_results_count",  "type" => DB_COLUMN_NUMERIC, "length"=>3,      "notnull"=>0, "dtype"=>"int");
        $this->columns[] = array("name" => "contest_finished",    "type" => DB_COLUMN_NUMERIC, "length"=>1,      "notnull"=>0, "dtype"=>"int");
        $this->columns[] = array("name" => "disable_voting",      "type" => DB_COLUMN_NUMERIC, "length"=>1,      "notnull"=>0, "dtype"=>"int");
        $this->columns[] = array("name" => "rotate_fotos",        "type" => DB_COLUMN_NUMERIC, "length"=>1,      "notnull"=>0, "dtype"=>"int");
        $this->columns[] = array("name" => "is_default",              "type" => DB_COLUMN_NUMERIC, "length"=>1,      "notnull"=>0, "dtype"=>"int");
        $this->columns[] = array("name" => "total_voted",         "type" => DB_COLUMN_NUMERIC, "length"=>10,     "notnull"=>0, "dtype"=>"int");
        $this->columns[] = array("name" => "contest_logo",        "type" => DB_COLUMN_STRING,  "length"=>255,    "notnull"=>0, "dtype"=>"string");

        $this->columns[] = array("name" => "_lastmodified",       "type" => DB_COLUMN_STRING,  "length"=>255,    "notnull"=>0, "dtype"=>"string");

        $this->columns[] = array("name" => "rpp",         "type" => DB_COLUMN_NUMERIC, "length"=>10,     "notnull"=>1, "dtype"=>"int");
        $this->columns[] = array("name" => "ppd",         "type" => DB_COLUMN_NUMERIC, "length"=>10,     "notnull"=>1, "dtype"=>"int");
        parent::prepareColumns();
    }

    /**
    * Method returns valid contests sorted by date
    * @return   array  Array with sorted and disassembled data
    * @access   public
    **/
    function GetValidContests(){
        $selected_contest_id = $this->Connection->Kernel->Page->Request->ToNumber("contest_id", 0);
        $language = $this->Connection->Kernel->Language;
        $SQL = sprintf("SELECT c.contest_id,
                               c.is_default,
                               c.caption_%s as caption,
                               c.description_%s as description,
                               c.starts_from,
                               c.ends_to,
                               c.contest_finished,
                               c.contest_logo,
                               count(*) as cnt
                        FROM %s as c, %s as f
                        WHERE c.contest_id = f.contest_id
                         AND c.active = 1
                         AND f.active = 1
                        GROUP BY c.contest_id
                        ORDER BY c.starts_from DESC
                        ",
                        $language, $language,
                        $this->GetTable("FotoContestsTable"),
                        $this->GetTable("FotosTable")
                       );
        //prn($SQL);
        $_reader = $this->Connection->ExecuteReader($SQL);
        $_contests = array();

        for($i=0; $i<$_reader->RecordCount; $i++){
            $_tmp = $_reader->Read();

            if($selected_contest_id == $_tmp["contest_id"]){
                $_tmp["selected"] = 1;
            }
            if(($selected_contest_id == 0) && ($_tmp["is_default"]==1)){
                $_tmp["selected"] = 1;
            }

            $_tmp["contest_starts"] = Component::dateconv($_tmp["starts_from"]);
            $_tmp["contest_ends"] = Component::dateconv($_tmp["ends_to"]);
            $now = date("Y-m-d");



            if($_tmp["starts_from"] > $now){
                $_contests["agenda"][] = $_tmp;
            } elseif(($_tmp["starts_from"] <= $now) && ($_tmp["ends_to"] >= $now)){
                $_contests["now"][] = $_tmp;
            } else {
                $_contests["history"][] = $_tmp;
            }
        }
        return $_contests;

    }

}

?>