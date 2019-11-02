<?php
     /** @const DB_COLUMN_NUMERIC Constant of numeric column type */
    define("DB_COLUMN_NUMERIC", 1);

  /** @const DB_COLUMN_STRING Constant of string column type */
    define("DB_COLUMN_STRING", 2);

  /**
   * Data manipulation class
   * @author Konstantin Matsebora<kmatsebora@activemedia.com.ua>
   * @version 1.0
   * @package Framework
   * @subpackage classes.system.data
   * @access public
   **/

class DataManipulator {

/**
  *  Method gets node from bottom to root
  *  @param  array   $data  Array with tree data
  *  @param  int      $node_id  Low-level node ID
  *  @param  string  $keyfield  Name of keyfield
  *  @param string  $parent_field  Name of parent field
  *  @param  array   $node_list  Nodelist
  *  @param boolean $removeprefix    Remove language prefixes from field names flag
  *  @access  public
  */
	static function BuildTreeFromBottom($data, $node_id, $keyfield, $parent_field, &$node_list, $removeprefix=false){
		if(!empty($data)){
			foreach($data as $key => $value){
				if($data[$key][$keyfield] == $node_id){
					if ($removeprefix) {
						foreach($data[$key] as $field_key =>$value)  {
							$data[$key][removeLangPrefix($field_key,$this->Connection->Kernel->Language)]=$data[$key][$field_key];
						}
					}
					$node_list[$data[$key][$keyfield]] = $data[$key];
					DataManipulator::BuildTreeFromBottom($data, $data[$key][$parent_field], $keyfield, $parent_field, $node_list);
				}
			}
		}
	}

   /**
   * Method returns list of nodes that belongs to selected node
   * @param    array       $raw_data         Raw list of records
   * @param    int        $node_id         Current node ID
   * @param    string      $key_field_name     Name of key-field
   * @param     string    $parent_id_name    Name of parent-link field
   * @param    array    &$node_list         Final list of nodes
   * @access  public
   */
   static function GetRecursiveNodeList($raw_data, $node_id, $key_field_name, $parent_id_name,&$node_list){
    for($i=0; $i<sizeof($raw_data); $i++)   {
     if($raw_data[$i][$parent_id_name] == $node_id){
      $node_list[$raw_data[$i][$key_field_name]] = $raw_data[$i];
      DataManipulator::GetRecursiveNodeList($raw_data, $raw_data[$i][$key_field_name], $key_field_name, $parent_id_name, $node_list);
     }
    }// for
   }

 /**
 * Method creates array of language-specific columns
 * @param    array  $array  array to make language-specific
 * @param   array  $langs  array with languages
 * @param   string   $callback_function Callback function to execute on each created array element
 * @return   array   Array  of language-specific columns
 * @access  public
 **/
 static function makeLangArray($array, $langs, $callback_function=null){
     $_result_arr = array();
     $sizeof = sizeof($langs);
     for($i=0; $i<$sizeof; $i++){
         $_tmp_array = $array;
         $_tmp_array["name"] = sprintf($_tmp_array["name"], $langs[$i]);
         if($callback_function !== null){
             $_tmp_array = call_user_func_array($callback_function, array($_tmp_array, $langs[$i]));
         }
         $_result_arr[] = $_tmp_array;
     }
     if(!empty($_result_arr)){
        return $_result_arr;
     } else {
        return  $array;
     }
 }

 /**
 * Method creates multilanguage columnsin table
 * @param  array    $__array    Array to make multilang
 * @param   array   $languages LAnguages array
 * @param   string   $callback_function Callback function to execute on each created array element
 * @access  public
 ***/
 static function prepareMultilangColumns(&$__array, $languages, $callback_function=null){
     $sizeof = sizeof($__array);
     $_tmp_array = array();
     for($i=0; $i<$sizeof; $i++){
        $_pos = strpos($__array[$i]["name"], "%s");
        if($_pos !== false){
            $_tmp_array = array_merge($_tmp_array, DataManipulator::makeLangArray($__array[$i], $languages, $callback_function));
        } else {
            $_tmp_array[] =  $__array[$i];
        }
     }
     if(!empty($_tmp_array)){
        $__array = $_tmp_array;
     }
 }


    /**
    * Method strips different language versions of array elements by replacing them with one current language version
    * @param    array   $array   Array to strip language version
    * @param    array   $languages  Array with language postfixes to strip
    * @param    string  $current_language  Current language
    * @return   array   array with stripped elements
    **/
    static function StripLanguageVersions($array, $languages, $current_language){
        $_array = array();
        if(!empty($array)){

        foreach($array as $key => $value){
            $probably_lang = substr($key, -2);
            $is_multilang = (in_array($probably_lang, $languages) ? 1:0);
            if($is_multilang){
                if($probably_lang == $current_language){
                   $_array[substr($key,0,-3)] = $value;
                }
            } else {
               $_array[$key] = $value;
            }
        }

        }
        return $_array;
    }

    static function TranslitEncode($text, $language="ru"){
    	global $translit_language;
    	$res="";
    	if ($translit_language!=""){
            $language=$translit_language;
    	}
    	switch ($language){
    		case "ru":$res=DataManipulator::TranslitEncodeRU($text); break;
    		case "ua":$res=DataManipulator::TranslitEncodeUA($text); break;
            default: $res=DataManipulator::TranslitEncodeRU($text);
    	}
        return $res;
    }

    static function TranslitEncodeUA($text){
    	$first=array("¿"=>"yi", "¯"=>"Yi", "é"=>"y", "É"=>"Y", "º"=>"ye", "ª"=>"Ye", "þ"=>"yu", "Þ"=>"Yu", "ÿ"=>"ya", "ß"=>"Ya",);

		foreach($first as $k=>$v){
            if (substr($text, 0, 1)==$k)
            	$text=$v.substr($text, 1, strlen($text)-1);
            $text=strtr($text, array(" ".$k=>" ".$v));
		}

     	$text=strtr($text, array(	"çã"=>"zgh", "Çã"=>"Zgh","ÇÃ"=>"Zgh",
     								"ü"=>"", "ú"=>"", "'"=>""));

     	$text=strtr($text,"àáâã´äåçè³¿éêëìíîïðñòóô", "abvggdezyiiiklmnoprstuf");
	    $text=strtr($text,"ÀÁÂÃ¥ÄÅÇÈ²¯ÉÊËÌÍÎÏÐÑÒÓÔ", "ABVGGDEZYIIIKLMNOPRSTUF");

	    $text=strtr($text, array(	"æ"=>"zh", "ö"=>"ts", "÷"=>"ch", "ø"=>"sh", "ù"=>"shch", "õ"=>"kh", "º"=>"ie", "þ"=>"³u",  "ÿ"=>"ia",
	                    			"Æ"=>"Zh", "Ö"=>"Ts", "×"=>"Ch", "Ø"=>"Sh", "Ù"=>"Shch", "Õ"=>"Kh", "ª"=>"Ie", "Þ"=>"Iu",  "ß"=>"Ia"));

      	return $text;
  	}

  	static function TranslitEncodeRU($text){
		$text=strtr($text,"àáâãäå¸çèéêëìíîïðñòóôõúûý_", "abvgdeeziyklmnoprstufh'iei");
		$text=strtr($text,"ÀÁÂÃÄÅ¨ÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÚÛÝ_", "ABVGDEEZIYKLMNOPRSTUFH'IEI");
    	$text=strtr($text, array(	"æ"=>"zh", "ö"=>"ts", "÷"=>"ch", "ø"=>"sh",
    								"ù"=>"shch","ü"=>"", "þ"=>"yu", "ÿ"=>"ya",
    								"Æ"=>"ZH", "Ö"=>"TS", "×"=>"CH", "Ø"=>"SH",
    								"Ù"=>"SHCH","Ü"=>"", "Þ"=>"YU", "ß"=>"YA",
    								"¿"=>"i", "¯"=>"Yi", "º"=>"ie", "ª"=>"Ye"));
    	return $text;
    }

  	static function TranslitToUrl($text, $language="ru"){
  		$text=DataManipulator::TranslitEncode($text, $language);
  		$text=preg_replace("~[\W_]~", "-", $text);
        return $text;
  	}



}//end of class