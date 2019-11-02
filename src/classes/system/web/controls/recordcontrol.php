<?php
$this->ImportClass("system.web.xmlcontrol","xmlcontrol");
$this->ImportClass("system.data.datamanipulator","datamanipulator");

/** RecordControl control
     * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
     * @version 1.0
     * @package Framework
     * @subpackage classes.system.web.controls
     * @access public
     */
    class RecordControl extends XmlControl {
        var $ClassName = "RecordControl";
        var $Version = "1.0";
        var $data;

    /**
     * Method  Executes on control load to the parent
     * @access  private
     */
    function ControlOnLoad(){
      parent::ControlOnLoad();
    }

 /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
   function XmlControlOnRender(&$xmlWriter) {
       $xmlWriter->WriteStartElement($this->XmlTag);
       if (sizeof($this->data)!=0)   {
           foreach ($this->data as $node => $value){
                if(strpos($value, "<") !== false){
                    $xmlWriter->WriteStartElement($node);
                        $xmlWriter->WriteCData($value);
                    $xmlWriter->WriteEndElement($node);

                } else {
                    $xmlWriter->WriteElementString($node,$value);
                }
           }
       }
       $xmlWriter->WriteEndElement();
   }

   static function StaticXmlControlOnRender(&$object, &$xmlWriter) {
       $xmlWriter->WriteStartElement($object->XmlTag);
       if (sizeof($object->data)!=0)   {
           foreach ($object->data as $node => $value){
             	if (!is_array($value) && !is_object($value)){
	                if(strpos($value, "<") !== false){
	                    $xmlWriter->WriteStartElement($node);
	                        $xmlWriter->WriteCData($value);
	                    $xmlWriter->WriteEndElement($node);

	                } else {
	                    $xmlWriter->WriteElementString($node,$value);
	                }
                }
           }
       }
       $xmlWriter->WriteEndElement();
   }

 }// class
?>