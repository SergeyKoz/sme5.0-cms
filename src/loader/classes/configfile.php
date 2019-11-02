<?php

    /**
     * Base Config class.
     * @author Sergey Grishko <sgrishko@reaktivate.com>
     * @modified Konstantin Matsebora <kmatsebora@activemedia.com.ua>
     * @modified Alexandr Degtiar <adegtiar@activemedia.com.ua>
     * @version 2.0
     * @package Loader
     * @subpackage classes
     * @access public
     */
class ConfigFile extends Component {
  /**
    *  Class name
    * @var  string  $ClassName
    **/
    var $ClassName = "ConfigFile";
  /**
    *  Class version
    * @var  string  $Version
    **/
    var $Version = "1.0";

  /**
    *  Insstance name
    * @var  string   $InstanceName
    **/
    var $InstanceName = "";

    /**
        * Configuration filename
      * @var    string  $FileName
      **/
    var $FileName;

    /**
      * Configuration sections array
      * @var    array       $Sections
      **/
    var $Sections = array();

  /**
    * Constructor
    * @param       string   $filename   file name with config directives
    * @param       string   $CacheRoot  cache directory
    * @access      public
    **/
        function ConfigFile($fileName = "",$CacheRoot) {

            if (!file_exists($fileName))    {
                    echo "Can't find a config file $fileName";
                die();
                //return;
             }
            $this->FileName = $fileName;
            $this->parse();
    }

    /**
     * Merge configs
     *
     * @param object $ConfigToMerge
     * @param string $mode Merge mode
     *                   w     -   rewrite section
     *                   a+    -   append and overwrite items
     *                   a     -   only append items
     */
    function mergeConfig(&$ConfigToMerge, $mode = 'a+')
    {
        foreach ($ConfigToMerge->Sections as $section_name => $section_data)
        {
            $this->mergeSection($section_data, $section_name, $mode);
        }
    }

   /**
    * Method parses config file
    * @param       string   $filename Config filename
    * @param       bool     $appendAppend flag
    * @access      private
    **/
    function Parse($fileName = "", $append = false) {

            if ($fileName == "")
                $fileName = $this->FileName;
            $currentSection = "";
            if (!$append)
                $this->Sections = array();

            $content = file($fileName);

            while (list($key, $value) = each($content)) {
                // Remove MS-DOS Carriage return from end of line
                $value = preg_replace("~\r*$~", "", $value);
                // Remove comments from line
                if (preg_match("/([^##]*)##.*/", $value, $parts))
                    $value = $parts[1];
                if (preg_match("~^\[([[:alnum:]_\.]+)\]~", $value, $parts))
                        $currentSection = strtolower(trim($parts[1]));
                else {
                    $data = preg_split("/=/", $value, 2);
                    //trim all values
                    for ($i=0;$i<sizeof($data);$i++)    $data[$i]=trim($data[$i]);
                    if (strlen($data[0])&& isset($data[1])) {
                        //parse value string
                        $this->_current_section = $currentSection;
                        $data[1] = preg_replace_callback("/{.*?}/ms",array($this,"getValueString"),$data[1]);
                      //if value not found in section
                      if (isset($this->Sections[$currentSection][$data[0]])==0)     {
                         $this->Sections[$currentSection][$data[0]] = trim($data[1]);
                      } else    {
                          //if values already exist
                        if (!is_array($this->Sections[$currentSection][$data[0]]))  {
                                //if array not exists
                            $_tmp=$this->Sections[$currentSection][$data[0]];
                            $this->Sections[$currentSection][$data[0]]=array();
                                                        $this->Sections[$currentSection][$data[0]][]=$_tmp;
                            $this->Sections[$currentSection][$data[0]][]=$data[1];
                        }   else    {
                                //if array already exists
                            $this->Sections[$currentSection][$data[0]][]=$data[1];
                        }
                      }
                    }
                }
            }
        }

   /**
     * Callback method for search and replace {variable} in variable definition
     * @param   array   $matches    regular expresion matches
     * @return  string              founded value or {variable}
     * @access private
     **/


	function getValueString($matches){
		$str =substr($matches[0], 1, -1);
		$section = $this->_current_section;
		if(defined($str)){
			return constant($str);
		}
		if(is_string($section)){
			if (@isset($this->Sections[$section][$str]) && !is_array($this->Sections[$section][$str])
				&& "{" . @$this->_current_varname . "}" != $matches[0]) {
				return $this->Sections[$section][$str];
			}   else    {
				foreach($this->Sections as $sname => $section){
					if (isset($section[$str]) && !is_array($section[$str])) {
						return $section[$str];
					}
				}
			}
			return $matches[0];
		}
	}

  /**
    * Method reparse  config values
    * @access      public
    **/
  function reParse()    {
       if (sizeof($this->Sections)!=0)  {}
       foreach ($this->Sections as $sname=>$section)    {
          if (sizeof($section)!=0) {
            foreach ($section as $varname=>$varvalue) {
                if (!is_array($varvalue))   {
                    $this->_current_section = $sname;
                    $this->_current_varname = $varname;
                    $varvalue = preg_replace_callback("/{.*?}/ms",array($this,"getValueString"),$varvalue);
                }   else      {
                    $_count = sizeof($varvalue);
                    for ($i=0;$i<$_count;$i++)  {
                      $this->_current_section = $sname;
                      $this->_current_varname = $varname;
                      $varvalue[$i] = preg_replace_callback("/{.*?}/ms",array($this,"getValueString"),$varvalue[$i]);
                    }
                }
                $this->Sections[$sname][$varname]=$varvalue;
            }
          }
       }
  }


   /**
    * Method returns the number of sections
    * @return      int   Number of sections
    * @access      public
    **/
        function GetCount() {
            return count($this->Sections);
        }

   /**
    * Method returns an array with the names of all the sections.
    * @return      array  Array with the names of all the sections
    * @access      public
    **/
        function GetKeys() {
            return array_keys($this->Sections);
        }

   /**
    * Method returns an associative array of the items in one section.
    * @param       string  $section Section name
    * @return      mixed  An associative array of the items in one section or false, if section does not exist
    * @access      public
    **/
        function &GetSection($section) {
            if (!$this->HasSection($section)) {
                $message = $this->AddErrorMessage($this->ClassName, "SECTION_NOT_EXIST", array($section,$this->InstanceName),false,true);
                user_error($message, E_USER_WARNING);
                return false;
            }
            foreach($this->Sections[strtolower($section)] as $_itemName =>$_itemVal)  {
                if (strpos($_itemName,"/")===false)
                  $result[htmlspecialchars($_itemName)]=$_itemVal;
            }
            return $result;
        }


        function mergeSectionWithMode_w($section,$name)   {
            $this->Sections[$name] = array();
            $this->mergeSectionWithMode_a_plus($section,$name);
        }

        function mergeSectionWithMode_a($section,$name) {
            foreach ($section as $key => $value)    {
               if (!$this->HasItem($name,$key))  {  //-- if value in config not exists
                 $this->Sections[$name][$key] = $value;
               }      else    {
                 if (is_array($value)) {    // if value is array
                    if (!is_array($this->Sections[$name][$key]))     // if current value not array
                        $this->Sections[$name][$key] = array($this->Sections[$name][$key]);
                     foreach($value as $i => $itemvalue)
                        $this->Sections[$name][$key][]=$itemvalue;
                 }
                 else { //if value not array
                   if (!is_array($this->Sections[$name][$key]))  // if current value not array
                    $this->Sections[$name][$key] = array($this->Sections[$name][$key]);
                    $this->Sections[$name][$key][] = $value;
               }
             }
            }
        }

        function mergeSectionWithMode_a_plus($section,$name)    {
            foreach ($section as $key => $value)    {
            //-- if value not array
               if (!is_array($value))   {
                   $this->Sections[$name][$key] = $value;
                }    else {
                    $this->Sections[$name][$key] = array();
                     foreach($value as $i => $itemvalue)
                      $this->Sections[$name][$key][]=$itemvalue;
                }
            }
        }

   /**
    * Method write or merge section to the configuration file.
    * @param       array         $section   Section data
    * @param       string        $name      Section name
    * @param       string        $mode      Merge mode
    *                                               w     -   rewrite section
    *                                               a+    -   append and overwrite items
    *                                               a     -   only append items
    * @return            boolean                        Merge status
    * @access      public
    **/
    function mergeSection($section,$name,$mode = "w")   {
      ConfigFileHelper::mergeSection($this,$section,$name,$mode);
    }


   /**
    * Method add section to the configuration file.
    * @param       string    $section Section name
    * @access      public
    **/
    function AddSection($section) {
            if ($this->HasSection($section)) {
                $message = $this->AddErrorMessage($this->ClassName, "SECTION_ALREADY_EXISTS", array($section,$this->InstanceName),false,true);
                user_error($message, E_USER_WARNING);
                return;
            }
            $this->Sections[strtolower($section)] = array();
    }


   /**
    * Method Empties section
    * @param       string  $section Section name
    * @access      public
    **/
        function EmptySection($section) {
            $section = strtolower($section);
            unset($this->Sections[$section]);
            $this->reInitInstance();
            //$this->Sections[$section] = array();
        }

   /**
    * Method Returns true if the section exists.
    * @param       string  $section Section name
    * @return      bool    True if section exists, False otherwise
    * @access      public
    **/
        function HasSection($section) {
        return isset($this->Sections[strtolower($section)]);
        }

   /**
    * Method Returns true if the section and item exists.
    * @param       string  $section Section name
    * @param       string  $item Item name
    * @param       string  $value Item value
    * @return      bool    True if both section and item exists, False otherwise
    * @access      public
    **/
        function HasItem($section, $item, $value=null) {
          $section = strtolower($section);
          if($value === null){
              return (isset($this->Sections[$section]) && isset($this->Sections[$section][$item]));
          } else {
              $check_item = $this->Sections[$section][$item];
              if(!is_array($check_item)){
                 return $check_item == $value;
              } else {
                 return in_array($value, $check_item);
              }
          }

        }

   /**
    * Method Reads an item from a section.
    * @param       string  $section Section name
    * @param       string  $item Item name
    * @param       bool    $isArray Boolean flag indicating if item is of an array-type
    * @param       bool    $wantArray Boolean flag indicating if item is of an array-type must be returned
    * @return      mixed   Value of an item (array or scalar)
    * @access      public
    **/
    function GetItem($section, $item, $isArray = false, $wantArray = false) {
            if (!$this->HasItem($section, $item)) {
                    $message = $this->AddErrorMessage($this->ClassName, "NO_ITEM_FOUND", array($item, $section, $this->InstanceName),false,true);
            user_error($message, E_USER_WARNING);
            return false;
            }
            $value = $this->Sections[strtolower($section)][$item];
            if ($isArray) {
                if ($value != "")
                    $value = &explode(";", $value);
                else
                    $value = array();
            }
            if($wantArray){
                if(!is_array($value)){
                    $value = array($value);
                }
            }
            return $value;
        }

   /**
    * Method Sets an item in a section.
    * @param       string  $section         Section name
    * @param       string  $item                Item name
    * @param       mixed   $value           Value to be set
    * @param             boolean $deleteflag    Is delete old value flag

    * @access      public
    **/
        function SetItem($section, $item, $value,$deleteflag=true) {
            if ($deleteflag) $this->Sections[strtolower($section)][$item]=null;
            $this->_current_section = strtolower($section);
            if(isset($this->Sections[strtolower($section)][$item])){
                if(!is_array($this->Sections[strtolower($section)][$item])){
                    $this->Sections[strtolower($section)][$item] = array($this->Sections[strtolower($section)][$item]);
                }
                $this->Sections[strtolower($section)][$item][] = preg_replace_callback("/{.*?}/ms",array($this,"getValueString"),$value);
            } else {
                $this->Sections[strtolower($section)][$item] = preg_replace_callback("/{.*?}/ms",array($this,"getValueString"),$value);
            }
            $this->reInitInstance();
        }

   /**
    * Method Gets instance of config file
    * @param       string  $varName     Name of the variable
    * @param       string  $fileName    Item name
    * @return      (object structure) Config Class instance
    * @access      public
    **/
    static function &GetInstance($varName, $fileName = "") {
		$configVarName="config_" . $varName;

		//try to get config object from GLOBALS
		$configFile = &$GLOBALS[$configVarName];
		if (is_object($configFile) && get_class($configFile) == "ConfigFile")
			return $configFile;

		//try to get config object from cache
		$configFile = ConfigFile::GetCacheInstance($configVarName);

		if ($configFile != null) return $configFile;

		//try to get config object from file		
        $configInstance=ConfigFile::newInstance($fileName,$configVarName);
        return $configInstance; 
    }

    /**
      * Method create new configfile object instance (using file)
      * @param     string      $fileName        path to file (full)
      * @param     string      $configVarName   configuration variable name
      * @return    mixed                        false - if file not found, ConfigFile object if file found and instance created
      **/
    static function newInstance($fileName,$configVarName)    {

        $Loader = &$GLOBALS["Loader"];
        if (file_exists($fileName)) {
                $configFile = new ConfigFile($fileName,"");

                $GLOBALS[$configVarName]=&$configFile;
                $configFile->InstanceName = $configVarName;
                 if ($Loader->state >= LOADER_STATE_PAGE_LOADED) {
                    if  ($Loader->Page->Kernel->UseCache)
                        ConfigFile::writeCacheInstance($configVarName,$configFile);
                 }
                return $configFile;

            }   else    {
                    return false;
            }
    }

    /**
      * Method get instance of configfile from disk cache
      * @param     string  $configName     Config variable name ("config_"+ first parameter of GetInstance method)
      * return     mixed                   null if cache file not found, otherwise ConfigFile object
      * @access    private
      **/
    static function GetCacheInstance($configName)   {
       $Loader = &$GLOBALS["Loader"];
       if ($Loader->state >= LOADER_STATE_PAGE_LOADED) {

         if  ($Loader->Page->Kernel->UseCache)     {

           $cacheFile = $Loader->Page->Kernel->Package->CacheRoot.strtolower($configName).".ini.obj";

           if (file_exists($cacheFile))  {
               $fp = @fopen($cacheFile,"r");
               if ($fp)    {
                   $obj = unserialize(fread($fp,filesize($cacheFile)));
                   fclose($fp);
                   return $obj;
              }    else    {
                   return null;
              }
           }
         }
       }
       return null;
     }

    /**
      * Method write cache of configfile object to disk
      * @param     string      $configName     Config variable name ("config_"+ first parameter of GetInstance method)
      * return     ConfigFile                   null if cache file not found, otherwise ConfigFile object
      * @access    private
      **/
    static function writeCacheInstance($configName,&$instance)   {

     //check if cache directory not exists
     $Loader = &$GLOBALS["Loader"];

     if ($Loader->state >= LOADER_STATE_PAGE_LOADED) {

      if  ($Loader->Page->Kernel->UseCache)     {

       if (!file_exists($Loader->Page->Kernel->Package->CacheRoot))    {
           mkdir($Loader->Page->Kernel->Package->CacheRoot,0775);
       }
       if (is_dir($Loader->Page->Kernel->Package->CacheRoot))  {
           $fname = $Loader->Page->Kernel->Package->CacheRoot.strtolower($configName).".ini.obj";
           $fp = @fopen($fname,"w");
           if ($fp)    {
               fwrite($fp,serialize($instance));
               fclose($fp);
               chmod ($fname,0777);
           }
       }
      }
     }
    }

    /**
    * Methods re-inits global instance of an object
    * @access   private
    **/
    function reInitInstance(){
        $GLOBALS[$this->InstanceName] = &$this;
    }

  /**
    * Method Gets instance of config file
    * @param       string  $varName     Name of the variable
    * @param       string  $fileName    Item name
    * @return      (object structure) Config Class instance
    * @access      public
    **/
       static function &SetInstance($varName, $instance = "") {
          if(is_object($instance)){
              $GLOBALS[$varName] = $instance;
              return true;
          } else {
              return false;
          }
        }
    /**
    * Method set to null instance of config file
    * @param       string  $varName     Name of the variable
    * @access      public
    **/
    static function &emptyInstance($varName)   {
        unset($GLOBALS["config_".$varName]);
    }

    /**
    * Method add and rewrite variables from config file to this instance
      * @param       ConfigFile          configfile object
      * @param       string    $mode    Merge mode ("w"-rewrite section,"a+"-append and owerwrite items, "a"-only append items)
      * @access public
      **/
    function mergeSections(&$config,$mode="a+")  {
      if ($config==null)    return;
      if (sizeof($config->Sections)==0) return;
        foreach($config->Sections as $_sname => $_section)  {
            $this->mergeSection($_section,$_sname,$mode);
      }
      $this->reInitInstance();

    }

    /**
      * Method defined object variables, set variables values like values in config section
      * @param  object   &$object         object        pointer
      * @param  string   $section         configuration object section name
      **/
    function fromSectionToVariables(&$object,$sectionname)    {
      if (sizeof($this->Sections[$sectionname])!=0)    {
          foreach($this->Sections[$sectionname] as $varname=>$varvalue)    $object->$varname=$varvalue;
      }
    }
    /**
      * Method check if instance exists in GLOBALS  array
      * @param  string   $varName         instance name
      * @return boolean                   exists - true, otherwise - false
      **/
    function HasInstance($varName)  {
        if (is_object($GLOBALS[$varName]))  {
            return true;
        }    else {
            return false;
        }
    }

    function Replace($Search, $Replace)
    {
        foreach ($this->Sections as $section_name => $section_values)
        {
            foreach ($section_values as $param_name => $param_value)
            {
                if (is_array($param_value))
                {
                    foreach ($param_value as $key => $val)
                    {
                        $this->Sections[$section_name][$param_name] =
                        str_replace($Search, $Replace, $this->Sections[$section_name][$param_name]);
                    }
                } else {
                    $this->Sections[$section_name][$param_name] =
                    str_replace($Search, $Replace, $this->Sections[$section_name][$param_name]);
                }
            }
        }
    }

 //end of class
 }
?>