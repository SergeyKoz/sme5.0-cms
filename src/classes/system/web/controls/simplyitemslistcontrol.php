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
  class SimplyItemsListControl extends XMLControl {

    var $ClassName = "SimplyItemsListControl";
    var $Version = "1.0";

    function ControlOnLoad(){
        parent::ControlOnLoad();

    }

    function initControl($data=array()){
        $this->data=$data;
        $this->listStorage=&$data["storage"];

        $this->_VAR=($this->data["var"]!="" ? $this->data["var"] : "start");
       	$this->_RPP = $this->data["rpp"];
       	$this->_START = $this->Page->Request->ToNumber($this->_VAR, 0);
        $cntMethod=$this->data["countMethod"];
       	$this->_TOTAL = $this->listStorage->$cntMethod($this->data);

       	if ($this->_START*$this->_RPP >= $this->_TOTAL){
       		$this->_START = ceil($this->_TOTAL/$this->_RPP)-1;
       	}

       	if($this->_START<0){
       		$this->_START=0;
       	}

       	$this->_URL="?".$this->data["url"];
       	$this->_VAR=$this->data["var"];

       	$this->AddControl(new NavigationControl("navigator","navigator"));
        $this->Controls["navigator"]->SetData(array(
                     "start" => $this->_START,
                     "total" => $this->_TOTAL,
                     "rpp" => $this->_RPP,
                     "url" => $this->_URL,
                     "var_name" => $this->_VAR));

        $this->_SORT=$this->data["sort"];

        $getMethod=$this->data["getMethod"];
        $this->ItemsList=$this->listStorage->$getMethod($this->_START*$this->_RPP, $this->_RPP, $this->_SORT);
    }

    function XmlControlOnRender(&$xmlWriter) {
        parent::XmlControlOnRender($xmlWriter);
        foreach ($this->ItemsList as $item){
            if (method_exists($this->Parent, "WriteRow")){
           		$this->Parent->WriteRow($xmlWriter, $item, $this->Name);
           	}else{
           		$xmlWriter->WriteStartElement("item");
	           	foreach($item as $k=>$v){
	            	if(!is_array($v)){
	            		$xmlWriter->WriteStartElement($k);
	            		$xmlWriter->WriteString($v);
	                   	$xmlWriter->WriteEndElement($k);
	            	}
	            }
	            $xmlWriter->WriteEndElement("item");
           	}
     	}
    }


 }// class
?>