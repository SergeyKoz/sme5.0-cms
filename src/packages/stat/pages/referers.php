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

class ReferersPage extends StatParentPage  {

    var $ClassName = "ReferersPage";
    var $Version = "1.0";
    var $id = 0;
    var $self = "referers";

    /** Method creates child controls
     * @access public
     */
    function ControlOnLoad()
    {
        parent::ControlOnLoad();
    }

    function CreateChildControls()
    {
        $this->AddControl(new DatePeriodControl("date_period", "date_period"));
        $this->Controls["date_period"]->SetData(array(
            'url' => "?" . $_SERVER['QUERY_STRING'])
        );
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

    /**
     * Handler of ItemsListControl for field processing
     *
     * @param unknown $field
     * @param unknown $row
     */
    function ProcessReferer(&$field, &$row)
    {
        // Set value of field to localized text if value is empty
        // and change type of control from link to string
        if ($row[$field["field_name"]] == '')
        {
            $field['control'] = 'string';
            $row[$field["field_name"]] =
                $this->Page->Kernel->Localization->GetItem('REFERERS', 'empty_ref');
        } else {
            $field['control'] = 'link';
        }
    }
}

?>