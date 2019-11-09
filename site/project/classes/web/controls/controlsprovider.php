<?php
$this->ImportClass("module.web.controls.cmscontrolsprovider", "CMSControlsProvider");

 /** Controlls provider class - plugs controls into pages
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @version 1.0
   * @package  Project
   * @subpackage classes.web.controls
   * @access public
   **/
    class ControlsProvider extends CMSControlsProvider{
       /**
       * Method plugs controls into page
       * @param     Page    $page   PAge object
       * @access    public
       **/
       static function AddControls(&$page){
       		parent::AddControls($page);

			//$this->Kernel->ImportClass("web.controls.publicationscontrolsselector", "PublicationsControlsSelector", "publications");
			//$this->AddControl(new PublicationsControlsSelector("publications_selector", "publications_selector"));

			$page->Kernel->ImportClass("web.controls.authindicatorcontrol", "AuthIndicatorControl");
            $page->AddControl(new AuthIndicatorControl("authindicator", "authindicator"));

            if (DataDispatcher::Get("page_id") == 1){
             	$page->Kernel->ImportClass("web.controls.calendarblockcontrol", "CalendarBlockControl", "calendar");
	            $page->AddControl(new CalendarBlockControl("calendar_block", "calendar_block"));
	        }
       }
    }
?>