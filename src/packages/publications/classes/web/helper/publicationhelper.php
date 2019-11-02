<?php
    /**
     * Publication package pages helper class
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Publications
     * @subpackage classes.helper
     * @static
     * @access public
     **/

     class PublicationHelper   {

         /**
         * Method checks if content has a paging delimiters
         * @param   string      $content        Content string
         * @return bool     whether or not given content string contains a paging delimiters
         * @access private
         **/
         static function HasPaging($content){
            if(substr($content, 0, 11) == "&lt;!--PAGE"){
                return true;
            } else {
                return false;
            }
         }

         /**
         * Method returns selected chunk of paged content string
         * @param   string      $content        Content string
         * @return string     chunk of content string
         * @access private
         **/
         static function GetSelectedPage($content, $field, $object){
            $fid = $this->Page->Request->Value("fid", REQUEST_ALL, false);
            $page = (int)$fid[$field["publication_id"].":".$field["tp_id"]];
            $i = 0;
            while(false !== $pos = strpos($content, "&lt;!--PAGE")){

                $content = substr($content, 1);

                $end_pos = strpos($content, "&lt;!--PAGE");
                if($end_pos === false){
                    $end_pos = strlen($content);
                }

                if($page == $i){
                    $end_tag = strpos($content, "--&gt;") + 6;
                    if($end_tag === false){
                        $end_tag = 0;
                    }
                    $chunk = substr($content, $end_tag, $end_pos-$end_tag);
                    return $chunk;
                }
                $content = substr($content, $end_pos);
                $i++;
            }

            return $content;
         }

         /**
         * Method sets paging for current field
         * @access private
         **/
         static function AddArticlePaging(&$object, $field){
            $fid = $this->Page->Request->Value("fid", REQUEST_ALL, false);
            $page = (int)$fid[$field["publication_id"].":".$field["tp_id"]];
            $object->FieldPaging[$field["publication_id"].":".$field["tp_id"]] = $page;
            return;
         }


         /**
        * Method prepares and formats values of field depending on field type
        * @param    string  $type   Field type
        * @param    string  $value  Field value
        * @return   string  Formatted value
        * @access   public
        **/
        static function PrepareFieldValue($type, $value, $flag=null, &$object, $field){
           switch ($type) {
               case "date":
                   $value = Component::dateconv($value, (bool)$flag);

               break;
               case "spaweditor":
                   if(PublicationHelper::HasPaging($value)){
                        $value = PublicationHelper::GetSelectedPage($value, $field, $object);
                        PublicationHelper::AddArticlePaging($object, $field);
                   }
               break;
               default:
               break;
           }
           return $value;
        }
        /**
        * Method draws publication field content
        *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
        *  @param   array   $field   field data
        *  @param   string   $language   Current language
        *  @param   PublicationtControl   $object   Referense to parent control
        *  @access  public
        **/
        static function DrawPublicationField(&$xmlWriter, &$field, $language,&$object){
                    // drawing field tag
            $xmlWriter->WriteStartElement("field");
                    // drawing attributes
                    $xmlWriter->WriteAttributeString("param_id", (int)$field["param_id"]);
                    $xmlWriter->WriteAttributeString("tp_id", (int)$field["tp_id"]);
                    $xmlWriter->WriteAttributeString("system_name", $field["system_name"]);
                    $xmlWriter->WriteAttributeString("param_name", $field["param_name"]);
                    $xmlWriter->WriteAttributeString("is_caption", (int)$field["is_caption"]);
                    $xmlWriter->WriteAttributeString("is_link", (int)$field["is_link"]);
                    $xmlWriter->WriteAttributeString("cut_to_length", (int)$field["cut_to_length"]);

               $xmlWriter->WriteElementString("caption", $field["caption_".$language]);
               $old_value =  $field["cur_value"];
               $value = PublicationHelper::PrepareFieldValue($field["system_name"], $field["cur_value"], $field["cut_to_length"], $object, $field);
               $xmlWriter->WriteElementString("value", $object->Page->Kernel->prepareContent($value));

                if ($field["system_name"]=="file"){
               		$fileStorage=$object->Page->Kernel->Settings->GetItem("SETTINGS", "FileStoragePath");
               		$xmlWriter->WriteElementString("size", GetFileSize($fileStorage.$value));
           		}

               if(isset($object->FieldPaging[$field["publication_id"].":".$field["tp_id"]])){
                    PublicationHelper::WriteFieldPaging($xmlWriter, $object, $field);
               }

            $xmlWriter->WriteEndElement("field");

        }

    static function WriteFieldPaging(&$xmlWriter, &$object, &$field){
        if(preg_match_all("/&lt;!--\s{0,}PAGE (TITLE=\"(.*?)\")\s{0,}--&gt;/", $field["cur_value"], $m)){
            $pages = $m[2];
            if(is_array($pages)){
                $xmlWriter->WriteStartElement("field_paging");
                foreach($pages as $page => $title){
                    $xmlWriter->WriteStartElement("page");
                        if($object->FieldPaging[$field["publication_id"].":".$field["tp_id"]] == $page){
                            $xmlWriter->WriteAttributeString("selected", 1);
                        }
                        $xmlWriter->WriteElementString("number", $page);
                        $xmlWriter->WriteElementString("title", $title);
                    $xmlWriter->WriteEndElement("page");
                }
                $xmlWriter->WriteEndElement("field_paging");
            }

        }
    }

    /**
    * Method extracts template if assigned for specified mapping
    * @param    array     $_mapping     Mapping data
    * @access   public
    **/
    static function ExtractPublicationTemplate(&$page, &$_mapping){
        // getting relative path to publications templates
        $_path = $page->Kernel->Settings->GetItem("COMMON","PublicationsTemplatesPath");

        if($_mapping["xsl_template"] != '')
            $page->IncludeTemplate($_path.$_mapping["xsl_template"]);
    }

      /**
        *  Method processes publication content
        *  @param   PublicationtControl   $object   Referense to parent control
        *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
        *  @param   array   $mapping   mapping array data
        *  @param   array   $publication   Publication array data

        *  @access  public
        */
        static function ProcessPublicationContent(&$object, &$xmlWriter, &$mapping, &$tags, &$publication){
            // Drawing publication xml-data
            $PublicationRecord = $object->publicationsStorage->Get (array("publication_id" => $mapping["publication_id"]));
            $xmlWriter->WriteStartElement("publication");
                        $xmlWriter->WriteAttributeString("publication_id", $mapping["publication_id"]);
                        $xmlWriter->WriteAttributeString("system", $PublicationRecord['system']);
                        $xmlWriter->WriteAttributeString("created_by", $mapping['owner_id']);
                        $xmlWriter->WriteAttributeString("publication_type", 0);
                        $xmlWriter->WriteAttributeString("is_category", $mapping["is_category"]);
                        $xmlWriter->WriteAttributeString("mapping_enable_comments", $mapping["enable_comments"]);
                        $xmlWriter->WriteAttributeString("publication_disable_comments", $mapping["disable_comments"]);
                        $xmlWriter->WriteAttributeString("template_id", $mapping["template_id"]);
                        if ($mapping["is_priveledged"]==1){
							$xmlWriter->WriteAttributeString("is_priveledged", 1);
						}
            $sizeof = sizeof($publication);
            for($i=0; $i<$sizeof; $i++){
                $_tmp = &$publication[$i];
                // if is caption add to titles
                if(($mapping["show_empty_fields"] == 1) || (strlen($_tmp["cur_value"]) > 0 )){
                    // Drawing publication field
                    PublicationHelper::DrawPublicationField($xmlWriter, $_tmp, $object->Page->Kernel->Language,$object);
                }

            }
            if ($object->UseTags)
            	PublicationHelper::DrawPublicationTags($xmlWriter, $tags[$mapping["publication_id"]], $object);
            $xmlWriter->WriteEndElement("publication");
        }
      /**
        *  Method gets single publication content
        *  @param   PublicationtControl   $object   Referense to parent control
        *  @param   array   $mapping   mapping array data
        *  @return  array   Array with publication data
        *  @access  public
        */
        static function GetSinglePublicationContent(&$object,  &$mapping){
            DataFactory::GetStorage($object, "PublicationParamsTable", "pStorage",true,"publications");
            // Getting parameters for selected publication
            $_reader = $object->pStorage->GetPublicationParameters($mapping["template_id"],
                                                                   $mapping["publication_id"],
                                                                   $object->Page->Kernel->Language,
                                                                   false,
                                                                   1);
            $_tmp = array();
            for($i=0; $i<$_reader->RecordCount; $i++)
                $_tmp[] = $_reader->Read();

            if ($object->UseTags)
            	$object->tags[$mapping ["mapping_id"]]=PublicationHelper::GetPublicationTags($object, array($mapping["publication_id"]));

            return $_tmp;
        }

      /**
        *  Method processes publication content
        *  @param   PublicationtControl   $object   Referense to parent control
        *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
        *  @param   array   $publications_id   Publications ID data
        *  @param   array   $publications   Publications data
        *  @param   array   $_params   Parameters of publications
        *  @param   array   $mapping   mapping array data
        *  @param   int   $in_list   Select only fields that has SHOW IN LIST flag set if 1, or all otherwise
        *  @access  public
        */
        static function DrawPublicationShortList(&$object, &$xmlWriter, &$publications_id, &$publications, &$_params, &$_tags, &$mapping, $in_list=1){

            $sizeof = sizeof($publications);
            // For each publication got
            for($i=0; $i<$sizeof; $i++){
                // Drawing publication header
            	$xmlWriter->WriteStartElement("publication");
                     $xmlWriter->WriteAttributeString("publication_id", $publications[$i]["publication_id"]);
                     $xmlWriter->WriteAttributeString("system", $publications[$i]["system"]);
                     $xmlWriter->WriteAttributeString("publication_type", 1);
                     $xmlWriter->WriteAttributeString("is_category", $publications[$i]["is_category"]);
                     $xmlWriter->WriteAttributeString("template_id", $publications[$i]["template_id"]);
                     if ($publications[$i]["is_priveledged"]==1){
                     	 $xmlWriter->WriteAttributeString("is_priveledged", 1);
                     }
                     if( !is_null($publications[$i]["path"]))
                         $xmlWriter->WriteAttributeString("target_entry_point_url", $publications[$i]["path"].($publications[$i]["path"]!="" ? "/" : "" ));

                     $p_sizeof = sizeof($_params[$publications[$i]["publication_id"]]);
                     for($j=0; $j<$p_sizeof; $j++){
                          if(($publications[$i]["show_empty_fields"]==1) || (strlen($_params[$publications[$i]["publication_id"]][$j]["cur_value"]) > 0))   {
                            //Drawing publication field
                             PublicationHelper::DrawPublicationField($xmlWriter, $_params[$publications[$i]["publication_id"]][$j], $object->Page->Kernel->Language,$object);
                          }
                     }
                     if ($object->UseTags)
                     	PublicationHelper::DrawPublicationTags($xmlWriter, $_tags[$publications[$i]["publication_id"]], $object);

            	$xmlWriter->WriteEndElement("publication");

            }

        }

      /**
        *  Method gets publications content
        *  @param   PublicationtControl   $object   Referense to parent control
        *  @param   array   $publications_id   Publications ID data
        *  @param   array   $publications   Publications data
        *  @param   int   $in_list   Select only fields that has SHOW IN LIST flag set if 1, or all otherwise
        *  @param   array   $mapping   mapping array data
        *  @access  public
        */
        static function GetPublicationShortListData(&$object, &$publications_id, &$publications, &$mapping, $in_list=1){
            // If no publication defined - filling with 0 first element
            if(empty($publications_id)){
               $publications_id = array(0);
            }
            DataFactory::GetStorage($object, "PublicationParamsTable", "pStorage",true,"publications");
            // Getting publications' fileds list
            $_reader = $object->pStorage->GetPublicationListParameters(
                                                                   $publications_id,
                                                                   $object->Page->Kernel->Language,
                                                                   true,
                                                                   $in_list
                                                                   );
            // Aggregating publications fields in arrays by publication ID
            $_params = array();
            for($i=0; $i<$_reader->RecordCount; $i++){
                $_tmp = $_reader->Read();
                $_params[$_tmp["publication_id"]][] = $_tmp;
            }

       		return $_params;
        }

        static function GetPublicationTags(&$object, $publications_id){
        	return $tags=$object->tagsStorage->GetPublicationsTags($publications_id, "publication");
        }

        static function GetMappingsTags(&$object, &$mappings){
        	$mapping_id=array();
            foreach ($mappings as $mapping)
            	$mapping_id[]=$mapping["mapping_id"];
            $tags=$object->tagsStorage->GetPublicationsTags($mapping_id, "mapping");

            for ($i=0; $i<count($mappings); $i++)
            	$mappings[$i]["tags"]=$tags[$mappings[$i]["mapping_id"]];
        }

        static function DrawPublicationTags(&$xmlWriter, &$tags, &$object){
            // drawing field tag
            $xmlWriter->WriteStartElement("tags");
            if (is_array($tags)){
	            foreach($tags AS $tag){
	            	 $xmlWriter->WriteStartElement("tag");
	            	 	$xmlWriter->WriteAttributeString("encode", urlencode($tag));
	            	 	$xmlWriter->WriteString($tag);
	            	 $xmlWriter->WriteEndElement("tag");
	            }
            }
            $xmlWriter->WriteEndElement("tags");

        }


     } //  end of class
?>