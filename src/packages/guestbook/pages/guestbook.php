<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Guestbook
  * @access public
 **/

 $this->ImportClass("project", "ProjectPage");
 $this->ImportClass("web.controls.controlsprovider", "ControlsProvider");
 $this->ImportClass("web.controls.guestbookformcontrol", "GuestbookFormControl");

class GuestbookPage extends ProjectPage  {

	var $ClassName="GuestbookPage";
	var $Version="1.0";
	var $id = 0;
/**
  * Page mode variable (enum (Backend,Frontend,Transitional)), default - Backend
  * @var string    $PageMode
  */
	var $PageMode = "Frontend";


/** Method creates child controls
 * @access public
 */
	function CreateChildControls()
	{
		parent::CreateChildControls();
		$this->AddControl(new GuestbookFormControl("guestbook_form", "guestbook_form"));
	}

/**
  *  Method draws xml-content of page
  *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
  *  @access  public
  */
	function XmlControlOnRender(&$xmlWriter)
	{
	//render page node
		parent::XmlControlOnRender(&$xmlWriter);
	}
}
?>