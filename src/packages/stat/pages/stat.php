<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Stat
  * @access public
 **/

$this->ImportClass("web.statparentpage", "StatParentPage");
$this->ImportClass("web.controls.controlsprovider", "ControlsProvider");
$this->ImportClass("system.web.controls.listcontrol", "ListControl");
$this->ImportClass("web.controls.diagramcontrol", "DiagramControl");
class StatPage extends StatParentPage  {

    var $ClassName = "StatPage";
    var $Version = "1.0";        
    var $id = 0;
//    var $libs = array("stat");
       
    function DrawDiagramHourly()
    {
        $this->AddControl(new DiagramControl("diagram_hourly", "diagram"));
        $_stat_reader = $this->statStorage->GetStatHourly();
        $stat_data = array_fill(0, 24, array(0, 0, 0));
        if ($_stat_reader->RecordCount)
        {
            while ($record = $_stat_reader->Read())
            {
                $stat_data[$record['hour_val']] = array(
                    $record['c_hosts'],
                    $record['c_hits'],
                    $record['c_refs']
                );
            }
        }
        $this->Controls['diagram_hourly']->SetData(array(
            'data' => $stat_data
            ));
    }
    
    function DrawDiagramWeekly()
    {
        $this->AddControl(new DiagramControl("diagram_weekly", "diagram"));
        $_stat_reader = $this->statStorage->GetStatWeekly();
        $weekday_names = $this->Page->Kernel->Localization->GetItem('DIAGRAM', 'weekday');
        $stat_data = array();
        foreach ($weekday_names as $tmp)
        {
            $stat_data[$tmp] = array(0, 0, 0);
        }
        if ($_stat_reader->RecordCount)
        {
            while ($record = $_stat_reader->Read())
            {
                if ($record['dow_val'] == 1)
                {
                    $stat_data[$weekday_names[6]] = array(
                        $record['c_hosts'],
                        $record['c_hits'],
                        $record['c_refs']
                    );
                } else {
                    $stat_data[$weekday_names[($record['dow_val']-2)]] = array(
                        $record['c_hosts'],
                        $record['c_hits'],
                        $record['c_refs']
                    );
                }
            }
        }
        $this->Controls['diagram_weekly']->SetData(array(
            'data' => $stat_data
            ));
    }
    
    function DrawDiagramDaily()
    {
        $this->AddControl(new DiagramControl("diagram_daily", "diagram"));
        $_stat_reader = $this->statStorage->GetStatDaily();
        $stat_data = array_fill(1, 31, array(0, 0, 0));
        if ($_stat_reader->RecordCount)
        {
            while ($record = $_stat_reader->Read())
            {
                $stat_data[$record['dom_val']] = array(
                    $record['c_hosts'],
                    $record['c_hits'],
                    $record['c_refs']
                );
            }
        }
        $this->Controls['diagram_daily']->SetData(array(
            'data' => $stat_data
            ));
    }

    function DrawDiagramMonthly()
    {
        $this->AddControl(new DiagramControl("diagram_monthly", "diagram"));
        $_stat_reader = $this->statStorage->GetStatMonthly();
        $month_names = $this->Page->Kernel->Localization->GetItem('DIAGRAM', 'month');
        $stat_data = array();
        foreach ($month_names as $tmp)
        {
            $stat_data[$tmp] = array(0, 0, 0);
        }
        if ($_stat_reader->RecordCount)
        {
            while ($record = $_stat_reader->Read())
            {
                $stat_data[$month_names[($record['m_val']-1)]] = array(
                    $record['c_hosts'],
                    $record['c_hits'],
                    $record['c_refs']
                );
            }
        }
        $this->Controls['diagram_monthly']->SetData(array(
            'data' => $stat_data
            ));
    }
    
    function DrawDiagramYearly()
    {
        $this->AddControl(new DiagramControl("diagram_yearly", "diagram"));
        $_stat_reader = $this->statStorage->GetStatYearly();
        $stat_data = array();
        if ($_stat_reader->RecordCount)
        {
            while ($record = $_stat_reader->Read())
            {
                $stat_data[$record['year_val']] = array(
                    $record['c_hosts'],
                    $record['c_hits'],
                    $record['c_refs']
                );
            }
        }
        $this->Controls['diagram_yearly']->SetData(array(
            'data' => $stat_data
            ));
    }
    
    
/** Method creates child controls
 * @access public
 */
    function CreateChildControls()
    {
        parent::CreateChildControls();
        // will set to true if requested action is table view of diagram data
        $this->_diagram_data = false;
        DataFactory::GetStorage($this, "StatTable", "statStorage", true, "stat");
        switch ($this->Page->Request->QueryString['action'])
        {
            case 'dia_data_hourly':
                $this->DrawDiagramHourly();
                $this->XslTemplate = 'diagram_data';
                $this->_diagram_data = true;
                break;
            case 'dia_data_weekly':
                $this->DrawDiagramWeekly();
                $this->XslTemplate = 'diagram_data';
                $this->_diagram_data = true;
                break;
            case 'dia_data_daily':
                $this->DrawDiagramDaily();
                $this->XslTemplate = 'diagram_data';
                $this->_diagram_data = true;
                break;
            case 'dia_data_monthly':
                $this->DrawDiagramMonthly();
                $this->XslTemplate = 'diagram_data';
                $this->_diagram_data = true;
                break;
            case 'dia_data_yearly':
                $this->DrawDiagramYearly();
                $this->XslTemplate = 'diagram_data';
                $this->_diagram_data = true;
                break;
            default:
                $this->DrawDiagramHourly();
                $this->DrawDiagramWeekly();
                $this->DrawDiagramDaily();
                $this->DrawDiagramMonthly();
                $this->DrawDiagramYearly();
        }
    }

/**
  *  Method draws xml-content of page
  *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
  *  @access  public
  */
    function XmlControlOnRender(&$xmlWriter)
    {
        $xmlWriter->WriteStartElement("stat");
        $xmlWriter->WriteElementString('period_hits', $this->statStorage->GetPeriodHits());
        $xmlWriter->WriteElementString('period_hosts', $this->statStorage->GetPeriodHosts());
        $xmlWriter->WriteElementString('period_transfers', $this->statStorage->GetPeriodTransfers());

        $xmlWriter->WriteElementString('first_visit', $this->statStorage->GetDateOfFirstVisit());
        $xmlWriter->WriteElementString('last_visit', $this->statStorage->GetDateOfLastVisit());

        $xmlWriter->WriteElementString('hits', $this->statStorage->GetAverallHits());
        $xmlWriter->WriteElementString('hosts', $this->statStorage->GetAverallHosts());
        $xmlWriter->WriteElementString('transfers', $this->statStorage->GetAverallTransfers());
        
        $xmlWriter->WriteElementString('stat_days', $this->statStorage->GetAvailDaysCount());
        $tmp = $this->statStorage->GetMaxVisitorsDay();
        $xmlWriter->WriteStartElement("max_hits");
            $xmlWriter->WriteElementString('date', $tmp['date']);
            $xmlWriter->WriteElementString('count', $tmp['count']);
        $xmlWriter->WriteEndElement("max_visitors");
        $xmlWriter->WriteEndElement("stat");
        if ($this->_diagram_data)
        {
            $xmlWriter->WriteStartElement("diagram_header");
            switch ($this->Page->Request->QueryString['action'])
            {
                case 'dia_data_hourly':
                    $xmlWriter->WriteElementString('caption', 
                        $this->Page->Kernel->Localization->GetItem('DIAGRAM', 'caption_time'));
                    $xmlWriter->WriteElementString('title', 
                        $this->Page->Kernel->Localization->GetItem('MAIN', '_diagram_hourly_title'));
                    break;
                case 'dia_data_weekly':
                    $xmlWriter->WriteElementString('caption', 
                        $this->Page->Kernel->Localization->GetItem('DIAGRAM', 'caption_week_day'));
                    $xmlWriter->WriteElementString('title', 
                        $this->Page->Kernel->Localization->GetItem('MAIN', '_diagram_weekly_title'));
                    break;
                case 'dia_data_daily':
                    $xmlWriter->WriteElementString('caption', 
                        $this->Page->Kernel->Localization->GetItem('DIAGRAM', 'caption_month_day'));
                    $xmlWriter->WriteElementString('title', 
                        $this->Page->Kernel->Localization->GetItem('MAIN', '_diagram_daily_title'));
                    break;
                case 'dia_data_monthly':
                    $xmlWriter->WriteElementString('caption', 
                        $this->Page->Kernel->Localization->GetItem('DIAGRAM', 'caption_month'));
                    $xmlWriter->WriteElementString('title', 
                        $this->Page->Kernel->Localization->GetItem('MAIN', '_diagram_monthly_title'));
                    break;
                case 'dia_data_yearly':
                    $xmlWriter->WriteElementString('caption', 
                        $this->Page->Kernel->Localization->GetItem('DIAGRAM', 'caption_year'));
                    $xmlWriter->WriteElementString('title', 
                        $this->Page->Kernel->Localization->GetItem('MAIN', '_diagram_yearly_title'));
                    break;
                default:
            }
            $xmlWriter->WriteElementString('caption', 
                $this->Page->Kernel->Localization->GetItem('DIAGRAM', 'caption_hosts'));
            $xmlWriter->WriteElementString('caption', 
                $this->Page->Kernel->Localization->GetItem('DIAGRAM', 'caption_hits'));
            $xmlWriter->WriteElementString('caption', 
                $this->Page->Kernel->Localization->GetItem('DIAGRAM', 'caption_transfers'));
            $period_settings = $this->Page->Session->Get('date_period');
            if (strlen($period_settings['start']) > 0)
//                (strlen($period_settings['end']) > 0))
            {
                $xmlWriter->WriteElementString('period_start',
                    sprintf('%02d.%02d.%02d',
                        $period_settings['start_day'],
                        $period_settings['start_month'],
                        $period_settings['start_year']
                ));
                $xmlWriter->WriteElementString('period_end', 
                    sprintf('%02d.%02d.%02d',
                        $period_settings['end_day'],
                        $period_settings['end_month'],
                        $period_settings['end_year']
                ));
            }
            $xmlWriter->WriteEndElement("diagram_header");
        }
        
        parent::XmlControlOnRender(&$xmlWriter);
    }
}

?>