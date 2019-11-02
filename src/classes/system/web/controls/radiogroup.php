<?php

 $this->ImportClass("system.web.controls.radio","radiocontrol");
 $this->ImportClass("system.web.controls.dbradiogroup","dbradiogroupcontrol");

/** RadioGroup control
   * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
   * @version 1.0
   * @package Framework
   * @subpackage classes.system.web.controls
   * @access public
   */
  class RadioGroupControl extends DbRadioGroupControl  {
    var $ClassName = "RadioGroupControl";
    var $Version = "1.0";
    var $list;
        /**
          * Initialization data array
          * structure:
          *           <ul>
          *           <li> <b>name</b>                - control name
          *           <li> <b>value</b>               - control value
          *           <li> <b>selected_value</b>      - selected value
          *           <li> <b>options</b>             - options array, format array (
          *                                                                           0 => array("value"=>"value","caption"=>"caption",
          *                                                                           1 => array...)
          *                                                                          );
          *           <li> <b>caption</b>             - field caption
          *           </ul>
          * @var    array   $data
          **/
          var $data = array();
  /**
    * Method sets control with initial data
    * @access public
    **/
    function InitControl($data=array()){
    	     FormControl::InitControl($data);
			if (strlen($this->data["selected_value"])==0)
      	$this->data["selected_value"]=$this->data["options"][0]["value"];
    }
 }// class
?>