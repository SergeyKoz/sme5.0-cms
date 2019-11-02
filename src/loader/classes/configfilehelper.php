<? /**
      * ConfigFile helper class (used for merge sections etc.)
      * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
      * @version 1.0
      * @package Loader
      * @subpackage classes
      * @access public
      * @static
      **/

      class ConfigFileHelper    {
  /**
    * Method  merge section in "a" mode
    * @param       ConfigFile  $object          ConfigFile instance
    * @param       array	   $section         Section data
    * @param	   string	   $name		    Section name
    * @return	   boolean						Merge status
    * @access      public
    * @access      private
    **/
        static function mergeSectionWithMode_w(&$object,$section,$name)   {
            $object->Sections[$name] = array();
            $object->mergeSectionWithMode_a_plus($section,$name);
        }

  /**
    * Method  merge section in "a" mode
    * @param       ConfigFile  $object          ConfigFile instance
    * @param       array	   $section         Section data
    * @param	   string	   $name		    Section name
    * @return	   boolean						Merge status
    * @access      public
    * @access      private
    **/
        static function mergeSectionWithMode_a(&$object,$section,$name) {
            foreach	($section as $key => $value)    {
               if (!$object->HasItem($name,$key))  {  //-- if value in config not exists
                 $object->Sections[$name][$key] = $value;
               }      else    {
                 if (is_array($value)) {    // if value is array
                    if (!is_array($object->Sections[$name][$key]))     // if current value not array
                        $object->Sections[$name][$key] = array($object->Sections[$name][$key]);
                     foreach($value as $i => $itemvalue)
                        $object->Sections[$name][$key][]=$itemvalue;
                 }
                 else { //if value not array
                   if (!is_array($object->Sections[$name][$key]))  // if current value not array
                    $object->Sections[$name][$key] = array($object->Sections[$name][$key]);
                    $object->Sections[$name][$key][] = $value;
               }
             }
            }
        }

  /**
    * Method  merge section in "a+" mode
    * @param       ConfigFile  $object          ConfigFile instance
    * @param       array	   $section         Section data
    * @param	   string	   $name		    Section name
    * @return	   boolean						Merge status
    * @access      public
    * @access      private
    **/
      static function mergeSectionWithMode_a_plus(&$object,$section,$name)    {
            foreach	($section as $key => $value)    {
            //-- if value not array
               if (!is_array($value))	{
                   $object->Sections[$name][$key] = $value;
                }    else {
                    $object->Sections[$name][$key] = array();
                     foreach($value as $i => $itemvalue)
                      $object->Sections[$name][$key][]=$itemvalue;
                }
            }
        return true;
      }

   /**
    * Method write or merge section to the configuration file.
    * @param       ConfigFile  $object          ConfigFile instance
    * @param       array	   $section         Section data
    * @param	   string	   $name		    Section name
    * @param       string      $mode            Merge mode
    *                                               w     -   rewrite section
    *                                               a+    -   append and overwrite items
    *                                               a     -   only append items
    * @return	   boolean						Merge status
    * @access      public
    **/
    static function mergeSection(&$object,$section,$name,$mode = "w")	{
      if (sizeof($section) == 0) return false;
	   switch ($mode)  {
	       case    "a":
	                   ConfigFileHelper::mergeSectionWithMode_a($object,$section,$name);
	                   break;
	       case    "a+":
	                   ConfigFileHelper::mergeSectionWithMode_a_plus($object,$section,$name);
	                   break;
	       default:
	                   ConfigFileHelper::mergeSectionWithMode_w($object,$section,$name);
	                   break;
	   }
       $object->reInitInstance();
       return true;
    }

}  //--end of class
?>