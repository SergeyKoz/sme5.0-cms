<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Stat
  * @access public
 **/

$this->ImportClass("web.listpage", "ListPage");
$this->ImportClass("web.statparentpage", "StatParentPage");
$this->ImportClass("web.controls.controlsprovider", "ControlsProvider");
$this->ImportClass("web.controls.itemslistcontrol", "ItemsListControl");

class PopularPage extends StatParentPage  {

	var $ClassName = "PopularPage";
	var $Version = "1.0";
	var $self = 'popular';
	var $id = 0;

    /** Method creates child controls
     * @access public
     */
    function ControlOnLoad()
    {
        parent::ControlOnLoad();
    }

    function CreateChildControls()
	{
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