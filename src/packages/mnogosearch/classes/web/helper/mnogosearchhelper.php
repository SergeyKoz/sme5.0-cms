<?php
   Kernel::ImportClass("system.web.controls.navigationcontrol", "NavigationControl");

  /**  Helper class for mnogosearch
   * @author Sergey Kozin <skozin@activemedia.com.ua>
   * @version 1.0
   * @package Mnogosearch
   * @access public
   **/
  class MnogoSearchHelper {

    var $ClassName = "MnogoSearhHelper";
    var $Version = "1.0";

   /**
    * Method executes on page load
    * @access public
   **/

   function InitSearchAgent($init_data) {

if (($init_data["dt"]!='back') && ($init_data["dt"]!='er') && ($init_data["dt"]!='range')) $init_data["dt"]='';
if ($init_data["dp"]=="") $init_data["dp"]=0;
if (($init_data["dx"]!=0) && ($init_data["dx"]!=-1) && ($init_data["dx"]!=1)) $init_data["dx"]=0;
if ($init_data["dy"]<1970) $init_data["dy"]=1970;
if (($init_data["dm"]<0) || ($init_data["dm"]>11)) $init_data["dm"]=0;
if (($init_data["dd"]<=0) || ($init_data["dd"]>31)) $init_data["dd"]="01";

$init_data["db"]=urldecode($init_data["db"]);
$init_data["de"]=urldecode($init_data["de"]);

if ($init_data["db"]=="") $init_data["db"]='01/01/1970';
if ($init_data["de"]=="") $init_data["de"]='31/12/2020';

if (isset($init_data["q"])) {
        $init_data["q"]=urldecode($init_data["q"]);
        $have_query_flag=1;
} else {
        $have_query_flag=0;
}

$query_orig=$init_data["q"];

        $q_string=$init_data["QUERY_STRING"];

   if (preg_match("/^(\d+)\.(\d+)\.(\d+)/",phpversion(),$param)) {
        $phpver=$param[1];
           if ($param[2] < 9) {
                   $phpver .= "0$param[2]";
           } else {
                   $phpver .= "$param[2]";
           }
        if ($param[3] < 9) {
                   $phpver .= "0$param[3]";
           } else {
                   $phpver .= "$param[3]";
           }
   } else {
           //Cannot determine php version
   }

   if ($init_data["sy"]=='') $init_data["sy"]=0;
   if (Udm_Api_Version() >= 30211) {
        $udm_agent=Udm_Alloc_Agent_Array(array($init_data["DBAddr"]));
   } elseif (Udm_Api_Version() >= 30204) {
        $udm_agent=Udm_Alloc_Agent($init_data["DBAddr"]);
   } else {
        $udm_agent=Udm_Alloc_Agent($init_data["DBAddr"],$init_data["dbmode"]);
   }

   Udm_Set_Agent_Param($udm_agent,UDM_PARAM_PAGE_SIZE,$init_data["ps"]);
   Udm_Set_Agent_Param($udm_agent,UDM_PARAM_PAGE_NUM, $init_data["np"]);

   if ($init_data["trackquery"] == 1) {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_TRACK_MODE,UDM_ENABLED);
   } else {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_TRACK_MODE,UDM_DISABLED);
   }

   if ($init_data["cache"] == 1) {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_CACHE_MODE,UDM_ENABLED);
   } else {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_CACHE_MODE,UDM_DISABLED);
   }

   if ($init_data["IspellPrefixes"] == 1) {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_ISPELL_PREFIXES,UDM_ENABLED);
   } else {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_ISPELL_PREFIXES,UDM_DISABLED);
   }

   if (Udm_Api_Version() >= 30111) {
           if ($init_data["CrossWords"] == 1) {
                   Udm_Set_Agent_Param($udm_agent,UDM_PARAM_CROSS_WORDS,UDM_ENABLED);
           } else {
                   Udm_Set_Agent_Param($udm_agent,UDM_PARAM_CROSS_WORDS,UDM_DISABLED);
           }
   }



   if ($init_data["LocalCharset"] != '') {
          if (!is_array($init_data["LocalCharset"])) {
               Udm_Set_Agent_Param($udm_agent,UDM_PARAM_CHARSET,$init_data["LocalCharset"]);
          } else {
              for ($i=0; $i<count($init_data["LocalCharset"]); $i++){
                  Udm_Set_Agent_Param($udm_agent,UDM_PARAM_CHARSET,$init_data["LocalCharset"][$i]);
              }
          }
          if (Udm_Api_Version() >= 30200) {
                  if (!Udm_Check_Charset($udm_agent, $init_data["LocalCharset"])) {
                      //Incorrect browsercharset
                  }
          }
   }

   if (Udm_Api_Version() >= 30200) {
        if ($init_data["LocalCharset"] == '') Udm_Set_Agent_Param($udm_agent,UDM_PARAM_CHARSET,'utf-8');

        if ($init_data["BrowserCharset"] != '') {
             if (!Udm_Check_Charset($udm_agent, $init_data["BrowserCharset"])) {
                  //Incorrect browsercharset
             }
             Udm_Set_Agent_Param($udm_agent,UDM_PARAM_BROWSER_CHARSET, $init_data["BrowserCharset"]);
             Header ("Content-Type: text/html; charset=".$init_data["BrowserCharset"]);
        } else {
             Udm_Set_Agent_Param($udm_agent,UDM_PARAM_BROWSER_CHARSET,'utf-8');
             Header ("Content-Type: text/html; charset=utf-8");
        }

        Udm_Set_Agent_Param($udm_agent,UDM_PARAM_HLBEG, $init_data["hlbeg"]);
        Udm_Set_Agent_Param($udm_agent,UDM_PARAM_HLEND, $init_data["hlend"]);

   } else {

        if ($init_data["phrase"] == 1) {
                   Udm_Set_Agent_Param($udm_agent,UDM_PARAM_PHRASE_MODE,UDM_ENABLED);
        } else {
                   Udm_Set_Agent_Param($udm_agent,UDM_PARAM_PHRASE_MODE,UDM_DISABLED);
        }
        if ($init_data["stopwordtable"]!="") {
            if (!is_array($init_data["stopwordtable"])) {
                Udm_Set_Agent_Param($udm_agent,UDM_PARAM_STOPTABLE,$init_data["stopwordtable"]);
            } else {
                for ($i=0; $i<count($init_data["stopwordtable"]); $i++){
                    Udm_Set_Agent_Param($udm_agent,UDM_PARAM_STOPTABLE,$init_data["stopwordtable"][$i]);
                }
            }
        }
   }
   if ($init_data["StopwordFile"]!=""){
      if (!is_array($init_data["StopwordFile"])) {
          Udm_Set_Agent_Param($udm_agent,UDM_PARAM_STOPFILE,$init_data["StopwordFile"]);
      } else {
          for ($i=0; $i<count($init_data["StopwordFile"]); $i++){
              Udm_Set_Agent_Param($udm_agent,UDM_PARAM_STOPFILE,$init_data["StopwordFile"][$i]);
          }
      }
   }

   if (Udm_Api_Version() >= 30203) {
      if (!$init_data["sy"]){
             if ($init_data["Synonym"]!=""){
                  if (!is_array($init_data["Synonym"])) {
                      Udm_Set_Agent_Param($udm_agent,UDM_PARAM_SYNONYM, $init_data["Synonym"]);
                  } else {
                      for ($i=0; $i<count($init_data["Synonym"]); $i++){
                          Udm_Set_Agent_Param($udm_agent,UDM_PARAM_SYNONYM, $init_data["Synonym"][$i]);
                      }
                  }
             }
      }

        Udm_Set_Agent_Param($udm_agent,UDM_PARAM_QSTRING,$q_string);
        Udm_Set_Agent_Param($udm_agent,UDM_PARAM_REMOTE_ADDR,$init_data["REMOTE_ADDR"]);
   }

   if (Udm_Api_Version() >= 30204) {
        if ($have_query_flag) Udm_Set_Agent_Param($udm_agent,UDM_PARAM_QUERY,$query_orig);
        if ($init_data["storedaddr"] != '') Udm_Set_Agent_Param($udm_agent,UDM_PARAM_STORED, $init_data["storedaddr"]);
   }

   if (Udm_Api_Version() >= 30207) {

           if ($init_data["groupbysite"] == 1) {
                   Udm_Set_Agent_Param($udm_agent,UDM_PARAM_GROUPBYSITE,UDM_ENABLED);
           } else {
                   Udm_Set_Agent_Param($udm_agent,UDM_PARAM_GROUPBYSITE,UDM_DISABLED);
           }

           if ($init_data["site"]) Udm_Set_Agent_Param($udm_agent,UDM_PARAM_SITEID, $init_data["site"]);
           if ($init_data["DetectClones"] == "") $init_data["DetectClones"]=1;
           if ($init_data["DetectClones"] == 1) {
                   Udm_Set_Agent_Param($udm_agent,UDM_PARAM_DETECT_CLONES,UDM_ENABLED);
           } else {
                   Udm_Set_Agent_Param($udm_agent,UDM_PARAM_DETECT_CLONES,UDM_DISABLED);
           }
   }

   if  ($init_data["m"]=='any') {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_SEARCH_MODE,UDM_MODE_ANY);
   } elseif ($init_data["m"]=='all') {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_SEARCH_MODE,UDM_MODE_ALL);
   } elseif ($init_data["m"]=='bool') {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_SEARCH_MODE,UDM_MODE_BOOL);
   } elseif ($init_data["m"]=='phrase') {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_SEARCH_MODE,UDM_MODE_PHRASE);
   } else {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_SEARCH_MODE,UDM_MODE_ALL);
   }

   if  ($init_data["wm"]=='wrd') {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_WORD_MATCH,UDM_MATCH_WORD);
   } elseif ($init_data["wm"]=='beg') {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_WORD_MATCH,UDM_MATCH_BEGIN);
   } elseif ($init_data["wm"]=='end') {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_WORD_MATCH,UDM_MATCH_END);
   } elseif ($init_data["wm"]=='sub') {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_WORD_MATCH,UDM_MATCH_SUBSTR);
   } else {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_WORD_MATCH,UDM_MATCH_WORD);
   }

   if ($init_data["MinMordLength"] > 0) {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_MIN_WORD_LEN,$minwordlength);
   } else {
        Udm_Set_Agent_Param($udm_agent,UDM_PARAM_MIN_WORD_LEN,1);
   }

   if ($init_data["MaxMordLength"] > 0) {
           Udm_Set_Agent_Param($udm_agent,UDM_PARAM_MAX_WORD_LEN,$maxwordlength);
   } else {
        Udm_Set_Agent_Param($udm_agent,UDM_PARAM_MAX_WORD_LEN,32);
   }

   if ($phpver >= 40007) {
        if ($init_data["VarDir"]!='') Udm_Set_Agent_Param($udm_agent,UDM_PARAM_VARDIR,$init_data["VarDir"]);
        if ($init_data["datadir"]!='') Udm_Set_Agent_Param($udm_agent,UDM_PARAM_VARDIR,$init_data["datadir"]);
   }

   if ($init_data["wf"] != '') {
       Udm_Set_Agent_Param($udm_agent,UDM_PARAM_WEIGHT_FACTOR, $init_data["wf"]);
   }

   for($i=0; $i<count($ul_arr); $i+=1) {
        $temp_ul=$ul_arr[$i];
        if ($temp_ul != '') {
               $auto_wild=strtolower($auto_wild);
               if (($auto_wild == 'yes') ||
                ($auto_wild == '')) {
                      if ((substr($temp_ul,0,7) == 'http://') ||
                        (substr($temp_ul,0,8) == 'https://') ||
                        (substr($temp_ul,0,7) == 'news://') ||
                        (substr($temp_ul,0,6) == 'ftp://')) {
                                Udm_Add_Search_Limit($udm_agent,UDM_LIMIT_URL,"$temp_ul%");
                    } else {
                            Udm_Add_Search_Limit($udm_agent,UDM_LIMIT_URL,"%$temp_ul%");
                    }
               } else {
                       Udm_Add_Search_Limit($udm_agent,UDM_LIMIT_URL,$temp_ul);
               }
        }
   }


   for($i=0; $i<count($tag_arr); $i+=1) {
        $temp_tag=$tag_arr[$i];
        if ($temp_tag != '') Udm_Add_Search_Limit($udm_agent,UDM_LIMIT_TAG,$temp_tag);
   }

   if (Udm_Api_Version() >= 30207) {
           for($i=0; $i<count($type_arr); $i+=1) {
                $temp_type=$type_arr[$i];
                if ($temp_type != '') Udm_Add_Search_Limit($udm_agent,UDM_LIMIT_TYPE,$temp_type);
        }
   }


   for($i=0; $i<count($cat_arr); $i+=1) {
        $temp_cat=$cat_arr[$i];
        if ($temp_cat != '') Udm_Add_Search_Limit($udm_agent,UDM_LIMIT_CAT,$temp_cat);
   }

   for($i=0; $i<count($init_data["lang"]); $i+=1) {
        if ($init_data["lang"][$i]!= '') {
            Udm_Add_Search_Limit($udm_agent,UDM_LIMIT_LANG,$init_data["lang"][$i]);
        }
   }

   if (function_exists('Udm_Set_Agent_Param_Ex')) {
        if ($init_data["excerptsize"]>0) Udm_Set_Agent_Param_Ex($udm_agent,'ExcerptSize',$init_data["excerptsize"]);
        if ($init_data["excerptpadding"]>0) Udm_Set_Agent_Param_Ex($udm_agent,'ExcerptPadding',$init_data["excerptpadding"]);
        if ($init_data["dateformat"]!='') Udm_Set_Agent_Param_Ex($udm_agent,'DateFormat',$init_data["dateformat"]);

        if (Udm_Api_Version() >= 30215) {
            if ($init_data["s"]!='') Udm_Set_Agent_Param_Ex($udm_agent,'s',$init_data["s"]);
            if ($init_data["resultslimit"]>0) Udm_Set_Agent_Param_Ex($udm_agent,'resultslimit',$init_data["resultslimit"]);
        }

           if (($init_data["dt"] == 'back') ||
               ($init_data["dt"] == 'er') ||
               ($init_data["dt"] == 'range')) {
                   Udm_Set_Agent_Param_Ex($udm_agent,'dt',$init_data["dt"]);
                   Udm_Set_Agent_Param_Ex($udm_agent,'dx',$init_data["dx"]);
                   Udm_Set_Agent_Param_Ex($udm_agent,'dm',$init_data["dm"]);
                   Udm_Set_Agent_Param_Ex($udm_agent,'dy',$init_data["dy"]);
                   Udm_Set_Agent_Param_Ex($udm_agent,'dd',$init_data["dd"]);
                   Udm_Set_Agent_Param_Ex($udm_agent,'dp',$init_data["dp"]);
                   Udm_Set_Agent_Param_Ex($udm_agent,'db',$init_data["db"]);
                   Udm_Set_Agent_Param_Ex($udm_agent,'de',$init_data["de"]);
        }
   }



   if (($init_data["dt"] == 'back') && ($init_data["dp"] != '0')) {
                   $recent_time=MnogoSearchHelper::format_dp($init_data["dp"]);         //
                   if ($recent_time != 0) {
                           $dl=time()-$recent_time;
                        Udm_Add_Search_Limit($udm_agent,UDM_LIMIT_DATE,">$dl");
                   }
   } elseif ($init_data["dt"]=='er') {
                   $recent_time=mktime(0,0,0,($dm+1),$init_data["dd"],$init_data["dy"]);
                   if ($init_data["dx"] == -1) {
                        Udm_Add_Search_Limit($udm_agent,UDM_LIMIT_DATE,"<$recent_time");
                   } elseif ($init_data["dy"] == 1) {
                        Udm_Add_Search_Limit($udm_agent,UDM_LIMIT_DATE,">$recent_time");
                   }
   } elseif ($init_data["dt"]=='range') {
                   $begin_time=MnogoSearchHelper::format_userdate($init_data["db"]);           //
                   if ($begin_time) Udm_Add_Search_Limit($udm_agent,UDM_LIMIT_DATE,">$begin_time");

                $end_time=MnogoSearchHelper::format_userdate($init_data["de"]);
                   if ($end_time) Udm_Add_Search_Limit($udm_agent,UDM_LIMIT_DATE,"<$end_time");
   }



   if (!is_array($init_data["IspellData"])){
       $init_data["IspellData"][0]=$init_data["IspellData"];
   }

   for ($i=0; $i<count($init_data["IspellData"]); $i++){
       $tmp=explode(",", $init_data["IspellData"][$i]);
       switch ($tmp[0]){
           case "UDM_ISPELL_TYPE_DB": Udm_Load_Ispell_Data($udm_agent, UDM_ISPELL_TYPE_BD,  $tmp[1],  $tmp[2], $tmp[3]); break;
           case "UDM_ISPELL_TYPE_AFFIX":Udm_Load_Ispell_Data($udm_agent,UDM_ISPELL_TYPE_AFFIX,$tmp[1],$tmp[2],$tmp[3]); break;
           case "UDM_ISPELL_TYPE_SPELL":Udm_Load_Ispell_Data($udm_agent,UDM_ISPELL_TYPE_SPELL,$tmp[1],$tmp[2],$tmp[3]); break;
           case "UDM_ISPELL_TYPE_SERVER":Udm_Load_Ispell_Data($udm_agent, UDM_ISPELL_TYPE_SERVER, $tmp[1], $tmp[2], $tmp[3]); break;
       }
   }

   if (Udm_Api_Version() >= 30215) {
        Udm_Parse_Query_String($udm_agent,$init_data["q_string"]);
   }

  return $udm_agent;

 }

function format_dp($dp) {
        $result=0;

        while ($dp != '') {
                if (preg_match('/^([\-\+]?\d+)([sMhdmy]?)/',$dp,$param)) {
                        switch ($param[2]) {
                                case 's':  $multiplier=1; break;
                                case 'M':  $multiplier=60; break;
                                case 'h':  $multiplier=3600; break;
                                case 'd':  $multiplier=3600*24; break;
                                case 'm':  $multiplier=3600*24*31; break;
                                case 'y':  $multiplier=3600*24*365; break;
                                default: $multiplier=1;
                        }

                        $result += $param[1]*$multiplier;
                        $dp=preg_replace("/^[\-\+]?\d+$param[2]/",'',$dp);
                } else {
                        return 0;
                }
        }

        return $result;
}

// -----------------------------------------------
// format_userdate($date)
// -----------------------------------------------
function format_userdate($date) {
        $result=0;

        if (preg_match('/^(\d+)\/(\d+)\/(\d+)$/',$date,$param)) {
                $day=$param[1];
                $mon=$param[2];
                $year=$param[3];

                $result=mktime(0,0,0,$mon,$day,$year);
        }

        return $result;
}


// -----------------------------------------------
// format_lastmod($lastmod)
// -----------------------------------------------
function format_lastmod($lastmod) {
        $temp=$lastmod;
        if (!$temp) $temp = 'undefined';
        elseif (Udm_Api_Version() < 30204) $temp = strftime('%a, %d %b %Y %H:%M:%S %Z',$temp);
        return $temp;
}



//funcrtio
function GetList($udm_agent, &$xmlWriter, $init_data, $PPD=10){
    $err=false;
    $res=Udm_Find($udm_agent,$init_data["q"]);
    if (!$res) {
        //error
        $err=true;

    } else {

        $search_data["found"]=Udm_Get_Res_Param($res,UDM_PARAM_FOUND);
        $search_data["rows"]=Udm_Get_Res_Param($res,UDM_PARAM_NUM_ROWS);
        $search_data["wordinfo"]=Udm_Get_Res_Param($res,UDM_PARAM_WORDINFO_ALL);
        $search_data["searchtime"]=Udm_Get_Res_Param($res,UDM_PARAM_SEARCHTIME);
        $search_data["first_doc"]=Udm_Get_Res_Param($res,UDM_PARAM_FIRST_DOC);
        $search_data["last_doc"]=Udm_Get_Res_Param($res,UDM_PARAM_LAST_DOC);



        for ($i=0; $i<$search_data["rows"]; $i++){


                $excerpt_flag=0;
                $clonestr='';

                $rec_id=Udm_Get_Res_Field($res,$i,UDM_FIELD_URLID);

                $global_res_position=$i;

                if (Udm_Api_Version() >= 30207) {
                        $origin_id=Udm_Get_Res_Field($res,$i,UDM_FIELD_ORIGINID);
                        if ($origin_id) continue;
                        else {
                                for($j=0;$j<$rows;$j+=1){
                                        $cl_origin_id=Udm_Get_Res_Field($res,$j,UDM_FIELD_ORIGINID);
                                        if (($cl_origin_id) &&
                                            ($cl_origin_id == $rec_id)) {
                                                  $url=Udm_Get_Res_Field($res,$j,UDM_FIELD_URL);     //
                                                  $contype=Udm_Get_Res_Field($res,$j,UDM_FIELD_CONTENT);//
                                                  $docsize=Udm_Get_Res_Field($res,$j,UDM_FIELD_SIZE);  //
                                                  $lastmod=MnogoSearchHelper::format_lastmod(Udm_Get_Res_Field($res,$j,UDM_FIELD_MODIFIED));
                                                if (Udm_Api_Version() >= 30207) {
                                                    $pop_rank=Udm_Get_Res_Field($res,$i,UDM_FIELD_POP_RANK);  //
                                                } else $pop_rank='';
                                                //$clonestr.=print_template('clone',0)."\n";
                                        }
                                }
                        }
                }

                if (Udm_Api_Version() >= 30204) {
                               $search_data["data"][$i]["excerpt_flag"]=Udm_Make_Excerpt($udm_agent, $res, $i);
                }

                $search_data["data"][$i]["ndoc"]=Udm_Get_Res_Field($res,$i,UDM_FIELD_ORDER);
                $search_data["data"][$i]["rating"]=Udm_Get_Res_Field($res,$i,UDM_FIELD_RATING);
                $search_data["data"][$i]["url"]=Udm_Get_Res_Field($res,$i,UDM_FIELD_URL);
                $search_data["data"][$i]["contype"]=Udm_Get_Res_Field($res,$i,UDM_FIELD_CONTENT);
                $search_data["data"][$i]["docsize"]=Udm_Get_Res_Field($res,$i,UDM_FIELD_SIZE);

                $search_data["data"][$i]["lastmod"]=MnogoSearchHelper::format_lastmod(Udm_Get_Res_Field($res,$i,UDM_FIELD_MODIFIED));
                $search_data["data"][$i]["title"]=Udm_Get_Res_Field($res,$i,UDM_FIELD_TITLE);

                $search_data["data"][$i]["title"]=($search_data["data"][$i]["title"]) ? htmlspecialChars($search_data["data"][$i]["title"]):basename($search_data["data"][$i]["url"]);
                $search_data["data"][$i]["title"]=MnogoSearchHelper::ParseDocText($search_data["data"][$i]["title"], $init_data["hlbeg"], $init_data["hlend"]);
                $search_data["data"][$i]["text"]=MnogoSearchHelper::ParseDocText(htmlspecialChars(Udm_Get_Res_Field($res,$i,UDM_FIELD_TEXT)), $init_data["hlbeg"], $init_data["hlend"]);
                //$search_data["data"][$i]["text"]=MnogoSearchHelper::ParseDocText(htmlspecialChars(Udm_Get_Res_Field_ex($res,$i,"Body")), $init_data["hlbeg"], $init_data["hlend"]);
                $search_data["data"][$i]["keyw"]=MnogoSearchHelper::ParseDocText(htmlspecialChars(Udm_Get_Res_Field($res,$i,UDM_FIELD_KEYWORDS)), $init_data["hlbeg"], $init_data["hlend"]);
                $search_data["data"][$i]["desc"]=MnogoSearchHelper::ParseDocText(htmlspecialChars(Udm_Get_Res_Field($res,$i,UDM_FIELD_DESC)), $init_data["hlbeg"], $init_data["hlend"]);

                  $search_data["data"][$i]["crc"]=Udm_Get_Res_Field($res,$i,UDM_FIELD_CRC);

                if (Udm_Api_Version() >= 30203) {
                    $search_data["data"][$i]["doclang"]=Udm_Get_Res_Field($res,$i,UDM_FIELD_LANG);
                    $search_data["data"][$i]["doccharset"]=Udm_Get_Res_Field($res,$i,UDM_FIELD_CHARSET);
                }

                  if ($phpver >= 40006) {
                          $search_data["data"][$i]["category"]=Udm_Get_Res_Field($res,$i,UDM_FIELD_CATEGORY);
                  } else {
                          $search_data["data"][$i]["category"]='';
                  }

                if (Udm_Api_Version() >= 30207) {
                        $search_data["data"][$i]["pop_rank"]=Udm_Get_Res_Field($res,$i,UDM_FIELD_POP_RANK);
                } else $search_data["data"][$i]["pop_rank"]='';


                  if ((substr($url,0,6)=="ftp://") &&
                              ($templates['ftpres'][0] != '')) {
                        //print_template('ftpres');
                  } elseif (((substr($url,0,7)=="http://")||(substr($url,0,8)=="https://")) &&
                        ($templates['httpres'][0] != '')) {
                        //print_template('httpres');
                  } else {
                        //print_template('res');
                  }


        }

        $xmlWriter->WriteElementString("found", $search_data["found"]);
        $xmlWriter->WriteElementString("rows", $search_data["rows"]);
        $xmlWriter->WriteElementString("wordinfo", $search_data["wordinfo"]);
        $xmlWriter->WriteElementString("searchtime", $search_data["searchtime"]);
        $xmlWriter->WriteElementString("first_doc", $search_data["first_doc"]);
        $xmlWriter->WriteElementString("last_doc", $search_data["last_doc"]);
        $xmlWriter->WriteElementString("o", $init_data["o"]);


        //set navigator parameters
        $_PREFIX = "";
        $_VAR_NAME = "np";
        $_START = $init_data["np"];
        $_TOTAL = $search_data["found"];
        $_PPD = $PPD;
        
        $_RPP = $init_data["ps"];
        $_URL = $init_data["QUERY_STRING"];

        //create navigator
        $this->AddControl(new NavigationControl("navigator","navigator"));
        $this->Controls["navigator"]->SetData(array(
                        "prefix" => $_PREFIX,
                        "var_name" =>$_VAR_NAME,
                        "start"=>$_START,
                        "total"=>$_TOTAL,
                        "ppd"  =>$_PPD,
                        "rpp"  => $_RPP,
                        "url"  =>"?".$_URL
                        ));

        for ($i=0; $i<count($search_data["data"]); $i++){

             $xmlWriter->WriteStartElement("item");

             $xmlWriter->WriteAttributeString("ndoc", $search_data["data"][$i]["ndoc"]);
             $xmlWriter->WriteAttributeString("rating", $search_data["data"][$i]["rating"]);
             $xmlWriter->WriteAttributeString("docsize", $search_data["data"][$i]["docsize"]);
             $xmlWriter->WriteAttributeString("crc", $search_data["data"][$i]["crc"]);
             $xmlWriter->WriteAttributeString("category", $search_data["data"][$i]["category"]);
             $xmlWriter->WriteAttributeString("pop_rank", $search_data["data"][$i]["pop_rank"]);

             $xmlWriter->WriteElementString("url", $search_data["data"][$i]["url"]);
             $xmlWriter->WriteElementString("title", $search_data["data"][$i]["title"]);
             $xmlWriter->WriteElementString("text", $search_data["data"][$i]["text"]);
             $xmlWriter->WriteElementString("lastmod", str_replace(array(chr(2), chr(3)), "", $search_data["data"][$i]["lastmod"]));
             $xmlWriter->WriteElementString("keyw", $search_data["data"][$i]["keyw"]);
             $xmlWriter->WriteElementString("desc", $search_data["data"][$i]["desc"]);
             $xmlWriter->WriteElementString("contype", $search_data["data"][$i]["contype"]);
             $xmlWriter->WriteElementString("doclang", $search_data["data"][$i]["doclang"]);

            $xmlWriter->WriteEndElement("item");
        }

        Udm_Free_Res($res);

    }
    return $err;
}

// -----------------------------------------------
// ParseDocText($text)
// -----------------------------------------------
function ParseDocText($text, $hlbeg, $hlend){
    //global $all_words;
    //global $hlbeg, $hlend;
    $all_words=array();

    $str=$text;
    if (Udm_Api_Version() < 30200) {
            for ($i=0; $i<count($all_words); $i+=1) {
                $word=$all_words[$i];
                $str = preg_replace("/([\s\t\r\n\~\!\@\#\$\%\^\&\*\(\)\-\_\=\+\\\|\{\}\[\]\;\:\'\"\<\>\?\/\,\.]+)($word)/i","\\1$hlbeg\\2$hlend",$str);
                $str = preg_replace("/^($word)/i","$hlbeg\\1$hlend",$str);
            }
    } else {
            $str = str_replace("\2",$hlbeg,$str);
            $str = str_replace("\3",$hlend,$str);
    }

    return $str;
}

}// class
?>