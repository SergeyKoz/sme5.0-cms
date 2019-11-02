<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Stat
  * @access public
 **/

$this->ImportClass("web.controls.controlsprovider", "ControlsProvider");
$this->ImportClass("web.listpage", "ItemsList");
$this->ImportClass("web.statparentpage", "StatParentPage");
$this->ImportClass("web.controls.itemslistcontrol", "ItemsListControl");

class ReferersDetailPage extends StatParentPage  {

	var $ClassName = "ReferersDetailPage";
	var $Version = "1.0";        
	var $id = 0;
    var $referer_domain = '';
    var $self = "referersdetail";

/** Method creates child controls
 * @access public
 */
    function ControlOnLoad()
    {
        DataFactory::GetStorage($this, "StatTable", "statStorage", true, "stat");
        $this->referer_domain = $this->statStorage->GetRefererDomainById(
            $this->Page->Request->QueryString['referers_parent_id']
        );
        $this->Page->Kernel->Localization->SetItem('REFERERS_DETAIL', '_LIST_TITLE',
            sprintf($this->Page->Kernel->Localization->GetItem('REFERERS_DETAIL', '_LIST_TITLE'),
            $this->referer_domain
        ));
        parent::ControlOnLoad();
    }


  /** Method creates child controls
      * @access public
      */
    function CreateChildControls()
    {
		$this->AddControl(new DatePeriodControl("date_period", "date_period"));
		$this->Controls["date_period"]->SetData(array(
			'url' => "?" . $_SERVER['QUERY_STRING']));
			
        $this->_library = 'referers_detail';
        $this->libs = array($this->_library);
        parent::CreateChildControls();
        $restore = $this->Request->Value("restore");  // encrypted part of url to restore previous state
        // Adding hidden to restore catalog state
        $this->AddControl(new HiddenControl("_return", "_return"));
        $this->Controls["_return"]->SetControl(array(
            "name"=>"_return",
            "value" => base64_decode($restore)
        ));
        
        $this->Controls["ItemsList_{$this->_library}"]->append_hrefs=
        "&restore=$restore&referers_parent_id=" .
        $this->Page->Request->QueryString['referers_parent_id'];
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