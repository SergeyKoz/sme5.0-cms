<?php
  $this->ImportClass("system.web.controls.form","formcontrol");

/** File control
     * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
     * @package	Framework
     * @subpackage classes.system.web.controls
     * @access public
     */
    class File2Control extends FormControl {
		var $ClassName = "File2Control";
        var $Version = "1.0";
          var $data = array();

    function SetData($data=array())
    {
          $this->data = $data;
          $this->setControlParameter("size","Text_size",$data["size"]);
          prn($data);
    }

        function XmlControlOnRender(&$xmlWriter) {

         $xmlWriter->WriteStartElement("file2");
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