<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

class FotosTable extends ProjectTable
{
  var $ClassName = "FotosTable";
  var $Version = "1.0";

/**
 * Class constructor
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @param  MySqlConnection   $Connection Connection object
 * @param  string    $TableName    Table name
 * @access public
 */
    function FotosTable(&$Connection, $TableName) {
        ProjectTable::ProjectTable($Connection, $TableName);
    }

    function prepareColumns()
    {
        $this->columns[] = array("name" => "foto_id",            "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
        $this->columns[] = array("name" => "contest_id",         "type" => DB_COLUMN_NUMERIC);

        $this->columns[] = array("name" => "caption_%s",         "type" => DB_COLUMN_STRING,  "length"=>255,    "notnull"=>0, "dtype"=>"string");
        $this->columns[] = array("name" => "author_%s",          "type" => DB_COLUMN_STRING,  "length"=>255,    "notnull"=>0, "dtype"=>"string");
        $this->columns[] = array("name" => "author_email",       "type" => DB_COLUMN_STRING,  "length"=>255,    "notnull"=>0, "dtype"=>"email");
        $this->columns[] = array("name" => "description_%s",     "type" => DB_COLUMN_STRING,  "length"=>16000,  "notnull"=>0, "dtype"=>"string");
        $this->columns[] = array("name" => "date_posted",        "type" => DB_COLUMN_STRING,  "length"=>255,    "notnull"=>0, "dtype"=>"date");

        $this->columns[] = array("name" => "shown",              "type" => DB_COLUMN_NUMERIC, "length"=>1,      "notnull"=>0, "dtype"=>"int");
        $this->columns[] = array("name" => "current_shown",      "type" => DB_COLUMN_NUMERIC, "length"=>1,      "notnull"=>0, "dtype"=>"int");
        $this->columns[] = array("name" => "votes_count",        "type" => DB_COLUMN_NUMERIC, "length"=>10,     "notnull"=>0, "dtype"=>"int");
        $this->columns[] = array("name" => "foto_file",          "type" => DB_COLUMN_STRING,  "length"=>255,    "notnull"=>0, "dtype"=>"string");
        $this->columns[] = array("name" => "foto_file_thumb",    "type" => DB_COLUMN_STRING,  "length"=>255,    "notnull"=>0, "dtype"=>"string");

        $this->columns[] = array("name" => "time_shown",         "type" => DB_COLUMN_STRING,  "length"=>255,    "notnull"=>0, "dtype"=>"date");

        $this->columns[] = array("name" => "_lastmodified",      "type" => DB_COLUMN_STRING,  "length"=>255,    "notnull"=>0, "dtype"=>"string");
        parent::prepareColumns();
    }


    /**
    * Method returns new selected foto if time is up, or currently selected foto otherwise
    * @param int    $interval   Interval in seconds of rotating fotos
    * @return  array    Array with foto data
    * @access public
    **/
    function GetNewFoto($interval){

          $time_to_rotate = time() - 60*$interval;
          // Checking if time to change foto

          $SQL = sprintf("SELECT f.*, c.caption_%s as contest_caption
                            FROM %s as f, %s as c
                            WHERE f.contest_id = c.contest_id
                            AND c.rotate_fotos = 1
                            AND c.active = 1
                            AND f.active = 1
                            AND current_shown = 1
                            ORDER BY f.time_shown DESC
                            LIMIT 0, 1
                            ",
                            $this->Connection->Kernel->Language,
                            $this->GetTable("FotosTable"),
                            $this->GetTable("FotoContestsTable")
                        );
          // Getting Current Foto
          $current_foto = $this->Connection->ExecuteScalar($SQL);
          $curent_foto_id = $current_foto["foto_id"];
          if(!empty($current_foto)){
                 if($current_foto["time_shown"] < $time_to_rotate){
                     // Setting new foto to show
                     $SQL = sprintf("SELECT f.*, c.caption_%s  as contest_caption
                            FROM %s as f, %s as c
                            WHERE f.contest_id = c.contest_id
                            AND c.rotate_fotos = 1
                            AND c.active = 1
                            AND f.active = 1
                            AND shown = 0
                            ORDER BY RAND()
                            LIMIT 0, 1
                            ",
                            $this->Connection->Kernel->Language,
                            $this->GetTable("FotosTable"),
                            $this->GetTable("FotoContestsTable")
                        );
                     $current_foto = $this->Connection->ExecuteScalar($SQL);
                     if(!empty($current_foto)){
                        //found new foto. setting flags and date of selection
                        $update_data = array("foto_id" => $current_foto["foto_id"],
                                            "current_shown" => 1,
                                            "shown" => 1,
                                            "time_shown" => time()
                                );
                        $this->Update($update_data);
                        return $current_foto;
                     } else {
                        // No not shown fotos left. Reseting Shown flag and selecting new foto;

                        $SQL = sprintf("UPDATE %s
                                        SET shown = 0,
                                            current_shown = 0",
                                        $this->GetTable("FotosTable")
                        );
                        $this->Connection->ExecuteNonQuery($SQL);

                        $SQL = sprintf("SELECT f.*, c.caption_%s  as contest_caption
                            FROM %s as f, %s as c
                            WHERE f.contest_id = c.contest_id
                            AND c.rotate_fotos = 1
                            AND c.active = 1
                            AND f.active = 1
                            AND shown = 0
                            AND foto_id != %d
                            ORDER BY RAND()
                            LIMIT 0, 1
                            ",
                            $this->Connection->Kernel->Language,
                            $this->GetTable("FotosTable"),
                            $this->GetTable("FotoContestsTable"),
                            $curent_foto_id
                        );
                        $current_foto = $this->Connection->ExecuteScalar($SQL);

                        $update_data = array("foto_id" => $current_foto["foto_id"],
                                            "current_shown" => 1,
                                            "shown" => 1,
                                            "time_shown" => time()
                                );
                        $this->Update($update_data);
                        return $current_foto;



                     }
                 }  else {
                    // Returning NOT expired Current Foto
                    return $current_foto;
                 }
          } else {
          // No current foto found at all. setting current foto
              $SQL = sprintf("SELECT f.*, c.caption_%s  as contest_caption
                            FROM %s as f, %s as c
                            WHERE f.contest_id = c.contest_id
                            AND c.rotate_fotos = 1
                            AND c.active = 1
                            AND f.active = 1
                            AND shown = 0
                            AND foto_id != %d
                            ORDER BY RAND()
                            LIMIT 0, 1
                            ",
                            $this->Connection->Kernel->Language,
                            $this->GetTable("FotosTable"),
                            $this->GetTable("FotoContestsTable"),
                            $curent_foto_id
                        );
              $current_foto = $this->Connection->ExecuteScalar($SQL);

              $update_data = array("foto_id" => $current_foto["foto_id"],
                                            "current_shown" => 1,
                                            "shown" => 1,
                                            "time_shown" => time()
                                );
              $this->Update($update_data);
              return $current_foto;


          }

    }

}

?>