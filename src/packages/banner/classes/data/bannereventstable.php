<?php
$this->ImportClass("system.data.abstracttable", "AbstractTable");
define('BANNER_EVENT_VIEW', 0);
define('BANNER_EVENT_CLICK', 1);

/** Banner events storage class
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package Banner
 * @subpackage classes.data
 * @access public
 */
class BannerEventsTable extends AbstractTable   {
  var $ClassName = "BannerEventsTable";
  var $Version = "1.0";
  

 function prepareColumns() {  
  $this->columns[] = array("name" => "banner_id",     "type" => DB_COLUMN_NUMERIC,   "length"=>255,   "notnull"=>1);
  $this->columns[] = array("name" => "page_id",       "type" => DB_COLUMN_NUMERIC,   "length"=>255,   "notnull"=>1);
  $this->columns[] = array("name" => "place_id",      "type" => DB_COLUMN_NUMERIC,   "length"=>255,   "notnull"=>1);
  $this->columns[] = array("name" => "event_type",    "type" => DB_COLUMN_NUMERIC,   "length"=>255,   "notnull"=>1);  
  $this->columns[] = array("name" => "event_time",    "type" => DB_COLUMN_STRING,    "length"=>10,    "notnull"=>1);
  $this->columns[] = array("name" => "language",      "type" => DB_COLUMN_STRING,    "length"=>2,     "notnull"=>1);
  $this->columns[] = array("name" => "ip",            "type" => DB_COLUMN_STRING,    "length"=>10,    "notnull"=>1);

  //    parent::prepareColumns();
 }

  /**
  * Method returns quantities of banners that could be allocated in each banner placeholder
  * @return     MySQLReader   Reader of banner placeholder data
  * @access     public
  **/
  function LogEvent($banner_id, $page_id, $place_id, $event_type=BANNER_EVENT_VIEW, $language=null){
      $data = array("banner_id"=>$banner_id,
                          "page_id"  => $page_id,
                          "place_id" => $place_id,
                          "event_type" => $event_type,
                          "event_time" => date("Y-m-d H:i:s", time()),
                          "language" => ($language === null ? $this->Connection->Kernel->Language : $language),
                          "ip" => sprintf("%u",ip2long($_SERVER["REMOTE_ADDR"]))
      );
      $this->Insert($data);
  }
  
  /**
  * 
  *
  *
  ***/
  function GetDaysStats($start_date, $end_date, $event=BANNER_EVENT_VIEW){
        $SQL = sprintf("SELECT count(*) as counter 
                        FROM %s
                        WHERE event_type = %d
                          AND DATE_FORMAT(event_time, '%s') BETWEEN '%s' and '%s'
                        ", 
                        $this->defaultTableName,
                        $event,
                        "%Y%m%d",
                        date("Ymd", $start_date),
                        date("Ymd", $end_date)
            );
            
       $_tmp = $this->Connection->ExecuteScalar($SQL);
       //echo pr($_tmp);
       return $_tmp["counter"];
  }

  /**
  * Method gets distincive list of monthes covered with tatistics
  * @access public
  * @return MySQLReader Reader object
  **/
  function GetMonthList(){
       //$SQL = sprintf("SELECT DISTINCT(CONCAT(YEAR(event_time), '-', MONTH(event_time))) as month 
       $SQL = sprintf("SELECT DISTINCT(DATE_FORMAT(event_time, '%s')) as month 
                        FROM %s",
                        "%Y-%m",
                        $this->defaultTableName
       ); 
       return $this->Connection->ExecuteReader($SQL);
  }

  /**
  * Method gets distincive list of days for specified month covered with tatistics
  * @access public
  * @return MySQLReader Reader object
  **/
  function GetDaysList($data){
       $SQL = sprintf("SELECT DISTINCT(DATE_FORMAT(event_time, '%s')) as month 
                        FROM %s 
                        WHERE DATE_FORMAT(event_time, '%s') = '%s'
                        ORDER BY DATE_FORMAT(event_time, '%s')
                        ",
                        "%d",
                        $this->defaultTableName,
                        "%Y-%m", $data["month"],
                        "%d"
       ); 
       return $this->Connection->ExecuteReader($SQL);
  }
  
  
  /**
  * Method overrides default method for getting a key kolumns
  * @return array Array with key columns
  * @access public
  **/
  function GetKeyColumns(){
    return array(array("name" => "month",     "type" => DB_COLUMN_NUMERIC,   "length"=>255,   "notnull"=>1));
  }
  
  /**
  * Method returns reader with selected stats for specified month
  * @param  string  $month_id   Month of a year
  * @param  int     $event   Event type
  * @return MySQLReader
  * @access public
  **/
  function GetDailyStats($data, $event=BANNER_EVENT_VIEW){
    $SQL = sprintf("SELECT count(*) as counter, DATE_FORMAT(event_time, '%s') as _day 
                        FROM %s 
                        WHERE DATE_FORMAT(event_time, '%s')='%s'
                          AND event_type = %d 
                        %s
                        %s
                        %s
                        GROUP BY DATE_FORMAT(event_time, '%s') ORDER BY DATE_FORMAT(event_time, '%s')",
                        "%d",
                        $this->defaultTableName,
                        "%Y-%m", $data["month_id"],
                        $event,
                        ($data["banner_id"] ? sprintf("AND banner_id=%d", $data["banner_id"]) : ""),
                        ($data["page_id"] ? sprintf("AND page_id=%d", $data["page_id"]) : ""),
                        ($data["place_id"] ? sprintf("AND place_id=%d", $data["place_id"]) : ""),
                        
                        "%Y-%m-%d", "%Y-%m-%d"
                        );
    return $this->Connection->ExecuteReader($SQL);                    
  }

  /**
  * Method returns reader with selected stats for specified month
  * @param  string  $month_id   Month of a year
  * @param  int     $event   Event type
  * @return MySQLReader
  * @access public
  **/
  function GetDetailedStats($data, $event=BANNER_EVENT_VIEW){
    $SQL = sprintf("SELECT count(*) as counter, banner_id
                        FROM %s 
                        WHERE DATE_FORMAT(event_time, '%s')='%s'
                          AND event_type = %d 
                        %s
                        %s
                        %s
                        GROUP BY banner_id ORDER BY banner_id",
                        $this->defaultTableName,
                        "%Y-%m-%d", $data["date"],
                        $event,
                        ($data["banner_id"] ? sprintf("AND banner_id=%d", $data["banner_id"]) : ""),
                        ($data["page_id"] ? sprintf("AND page_id=%d", $data["page_id"]) : ""),
                        ($data["place_id"] ? sprintf("AND place_id=%d", $data["place_id"]) : "")
                        );
    return $this->Connection->ExecuteReader($SQL);                    
  }
  
  
} //--end of class

?>