<?php
$this->ImportClass("system.web.xmlcontrol","xmlcontrol");
  /** Navigation control
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Framework
     * @subpackage classes.system.web.controls
     * @access public
     */
    class NavigationControl extends XmlControl {
        var $ClassName = "NavigationControl";
        var $Version = "1.0";
        /** Array with initial data
        *   @var    array   $data
        */
        var $data = array();

        /**
        *  Method Sets initial data for the control
        * @param    array   $data       Array with initial data
        * @access   public
        */
        function SetData($data=array()) {
           $this->data = $data;
           if(!isset($this->data["var_name"])){
              $this->data["var_name"] = "start";
           }
        }

        /**
        * Method draws navigationbar element
        * @param    int     $i   Page index
        * @param    string        $caption   Page number caption

        * @param    XMLWriter   $xmlWriter      XML writer instance
        * @access   public
        **/
        function DrawElement($i, $caption, &$xmlWriter){
                   $xmlWriter->WriteStartElement("element");
                      if($i == $this->data["start"]){
                        $xmlWriter->WriteAttributeString("selected","yes");
                      }

                         $xmlWriter->WriteStartElement("url");
                            $xmlWriter->WriteString($this->data["url"].($this->data["url"]=="?" ? "" : "&amp;").$this->data["prefix"].$this->data["var_name"]."=".$i);
                         $xmlWriter->WriteEndElement();
                         $xmlWriter->WriteStartElement("page");
                         $xmlWriter->WriteString($i+1);
                         $xmlWriter->WriteEndElement();
                         $xmlWriter->WriteStartElement("caption");
                         $xmlWriter->WriteString($caption);
                         $xmlWriter->WriteEndElement();

                         $xmlWriter->WriteStartElement("order_by");
                            $xmlWriter->WriteString($this->data["order_by"]);

                         $xmlWriter->WriteEndElement();

                    $xmlWriter->WriteEndElement();

        }
       /**
       *  Method draws xml-content of navigatrion bar
       *  @param    XMLWriter     $xmlWriter Instance of Writer object
       *   @access  public
       */
        function WriteNavigationBar(&$xmlWriter)    {
           $pages_in_decade = 10;
           if(intval($this->data["ppd"])){
                $pages_in_decade = intval($this->data["ppd"]);
           }
           if($this->data["rpp"] != 0 ){
            $pages = ceil($this->data["total"] / $this->data["rpp"]);
           } else {
            $pages = 0;
           }
           $current_decade=floor(($this->data["start"])/$pages_in_decade);
           $current_start = $pages_in_decade*($current_decade);
           $current_end = $current_start+($pages_in_decade-1);
           if($current_start < 0){
                  $current_start = 0;
           }
           if($current_end >= $pages){
                  $current_end = $pages-1;
           }
           //echo $current_decade." . ".$current_start." . ".$current_end."<br>";
           $xmlWriter->WriteStartElement("bar");
           if($current_decade > 0){
              $this->DrawElement(($current_decade*$pages_in_decade)-1, sprintf($this->Page->Kernel->Localization->GetItem("MAIN","_navigation_prev_10"),$pages_in_decade), $xmlWriter);
           }
                for($i=$current_start; $i<=$current_end; $i++)
                  {
                     $this->DrawElement($i, $i+1, $xmlWriter);
                  }
           if($current_decade < (ceil($pages / $pages_in_decade)-1)){
              $this->DrawElement((($current_decade+1)*$pages_in_decade), sprintf($this->Page->Kernel->Localization->GetItem("MAIN","_navigation_next_10"),$pages_in_decade), $xmlWriter);
           }

           $xmlWriter->WriteEndElement();


        }

       /**
        *  Method draws xml-content of control
        *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
        *  @access  public
        */
        function XmlControlOnRender(&$xmlWriter) {
                 $xmlWriter->WriteElementString("start", $this->data["start"]);
                 $xmlWriter->WriteElementString("total", $this->data["total"]);
                 $xmlWriter->WriteElementString("rpp", $this->data["rpp"]);
                 $this->WriteNavigationBar($xmlWriter);
        }

} // class

?>