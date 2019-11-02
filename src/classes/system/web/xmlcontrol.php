<?php
	$this->ImportClass("system.web.control", "Control");

	/** Class represents xml-based control
	  * @author Sergey Grishko <sgrishko@reaktivate.com>
      * @modified Artem Mikhmel <amikhmel@activemedia.com.ua>
      * @modified Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	  * @version 1.0
	  * @package Framework
	  * @subpackage classes.system.web
	  * @access public
	  **/
	class XmlControl extends Control {
		// Class information
		var $ClassName = "XmlControl";
		var $Version = "1.0";
		/**
		  * Name of Xml node of control
		  * @param    string      $XmlTag
		  **/
		var $XmlTag;
		/**
		  * Initialization data array
		  * @param    array   $data
		  **/
        var $data = array();

		/** Constructor. Initializes a new instance of the Control class.
		  * @param     string    		$name    Name of  control
		  * @param     string    		$xmlTag  Name of XML Tag
          * @param	 array          $data    Initialization data array
		  * @access    public
		  **/
		function XmlControl($name, $xmlTag,$data = array()) {
			parent::Control($name);
			$this->XmlTag = $xmlTag;
			$this->data =$data;
		}

		 /**
           * Method renders XML into html
           * @param   (object structure)  $xmlWriter   Instence of xmlWriter
           * @access   public
		   **/
		function renderXmlInternal(&$xmlWriter) {
			$xmlWriter->WriteStartElement($this->XmlTag);
			$this->XmlControlOnRender($xmlWriter);
			if ($this->HasControls()) {
				foreach($this->Controls as $control) {
					if (method_exists($control, "renderXmlInternal"))
					$control->renderXmlInternal($xmlWriter);
				}
			}
			$xmlWriter->WriteEndElement();
		}

	   /**
         * Method executes additional actions on xmlControl Render event
         * @param   (object structure)  $xmlWriter   Instence of xmlWriter
         * @access   public
         **/
		function XmlControlOnRender(&$xmlWriter) {
		}


      /**
        * Method sets initial data for control
        *  @param     array    $data    Array with initial data
        *  @access public
        **/
        function SetData($data=array()) {
           $this->data=$data;
        }

        /**
          * Method sets additionsl initial data for control
          *  @param     array    $data    Array with initial data
          *  @access public
          **/
        function InitControl($data=array()){
          $this->SetData($data);

        }

        /**
          * Method set parent page to control
          *  @param     XmlPage    $page    XmlPage (or inherited class object) object
          *  @access public
          **/
        function setPage(&$page) {
          $this->Page = $page;
        }

  /**
    * Method Render control events tags
    * @param    xmlWriter   $xmlWriter  xmlWriter object
    * @param    mixed       $events     events string or array (format "event_name[space]event_string")
    * @access   private
    **/
  static function XmlRenderEvent(&$xmlWriter,$events)  {
     if (!is_array($events)) $events = array($events);
     foreach($events as $i => $event)    {
                list($event_name,$event_str) = preg_split("/ /",$event);
                $xmlWriter->WriteStartElement("event");
                $xmlWriter->WriteElementString("name",$event_name);
                $xmlWriter->WriteElementString("value",$event_str);
                $xmlWriter->WriteEndElement("event");
     }
  }

 }
?>