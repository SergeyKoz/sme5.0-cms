<?php
 $this->ImportClass("system.web.controls.select","selectcontrol");
 $this->ImportClass("system.web.controls.dbfield","DbFieldControl");

/** DbComboBoxControl control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class DbComboBoxControl extends DbFieldControl {
		var $ClassName = "DbComboBoxControl";
		var $Version = "1.0";

		/** Table object
		  * @var  AbstractTable   $Storage
		  **/
		var $Storage;

		/**  Array with phonetypes
		  * @var    array   $types
		  **/
		var $list;

	    /**
          * Initialization data array
          * structure:
          *           <ul>
          *           <li> <b>name</b>           - control name
          *           <li> <b>selected_value</b> - control selected value
          *           <li> <b>table</b>          - Storage name (in module.ini) for get values
          *           <li> <b>caption_field</b>  - Field name in storage where caption is
          *           <li> <b>method</b>         - Get method for get values )(default GetList)
          *           <li> <b>query_data</b>     - WHERE clause data array for get method {@see GetList()}
          *           <li> <b>orders</b>         - ORDER BY clause data array for get method {@see GetList()}
          *           <li> <b>caption</b>        - control caption
          *           <li> <b>multiple</b>       - draw multiple control , flag
          *           <li> <b>number</b>         - control number
          *           <li> <b>use_root_caption</b>  - draw root caption(Like --Root---), flag
          *           <li> <b>event</b>          - field events array (format: array("eventname javascript","eventname javascript")
          *           </ul>
          * @var    array   $data
          **/
          var $data = array();


	/**
	  * Method  Executes on control load to the parent
	  * @access  private
	  **/
	function ControlOnLoad(){
	  parent::ControlOnLoad();
	}

   /**
     *  Method Draws XML-content of a control
     *  @param XMLWriter    $xmlWriter  instance of XMLWriter
     *  @access private
     **/
   function XmlControlOnRender(&$xmlWriter) {
	  SelectControl::StaticXmlControlOnRender($this, $xmlWriter);
   }


   }// class
?>