<?php
 $this->ImportClass("system.web.controls.dbtreecombobox","dbtreecomboboxcontrol");
 $this->ImportClass("system.types.string","string");

/** DbTreeTextControl control
   * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
   * @version 1.0
   * @package Framework
   * @subpackage classes.system.web.controls
   * @access public
   */
  class DbTreeTextControl extends DbTreeComboBoxControl {

    var $ClassName = "DbTreeTextControl";

    var $Version = "1.0";
    /**  Control node name
      *  @var  string   $nodeName
      **/
    var $nodeName = "dbtreetext";

        /**
          * Initialization data array
          * structure:
          *           <ul>
          *           <li> <b>name</b>           - control name
          *           <li> <b>selected_value</b> - control selected value
          *           <li> <b>table</b>          - Storage name (in module.ini) for get values
          *           <li> <b>caption_field</b>  - Field name in storage where caption is
          *           <li>  <B>parent</B>        - Parent field name
          *           <li> <b>method</b>         - Get method for get values )(default GetList)
          *           <li> <b>query_data</b>     - WHERE clause data array for get method {@see GetList()}
          *           <li> <b>orders</b>         - ORDER BY clause data array for get method {@see GetList()}
          *           <li> <b>caption</b>        - control caption
          *           <li> <b>multiple</b>       - draw multiple control , flag
          *           <li> <b>number</b>         - control number
          *           <li> <b>user_root_caption</b>  - draw root caption(Like --Root---), flag
          *           <li> <b>event</b>          - field events array (format: array("eventname javascript","eventname javascript")
          *           <li> <b>use_entries</b>    - use entries, flag
          *           <li> <B>entries_table</B>  - entries table (in DATABASE section module.ini.php)
          *           <li>  <B>entriesvalue_name</B> - entries values id field name
          *           <li>  <B>entriesvalue_caption</B>  - entries values caption field name
          *           <li>  <B>allow_category_select</B> - allow category select , flag
          *           <li>  <B>get_method</B>         - get method name (like GetList())
          *           <li>  <B>entries_get_method</B> - entries get method name (like GetList())
          *           <li>  <B>get_from</B>           - ID of root record
          *           <li>  <B>parsed_fields</B>      - parsed (htmlentities) fields names, array
          *           </ul>
          * @var    array   $data
          **/
          var $data = array();

 /**
   * Method sets data to draw by select control
   * @param    array   $data  Array with data
   * @access   public
   **/
   function InitControl($data=array()){
   	parent::InitControl($data);
    if (strlen($data["node"])!=0)	{
      $this->nodeName=$data["node"];
    }
     $this->data["parsed_fields"]=$data["parsed_fields"];
   }

   /**
     * Method build item  data array
     * @param    array      $data            input data
     * @param    string    $indent          string indent
     * @return  array      item data array
     * @access  private
     **/
   function BuildItemData($data,$indent="")  {
        $option=$data;
        return $option;

   }

   /**
   	 * Method prepare data for insert
   	 **/
   function PrepareData()	{
	$str=new String();
   	if (strlen($this->data["parsed_fields"]))	{
   		$keys_arr=explode(",",$this->data["parsed_fields"]);
   		foreach($keys_arr as $key => $field)	{
   			foreach($this->data["options"] as $i=>$option)	{
            if(!empty($option))
   			 foreach($option as $node => $value)	{
        		   if ($node==$field) 	{
        		   	$this->data["options"][$i][$node]=$str->ParseForBR($value);
        		   }
        	 }
   			}
   		}
   	}
   }

   function XmlControlOnRender(&$xmlWriter) {
   			$this->PrepareData();
   			$xmlWriter->WriteStartElement($this->nodeName);
        if(!empty($this->data["caption"]))  $xmlWriter->WriteElementString("title",$this->data["caption"]);

			foreach($this->data["options"] as $i=>$option)	{
       if (is_array($option))  {
	      $xmlWriter->WriteStartElement("item");
        $xmlWriter->WriteAttributeString("id",$option[$this->key_field_name]);
        foreach($option as $node => $value)	{
           $xmlWriter->WriteElementString($node,$value);
        }
        $xmlWriter->WriteEndElement("item");
       }
      }
      $xmlWriter->WriteEndElement();

   }


 }// class
?>