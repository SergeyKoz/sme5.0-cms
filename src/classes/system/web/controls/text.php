<?php
  $this->ImportClass("system.web.controls.form","formcontrol");

/** Text control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class TextControl extends FormControl {
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
	  FormControl::SetData($data);
      $this->setControlParameter("size","Text_size",$data["size"]);
    }

	/**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
		function XmlControlOnRender(&$xmlWriter) {
		 $xmlWriter->WriteStartElement("text");
		  $this->WriteLanguageVersion($xmlWriter);
			 $this->XmlGetErrorFields($xmlWriter);
			$_keys = array_keys($this->data);
			for($i=0; $i<sizeof($_keys); $i++)
			   {
				  $xmlWriter->WriteStartElement($_keys[$i]);
					   $xmlWriter->WriteString($this->data[$_keys[$i]]);
				  $xmlWriter->WriteEndElement();
			   }

		 $xmlWriter->WriteEndElement();


   }


  }// class
?>