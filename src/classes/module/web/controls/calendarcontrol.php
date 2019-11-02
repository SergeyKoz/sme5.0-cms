<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");

/**
 * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
 * @version 1.0
 * @package Stat
 * @subpackage classes.web.controls
 * @access public
 */
define("CALENDAR_ACTION_CHOOSE_DAY", 1);
define("CALENDAR_ACTION_CHOOSE_WEEK", 2);
define("CALENDAR_ACTION_CHOOSE_MONTH", 3);
define("CALENDAR_ACTION_CHOOSE_YEAR", 4);
define("CALENDAR_ACTION_CHOOSE_NODAY", 5);
class CalendarControl extends XmlControl {
    var $ClassName = "CalendarControl";
    var $Version = "1.0";

    var $data = array();

    /**
    *  Method Sets initial data for the control
    * @param    array   $data       Array with initial data
    * @access   public
    */
    function SetData($data=array())
    {
        foreach($data as $key => $val)
        {
            $this->data[$key] = $val;
        }
    }

    /**
    * Method executes on control load
    * @access   public
    **/
    function ControlOnLoad()
    {
        $this->ReadSettings();
    }

    function ReadSettings()
    {
    	$this->_currentDate = getdate();
		if (isset($this->Page->Request->QueryString['c_day']))
		{
			$this->data['day'] = $this->Page->Request->QueryString['c_day'];
		} else {
			$this->data['day'] = $this->_currentDate['mday'];
		}
		if (isset($this->Page->Request->QueryString['c_mon']))
		{
			$this->data['month'] = $this->Page->Request->QueryString['c_mon'];
		} else {
    		$this->data['month'] = $this->_currentDate['mon'];
		}
		if (isset($this->Page->Request->QueryString['c_year']))
		{
			$this->data['year'] = $this->Page->Request->QueryString['c_year'];
		} else {
    		$this->data['year'] = $this->_currentDate['year'];
		}
		if (isset($this->Page->Request->QueryString['c_action']))
		{
			$this->data['action'] = $this->Page->Request->QueryString['c_action'];
			$this->data['default_values'] = false;
		} else {
    		$this->data['action'] = CALENDAR_ACTION_CHOOSE_DAY;
			$this->data['default_values'] = true;
		}
    }

	function MakeUrl($day, $month, $year, $action = null)
	{
	    if ($action == null)
	    {
	        $action = $this->data['action'];
	    }
		$url = sprintf('%sc_day=%d&c_mon=%d&c_year=%d&c_action=%d',
			$this->data['url'],
			$day, $month, $year, $action);
	    // cleanup url from dupes
		/*
		 * @todo parse whole uri
		**/
		if (substr($url, 0, 1) == '?')
		{
		    $url_parts = array();
		    foreach(explode('&', substr($url, 1)) as $tmp)
		    {
		        list($key, $val) = explode('=', $tmp);
		        $url_parts[$key] = $val;
		    }
		    $url = "?" . $this->BuildRequestQuery($url_parts);
		}

		return $url;
	}

    /**
    * Method draw XML data
    * @access   public
    **/
    function DrawCalender(&$xmlWriter)
    {
        if (strlen($this->data['url']) > 0)
        {
            $this->data['url'] .= '&';
        } else {
            $this->data['url'] = '?';
        }
		$this->_days_in_prev_month = date("t", mktime(0, 0, 0,
			$this->data['month'] - 1, 1, $this->data['year']));
		$this->_days_in_current_month = date("d",
			mktime(0, 0, 0, $this->data['month'] + 1, 0, $this->data['year']));
        if ($this->data['day'] > $this->_days_in_current_month)
        {
            $this->data['day'] = $this->_days_in_current_month;
        }
	    // LOCALIZATION
		// write XML with localized names of weekdays
    	$xmlWriter->WriteStartElement("localization");
	    	$xmlWriter->WriteStartElement("weekdays");
	    	foreach($this->Page->Kernel->Localization->GetItem('calendar', 'day') as $item)
	    	{
		    	$xmlWriter->WriteElementString("day", $item);
	    	}
	    	$monthName_localized = $this->Page->Kernel->Localization->GetItem('calendar', 'month');
			$xmlWriter->WriteEndElement("weekdays");
	    	$xmlWriter->WriteElementString("today",
	    		$this->Page->Kernel->Localization->GetItem('calendar', 'today'));
    	$xmlWriter->WriteEndElement("localization");
		// END OF LOCALIZATION
       	$week_caption = $this->Page->Kernel->Localization->GetItem('calendar', 'week_caption');

    	$xmlWriter->WriteStartElement("navigation");
	    	$xmlWriter->WriteElementString('today',
	    		$this->MakeUrl($this->_currentDate['mday'], $this->_currentDate['mon'], $this->_currentDate['year'],
	    		 CALENDAR_ACTION_CHOOSE_DAY));
	    	$xmlWriter->WriteElementString('prior_year',
	    		$this->MakeUrl(
	    		 $this->data['day'],
	    		 $this->data['month'], $this->data['year'] - 1));
	    	$xmlWriter->WriteElementString('next_year',
	    		$this->MakeUrl($this->data['day'], $this->data['month'], $this->data['year'] + 1));

	    	$tmp_year = $this->data['year'];
			$tmp_month = $this->data['month'] - 1;
			if ($tmp_month < 1)
			{
				$tmp_month = 12;
				$tmp_year--;
			}
	    	$xmlWriter->WriteElementString('prior_month',
	    		$this->MakeUrl($this->data['day'], $tmp_month, $tmp_year));

			$tmp_year = $this->data['year'];
			$tmp_month = $this->data['month'] + 1;
			if ($tmp_month > 12)
			{
				$tmp_month = 1;
				$tmp_year++;
			}
	    	$xmlWriter->WriteElementString('next_month',
	    		$this->MakeUrl($this->data['day'], $tmp_month, $tmp_year));
    	$xmlWriter->WriteEndElement("navigation");

    	$xmlWriter->WriteStartElement("date");
	    	$xmlWriter->WriteElementString("day", $this->data['day']);
	    	$xmlWriter->WriteElementString("month", $this->data['month']);
            // month value, caption and link
        	$xmlWriter->WriteStartElement("monthCaption");
    		$xmlWriter->WriteAttributeString('href',
				$this->MakeUrl($this->data['day'], $this->data['month'], $this->data['year'],
				    CALENDAR_ACTION_CHOOSE_MONTH)
    		);
			$xmlWriter->WriteEndAttribute();
	    	$xmlWriter->WriteString($monthName_localized[$this->data['month'] - 1]);
        	$xmlWriter->WriteEndElement("monthCaption");
            // year value, caption and link
        	$xmlWriter->WriteStartElement("year");
    		$xmlWriter->WriteAttributeString('href',
				$this->MakeUrl($this->data['day'], $this->data['month'], $this->data['year'],
				    CALENDAR_ACTION_CHOOSE_YEAR)
    		);
			$xmlWriter->WriteEndAttribute();
	    	$xmlWriter->WriteString($this->data['year']);
        	$xmlWriter->WriteEndElement("year");

	    	$xmlWriter->WriteElementString("yearShort",
	    		substr($this->data['year'], -2, 2));
    	$xmlWriter->WriteEndElement("date");
		// month starts at this week day
		$this->_start_weekDay = date("w", mktime(0, 0, 0,
			$this->data['month'], 1, $this->data['year']));
		if ($this->_start_weekDay == 0)
		{
			$this->_start_weekDay = 7;
		}

    	$xmlWriter->WriteStartElement("week");
    	// --- Create XML
		// if month starts not from monday, then
		// fill week with days of prior month
		for ($i = 1; $i < $this->_start_weekDay; $i++)
		{
	    	$xmlWriter->WriteStartElement("day");
			$xmlWriter->WriteAttributeString('outside', 1);
			if (($i == 6) || ($i == 7))
			{
				$xmlWriter->WriteAttributeString('weekend', 1);
			}
			$xmlWriter->WriteEndAttribute();
			$xmlWriter->WriteString($this->_days_in_prev_month - $this->_start_weekDay + 1 + $i);
	    	$xmlWriter->WriteEndElement("day");
		}
		// fill with days of current month
		$week_day = $this->_start_weekDay;
		for ($i = 1; $i <= $this->_days_in_current_month; $i++) {
			// weekend days
			if (($week_day == 6) || ($week_day == 7))
			{
				$is_weekend = true;
			} else {
				$is_weekend = false;
			}
			// end of week, starting from monday
			if ($week_day > 7)
			{
				$week_day = 1;
				// week "day" - select whole week element
    	    	$xmlWriter->WriteStartElement("day");
    			$xmlWriter->WriteAttributeString('href',
    				$this->MakeUrl($i - 1, $this->data['month'], $this->data['year'],
    				    CALENDAR_ACTION_CHOOSE_WEEK));
    			$xmlWriter->WriteEndAttribute();
    			$xmlWriter->WriteString($week_caption);
    	    	$xmlWriter->WriteEndElement("day");
				// end week "day"

		        $xmlWriter->WriteEndElement("week");
		    	$xmlWriter->WriteStartElement("week");
			}
	    	$xmlWriter->WriteStartElement("day");
			$xmlWriter->WriteAttributeString('href',
				$this->MakeUrl($i, $this->data['month'], $this->data['year'],
				    CALENDAR_ACTION_CHOOSE_DAY));

			if ($is_weekend)
			{
				$xmlWriter->WriteAttributeString('weekend', 1);
			}
	    	if (($i == $this->_currentDate['mday']) &&
	    		($this->data['month'] == $this->_currentDate['mon']) &&
    			($this->data['year'] == $this->_currentDate['year']))
			{
				$xmlWriter->WriteAttributeString('today', 1);
			}

	    	if (($this->data['day'] == $i) &&
	    	    ($this->data['action'] == CALENDAR_ACTION_CHOOSE_DAY))
			{
				$xmlWriter->WriteAttributeString('selected', 1);
			}

			$xmlWriter->WriteEndAttribute();
			$xmlWriter->WriteString($i);
	    	$xmlWriter->WriteEndElement("day");
			$week_day++;
		}
		// fill rest of week with days of next month
		$days_left = 8 - $week_day;
		for ($i = 1; $i <= $days_left; $i++)
		{
	    	$xmlWriter->WriteStartElement("day");
			$xmlWriter->WriteAttributeString('outside', 1);
			if (($week_day == 6) || ($week_day == 7))
			{
				$xmlWriter->WriteAttributeString('weekend', 1);
			}
			$xmlWriter->WriteEndAttribute();
			$xmlWriter->WriteString($i);
	    	$xmlWriter->WriteEndElement("day");
	    	$week_day++;
		}
		// draw week "day" - select whole week element
    	$xmlWriter->WriteStartElement("day");
    	// calculating date of last day in this week
		if ($days_left > 0)
		{
        	$tmp = getdate(mktime(0, 0, 0,
        	   $this->data['month'] + 1,
        	   1,
        	   $this->data['year']
        	));
        	$tmp['mday'] =  + $days_left;
		} else {
        	$tmp = getdate(mktime(0, 0, 0,
        	   $this->data['month'] + 1,
        	   0,
        	   $this->data['year']
        	));
		}
		// end of calculating
		$xmlWriter->WriteAttributeString('href',
			$this->MakeUrl($tmp['mday'], $tmp['mon'], $tmp['year'],
			    CALENDAR_ACTION_CHOOSE_WEEK));
		$xmlWriter->WriteEndAttribute();
			$xmlWriter->WriteString($week_caption);
    	$xmlWriter->WriteEndElement("day");
		// end week "day"
    	$xmlWriter->WriteEndElement("week");


    	$xmlWriter->WriteElementString('mode', $this->data['action']);
    }

    /**
    *  Method draws xml-content of control
    *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
    *  @access  public
    */
    function XmlControlOnRender(&$xmlWriter) {
		$this->DrawCalender($xmlWriter);
    }

} // class

?>