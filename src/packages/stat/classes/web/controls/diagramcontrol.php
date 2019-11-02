<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");

/**
 * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
 * @version 1.0
 * @package Stat
 * @subpackage classes.web.controls
 * @access public
 */
class DiagramControl extends XmlControl {
    var $ClassName = "DiagramControl";
    var $Version = "1.0";
    
    var $data = array();

    /**
    * Method draw XML data
    * @access   public  
    **/
    function DrawDiagram(&$xmlWriter)
    {
        $min_value = null;
        $max_value = null;
        $min_value_caption = null;
        $max_value_caption = null;
    	$xmlWriter->WriteStartElement("data");
    	$xmlWriter->WriteAttributeString("id", $this->Name);
    	
    	if (!isset($this->data['data']))
    	{
    	    $this->data['data'] = array();
    	}
        // calculating min/max value for values normalization
        foreach($this->data['data'] as $caption => $value_temp)
		{
		    if (!is_array($value_temp))
		    {
		        $value_temp = array($value_temp);
		    }
		    foreach($value_temp as $value)
		    {
            	if ($min_value == null)
            	{
            	    $min_value = $value;
            	    $min_value_caption = $caption;
            	} else {
            	    if ($value < $min_value)
            	    {
            	        $min_value = $value;
                	    $min_value_caption = $caption;
            	    }
            	}
            	if ($max_value == null)
            	{
            	    $max_value = $value;
            	    $max_value_caption = $caption;
            	} else {
            	    if ($value > $max_value)
            	    {
            	        $max_value = $value;
                	    $max_value_caption = $caption;
            	    }
            	}
		    }
		}
    	// end of foreach
    	
    	$xmlWriter->WriteElementString('abs_min_value', $min_value);
    	$xmlWriter->WriteElementString('abs_max_value', $max_value);
//    	$xmlWriter->WriteElementString('min_value_caption', $min_value_caption);
//    	$xmlWriter->WriteElementString('max_value_caption', $max_value_caption);
	    	
        $values_in_group_count = 0;
    	foreach($this->data['data'] as $caption => $value)
		{
        	$xmlWriter->WriteStartElement("item");
	    	$xmlWriter->WriteElementString('caption', $caption);
		    if (!is_array($value))
		    {
		        $value = array($value);
		    }
		    if (count($value) > $values_in_group_count)
		    {
		        $values_in_group_count = count($value);
		    }
	    	foreach($value as $value_temp)
	    	{
            	$xmlWriter->WriteStartElement("value");
	    	    // absolute value of item
    	    	$xmlWriter->WriteElementString('abs', $value_temp);
	    	    // normalized value of item
	    	    if ($max_value == 0)
	    	    {
        	    	$xmlWriter->WriteElementString('norm', 0);
	    	    } else {
        	    	$xmlWriter->WriteElementString('norm', $value_temp / $max_value);
	    	    }
            	$xmlWriter->WriteEndElement("value");
	    	}
        	$xmlWriter->WriteEndElement("item");
		}
    	$xmlWriter->WriteElementString('values_in_group', $values_in_group_count);
    	$xmlWriter->WriteElementString('values_count', count($this->data['data']));

    	$xmlWriter->WriteStartElement("localization");
        	$xmlWriter->WriteElementString('hits', 
            	$this->Page->Kernel->Localization->GetItem('DIAGRAM', 'caption_hits'));
        	$xmlWriter->WriteElementString('hosts', 
            	$this->Page->Kernel->Localization->GetItem('DIAGRAM', 'caption_hosts'));
        	$xmlWriter->WriteElementString('refs', 
            	$this->Page->Kernel->Localization->GetItem('DIAGRAM', 'caption_transfers'));
    	$xmlWriter->WriteEndElement("localization");
    	$xmlWriter->WriteEndElement("data");
    }

    /**
    *  Method draws xml-content of control
    *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
    *  @access  public
    */
    function XmlControlOnRender(&$xmlWriter) {
		$this->DrawDiagram($xmlWriter);
    }

} // class

?>