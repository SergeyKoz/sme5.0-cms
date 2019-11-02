<?php
   /** Class for store and get global engine data
     * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
     * @version 1.0
     * @package Loader
     * @subpackage classes
     * @access public
     * @static
     */
class DataDispatcher    {
    /**
      * Method clear global engine data
      * @access public
      * @public
      * @static
      **/
    function DataDispatcher(){
    }

    static function Init(){
    	$GLOBALS["ENGINE_DATA"] = array();
    }

    /**
      * Method set value to global engine storage
      * @param  string      $name   variable name
      * @param  mixed       $value  variable value
      * @param  string      $mode   set mode (w - overwrite, a - add if exist)
      * @param  string      $section    Section name
      * @static
      **/
    static function Set ($name, $value,$mode = "w", $section=null) {
        if($section === null){
            $cvalue = $GLOBALS["ENGINE_DATA"][$name];
        } else {
            $cvalue = $GLOBALS["ENGINE_DATA"][$name][$section.""];
        }
            if ($mode == "a")   {
                if (!isset($cvalue))    {
                   $cvalue = $value;
                }    else   {
                    if (!is_array($cvalue)) $cvalue = array($cvalue);
                    $cvalue[] = $value;
                }
            }    else   {
                $cvalue = $value;
            }
        if($section === null){
            $GLOBALS["ENGINE_DATA"][$name] = $cvalue;
        } else {
            $GLOBALS["ENGINE_DATA"][$name][$section.""] = $cvalue;

        }
    }

    /**
      * Method get value from global engine storage
      * @param   string      $name   variable name
      * @param  string      $section    Section name
      * @return  mixed               if value is set  - value, otherwise - null
      * @static
      **/
    static function Get($name, $section=null)  {
        if($section === null){
            if (isset($GLOBALS["ENGINE_DATA"][$name]))   {
                return $GLOBALS["ENGINE_DATA"][$name];
            }    else   {
                return null;
            }
        } else {
            if (isset($GLOBALS["ENGINE_DATA"][$name][$section.""]))   {
                return $GLOBALS["ENGINE_DATA"][$name][$section.""];
            }    else   {
                return null;
            }
        }
    }

    /**
      * Method check  value existence
      * @param   string      $name   variable name
      * @return  mixed               if value is set  - true, otherwise - false
      * @static
      **/
    static function isExists($name)   {
        if (isset($GLOBALS["ENGINE_DATA"][$name]))   {
            return true;
        }    else   {
            return false;
        }
    }

     /**
      * Method return all variables names from global engine data storage
      * @return  array              variable names
      * @static
      **/
    static function getVariables()  {
        if (!is_array($GLOBALS["ENGINE_DATA"])) $GLOBALS["ENGINE_DATA"] = array();
        return array_keys($GLOBALS["ENGINE_DATA"]);
    }

}  //end of class
?>