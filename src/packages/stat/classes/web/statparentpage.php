<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Stat
  * @access public
 **/

$this->ImportClass("web.listpage", "ListPage");
$this->ImportClass("web.controls.controlsprovider", "ControlsProvider");
$this->ImportClass("web.controls.dateperiodcontrol", "DatePeriodControl");
$this->ImportClass("module.web.controls.calendarcontrol", "CalendarControl");
$this->ImportClass("web.controls.itemslistcontrol", "ItemsListControl");

class StatParentPage extends ListPage  {

    var $ClassName = "StatParentPage";
    var $Version = "1.0";

/** Method creates child controls
 * @access public
 */
    function ControlOnLoad()
    {
        parent::ControlOnLoad();
    }

    function CreateChildControls()
    {
        $this->AddControl(new CalendarControl("calendar", "calendar"));
        $this->AddControl(new DatePeriodControl("date_period", "date_period"));
        // date period form has been submited ...
        if ($this->Controls["date_period"]->data['submited'])
        {
            // ... with custom period
            // check if period id valid and start_date equal to end_date
            // if all is OK, then set calendar to mode (action) CALENDAR_ACTION_CHOOSE_DAY
            // and set selected date
            if (($this->Controls["date_period"]->data['valid']) &&
                ($this->Controls["date_period"]->data['start_date'] != '') &&
                ($this->Controls["date_period"]->data['start_date'] ==
                $this->Controls["date_period"]->data['end_date']))
            {
                $this->Page->Session->Set('calendar', array(
                    'day' => $this->Controls["date_period"]->data['start_day'],
                    'month' => $this->Controls["date_period"]->data['start_month'],
                    'year' => $this->Controls["date_period"]->data['start_year'],
                    'action' => CALENDAR_ACTION_CHOOSE_DAY
                ));
                // set to 'true' in order to this settings will be restored from session
                $this->Controls["calendar"]->data['default_values'] = true;
            } else {
                // date period form has been submited with preset period
                // remove day selection from calendar
                $this->Page->Session->Set('calendar', array(
                   'action' => CALENDAR_ACTION_CHOOSE_NODAY
                ));
                // set to 'true' in order to this settings will be restored from session
                $this->Controls["calendar"]->data['default_values'] = true;
            }
        } else {
            // calendar has been submited
            if (!$this->Controls["calendar"]->data['default_values'])
            {
                // check calendar mode (submit action)
                switch ($this->Controls["calendar"]->data['action'])
                {
                    case CALENDAR_ACTION_CHOOSE_DAY:
                      $this->Controls["date_period"]->SetData(array(
                          'period' => DATE_PERIOD_CUSTOM,
                          'start_day' => $this->Controls["calendar"]->data['day'],
                          'start_month' => $this->Controls["calendar"]->data['month'],
                          'start_year' => $this->Controls["calendar"]->data['year'],
                          'end_day' => $this->Controls["calendar"]->data['day'],
                          'end_month' => $this->Controls["calendar"]->data['month'],
                          'end_year' => $this->Controls["calendar"]->data['year']
                      ));
                      // parse, validate period settings and store data to session
                      $this->Controls["date_period"]->ParseAndValidate();
                      break;
                    case CALENDAR_ACTION_CHOOSE_WEEK:
                      $week_start_date = getdate(mktime(0, 0, 0,
                              $this->Controls["calendar"]->data['month'],
                              $this->Controls["calendar"]->data['day'] - 6,
                              $this->Controls["calendar"]->data['year']));

                      $this->Controls["date_period"]->SetData(array(
                          'period' => DATE_PERIOD_CUSTOM,
                          'start_day' => $week_start_date['mday'],
                          'start_month' => $week_start_date['mon'],
                          'start_year' => $week_start_date['year'],
                          'end_day' => $this->Controls["calendar"]->data['day'],
                          'end_month' => $this->Controls["calendar"]->data['month'],
                          'end_year' => $this->Controls["calendar"]->data['year']
                      ));
                      // parse, validate period settings and store data to session
                      $this->Controls["date_period"]->ParseAndValidate();
                      break;
                    case CALENDAR_ACTION_CHOOSE_MONTH:
                      $this->Controls["date_period"]->SetData(array(
                          'period' => DATE_PERIOD_CUSTOM,
                          'start_day' => 1,
                          'start_month' => $this->Controls["calendar"]->data['month'],
                          'start_year' => $this->Controls["calendar"]->data['year'],
                          'end_day' => date("d", mktime(0, 0, 0,
                              $this->Controls["calendar"]->data['month'] + 1,
                              0,
                              $this->Controls["calendar"]->data['year'])),
                          'end_month' => $this->Controls["calendar"]->data['month'],
                          'end_year' => $this->Controls["calendar"]->data['year']
                      ));
                      // parse, validate period settings and store data to session
                      $this->Controls["date_period"]->ParseAndValidate();
                      break;
                    case CALENDAR_ACTION_CHOOSE_YEAR:
                      $this->Controls["date_period"]->SetData(array(
                          'period' => DATE_PERIOD_CUSTOM,
                          'start_day' => 1,
                          'start_month' => 1,
                          'start_year' => $this->Controls["calendar"]->data['year'],
                          'end_day' => 31,
                          'end_month' => 12,
                          'end_year' => $this->Controls["calendar"]->data['year']
                      ));
                      // parse, validate period settings and store data to session
                      $this->Controls["date_period"]->ParseAndValidate();
                      break;
                }
            }
        }

		$_url = str_replace('&init=1', '', $_SERVER['QUERY_STRING']);

        $this->Controls["date_period"]->SetData(array(
            'url' => "?" . $_url)
        );
        $this->Controls["calendar"]->SetData(array(
            'url' => "?" . $_url
        ));
        // if default_values = true, then calendar settings was not submited
        // default (current) date applied, otherwise we have to store
        // values in session
        if ($this->Controls["calendar"]->data['default_values'])
        {
            // restore calendar date, if it were stored in session
            $date_settings = $this->Page->Session->Get('calendar');
            if (isset($date_settings))
            {
                $this->Controls["calendar"]->SetData($date_settings);
            }
        } else {

        }
        $this->Page->Session->Set('calendar', array(
            'day' => $this->Controls["calendar"]->data['day'],
            'month' => $this->Controls["calendar"]->data['month'],
            'year' => $this->Controls["calendar"]->data['year'],
            'action' => $this->Controls["calendar"]->data['action']
        ));
        parent::CreateChildControls();
    }

/**
  *  Method draws xml-content of page
  *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
  *  @access  public
  */
    function XmlControlOnRender(&$xmlWriter)
    {
        parent::XmlControlOnRender(&$xmlWriter);
    }

}

?>