<?php

  Kernel::ImportClass("system.web.xmlcontrol", "XMLControl");
  Kernel::ImportClass("system.web.controls.navigationcontrol","NavigationControl");
  /**  Cover control class for main page
   * @author Alexandr Degtiar <aedgtiar@activemedia.com.ua>
   * @version 1.0
   * @package
   * @access public
   * class for poll controll attached to page
   **/
  class FrontItemsListControl extends XMLControl {

    var $ClassName = "FrontItemsListControl";
    var $Version = "1.0";

    function ControlOnLoad(){
        parent::ControlOnLoad();

    }

    function initControl($data=array()){
        $this->data=$data;
        $this->listStorage=&$data["storage"];
    }

    function CreateChildControls(){
       	parent::CreateChildControls();

       	$this->_RPP = $this->data["rpp"];
       	$this->_START = $this->Page->Request->ToNumber("start", 0);
        $cntMethod=$this->data["countMethod"];
       	$this->_TOTAL = $this->listStorage->$cntMethod($this->data);

       	if ($this->_START*$this->_RPP >= $this->_TOTAL)
       		$this->_START = ceil($this->_TOTAL/$this->_RPP)-1;

       	if($this->_START<0)$this->_START=0;

       	$this->_URL="?".$this->data["url"];

       	$this->AddControl(new NavigationControl("navigator","navigator"));
        $this->Controls["navigator"]->SetData(array(
                     "start"=>$this->_START,
                     "total"=>$this->_TOTAL,
                     "rpp"  =>$this->_RPP,
                     "url"  =>$this->_URL));

        $getMethod=$this->data["getMethod"];
        $this->ItemsList=$this->listStorage->$getMethod($this->_START*$this->_RPP, $this->_RPP);
    }

    function XmlControlOnRender(&$xmlWriter) {
        parent::XmlControlOnRender($xmlWriter);
        $this->XmlTag = "item";
        foreach ($this->ItemsList as $this->data){
        	RecordControl::StaticXmlControlOnRender($this, $xmlWriter);
        }
    }


 }// class
?>