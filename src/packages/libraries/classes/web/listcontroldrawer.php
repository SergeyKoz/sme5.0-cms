<?php

/** ItemsListControl controls drawer class
 * Provides routines to manipulate data and draw control for itemslistcontrol classes
 * Draw edit controls
 * @author Konstantin  Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package  Libraries
 * @subpackage classes.web
 * @access public
 * @static
 **/

class ListControlDrawer extends Component
{

    /**
     * Method draws xml-content of row string-control
     * @param    int     $i  Row number
     * @param    int     $j  Control number
     * @param    XMLWriter       $xmlWriter  Xml Writer instance
     * @param    ItemsListControl    $control  ItemsListControl object
     * @access   public
     */
    static function DrawLink($i, $j, &$xmlWriter, &$control)
    {
        if ($control->multilevel && ! ((sizeof($control->node_levels) + 1 >= $control->max_node_level) && ($control->max_node_level != 0))) {
            // if(strlen($control->alt_sublist_handler)){
            // $href = "?page=".$control->alt_sublist_handler."&amp;old_page=".$control->self."&amp;".$control->library_ID."_parent_id=". $control->_list[$i][$control->key_field]."&restore=".base64_encode(component::BuildRequestQuery($_GET,"&amp;").component::BuildRequestQuery($_POST,"&amp;")).$control->append_hrefs;
            // } else {
            $href = "?".($control->Package!="" ? "package=".$control->Package."&amp;" : "")."page=" . $control->self . "&amp;" . $control->library_ID . "_order_by=" . $control->order_by . "&amp;library=" . $control->library_ID . "&amp;" . $control->library_ID . "_parent_id=" . $control->_list[$i][$control->key_field] . $control->custom_str . "&amp;host_library_ID=" . $control->host_library_ID . $control->append_hrefs;
            //}
        }
        else {
            $href = $control->edit_url . "&amp;item_id=" . $control->_list[$i][$control->key_field] . "&amp;start=" . $control->_START . "&amp;order_by=" . $control->order_by . "&amp;library=" . $control->library_ID . "&amp;restore=" . rawurlencode("old_page=" . $control->self) . $control->custom_str . "&amp;host_library_ID=" . $control->host_library_ID . "&amp;" . $control->library_ID . "_parent_id=" . $control->parent_id . $control->append_hrefs;
        }
        if (strlen($control->alt_sublist_handler)) {
            $href = "?package=".$control->Package."&amp;page=" . $control->alt_sublist_handler . "&amp;old_page=" . $control->self . "&amp;" . $control->library_ID . "_parent_id=" . $control->_list[$i][$control->key_field] . "&restore=" . base64_encode(component::BuildRequestQuery($_GET, "&amp;") . component::BuildRequestQuery($_POST, "&amp;")) . $control->append_hrefs;
        }
        $array = array(
            "caption" => $control->_list[$i][$control->fields[$j]["field_name"]],
            "encoded_caption" => rawurlencode($control->_list[$i][$control->fields[$j]["field_name"]]),
            "href" => $href
        );
        if ($control->fields[$j]["bold"]) {
            $array["bold"] = "yes";
        }
        if ($control->fields[$j]["italic"]) {
            $array["italic"] = "yes";
        }
        if ($control->fields[$j]["cut_length"] > 0) {
            $array["cut_length"] = $control->fields[$j]["cut_length"];
        }
        if ($control->fields[$j]["control"] != "link") {
            $array["disabled"] = "yes";
        }
        if ($control->fields[$j]["control"] == "date") {
            if ($control->fields[$j]["is_unix_timestamp"] && $control->_list[$i][$control->fields[$j]["field_name"]] == 0) {
                $array["caption"] = '-';
            }
            else {
                $array["caption"] = $control->dateconv($control->_list[$i][$control->fields[$j]["field_name"]], $control->fields[$j]["fulldate"], $control->fields[$j]["is_unix_timestamp"]);
            }
        }

        $control->Controls["link"]->InitControl($array);
        $control->Controls["link"]->XmlControlOnRender($xmlWriter);
    }

    /**
     * Method draws xml-content of row hidden-control
     * @param    int     $i  Row number
     * @param    int     $j  Control number
     * @param    XMLWriter       $xmlWriter  Xml Writer instance
     * @param    ItemsListControl    $control  ItemsListControl object
     * @access   public
     */
    static function DrawHidden($i, $j, &$xmlWriter, &$control)
    {
        $array = array(
            "name" => $control->fields[$j]["field_name"],
            "value" => $control->_list[$i][$control->fields[$j]["field_name"]]
        );
        $control->Controls["hidden"]->InitControl($array);
        $control->Controls["hidden"]->XmlControlOnRender($xmlWriter);
    }

    /**
     * Method draws xml-content of row graphic-control
     * @param    int     $i  Row number
     * @param    int     $j  Control number
     * @param    XMLWriter       $xmlWriter  Xml Writer instance
     * @param    ItemsListControl    $control  ItemsListControl object
     * @access   public
     */
    static function DrawGraphic($i, $j, &$xmlWriter, &$control)
    {
        $array = array(
            "value" => $control->_list[$i][$control->fields[$j]["field_name"]]
        );
        $control->Controls["graphicprice"]->InitControl($array);
        $control->Controls["graphicprice"]->XmlControlOnRender($xmlWriter);
    }

    /**
     * Method draws xml-content of row caption-control
     * @param    int     $i  Row number
     * @param    int     $j  Control number
     * @param    XMLWriter       $xmlWriter  Xml Writer instance
     * @param    ItemsListControl    $control  ItemsListControl object
     * @access   public
     */
    static function DrawCaption($i, $j, &$xmlWriter, &$control)
    {
        $array = array(
            "disabled" => 1,
            "value" => $control->_list[$i][$control->fields[$j]["field_name"]]
        );
        for ($kk = 0; $kk < sizeof($control->fields[$j]["options"]); $kk ++) {
            if ($control->fields[$j]["options"][$kk]["value"] == $control->_list[$i][$control->fields[$j]["field_name"]]) {
                $array["caption"] = $control->fields[$j]["options"][$kk]["caption"];
            }
        }
        $control->Controls["link"]->InitControl($array);
        $control->Controls["link"]->XmlControlOnRender($xmlWriter);
    }

    /**
     * Method draws xml-content of row text-control
     * @param    int     $i  Row number
     * @param    int     $j  Control number
     * @param    XMLWriter       $xmlWriter  Xml Writer instance
     * @param    ItemsListControl    $control  ItemsListControl object
     * @access   public
     */
    static function DrawText($i, $j, &$xmlWriter, &$control)
    {
        //prn($control->_list);


        $array = array(
            "disabled" => 0,
            "value" => $control->_list[$i][$control->fields[$j]["field_name"]],
            "size" => $control->fields[$j]["size"],
            "name" => $control->fields[$j]["field_name"] . "[" . $control->_list[$i][$control->key_field] . "]"
        );
        for ($kk = 0; $kk < sizeof($control->fields[$j]["options"]); $kk ++) {
            if ($control->fields[$j]["options"][$kk]["value"] == $control->_list[$i][$control->fields[$j]["field_name"]]) {
                $array["caption"] = $control->fields[$j]["options"][$kk]["caption"];
            }
        }

        //prn($array);
        $control->Controls["edit"]->InitControl($array);
        $control->Controls["edit"]->XmlControlOnRender($xmlWriter);

    }

    /**
     * Method draws xml-content of row checkbox-control
     * @param    int     $i  Row number
     * @param    int     $j  Control number
     * @param    XMLWriter       $xmlWriter  Xml Writer instance
     * @param    ItemsListControl    $control  ItemsListControl object
     * @access   public
     */
    static function DrawCheckbox($i, $j, &$xmlWriter, &$control)
    {
        $array = array(
            "caption" => $control->_list[$i][$control->fields[$j]["field_name"]],
            "value" => $control->_list[$i][$control->key_field],
            "name" => $control->fields[$j]["field_name"] . "[]"
        );
        if ($control->_list[$i][$control->fields[$j]["field_name"]] == $control->fields[$j]["checkOn"]) {
            $array["checked"] = "yes";
        }
        $control->Controls["checkbox"]->InitControl($array);
        $control->Controls["checkbox"]->XmlControlOnRender($xmlWriter);
    }

    /**
     * Method draws xml-content of row radio-control
     * @param    int     $i  Row number
     * @param    int     $j  Control number
     * @param    XMLWriter       $xmlWriter  Xml Writer instance
     * @param    ItemsListControl    $control  ItemsListControl object
     * @access   public
     */
    static function DrawRadio($i, $j, &$xmlWriter, &$control)
    {
        $array = array(
            "caption" => $control->_list[$i][$control->fields[$j]["field_name"]],
            "value" => $control->_list[$i][$control->key_field],
            "name" => $control->fields[$j]["field_name"] . "[]"
        );
        if ($control->_list[$i][$control->fields[$j]["field_name"]] == $control->fields[$j]["checkOn"]) {
            $array["checked"] = "yes";
        }
        $control->Controls["radio"]->InitControl($array);
        $control->Controls["radio"]->XmlControlOnRender($xmlWriter);
    }

    /**
     * Method draws xml-content of row dbtext-control
     * @param    int     $i  Row number
     * @param    int     $j  Control number
     * @param    XMLWriter       $xmlWriter  Xml Writer instance
     * @param    ItemsListControl    $control  ItemsListControl object
     * @access   public
     */
    static function DrawDBText($i, $j, &$xmlWriter, &$control)
    {
        $array = array(
            "table" => $control->fields[$j]["field_table"],
            "caption_field" => sprintf($control->fields[$j]["fieldvalue_caption"], $control->Page->Kernel->Language),
            "query_data" => array(
                $control->fields[$j]["fieldvalue_name"] => $control->_list[$i][$control->fields[$j]["field_name"]]
            ),
            "get_method" => $control->fields[$j]["get_method"]
        );
        $control->Controls["dbtext"]->InitControl($array);
        $control->Controls["dbtext"]->XmlControlOnRender($xmlWriter);
    }

    /**
     * Method draws xml-content of row dbtreepath-control
     * @param    int     $i  Row number
     * @param    int     $j  Control number
     * @param    XMLWriter       $xmlWriter  Xml Writer instance
     * @param    ItemsListControl    $control  ItemsListControl object
     * @access   public
     */
    static function DrawDBTreePath($i, $j, &$xmlWriter, &$control)
    {
        $array = array(
            "table" => $control->fields[$j]["field_table"],
            "caption_field" => sprintf($control->fields[$j]["fieldvalue_caption"], $control->Page->Kernel->Language),
            "parent_field" => sprintf($control->fields[$j]["fieldvalue_parent"], $control->Page->Kernel->Language),
            "category_value" => $control->_list[$i][$control->fields[$j]["field_name"]]
        );
        $control->Controls["dbtreepath"]->InitControl($array);
        $control->Controls["dbtreepath"]->XmlControlOnRender($xmlWriter);
    }

    /**
     * Method draws xml-content of row file-control
     * @param    int     $i  Row number
     * @param    int     $j  Control number
     * @param    XMLWriter       $xmlWriter  Xml Writer instance
     * @param    ItemsListControl    $control  ItemsListControl object
     * @access   public
     */
    static function DrawFile($i, $j, &$xmlWriter, &$control)
    {
        $array = array(
            "name" => $control->fields[$j]["field_name"],
            "value" => $control->_list[$i][$control->fields[$j]["field_name"]],
            "caption" => $control->fields[$j]["fieldvalue_caption"],
            "directory" => $control->fields[$j]["file_directory"]
        );
        $control->Controls["file"]->InitControl($array);
        $control->Controls["file"]->XmlControlOnRender($xmlWriter);
    }

    static function DrawFile2($i, $j, &$xmlWriter, &$control)
    {
        $array = array(
            "name" => $control->fields[$j]["field_name"],
            "value" => $control->_list[$i][$control->fields[$j]["field_name"]],
            "caption" => $control->fields[$j]["fieldvalue_caption"],
            "directory" => $control->fields[$j]["file_directory"]
        );
        $control->Controls["file"]->InitControl($array);
        $control->Controls["file"]->XmlControlOnRender($xmlWriter);
    }

    static function DrawDBEditBlock($i, $j, &$xmlWriter, &$control)
    {
        $array = array(
            "table" => $control->fields[$j]["field_table"],
            "caption_field" => sprintf($control->fields[$j]["fieldvalue_caption"], $control->Page->Kernel->Language),
            "value_field" => sprintf($control->fields[$j]["fieldvalue_name"], $control->Page->Kernel->Language),
            "get_method" => $control->fields[$j]["get_method"],
            "link_to_value" => $control->_list[$i][$control->fields[$j]["link_to_field"]]
        );
        $control->Controls["dbeditblock"]->InitControl($array);
        $control->Controls["dbeditblock"]->XmlControlOnRender($xmlWriter);
    }

    static function DrawComboBox($i, $j, &$xmlWriter, &$control)
    {

        $array = array(
            "name" => $control->fields[$j]["field_name"] . "[" . $control->_list[$i][$control->key_field] . "]",
            "value" => $control->_list[$i][$control->fields[$j]["field_name"]],
            "options" => $control->fields[$j]["options"],
            "multiple" => $control->fields[$j]["multiple"],
            "selected_value" => $control->_list[$i][$control->fields[$j]["field_name"]]
        );

        $control->Controls["select"]->InitControl($array);
        $control->Controls["select"]->XmlControlOnRender($xmlWriter);
    }

} //--end of class
?>