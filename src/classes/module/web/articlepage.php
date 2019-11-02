<?php
  $this->ImportClass("module.web.modulepage", "ModulePage");
  /**
   * Frontend article page.
   * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
   * @version 1.0
   * @package  Framework
   * @subpackage classes.module.web
   * @access public
   **/
  class ArticlePage extends ModulePage {
  	//class variables
    var $ClassName = "ArticlePage";
    var $Version = "1.0";
    var $XslTemplate="article";
		/**
    	* Table keyfield name
      * @var	string	$key_field
      **/
    var $key_field="articleid";
    /**
      * Item id GET paramater name
      * @var  string  $itemvariable
      **/
    var $itemvariable="item_id";
    /**
      * Page navigation parameter name
      * @var  string  $start_variable
      **/
    var $start_variable="article_start";
    /**
      * Article storage name
      * @var  string  $storagename
      **/
    var $storagename="ArticleTable";
    /**
      * Active field name
      * @var  string  $activefield
      **/
    var $activefield="active";
		/**
      * Articles list page
      * @var  string  $listpage
      **/
    var $listpage="index.php";
    /**
      * Article data array
      * @var  array		$data
      **/
	var $data=array();
    /**
      * Navigator page value
      * @var  int    $start
      **/
	var $start;
    /**
      * Page mode variable
      * @var string    $PageMode
      **/
    var $PageMode="Frontend";

    /**
      * OnLoad event handler
      * @access public
      **/
    function ControlOnLoad()  {
        parent::ControlOnLoad();
        //create table object
        $this->Kernel->ImportClass("data.".strtolower($this->storagename), $this->storagename);
				$this->Storage=new $this->storagename (&$this->Kernel->Connection,$this->Kernel->Settings->GetItem("database",$this->storagename));
        //eval('$this->Storage=new '.$this->storagename.'(&$this->Kernel->Connection,"'.
        //     $this->Kernel->Settings->GetItem("database",$this->storagename).'");');
        $item_id=$this->Request->Value($this->itemvariable);
        $this->start=$this->Request->Value($this->start_variable);
        $item=$this->Storage->GetByFields(array($this->key_field=>$item_id, sprintf($this->activefield, $this->Kernel->Language)=>"1"));
         //if item not found
        if (intval($item[$this->key_field])==0)  {
          $this->Response->Redirect($this->listpage."?".$this->start_variable."=".$this->start);
        } else  {
          foreach($item as $key => $field)
            $this->data[removeLangPrefix($key,$this->Kernel->Language)]=$field;
        }
     }
    /**
      * Render page xml method
      * @param	xmlWriter		$xmlWriter		xmlWriter object
      * @access public
      **/
     function XmlControlOnRender(&$xmlWriter)  {
      parent::XmlControlOnRender(&$xmlWriter);
      $xmlWriter->WriteStartElement("article");
      $this->Kernel->ImportClass("system.web.controls.recordcontrol", "RecordControl");
      $record=new RecordControl("record","record");
      $record->InitControl($this->data);
      $record->XmlControlOnRender(&$xmlWriter);
      $xmlWriter->WriteStartElement("navigator");
	  $xmlWriter->WriteElementString("list",$this->listpage);
      $xmlWriter->WriteElementString("parameter",$this->start_variable);
      $xmlWriter->WriteElementString("value",$this->start);
      $xmlWriter->WriteEndElement("navigator");
      $xmlWriter->WriteEndElement("article");
     }
//end of class
}

?>