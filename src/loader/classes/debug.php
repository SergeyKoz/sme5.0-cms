<?php
   /** Debug information class
     * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
     * @version 1.0
     * @package  Loader
     * @subpackage classes
     * @access public
     */
        class Debug {

        /**
        * Debug sections array
        * @var  array   $Sections
        **/
        var $Sections=array();

      /**
        * Debug files storage directory
        * @var  string  $DebugRoot
        **/
       var $DebugRoot;

      /**
        * Debug files storage URL
        * @var  string  $DebugURL
        **/
       var $DebugURL;

       /**
        * Debug restrict sections
        * @var  array  $restrictSections
        **/
        var $restrictSections=array("database");

        /**
            * Page information array
          * @var array  $page_info
          **/
        var $page_info=array();
        /**
        * Class constructor
        * @param  string        $root  debug storage root directory
          * @param  string    $url  debug storage URL
        * @access public
        **/

       function Debug($root,$url, $show_debug)  {
        $this->DebugRoot=$root;
        $this->DebugURL=$url;
        $this->ShowDebug=$show_debug;

       }

      /**
        * Method add debug item to Sections array
        * @param    string  $section    section name
        * @param    mixed       $data           array    of item data or
        * @access public
        **/
      function AddDebugItem($section,$data) {
        if($this->ShowDebug){
            if (is_array($data))    {
               $this->Sections[$section][]=$data;
            }   else    {
                 $this->Sections[$section][sizeof($this->Sections[$section])]["description"]=$data;
            }
        }
      }

      /**
        * Method clears debug section
        * @param    string    $section    section name
        * @access public
        **/
      function ClearDebugSection($section)    {
         unset($this->Sections[$section]);
      }

      /**
        * Method create debug information files and add xml nodes to output XML
        * @param    xmlWriter   $xmlWriter  XmlWriter object
        * @param    string      $page               page name
        * @param    Kernel      &$Kernel        Kernel object
                * access    public
        */
        function Render(&$xmlWriter,&$Kernel)   {
                                //save localization
               $this->saveConfigDebug("localization.".$Kernel->Language,$Kernel->Localization);
               //save errors log
               //global $config_errorMessages;
               $this->saveConfigDebug("errors.".$Kernel->Language,$Kernel->Errors);
               //save module config
                            $this->saveConfigDebug("module.ini",$Kernel->Settings);
                             //save packagee config
              $this->saveConfigDebug("package.ini",$Kernel->Package->Settings);
              //render xml
              $xmlWriter->WriteStartElement("debug");
              $this->RenderContentDebug($xmlWriter,$Kernel);

              //write page node
              if (count($this->page_info))  {
                        $xmlWriter->WriteStartElement("page_info");
                    foreach($this->page_info as $node   =>  $value)
                     $xmlWriter->WriteElementString($node,$value);
                  $xmlWriter->WriteEndElement("page_info");
              }
                     foreach($this->Sections as $_name=>$_section)  {
                     $xmlWriter->WriteStartElement($_name);
                                            $time=0;
                                            for ($i=0;$i<sizeof($_section);$i++)    {
                                                    $time=$time+ $_section[$i]["time"];
                                                    $xmlWriter->WriteStartElement("item");
                                                    foreach ($_section[$i] as $_nodename => $_nodevalue)
                                                        $xmlWriter->WriteElementString($_nodename,$_nodevalue);
                                                    $xmlWriter->WriteEndElement();

                                             }
                      $xmlWriter->WriteElementString("total",$time);
                      $xmlWriter->WriteEndElement();
              }
              $xmlWriter->WriteEndElement();
        }

        /**
            * Method save config files to debug directory
          * @param  string          $name       config name
          * @param  ConfigFile  $config config file
          * @access private
          **/

        function    saveConfigDebug($name,$config)  {
          //create debug root directory
          if (!file_exists($this->DebugRoot))   {
            if (!@mkdir($this->DebugRoot,0777)) {
                                    $this->AddDebugItem("config",array("name" =>$this->DebugRoot,
                                                     "description"=>"Create debug directory",
                                                     "error"    => "<b>Error</b>")
                                        );
            }  else {
                chmod ($this->DebugRoot,0777);
            }
          } else    {
            //create debug file
            $_fname=$this->DebugRoot.$name.".txt";
            $_furlname=$this->DebugURL.$name.".txt";
            $_fdisplayname=$name.".php";
                        $_fp=@fopen($_fname,"w");
            if (!$_fp) {
                    $this->AddDebugItem("config",array("name" =>$_fname,
                                                     "description"=>"Create config file  dump",
                                                     "error"  => "<b>Error</b>")
                );
            }   else    {
               @chmod($_fname,0777);
               //write config
               if (count($config->Sections))    {
                foreach ($config->Sections as $_name => $_section)  {
                    if (!in_array($_name,$this->restrictSections))    {
                    //write section name
                        fwrite($_fp,"\r\n"."[".$_name."]"."\r\n");
                     if (count($_section))  {
                        //write variables
                          foreach($_section  as $_varname => $_varvalue)    {
                            if (!is_array($_varvalue))  {
                              fwrite($_fp,$_varname."=".$_varvalue."\r\n");
                          } else    {
                             for ($i=0;$i<sizeof($_varvalue);$i++)
                                 fwrite($_fp,$_varname."=".$_varvalue[$i]."\r\n");
                          }
                        }
                     }
                  }
                }
               }
               fclose($_fp);
               if (strpos($_fdisplayname,"localization.")===false && strpos($_fdisplayname,"errors.")===false)  {
                $description="Object dump <a href=".$_furlname." target=_blank><b>&gt;&gt;</b></a>";
               }    else    {
                if (strpos($_fdisplayname,"localization.")!==false) {
                    $description.="Page localization <a href=\"#_debug_localization\"><b>&gt;&gt;</b></a><BR>";
                }   else    {
                  $description.="Page messages <a href=\"#_debug_messages\"><b>&gt;&gt;</b></a><BR>";
                }
                $description.="Object dump <a href=".$_furlname." target=_blank><b>&gt;&gt;</b></a>";
               }
               $this->AddDebugItem("config",array("name" =>$_fdisplayname,
                                                  "description"=>$description,
                                                  "error"  => "OK")
               );
            }
          }
          }

        /**
            * Method save content to file
          * @param      string  $filename       Filename
                  * @param      string  $content        content
          * @return     boolean                         operation status
                  **/
        function ToFile($filename,$content) {
            $_fname=$this->DebugRoot.$filename;
            $_fp=@fopen($_fname,"w");
            if (!$_fp) return false;
            @chmod($_fname,0777);
            fwrite($_fp,$content);
            fclose($_fp);
            return true;
        }



      /**
      * Render page content  debug (localization,messages)
      * @param    XmlWriter    $xmlWriter    XmlWriter object
      * @param    Kernel      $Kernel       Kernel object
      **/
         function RenderContentDebug(&$xmlWriter,&$Kernel)  {
        //array with path to localization and errors files
        $this->cfile_path_array=array(
                        "package" => $Kernel->Package->Settings->GetItem("package","ResourcePath"),
                        "project"  => $Kernel->Settings->GetItem("Module","ResourcePath")
                      );
            //render localization debug
         $this->DefineLocalizationDebug($Kernel);
         $xmlWriter->WriteStartElement("_debug_localization");
         $this->RenderDebugContentPart($xmlWriter,$Kernel);
         $xmlWriter->WriteEndElement("_debug_localization");
         //render messages debug
         $this->DefineMessagesDebug($Kernel);
         $xmlWriter->WriteStartElement("_debug_messages");
         $this->RenderDebugContentPart($xmlWriter,$Kernel);
         $xmlWriter->WriteEndElement("_debug_messages");
         }

    /**
        * Method define class variables for localization debug render
      * @access private
      **/
    function DefineLocalizationDebug(&$Kernel)  {
      //localization files array
      $this->files_array=array(
                                $Kernel->Package->PackageName => ConfigFile::GetInstance("package_errors_".$this->cfile_path_array["package"],$this->cfile_path_array["package"]."/localization.".$Kernel->Language.".php"),
                                "project"  => ConfigFile::GetInstance("module_errors_".$this->cfile_path_array["package"],$this->cfile_path_array["project"]."/localization.".$Kernel->Language.".php"),
                                );
      //localization sections array

      if ($Kernel->Localization->HasSection($Kernel->Page->ClassName)) {
        $this->sections_arr[$Kernel->Page->ClassName] =  $Kernel->Localization->GetSection($Kernel->Page->ClassName);
      }
      $this->sections_array["main"] =  $Kernel->Localization->GetSection("main");
         //localization settings array
      if (count($Kernel->Page->libs)) {
        $library_ID=$Kernel->Page->libs;
      } else  {
        $library_ID=$Kernel->Page->library_ID;
      }

      if (sizeof($library_ID))  {
        if (!is_array($library_ID)) $library_ID=array($library_ID);
        for ($i=0;$i<count($library_ID);$i++)  {
          if ($Kernel->Localization->HasSection($library_ID[$i]))
            $this->sections_array[strtoupper($library_ID[$i])]=$Kernel->Localization->GetSection($library_ID[$i]);
        }
      }
    } //--end of function

  /**
    * Method define class variables for messages (errors and warnings) debug render
    * @access  private
    **/
    function DefineMessagesDebug(&$Kernel)  {
      //localization files array
      $this->files_array=array(
                                $Kernel->Package->PackageName => ConfigFile::GetInstance("_debugPackageLocalization",$this->cfile_path_array["package"]."/errors.".$Kernel->Language.".php"),
                                "project"  => ConfigFile::GetInstance("_debugModuleLocalization",$this->cfile_path_array["project"]."/errors.".$Kernel->Language.".php"),
                                );
      //localization sections array
      $errors=$Kernel->GetErrorMessages();
      $warnings=$Kernel->GetWarningMessages();
      if (!is_array($warnings)) $warnings=array();
      if (!is_array($errors)) $errors=array();
      $this->sections_array   = array_merge($errors,$warnings);

    }

    /**
      * Render content part debug (localization or messages)
      * @param    XmlWriter    $xmlWriter    XmlWriter object
      * @param    Kernel      $Kernel       Kernel object
      **/
    function RenderDebugContentPart(&$xmlWriter,&$Kernel)  {
      //render all messages

      foreach ($this->sections_array as $sectionname => $section)   {
        if (sizeof($section) && is_array($section)) {
            foreach ($section as $varname => $varvalue) {
                $vardef_array=$this->GetLocalizationVariable($sectionname,$varname,$varvalue);
                if (sizeof($vardef_array))  {
                 if(strlen(trim($vardef_array["name"]))){
                    $xmlWriter->WriteStartElement($vardef_array["name"]);
                        $xmlWriter->WriteAttributeString("package",$vardef_array["location"]);
                        $xmlWriter->WriteAttributeString("section",$vardef_array["section"]);
                        $xmlWriter->WriteString($vardef_array["value"]);
                                    $xmlWriter->WriteEndElement();
                 }
                }
                }
        }
      }
   }

   /**
     * Method get localization variable definition array
     * @param       string      $section        Section name
     * @param       string    $variable     Variable name
     * @param       string      $value          Variable value
     * @return  array                                   Variable definition array
     * @access  public
     **/
   function GetLocalizationVariable($section,$variable,$value)  {
        reset ($this->files_array);
        foreach ($this->files_array as $location => $localization)  {
            if (is_object($localization))   {
            if ($localization->HasItem($section,$variable)) {
            $def_array=array(
                              "name"        =>  $variable,
                              "section"     =>  $section,
                              "location"    =>  $location,
                              "value"       =>  $value
                            );
                        return $def_array;
            }
        }
        }
        //echo pr($this->sections_array);
     if (in_array($section,array_keys($this->sections_array)))  {
      $def_array=array(       "name"      =>  $variable,
                              "section"   =>  "--UNKNOWN--",
                              "location"  =>  "--UNKNOWN--",
                              "value"     =>  $value
                            );
            return $def_array;
     }  else    {
        return null;
     }
   }

//end of class
}
?>