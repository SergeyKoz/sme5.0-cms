<?php
$this->ImportClass("system.web.controls.form", "formcontrol");
/** Select control
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package Framework
 * @subpackage classes.system.web.controls
 * @access public
 */
class SelectControl extends FormControl
{
    var $ClassName = "SelectControl";
    var $Version = "1.0";
    /**
     *  Method Draws XML-content of a control
     *  @param XMLWriter    $xmlWriter  instance of XMLWriter
     *  @access private
     */
     function XmlControlOnRender(&$xmlWriter){
         SelectControl::StaticXmlControlOnRender($this, $xmlWriter);
     }

    /*function XmlControlOnRender (&$xmlWriter)
    {
        $xmlWriter->WriteStartElement("select");
        //--render events handlers
        if (isset($this->data["event"])) {
            SelectControl::XmlRenderEvent(&$xmlWriter, $this->data["event"]);
        }
        $this->XmlGetErrorFields(&$xmlWriter);
        $xmlWriter->WriteStartElement("name");
        $xmlWriter->WriteString($this->data["name"]);
        $xmlWriter->WriteEndElement(); //name
        if (strlen($this->data["multiple"])) {
            $xmlWriter->WriteStartElement("multiple");
            $xmlWriter->WriteString($this->data["multiple"]);
            $xmlWriter->WriteEndElement(); //multiple
        }
        if (strlen($this->data["size"])) {
            $xmlWriter->WriteStartElement("size");
            $xmlWriter->WriteString($this->data["size"]);
            $xmlWriter->WriteEndElement(); //size
        }
        if (strlen($this->data["disabled"])) {
            $xmlWriter->WriteStartElement("disabled");
            $xmlWriter->WriteString($this->data["disabled"]);
            $xmlWriter->WriteEndElement(); //disabled
        }
        if (strlen($this->data["onchange"])) {
            $xmlWriter->WriteStartElement("onchange");
            $xmlWriter->WriteString($this->data["onchange"]);
            $xmlWriter->WriteEndElement(); //onchange
        }
        if (strlen($this->data["notnull"])) {
            $xmlWriter->WriteStartElement("notnull");
            $xmlWriter->WriteString($this->data["notnull"]);
            $xmlWriter->WriteEndElement();
        }
        if (strlen($this->data["error_field"])) {
            $xmlWriter->WriteStartElement("error_field");
            $xmlWriter->WriteString($this->data["error_field"]);
            $xmlWriter->WriteEndElement(); //onchange
        }
        if (strlen($this->data["caption"])) {
            $xmlWriter->WriteStartElement("caption");
            $xmlWriter->WriteString($this->data["caption"]);
            $xmlWriter->WriteEndElement(); //onchange
        }
        if (! empty($this->data["title"])) {
            $xmlWriter->WriteStartElement("title");
            $xmlWriter->WriteStartElement("caption");
            if (isset($this->data["title"]["caption"])) {
                $xmlWriter->WriteString($this->data["title"]["caption"]);
                $xmlWriter->WriteEndElement(); //caption
            }
            if (isset($this->data["title"]["align"])) {
                $xmlWriter->WriteStartElement("align");
                $xmlWriter->WriteString($this->data["title"]["align"]);
                $xmlWriter->WriteEndElement(); //align
            }
            if (isset($this->data["title"]["separator"])) {
                $xmlWriter->WriteStartElement("separator");
                $xmlWriter->WriteString($this->data["title"]["separator"]);
                $xmlWriter->WriteEndElement(); //separator
            }
            $xmlWriter->WriteEndElement(); //title
        }
        $xmlWriter->WriteStartElement("options");
        //--create options data
        if (strlen($this->data["options_mask"]) != 0) {
            $this->createOptionsData($this->data["options_mask"]);
        }
        if (! is_array($this->data["selected_value"]))
            $this->data["selected_value"] = array($this->data["selected_value"]);
            // Making selected a strings
        for ($i = 0, $sizeof = sizeof($this->data["selected_value"]); $i < $sizeof; $i ++) {
            $this->data["selected_value"][$i] = (string) $this->data["selected_value"][$i];
        }
        for ($i = 0; $i < sizeof($this->data["options"]); $i ++) {
            $xmlWriter->WriteStartElement("option");
            if (($this->data["options"][$i]["selected"] != "") or (in_array($this->data["options"][$i]["value"], $this->data["selected_value"], true))) {
                $xmlWriter->WriteAttributeString("selected", "yes");
            }
            if ($this->data["options"][$i]["class"] != "") {
                $xmlWriter->WriteAttributeString("class", $this->data["options"][$i]["class"]);
            }
            if ($this->data["options"][$i]["disabled"]) {
                $xmlWriter->WriteAttributeString("disabled", "1");
            }
            if (isset($this->data["options"][$i]["value"])) {
                $xmlWriter->WriteStartElement("value");
                $xmlWriter->WriteString($this->data["options"][$i]["value"]);
                $xmlWriter->WriteEndElement(); // value
            }
            $xmlWriter->WriteStartElement("caption");
            $xmlWriter->WriteString($this->data["options"][$i]["caption"]);
            $xmlWriter->WriteEndElement(); //caption
            $xmlWriter->WriteEndElement(); //option
        }
        $xmlWriter->WriteEndElement(); //options
        //write language version
        $this->WriteLanguageVersion(&$xmlWriter);
        $xmlWriter->WriteEndElement(); // select
    }    */
    /**
     * Method create control options array with range
     * @param  string $mask    range mask
     * @access public
     **/
    function createOptionsData ($mask)
    {
        //
        $range_arr = explode("..", $mask);
        for ($i = $range_arr[0]; $i <= $range_arr[1]; $i ++)
            $this->data["options"][] = array("value" => (string) $i , "caption" => $i);
    }

    static function StaticXmlControlOnRender (&$object, &$xmlWriter)
    {   $data=$object->data;
        $xmlWriter->WriteStartElement("select");
        //--render events handlers
        if (isset($data["event"]))
            SelectControl::XmlRenderEvent($xmlWriter, $data["event"]);

        $object->XmlGetErrorFields($xmlWriter);
        $xmlWriter->WriteStartElement("name");
        $xmlWriter->WriteString($data["name"]);
        $xmlWriter->WriteEndElement(); //name
        if (strlen($data["multiple"])) {
            $xmlWriter->WriteStartElement("multiple");
            $xmlWriter->WriteString($data["multiple"]);
            $xmlWriter->WriteEndElement(); //multiple
        }
        if (strlen($data["size"])) {
            $xmlWriter->WriteStartElement("size");
            $xmlWriter->WriteString($data["size"]);
            $xmlWriter->WriteEndElement(); //size
        }
        if (strlen($data["disabled"])) {
            $xmlWriter->WriteStartElement("disabled");
            $xmlWriter->WriteString($data["disabled"]);
            $xmlWriter->WriteEndElement(); //disabled
        }
        if (strlen($data["onchange"])) {
            $xmlWriter->WriteStartElement("onchange");
            $xmlWriter->WriteString($data["onchange"]);
            $xmlWriter->WriteEndElement(); //onchange
        }
        if (strlen($data["notnull"])) {
            $xmlWriter->WriteStartElement("notnull");
            $xmlWriter->WriteString($data["notnull"]);
            $xmlWriter->WriteEndElement();
        }
        if (strlen($data["error_field"])) {
            $xmlWriter->WriteStartElement("error_field");
            $xmlWriter->WriteString($data["error_field"]);
            $xmlWriter->WriteEndElement(); //onchange
        }
        if (strlen($data["caption"])) {
            $xmlWriter->WriteStartElement("caption");
            $xmlWriter->WriteString($data["caption"]);
            $xmlWriter->WriteEndElement(); //onchange
        }
        if (! empty($data["title"])) {
            $xmlWriter->WriteStartElement("title");
            $xmlWriter->WriteStartElement("caption");
            if (isset($data["title"]["caption"])) {
                $xmlWriter->WriteString($data["title"]["caption"]);
                $xmlWriter->WriteEndElement(); //caption
            }
            if (isset($data["title"]["align"])) {
                $xmlWriter->WriteStartElement("align");
                $xmlWriter->WriteString($data["title"]["align"]);
                $xmlWriter->WriteEndElement(); //align
            }
            if (isset($data["title"]["separator"])) {
                $xmlWriter->WriteStartElement("separator");
                $xmlWriter->WriteString($data["title"]["separator"]);
                $xmlWriter->WriteEndElement(); //separator
            }
            $xmlWriter->WriteEndElement(); //title
        }
        $xmlWriter->WriteStartElement("options");
        //--create options data
        if (strlen($data["options_mask"]) != 0) {
            $object->createOptionsData($data["options_mask"]);
        }
        if (! is_array($data["selected_value"]))
            $data["selected_value"] = array($data["selected_value"]);
            // Making selected a strings
        for ($i = 0, $sizeof = sizeof($data["selected_value"]); $i < $sizeof; $i ++) {
            $data["selected_value"][$i] = (string) $data["selected_value"][$i];
        }
        for ($i = 0; $i < sizeof($data["options"]); $i ++) {
            $xmlWriter->WriteStartElement("option");
            if (($data["options"][$i]["selected"] != "") or (in_array($data["options"][$i]["value"], $data["selected_value"], true))) {
                $xmlWriter->WriteAttributeString("selected", "yes");
            }
            if ($data["options"][$i]["class"] != "") {
                $xmlWriter->WriteAttributeString("class", $data["options"][$i]["class"]);
            }
            if ($data["options"][$i]["disabled"]) {
                $xmlWriter->WriteAttributeString("disabled", "1");
            }
            if (isset($data["options"][$i]["value"])) {
                $xmlWriter->WriteStartElement("value");
                $xmlWriter->WriteString($data["options"][$i]["value"]);
                $xmlWriter->WriteEndElement(); // value
            }
            $xmlWriter->WriteStartElement("caption");
            $xmlWriter->WriteString($data["options"][$i]["caption"]);
            $xmlWriter->WriteEndElement(); //caption
            $xmlWriter->WriteEndElement(); //option
        }
        $xmlWriter->WriteEndElement(); //options
        //write language version
        $object->WriteLanguageVersion($xmlWriter);
        $xmlWriter->WriteEndElement(); // select
    }
} // class
?>