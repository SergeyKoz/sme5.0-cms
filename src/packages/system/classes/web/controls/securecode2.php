<?php
  $this->ImportClass("system.web.controls.text","textcontrol");
  $this->ImportClass("system.web.controls.hidden","hiddencontrol");

/** SecureCode control
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @modified Alexandr Degtiar <adegtiar@activemedia.com.ua>
     * @version 1.0
     * @package wizard
     * @access public
     */
    class SecureCode2Control extends TextControl {
        var $ClassName = "SecureCode2Control";
        var $Version = "1.0";

        /**
          * Initialization data array
          * structure:
          *           <ul>
          *           <li> <b>name</b>                - control name
          *           <li> <b>value</b>               - control value
          *           <li> <b>maxlength</b>           -  maximum length value
          *           <li> <b>size</b>                - text field size
          *           <li> <b>caption</b>             - field caption
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
        $xmlWriter->WriteStartElement("securecode");
        TextControl::XmlControlOnRender($xmlWriter);
        $xmlWriter->WriteEndElement("securecode");
   }

   function Wipe()
   {
        unset($_SESSION['SECURE_CODE']);
   }

   function Check($Code)
   {
       if (($_SESSION['SECURE_CODE'] == "") || $_SESSION['SECURE_CODE'] != $Code)
       {
           $this->Wipe();
           return false;
       } else {
           $this->Wipe();
           return true;
       }
   }
}// class
?>