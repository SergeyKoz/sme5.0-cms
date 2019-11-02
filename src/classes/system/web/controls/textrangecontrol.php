<?php
  $this->ImportClass("system.web.controls.text","textcontrol");

   /** Text range control
	 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 **/
	class TextRangeControl extends TextControl {
		var $ClassName = "TextControl";
		var $Version = "1.0";
		 /**
          * Initialization data array
          * structure:
          *           <ul>
          *           <li> <b>name</b>           - control name
          *           <li> <b>value</b>          - control value
          *           <li> <b>maxlength</b>      - maximum length value
          *           <li> <b>size</b>           - text field size
          *           <li> <b>caption</b>        - field caption
          *           <li> <b>hint</b>           - field hint
          *           </ul>
          * @var    array   $data
          **/
          var $data = array();
  /**
    * Method sets initial data for control
    *  @param   array  $data  Array with initial data
    *  @access public
    */
    function SetData($data=array())
    {
	  parent::SetData($data);

    }
  /**
    *	Notifies server controls that use composition-based implementation to
    *	create any child controls they contain in preparation for posting back
    *	or rendering.
    * @access public
    *
    */
    function CreateChildControls()  {
        Control::CreateChildControls();
        $this->AddControl(new TextControl("min","control"));
        $this->AddControl(new TextControl("max","control"));
        foreach ($this->Controls as $name => $control)  {

         $array =  array ("name"      =>  $this->data["name"]."_".$name,
                          "value"    =>  $this->data["value"][$name],
                          "maxlength"=>  $this->data["maxlength"],
                          "caption"  =>  $this->data["caption"][$name],
                          "size"     =>  $this->data["size"]);
           $this->Controls[$name]->InitControl($array);
        }
    }
	/**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
		function XmlControlOnRender(&$xmlWriter) {
		 $xmlWriter->WriteStartElement("range");
		 if (strlen($this->data["hint"])) {
		     $xmlWriter->WriteElementString("hint",$this->data["hint"]);
		 }
		 if (strlen($this->data["caption"]["main"])) {
		     $xmlWriter->WriteElementString("caption",$this->data["caption"]["main"]);
		 }
		 $xmlWriter->WriteEndElement();


   }


  }// class
?>