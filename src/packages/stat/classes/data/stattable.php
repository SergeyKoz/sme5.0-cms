<?php
$this->ImportClass("module.data.projecttable", "ProjectTable");

class StatTable extends ProjectTable
{
  var $ClassName = "StatTable";
  var $Version = "1.0";

/**
 * Class constructor
 * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
 * @param  MySqlConnection   $Connection Connection object
 * @param  string    $TableName    Table name
 * @access public
 */
	function StatTable(&$Connection, $TableName) {
	    ProjectTable::ProjectTable($Connection, $TableName);
	}

	function prepareColumns()
	{
/*
        $this->columns[] = array("name" => "message_id", "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
		$this->columns[] = array("name" => "message", "type" => DB_COLUMN_STRING,"length"=>4096,"notnull"=>0,"dtype"=>"string");
		$this->columns[] = array("name" => "email", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0,"dtype"=>"string");
		$this->columns[] = array("name" => "signature", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0,"dtype"=>"string");
		$this->columns[] = array("name" => "comment", "type" => DB_COLUMN_STRING,"length"=>4096,"notnull"=>0,"dtype"=>"string");
		$this->columns[] = array("name" => "language", "type" => DB_COLUMN_STRING,"length"=>2,"notnull"=>1,"dtype"=>"string");
		$this->columns[] = array("name" => "posted_date", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0,"dtype"=>"string");
		$this->columns[] = array("name" => "_lastmodified", "type" => DB_COLUMN_STRING,"length"=>255,"notnull"=>0,"dtype"=>"string");
		parent::prepareColumns();
*/
	}
	/**
	 * Return max hits of choosen period
	 *
	 * @return int
	 */
	function GetPeriodHits()
	{
        $date_clause = $this->MakeSqlForDate();
        if (strlen($date_clause) > 0)
        {
            $date_clause = " WHERE $date_clause ";;
        }
		$SQL = sprintf("
			SELECT
				COUNT(id) AS hits
			FROM %s
			%s
			", $this->getTable("StatTable"), $date_clause);
        $_tmp = $this->Connection->ExecuteScalar($SQL);
        return $_tmp["hits"];
	}

	/**
	 * Get count of uniq hosts of choosen period
	 *
	 * @return int
	 */
	function GetPeriodHosts()
	{
        $date_clause = $this->MakeSqlForDate();
        if (strlen($date_clause) > 0)
        {
            $date_clause = " WHERE $date_clause ";;
        }
		$SQL = sprintf("
			SELECT
				COUNT(DISTINCT(remote_host)) AS hosts
			FROM %s
			%s
			", $this->getTable("StatTable"), $date_clause);
        $_tmp = $this->Connection->ExecuteScalar($SQL);
        return $_tmp["hosts"];
	}

	/**
	 * Get count of transfers of choosen period
	 *
	 * @return int
	 */
	function GetPeriodTransfers()
	{
        $date_clause = $this->MakeSqlForDate();
        if (strlen($date_clause) > 0)
        {
            $date_clause = " AND $date_clause ";;
        }
		$SQL = sprintf("
			SELECT
				COUNT(id) AS transfers
			FROM %s
			WHERE
				referer <> ''
			%s
			", $this->getTable("StatTable"), $date_clause);
        $_tmp = $this->Connection->ExecuteScalar($SQL);
        return $_tmp["transfers"];
	}
// --------

	/**
	 * Return Hits count (overall, not of period)
	 *
	 * @return int
	 */
	function GetAverallHits()
	{
		$SQL = sprintf("
			SELECT
				COUNT(id) AS hits
			FROM %s
			", $this->getTable("StatTable"));
        $_tmp = $this->Connection->ExecuteScalar($SQL);
        return $_tmp["hits"];
	}

	/**
	 * Return uniq hosts count (overall, not of period)
	 *
	 * @return int
	 */
	function GetAverallHosts()
	{
		$SQL = sprintf("
			SELECT
				COUNT(DISTINCT(remote_host)) AS hosts
			FROM %s
			", $this->getTable("StatTable"));
        $_tmp = $this->Connection->ExecuteScalar($SQL);
        return $_tmp["hosts"];
	}

	/**
	 * Return transfers count - requests with not empty refers (overall, not of period)
	 *
	 * @return int
	 */
	function GetAverallTransfers()
	{
		$SQL = sprintf("
			SELECT
				COUNT(id) AS transfers
			FROM %s
			WHERE
				referer <> ''
			", $this->getTable("StatTable"));
        $_tmp = $this->Connection->ExecuteScalar($SQL);
        return $_tmp["transfers"];
	}

// --------
/**
    * Method gets a records from DB matching data  by limitcount and limitoffset
    * @param       array    $data        Array with data
    * @param       array    $orders      Array with orders
    * @param       int      $limitCount  Number of records to retrieve
    * @param       int      $limitoffset Offset of records to retrieve
    * @param             array      $ids                 Array of key fields values
    * @return      array    An associative array with record from DB
    * @access      public
    **/
	function &GetRefererDomainList($data = null, $orders = null, $limitCount = null, $limitOffset = null,$ids = null)
	{
        $date_clause = $this->MakeSqlForDate();
        if (strlen($date_clause) > 0)
        {
            $date_clause = " WHERE $date_clause ";;
        }
		$SQL = sprintf("
            SELECT
                id AS id,
                referer_domain AS ref,
                COUNT(referer) AS ref_count
            FROM %s
                %s
            GROUP BY ref
            ORDER BY ref_count DESC
            LIMIT %d, %d
			", $this->getTable("StatTable"),
		  $date_clause,
		  $limitOffset, $limitCount
		);
        $reader =& $this->Connection->ExecuteReader($SQL);
        return $reader;
	}

    function GetRefererDomainListCount($data = null, $table_alias="", $raw_sql=array())
	{
        $date_clause = $this->MakeSqlForDate();
        if (strlen($date_clause) > 0)
        {
            $date_clause = " WHERE $date_clause ";;
        }
		$SQL = sprintf("
            SELECT
                COUNT(DISTINCT(referer_domain)) AS counter
            FROM %s
                %s
			",
		    $this->getTable("StatTable"),
		    $date_clause
		);
        $_tmp = $this->Connection->ExecuteScalar($SQL);
        return $_tmp["counter"];
    }

	/**
	 * Return SQL query for choosen period
	 *
	 * @return string
	 */
	function MakeSqlForDate()
	{
		$SQL = '';
		$date_period = $this->Connection->Kernel->Page->Session->Get('date_period');
        if (isset($date_period))
        {
    		if (strlen($date_period['start']) > 0)
    		{
    			$SQL = " visit_date >= '{$date_period['start']} 00:00:00'";
    		}
    		if (strlen($date_period['end']) > 0)
    		{
    			$SQL .= " AND visit_date <= '{$date_period['end']} 23:59:59'";
    		}
        }
        return $SQL;
	}

	/**
	 * Return domain name by id of record in table
	 *
	 * @param int $record_id
	 * @return string
	 */
	function GetRefererDomainById($record_id)
	{
		$SQL = sprintf("
            SELECT
                referer_domain AS referer
            FROM %s
            WHERE id=%d
			", $this->getTable("StatTable"), $record_id
		);
        $_tmp = $this->Connection->ExecuteScalar($SQL);
        return $_tmp["referer"];

	}

	/**
	 * Reader for ItemsListControl, return abstarct table with data of referers
	 *
	 * @param unknown $data
	 * @param unknown $orders
	 * @param unknown $limitCount
	 * @param unknown $limitOffset
	 * @param unknown $ids
	 * @return object
	 */
	function &GetRefererDetailList($data = null, $orders = null, $limitCount = null, $limitOffset = null,$ids = null)
	{
        $date_clause = $this->MakeSqlForDate();
        if (strlen($date_clause) > 0)
        {
            $date_clause .= " AND ";;
        }
		$SQL = sprintf("
            SELECT
                id AS id,
                referer AS ref,
                COUNT(referer) AS ref_count
            FROM %s
            WHERE
                %s
                referer_domain='%s'
            GROUP BY ref
            ORDER BY ref
            LIMIT %d, %d
			",
    		$this->getTable("StatTable"),
    		$date_clause,
		    $this->Connection->Kernel->Page->referer_domain,
            $limitOffset, $limitCount
		);
        $reader =& $this->Connection->ExecuteReader($SQL);
        return $reader;
	}

	function GetRefererDetailListCount($data = null, $table_alias="", $raw_sql=array())
	{
        $date_clause = $this->MakeSqlForDate();
        if (strlen($date_clause) > 0)
        {
            $date_clause .= " AND ";;
        }
		$SQL = sprintf("
            SELECT
                COUNT(DISTINCT(referer)) AS counter
            FROM %s
            WHERE
                %s
                referer_domain='%s'
			", $this->getTable("StatTable"),
		    $date_clause,
		    $this->Connection->Kernel->Page->referer_domain
		);
		$_tmp = $this->Connection->ExecuteScalar($SQL);
        return $_tmp["counter"];
    }

    /**
     * Return reader with stat data: hits, hosts, refers grouped by hour
     *
     * @return object
     */
    function GetStatHourly()
    {
        $date_clause = $this->MakeSqlForDate();
        if (strlen($date_clause) > 0)
        {
            $date_clause = " WHERE $date_clause";;
        }
		$SQL = sprintf("
            SELECT
                COUNT(DISTINCT(remote_host)) AS c_hosts,
                COUNT(DISTINCT(referer_domain)) AS c_refs,
                COUNT(HOUR(visit_date)) AS c_hits,
                HOUR (visit_date) AS hour_val
            FROM %s %s
            GROUP BY HOUR (visit_date)
            ORDER BY hour_val
			",
    		$this->getTable("StatTable"),
    		$date_clause
		);
        $reader =& $this->Connection->ExecuteReader($SQL);
        return $reader;
    }

    /**
     * Return reader with stat data: hits, hosts, refers grouped by week
     *
     * @return object
     */
    function GetStatWeekly()
    {
        $date_clause = $this->MakeSqlForDate();
        if (strlen($date_clause) > 0)
        {
            $date_clause = " WHERE $date_clause";;
        }
		$SQL = sprintf("
                SELECT
                    COUNT(DISTINCT(remote_host)) AS c_hosts,
                    COUNT(DISTINCT(referer_domain)) AS c_refs,
                    COUNT(DAYOFWEEK(visit_date)) AS c_hits,
                    DAYOFWEEK(visit_date) AS dow_val
                FROM %s %s
                GROUP BY DAYOFWEEK(visit_date)
                ORDER BY dow_val
			",
    		$this->getTable("StatTable"),
    		$date_clause
		);
        $reader =& $this->Connection->ExecuteReader($SQL);
        return $reader;
    }

    /**
     * Return reader with stat data: hits, hosts, refers grouped by day of month
     *
     * @return object
     */
    function GetStatDaily()
    {
        $date_clause = $this->MakeSqlForDate();
        if (strlen($date_clause) > 0)
        {
            $date_clause = " WHERE $date_clause";;
        }
		$SQL = sprintf("
                SELECT
                    COUNT(DISTINCT(remote_host)) AS c_hosts,
                    COUNT(DISTINCT(referer_domain)) AS c_refs,
                    COUNT(DAYOFMONTH(visit_date)) AS c_hits,
                    DAYOFMONTH(visit_date) AS dom_val
                FROM %s %s
                GROUP BY DAYOFMONTH(visit_date)
                ORDER BY dom_val
			",
    		$this->getTable("StatTable"),
    		$date_clause
		);
//		print $SQL;
        $reader =& $this->Connection->ExecuteReader($SQL);
        return $reader;
    }


    /**
     * Return reader with stat data: hits, hosts, refers grouped by month
     *
     * @return object
     */
    function GetStatMonthly()
    {
        $date_clause = $this->MakeSqlForDate();
        if (strlen($date_clause) > 0)
        {
            $date_clause = " WHERE $date_clause";;
        }
		$SQL = sprintf("
                SELECT
                    COUNT(DISTINCT(remote_host)) AS c_hosts,
                    COUNT(DISTINCT(referer_domain)) AS c_refs,
                    COUNT(MONTH(visit_date)) AS c_hits,
                    MONTH(visit_date) AS m_val
                FROM %s %s
                GROUP BY MONTH(visit_date)
                ORDER BY m_val
			",
    		$this->getTable("StatTable"),
    		$date_clause
		);
//		print $SQL;
        $reader =& $this->Connection->ExecuteReader($SQL);
        return $reader;
    }

    /**
     * Return reader with stat data: hits, hosts, refers grouped by year
     *
     * @return object
     */
    function GetStatYearly()
    {
        $date_clause = $this->MakeSqlForDate();
        if (strlen($date_clause) > 0)
        {
            $date_clause = " WHERE $date_clause";;
        }
		$SQL = sprintf("
                SELECT
                    COUNT(DISTINCT(remote_host)) AS c_hosts,
                    COUNT(DISTINCT(referer_domain)) AS c_refs,
                    COUNT(MONTH(visit_date)) AS c_hits,
                    YEAR(visit_date) AS year_val
                FROM %s %s
                GROUP BY YEAR(visit_date)
                ORDER BY year_val
			",
    		$this->getTable("StatTable"),
    		$date_clause
		);
        $reader =& $this->Connection->ExecuteReader($SQL);
        return $reader;
    }

/**
    * Method gets a records from DB matching data  by limitcount and limitoffset
    * @param       array    $data        Array with data
    * @param       array    $orders      Array with orders
    * @param       int      $limitCount  Number of records to retrieve
    * @param       int      $limitoffset Offset of records to retrieve
    * @param             array      $ids                 Array of key fields values
    * @return      array    An associative array with record from DB
    * @access      public
    **/
	function &GetPopularPagesList($data = null, $orders = null, $limitCount = null, $limitOffset = null,$ids = null)
	{
        $date_clause = $this->MakeSqlForDate();
        if (strlen($date_clause) > 0)
        {
            $date_clause = " WHERE $date_clause ";;
        }
		$SQL = sprintf("
            SELECT
                DISTINCT(request_url) AS req,
                COUNT(request_url) AS req_count,
                id AS id
            FROM %s %s
            GROUP BY req
            ORDER BY req_count DESC
            LIMIT %d, %d
			", $this->getTable("StatTable"),
		  $date_clause,
		  $limitOffset, $limitCount
		);
        $reader =& $this->Connection->ExecuteReader($SQL);
        return $reader;
	}

    /**
     * for ItemsListControl, get pages count of popular pages
     *
     * @param unknown $data
     * @param unknown $table_alias
     * @param unknown $raw_sql
     * @return int
     */
    function GetPopularPagesListCount($data = null, $table_alias="", $raw_sql=array())
	{
        $date_clause = $this->MakeSqlForDate();
        if (strlen($date_clause) > 0)
        {
            $date_clause = " WHERE $date_clause ";;
        }
		$SQL = sprintf("
            SELECT
                COUNT(DISTINCT(request_url)) AS counter
            FROM %s %s
			",
		    $this->getTable("StatTable"),
		    $date_clause
		);
        $_tmp = $this->Connection->ExecuteScalar($SQL);
        return $_tmp["counter"];
    }

	/**
	 * Return count of days with not empty data
	 *
	 * @return int
	 */
	function GetAvailDaysCount()
	{
		$SQL = sprintf("
			SELECT
				COUNT(DISTINCT(DATE_FORMAT(visit_date, '%%Y-%%m-%%d'))) AS days_count
			FROM %s
			", $this->getTable("StatTable"));
        $_tmp = $this->Connection->ExecuteScalar($SQL);
        return $_tmp["days_count"];
	}

	/**
	 * Return array with keys 'date' - date when registered maximum visitors and 'count' - count of visitors in that day
	 *
	 * @return array
	 */
	function GetMaxVisitorsDay()
	{
		$SQL = sprintf("
            SELECT
            DISTINCT(DATE_FORMAT(visit_date, '%%d.%%m.%%Y')) AS date_max_visits,
            COUNT(DATE_FORMAT(visit_date, '%%d.%%m.%%Y')) AS max_visits
            FROM %s
            GROUP BY DATE_FORMAT(visit_date, '%%d.%%m.%%Y')
            ORDER BY max_visits DESC
			", $this->getTable("StatTable"));
        $_tmp = $this->Connection->ExecuteScalar($SQL);
        return array(
            'date' => $_tmp["date_max_visits"],
            'count' => $_tmp["max_visits"]
        );
	}

	/**
	 * Return date/time of first visit
	 *
	 * @return string
	 */
	function GetDateOfFirstVisit()
	{
		$SQL = sprintf("
            SELECT
            DATE_FORMAT(MIN(visit_date), '%%d.%%m.%%Y %%H:%%i') AS first_visit
            FROM %s
			", $this->getTable("StatTable"));
        $_tmp = $this->Connection->ExecuteScalar($SQL);
        return $_tmp["first_visit"];
	}

	/**
	 * Return date/time of last visit
	 *
	 * @return string
	 */
	function GetDateOfLastVisit()
	{
		$SQL = sprintf("
            SELECT
            DATE_FORMAT(MAX(visit_date), '%%d.%%m.%%Y %%H:%%i') AS first_visit
            FROM %s
			", $this->getTable("StatTable"));
        $_tmp = $this->Connection->ExecuteScalar($SQL);
        return $_tmp["first_visit"];
	}
}

?>