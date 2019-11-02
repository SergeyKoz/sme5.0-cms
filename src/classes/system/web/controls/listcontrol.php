<?php
 $this->ImportClass("system.web.xmlcontrol","xmlcontrol");
 $this->ImportClass("system.web.controls.link","linkcontrol");
 $this->ImportClass("system.web.controls.navigationcontrol","navigationcontrol");
   /** List control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package	Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class ListControl extends XmlControl {
		var $ClassName = "ListControl";
		var $Version = "1.0";
		/**    Data storage
		* @var   Object     $Storage
		*/
		var $Storage;
		/**   Data list
		* @var  array   $_list
		*/
		var $_list;
		/**   Headers array
		* @var   array  $headers
		*/
		var $headers = array();
		/**   Base url for page-navigator
		* @var   string   $navigator_url
		*/
		var $navigator_url;
		/**  Name of section
		* @var   string    $sectionname
		*/
		var $sectionname;
		/**   Records per page
		* @var   int   $_RPP
		*/
		var $_RPP;
		/**   List offset
		* @var   int   $_START
		*/
		var $_START;
		/**    Total number of records
		* @var    int   $_TOTAL
		*/
		var $_TOTAL;

		/** Constructor. Initializes a new instance of the Control class.
		* @param     string    $name   Name of  control
		* @param     string    $xmlTag  NAme of XML Tag
		* @param     object    $storage  Storage object
		* @access    public
		*/
		function ListControl($name, $xmlTag, &$storage)	{
		  parent::XmlControl($name, $xmlTag);
		  @$this->Storage = &$storage;

		}
		/**
		* Methiod sets initial data for control
		*  @param  	array	$data   Initial data
		* @access	public
		*/
		function SetData($data=array()){
		  $this->headers = $data["headers"];
		  $this->navigator_url = $data["navigator_url"];
		  $this->sectionname = $this->Page->ClassName;
		}
	 /**
	 * Method  Executes on control load to the parent
	 * @access	private
	 */
		function ControlOnLoad() {
			$this->_RPP = $this->Page->Kernel->Settings->GetItem("main","RecordsPerPage");
			$this->_START = ($this->Page->Request->Value("start") =="" ? "0":$this->Page->Request->Value("start"));
			$this->_TOTAL = $this->Storage->GetCount();

			if($this->_START*$this->_RPP >= $this->_TOTAL)	{
			   $this->_START = ceil($this->_TOTAL/$this->_RPP)-1;
			}

			if($this->_START<0)$this->_START=0;
			list($order, $attribute) = explode(":",$this->Page->Request->Value("order_by"));
			$orders[$order]=($attribute == "DESC"? false:true);
			$_list = $this->Storage->GetList(null, $orders, $this->_RPP, $this->_RPP*$this->_START);
			if($_list->RecordCount == 0){
			 $this->Page->AddErrorMessage("ConfigFile","EMPTY_LIST");
			}
			else{
				for($i=0; $i<$_list->RecordCount; $i++)  {
				   $this->_list[] = $_list->Read();
			}	}
		}
 /**
 *  Method builds rows of a list (prorotype)
 * @param  XMLWriter   $xmlWriter  instance of XMLWriter
 * @access private
 */
		function BuildRows(&$xmlWriter){

		}
		/**
		*  Method draws xml-content of control
		*  @param   XMLWriter 	$xmlWriter   Instance of XMLWriter
		*  @access	public
		*/
		function XmlControlOnRender(&$xmlWriter) {

		   $this->AddControl(new NavigationControl("navigator","navigator"));
		   $this->Controls["navigator"]->SetData(array(
						"start"=>$this->_START,
						"total"=>$this->_TOTAL,
						"rpp"  =>$this->_RPP,
						"url"  =>$this->navigator_url."&amp;order_by=".$this->Page->Request->Value("order_by"),
						"order_by" =>  $this->Page->Request->Value("order_by")
						));

		   $xmlWriter->WriteStartElement("headers");
			for($i=0; $i<sizeof($this->headers); $i++){
			  $xmlWriter->WriteStartElement("header");
				   $xmlWriter->WriteAttributeString("name", $this->headers[$i]);
				   $xmlWriter->WriteString($this->Page->Localization->GetItem($this->sectionname,$this->headers[$i]));
			  $xmlWriter->WriteEndElement();
			}

		   $xmlWriter->WriteEndElement();

		   $this->BuildRows($xmlWriter);

		}
} // class

?>