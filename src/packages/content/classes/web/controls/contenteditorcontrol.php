<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Stat
  * @access public
 **/
$this->ImportClass("system.web.controls.spaweditor", "SpawEditorControl");
class ContentEditorControl extends SpawEditorControl
{

    var $ClassName = "ContentEditorControl";
    var $Version = "1.0";
    var $id = 0;

    /** Method creates child controls
     * @access public
     */
    function ControlOnLoad()
    {
        parent::ControlOnLoad();
    }

  /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
        function XmlControlOnRender(&$xmlWriter) {
            parent::XmlControlOnRender($xmlWriter);
        }

}

?>