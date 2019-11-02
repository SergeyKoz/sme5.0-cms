<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Stat
  * @access public
 **/

$this->ImportClass("web.listpage", "ListPage");
$this->ImportClass("web.controls.reportcontrol", "ReportControl");
$this->ImportClass("system.web.controls.recordcontrol", "RecordControl");

class AdminEventsListPage extends ReportControl  {

	var $ClassName = "AdminEventsListPage";
	var $Version = "1.0";
	var $id = 0;
	var $self = "admineventslist";
	var $handler = "admineventsedit";
	var $access_role_id = array("ADMIN","CALENDAR_EDITOR");

	function XmlControlOnRender(&$xmlWriter){
		parent::XmlControlOnRender($xmlWriter);
	}
}

?>