<?php
  $this->ImportClass("system.web.controls.text","textcontrol");
  $this->ImportClass("system.web.controls.hidden","hiddencontrol");

/** SecureCode control
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Framework
     * @subpackage classes.system.web.controls
     * @access public
     */
    class SecureCodeControl extends TextControl {
        var $ClassName = "SecureCodeControl";
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
    * Method generates random number and writes data to securecode table
    * @access	public
    */
    function GegRandomNumber(){
       $random = rand(100000,999999);
       $hash = md5($random."+".rand(0,10000000));
       $this->Page->Kernel->ImportClass("module.data.securecodestable","securecodestable");
       $settings = &$this->Page->Kernel->Settings;
       $securecodestable = new SecureCodesTable($this->Page->Kernel->Connection, $settings->GetItem("database", "SecureCodesTable"));
       $data = array("hash"=>$hash, "number"=>$random, "inittime"=>date("YmdHis", time()));
       $securecodestable->Insert($data);
       $securecodestable->DeleteObsolete();
       return $hash;
    }


    /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
        function XmlControlOnRender(&$xmlWriter) {
        $this->secureid = $this->GegRandomNumber();
         $xmlWriter->WriteStartElement("securecode");
           TextControl::XmlControlOnRender($xmlWriter);
               $xmlWriter->WriteElementString("secureid",$this->secureid);
           $this->data["name"] .= "_code";
           $this->data["value"] = $this->secureid;
           HiddenControl::XmlControlOnRender($xmlWriter);
         $xmlWriter->WriteEndElement();


   }


   }// class
?>