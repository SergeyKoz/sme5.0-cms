<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Stat
  * @access public
 **/

$this->ImportClass("web.listpage", "ListPage");

class AdminEventsCategoriesListPage extends ListPage  {

	var $ClassName = "AdminEventsCategoriesListPage";
	var $Version = "1.0";
	var $id = 0;
	var $self = "admineventscategorieslist";
	var $handler = "admineventscategoriesedit";
	var $XslTemplate="itemslist";
	var $access_role_id = array("ADMIN","CALENDAR_EDITOR");

	function XmlControlOnRender(&$xmlWriter){
		parent::XmlControlOnRender($xmlWriter);
	}
}

?>