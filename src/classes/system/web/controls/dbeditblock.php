<?php
  $this->ImportClass("system.web.controls.form","formcontrol");

/** Select control
     * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
     * @version 1.0
     * @package Framework
     * @subpackage classes.system.web.controls
     * @access public
     */
    class DbEditBlockControl extends FormControl {
        var $ClassName = "DbEditBlockControl";
        var $Version = "1.0";


        function InitControl($params=array())
        {
            $category_id = $this->Page->Request->ToNumber('products_parent_id', -1);
            $ex_categories = DataDispatcher::Get('export_categories');
            $disabled_products = DataDispatcher::Get('export_disabled_products');
            $productsStorage = DataFactory::GetStorage($this, "ProductsTable");
            $category_id = $this->Page->Request->ToNumber('catalog_parent_id', -1);
            $main_storage = DataFactory::GetStorage($this, $params["table"], $params["table"]);
            $this->data["options"] = array();
            $list = $main_storage->$params["get_method"]($params);
            $price_data = array();
            while($r = $list->Read())
            {
                $price_data[$r["exsite_id"]] = $r;
            }
            if (isset($ex_categories[$category_id]))
            {
                foreach($ex_categories[$category_id] as $site_item)
                {
                    $r = $price_data[$site_item['exsite_id']];
                    if (!$disabled_products[$params['link_to_value']][$site_item['exsite_id']] &&
                    ($r['active']!= '0'))
                    {
                        $this->data["options"][$site_item['exsite_id']] = array(
                            'value' => $r[$params["value_field"]],
                            'caption' => $site_item[$params["caption_field"]],
                            'exsite_id' => $site_item['exsite_id'],
                            'error' => $_SESSION['_SPRICE_VALIDATE'][$params["link_to_value"]][$site_item['exsite_id']]
                        );
//                        prn($_SESSION['_SPRICE_VALIDATE'][$params["link_to_value"]]);
                    }
                }
            }
        }
   /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
        function XmlControlOnRender(&$xmlWriter) {
               $xmlWriter->WriteStartElement("dbeditblock");
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
               if ($this->data["options"])
               {
                   foreach($this->data["options"] as $item)
                   {
                       $xmlWriter->WriteStartElement("option");
                           $xmlWriter->WriteStartElement("caption");
                                  $xmlWriter->WriteString($item["caption"]);
                           $xmlWriter->WriteEndElement();//caption
                           $xmlWriter->WriteStartElement("value");
                                  $xmlWriter->WriteString($item["value"]);
                           $xmlWriter->WriteEndElement();//caption
                           $xmlWriter->WriteStartElement("site_id");
                                  $xmlWriter->WriteString($item["exsite_id"]);
                           $xmlWriter->WriteEndElement();//caption
                           $xmlWriter->WriteStartElement("error");
                                  $xmlWriter->WriteString($item["error"]);
                           if ($this->$item["error"])
                           {
                              $this->AddErrorMessage('PRODUCTSLIST', 'InvalidPrice');
                           }
                           $xmlWriter->WriteEndElement();//caption
                       $xmlWriter->WriteEndElement(); //option
                    }
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