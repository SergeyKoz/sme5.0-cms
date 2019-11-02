<?php
  $this->ImportClass("system.web.controls.form","formcontrol");

/** Select control
     * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
     * @version 1.0
     * @package Framework
     * @subpackage classes.system.web.controls
     * @access public
     */
    class DbEditBlockControl2 extends FormControl {
        var $ClassName = "DbEditBlockControl2";
        var $Version = "1.0";


        function InitControl($params=array())
        {
            $this->data["options"] = array();
            $price_data = array();
            $category_id = $this->Page->Request->ToNumber('products_parent_id', -1);
            $ex_categories = DataDispatcher::Get('export_categories');
            $disabled_products = DataDispatcher::Get('export_disabled_products');
            if (isset($ex_categories[$category_id]))
            {
                $price_data = array();
                foreach ($ex_categories[$category_id] as $item)
                {
                    $price_data[$item['exsite_id']] = $item;
                }
            }
            // Edit mode, read price data from DB
            $main_storage = DataFactory::GetStorage($this, $params["table"], $params["table"]);
            $list = $main_storage->$params["get_method"]($params);
            while($r = $list->Read())
            {
                if (isset($price_data[$r['exsite_id']]))
                {
                    if ($r['active']!= '0')
                    $price_data[$r['exsite_id']]['product_price'] = $r['product_price'];
                    $price_data[$r['exsite_id']]['active'] = $r['active'];
                } else {
                    $price_data[] = $r;
                }
            }

            $validate_ok = true;
            foreach($price_data as $r)
            {
                if (($this->Page->Event == 'DoEditItem') || ($this->Page->Event == 'DoAddItem'))
                {
                    $value = $_POST['_sprice'][$params["link_to_value"]][$r["exsite_id"]];
                } else {
                    $value = $r[$params["value_field"]];
                }

                if ($this->Page->Event == 'DoEditItem')
                {
                    $error = $_SESSION['_SPRICE_VALIDATE'][$params["link_to_value"]][$r["exsite_id"]];
                }
                if ($this->Page->Event == 'DoAddItem')
                {
                    $value = str_replace(' ', '', $value);
                    $value = str_replace(',', '.', $value);
                    if (preg_match('/^-?\d+(\.?\d+)?$/', $value))
                    {
                        $error = 0;
                    } else {
                        $error = 1;
                        $validate_ok = false;
                    }
                }
                if (!$disabled_products[$params['link_to_value']][$r['exsite_id']] &&
                    ($r['active']!= '0'))
                {
                    $this->data["options"][] = array(
                        'value' => $value,
                        'caption' => $r[$params["caption_field"]],
                        'exsite_id' => $r["exsite_id"],
                        'product_id' => $params["link_to_value"],
                        'error' => $error
                    );
                }
                unset($_SESSION['_SPRICE_VALIDATE'][$params["link_to_value"]][$r["exsite_id"]]);
            }
        }
   /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
        function XmlControlOnRender(&$xmlWriter) {
               $xmlWriter->WriteStartElement("dbeditblock2");
               //--render events handlers
               if (isset($this->data["event"]))   {
                   SelectControl::XmlRenderEvent($xmlWriter,$this->data["event"]);
               }
               $this->XmlGetErrorFields($xmlWriter);
               $xmlWriter->WriteStartElement("name");
                      $xmlWriter->WriteString($this->data["name"]);
               $xmlWriter->WriteEndElement(); //name

               if(strlen($this->data["size"])){
               $xmlWriter->WriteStartElement("size");
                      $xmlWriter->WriteString($this->data["size"]);
               $xmlWriter->WriteEndElement(); //size
               }

               if(strlen($this->data["disabled"])){
               $xmlWriter->WriteStartElement("disabled");
                      $xmlWriter->WriteString($this->data["disabled"]);
               $xmlWriter->WriteEndElement(); //disabled
               }

               $xmlWriter->WriteStartElement("options");
               // Making selected a strings
               for($i=0; $i<sizeof($this->data["options"]); $i++)
                    {
                       $xmlWriter->WriteStartElement("option");
                           $xmlWriter->WriteStartElement("caption");
                                  $xmlWriter->WriteString($this->data["options"][$i]["caption"]);
                           $xmlWriter->WriteEndElement();//caption
                           $xmlWriter->WriteStartElement("value");
                                  $xmlWriter->WriteString($this->data["options"][$i]["value"]);
                           $xmlWriter->WriteEndElement();//caption
                           $xmlWriter->WriteStartElement("site_id");
                                  $xmlWriter->WriteString($this->data["options"][$i]["exsite_id"]);
                           $xmlWriter->WriteEndElement();//caption
                           $xmlWriter->WriteStartElement("product_id");
                                  $xmlWriter->WriteString($this->data["options"][$i]["product_id"]);
                           $xmlWriter->WriteEndElement();//caption
                           $xmlWriter->WriteStartElement("error");
                                  $xmlWriter->WriteString($this->data["options"][$i]["error"]);
                           if ($this->data["options"][$i]["error"])
                           {
                              $this->AddErrorMessage('PRODUCTSLIST', 'InvalidPrice');
                           }
                           $xmlWriter->WriteEndElement();//caption
                       $xmlWriter->WriteEndElement(); //option
                    }
               $xmlWriter->WriteEndElement(); //options
               //write language version
               $this->WriteLanguageVersion($xmlWriter);
        $xmlWriter->WriteEndElement();// select
   }
    /**
      * Method create control options array with range
      * @param  string $mask    range mask
      * @access public
      **/
    function createOptionsData($mask)    {
        //
        $range_arr = explode("..",$mask);
        for ($i = $range_arr[0]; $i<=$range_arr[1];$i++)
            $this->data["options"][] = array ("value" =>(string) $i, "caption" => $i) ;
    }
}// class
?>