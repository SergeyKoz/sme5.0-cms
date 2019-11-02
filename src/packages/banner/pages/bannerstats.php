<?php
	$this->ImportClass("module.web.modulepage", "ModulePage");
	/**
	 * Banners stats page class.
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package	System
	 * @subpackage pages
	 * @access public
	 **/
	class BannerStatsPage extends ModulePage {
		// Class name
		var $ClassName = "BannerStatsPage";
		// Class version
		var $Version = "1.0";
		/**    Self page name
		* @var     string     $self
		*/
   /**
     * Page mode variable (enum (Backend,Frontend,Transitional)), default - Backend
     * @var string    $PageMode
     **/
    var $PageMode="Backend";

	  /**  Access to this page roles
		* @var     array     $access_role_id
		**/
		var $access_role_id = array("BANNER_ADMINISTRATOR",
		                            "BANNER_PUBLISHER");



    /**
	  * Method executes on page load
	  * @access public
	  **/
		function ControlOnLoad()  {
		    //parent::ControlOnLoad();
		    DataFactory::GetStorage($this, "BannerEventsTable", "bannereventsStorage", false, "banner");
            $this->Kernel->ImportClass("web.controls.bannersfiltercontrol", "BannersFilterControl");
		    $this->AddControl(new BannersFilterControl("filter", "filter"));
		}

		/**
		* Method handles Default page event
		* @access public
		**/
		function OnDefault(){
		    $this->Kernel->ImportClass("web.controls.bannergeneralstatscontrol", "BannerGeneralStatsControl");
		    $this->AddControl(new BannerGeneralStatsControl("general", "general"));
		}

		/**
		* Method handles Default page event
		* @access public
		**/
		function OnDaily(){
		    $this->Kernel->ImportClass("web.controls.bannerdailystatscontrol", "BannerDailyStatsControl");
		    $this->AddControl(new BannerDailyStatsControl("daily", "daily"));
		}

		/**
		* Method handles Default page event
		* @access public
		**/
		function OnDetailed(){
		    $this->Kernel->ImportClass("web.controls.bannerdetailedstatscontrol", "BannerDetailedStatsControl");
		    $this->AddControl(new BannerDetailedStatsControl("detailed", "detailed"));
		}

}
?>
