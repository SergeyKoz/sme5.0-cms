<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");

/**
 * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
 * @version 1.0
 * @package Stat
 * @subpackage classes.web.controls
 * @access public
 */

define("DATE_PERIOD_CUSTOM", 0);
define("DATE_PERIOD_WEEK", 1);
define("DATE_PERIOD_MONTH", 2);
define("DATE_PERIOD_QUARTER", 3);
define("DATE_PERIOD_YEAR", 4);
define("DATE_PERIOD_ALLTIME", 5);
define("DATE_PERIOD_SUBMIT_EVENT", "DatePeriodSelect");

class DatePeriodControl extends XmlControl {
    var $ClassName = "DatePeriodControl";
    var $Version = "1.0";

    var $data = array();
    /**
    * Method executes on control load
    * @access   public
    **/

    function SetData($data=array())
    {
        foreach($data as $key => $val)
        {
            $this->data[$key] = $val;
        }
    }
    function ControlOnLoad()
    {
		$this->data['period'] =	isset($this->Page->Request->Form['dateForm_periodSelector']) ?
		    $this->Page->Request->Form['dateForm_periodSelector'] : 5;
		$this->data['start_day'] = isset($this->Page->Request->Form['dateForm_dayEdit1']) ?
			$this->Page->Request->Form['dateForm_dayEdit1'] : date('d');
		$this->data['start_month'] = isset($this->Page->Request->Form['dateForm_monthEdit1']) ?
			$this->Page->Request->Form['dateForm_monthEdit1'] : date('m');
		$this->data['start_year'] = isset($this->Page->Request->Form['dateForm_yearEdit1']) ?
			$this->Page->Request->Form['dateForm_yearEdit1'] : date('Y');
		// end period date
		$this->data['end_day'] = isset($this->Page->Request->Form['dateForm_dayEdit2']) ?
			$this->Page->Request->Form['dateForm_dayEdit2'] : date('d');
		$this->data['end_month'] = isset($this->Page->Request->Form['dateForm_monthEdit2']) ?
			$this->Page->Request->Form['dateForm_monthEdit2'] : date('m');
		$this->data['end_year'] = isset($this->Page->Request->Form['dateForm_yearEdit2']) ?
			$this->Page->Request->Form['dateForm_yearEdit2'] : date('Y');
    	if (!isset($this->data['url']))
    	{
    	    $this->data['url'] = '?';
    	}

		if ($this->Page->Request->ToNumber('init', 0))
		{
			$this->Page->Request->Form['dateForm_periodSelector'] = 1;
			$this->data['period'] = DATE_PERIOD_WEEK;
		}

        if (isset($this->Page->Request->Form['dateForm_periodSelector']))
        {
        	$this->ParseAndValidate();
        } else {
            // if there are data in session variable then restore values
            $date_settings = $this->Page->Session->Get('date_period');
            if (isset($date_settings))
            {
                $this->data['start_date'] = $date_settings['start'];
                $this->data['end_date'] = $date_settings['end'];
                $this->data['start_month'] = $date_settings['start_month'];
                $this->data['start_day'] = $date_settings['start_day'];
                $this->data['start_year'] = $date_settings['start_year'];
                $this->data['end_month'] = $date_settings['end_month'];
                $this->data['end_day'] = $date_settings['end_day'];
                $this->data['end_year'] = $date_settings['end_year'];
                $this->data['period'] = $date_settings['period'];
            }
            // otherwise default values
        }
        // if form were submited, then set data['submited'] to "true"
        // otherwise false
        if ($this->Page->Request->Form['event'] == DATE_PERIOD_SUBMIT_EVENT)
        {
            $this->data['submited'] = true;
        } else {
            $this->data['submited'] = false;
        }
    }


    /**
    *   Method executes if no event assigned
    *   @access public
    **/
    function OnDefault()
    {
        $this->default = true;
    }

    function ParseAndValidate()
    {
    	$this->data['valid'] = true;
        $current_date = getdate(time());
        $this->data['start_date'] = null;
        $this->data['end_date'] = null;
        switch ($this->data['period'])
        {
            case DATE_PERIOD_CUSTOM:
        		if (checkdate(
        		      intval($this->data['start_month']),
        		      intval($this->data['start_day']),
        		      intval($this->data['start_year'])
        		    ))
        		{
                    $this->data['start_date'] =
                      strftime('%Y-%m-%d', mktime(0, 0, 0,
                        $this->data['start_month'],
                        $this->data['start_day'],
                        $this->data['start_year']));
        		} else {
        	    	$this->data['valid'] = false;
        			$this->AddErrorMessage('DATE_FORM', 'INVALID_START_DATE');
        		}
        		if (checkdate(
        		      intval($this->data['end_month']),
        		      intval($this->data['end_day']),
        		      intval($this->data['end_year'])
        		    ))
        		{
                    $this->data['end_date'] =
                      strftime('%Y-%m-%d', mktime(0, 0, 0,
                        $this->data['end_month'],
                        $this->data['end_day'],
                        $this->data['end_year']));
        		} else {
        	    	$this->data['valid'] = false;
        			$this->AddErrorMessage('DATE_FORM', 'INVALID_END_DATE');
        		}
        		// if date1 and date2 are valid, then check if date2 is greater date1
        		if ($this->data['valid'])
        		{
        		    if ($this->data['end_date'] < $this->data['start_date'])
        		    {
            	    	$this->data['valid'] = false;
            			$this->AddErrorMessage('DATE_FORM', 'INVALID_RANGE');
        		    }
        		}
        		break;
            case DATE_PERIOD_WEEK:
                $p_date = mktime(0, 0, 0,
                    $current_date['mon'],
                    $current_date['mday'] - 7,
                    $current_date['year']);
                $this->data['start_date'] = strftime('%Y-%m-%d', $p_date);
                $tmp = getdate($p_date);
                $this->data['start_day'] = $tmp['mday'];
                $this->data['start_month'] = $tmp['mon'];
                $this->data['start_year'] = $tmp['year'];
                break;
            case DATE_PERIOD_MONTH:
                $p_date = mktime(0, 0, 0,
                    $current_date['mon'],
                    $current_date['mday'] - 30,
                    $current_date['year']
                );
                $this->data['start_date'] = strftime('%Y-%m-%d', $p_date);
                $tmp = getdate($p_date);
                $this->data['start_day'] = $tmp['mday'];
                $this->data['start_month'] = $tmp['mon'];
                $this->data['start_year'] = $tmp['year'];
                break;
            case DATE_PERIOD_QUARTER:
                $p_date = mktime(0, 0, 0,
                    $current_date['mon'],
                    $current_date['mday'] - 90,
                    $current_date['year']
                );
                $this->data['start_date'] = strftime('%Y-%m-%d', $p_date);
                $tmp = getdate($p_date);
                $this->data['start_day'] = $tmp['mday'];
                $this->data['start_month'] = $tmp['mon'];
                $this->data['start_year'] = $tmp['year'];
                break;
            case DATE_PERIOD_YEAR:
                $p_date = mktime(0, 0, 0,
                    $current_date['mon'],
                    $current_date['mday'] - 365,
                    $current_date['year']
                );
                $this->data['start_date'] = strftime('%Y-%m-%d', $p_date);
                $tmp = getdate($p_date);
                $this->data['start_day'] = $tmp['mday'];
                $this->data['start_month'] = $tmp['mon'];
                $this->data['start_year'] = $tmp['year'];
                break;
            case DATE_PERIOD_ALLTIME:
                break;
        }
//        print "*st:" . $this->data['start_date'] . "<br>";
//        print "*end:" . $this->data['end_date'] . "<br>";
//        printf ("VALID %d<hr>", $this->data['valid']);
        // store period settings in session, if there are no errors
        if ($this->data['valid'])
        {
            $this->Page->Session->Set('date_period', array(
                'start' => $this->data['start_date'],
                'end' => $this->data['end_date'],
                'start_month' => $this->data['start_month'],
                'start_day' => $this->data['start_day'],
                'start_year' => $this->data['start_year'],
                'end_month' => $this->data['end_month'],
                'end_day' => $this->data['end_day'],
                'end_year' => $this->data['end_year'],
                'period' => $this->data['period']
            ));
        }
    }


    /**
    * Method handles period selection
    * @access   public
    **/
    function OnDatePeriodSelect(){
        $this->ParseAndValidate();
    }

    /**
    * Method draw XML data
    * @access   public
    **/
    function DrawDatePeriod(&$xmlWriter)
    {
    	$xmlWriter->WriteStartElement("localization");
    	foreach($this->Page->Kernel->Localization->GetSection('date_period') as $key => $val)
    	{
    		if (!is_array($val))
    		{
    			$val = array($val);
    		}
    		foreach ($val as $sub_val)
    		{
		    	$xmlWriter->WriteElementString($key, $sub_val);
    		}
    	}
    	$xmlWriter->WriteEndElement("localization");
    	$xmlWriter->WriteElementString("periodSelector", $this->data['period']);
    	$xmlWriter->WriteStartElement("start");
			$xmlWriter->WriteElementString("day", sprintf("%02d", $this->data['start_day']));
			$xmlWriter->WriteElementString("month", sprintf("%02d", $this->data['start_month']));
			$xmlWriter->WriteElementString("year", sprintf("%02d", $this->data['start_year']));
        $xmlWriter->WriteEndElement("start");
    	$xmlWriter->WriteStartElement("end");
			$xmlWriter->WriteElementString("day", sprintf("%02d", $this->data['end_day']));
			$xmlWriter->WriteElementString("month", sprintf("%02d", $this->data['end_month']));
			$xmlWriter->WriteElementString("year", sprintf("%02d", $this->data['end_year']));
        $xmlWriter->WriteEndElement("end");
       	$xmlWriter->WriteElementString("submit_url", $this->data['url']);
    }

    /**
    *  Method draws xml-content of control
    *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
    *  @access  public
    */
    function XmlControlOnRender(&$xmlWriter) {
		$this->DrawDatePeriod($xmlWriter);
    }

} // class

?>