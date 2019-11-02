<?php
  /**
   * Data manipulation class
   * @author Artem Mikhmel <amikhmel@activemedia.ua>
   * @version 1.0
   * @package Framework
   * @subpackage classes.system.cache
   * @access public
   **/

class CACHE {

    static function hasValidCache($file_name, $cache_timeout, $cache_force = false){
        if(defined("NO_CACHE") && (NO_CACHE == 1) && !$cache_force){
            return false;
        }

        $result = false;
        if(is_readable($file_name)){
            if((time() - filemtime($file_name)) < $cache_timeout){
                $result = true;
            }
        }
        return $result;
    }


    static function RenewCache($file_name, $data, $cache_force = false){
        if(!defined("NO_CACHE") || (NO_CACHE == 0) || $cache_force){
            serialize_data($file_name, $data);
        }
    }


    static function GetCachedContent($file_name, $cache_force = false){
        if(!defined("NO_CACHE") || (NO_CACHE == 0) || $cache_force){
            return unserialize_file($file_name);
        } else return "NO_CACHE";
    }


}//end of class
?>