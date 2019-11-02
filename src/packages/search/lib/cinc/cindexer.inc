<?
  /**
   * lass for indexing web pages
   * Copyright (c) 2001 Sergey Frolovithev (siteindexer@idesign.ru). All rights reserved.
   * @package Search
   * @subpackage lib.cinc
   * @access  public
   **/
 class cindexer
  { var $log;
    var $host;
    var $sw=array("and","or","no","on");
    var $mwl=2;
    var $needlog=false;

    function Restart($__host,$is_bad=0){
        if($is_bad){
           $stubbed = $this->conf->DB->selQuery($this->conf->selUrlFromProcessQuery);
           $this->conf->DB->updMQuery($this->conf->updIDFromProcessQuery, $stubbed[0]);
        }
        $this->conf->DB->updMQuery($this->conf->updUrlFromProcessQuery,array("url"=>$__host));
        echo "
        <script language='JavaScript'>
           parent.indexProcess();
           document.location = '?package=search&page=indexer&event=index&s=".$this->conf->Signature."&restore=yes';
        </script>
        ";
        die();
    }

    function log($message,$type)
     {
      if ($this->needlog){

            $this->logger->write($message,$type);
       }
     }

     function cindexer($host,&$log, &$conf){
       $__host = $host;
       //echo "Processing location: ".$__host."<br>";
       $this->conf = $conf;
       $host=str_replace("http://","http:::",$host);
       $host=str_replace("//","/",$host);
       $host=str_replace("//","/",$host);
       $host=str_replace("//","/",$host);
       $host=str_replace("http:::","http://",$host);

       $this->host=$host;
       $this->logger=$log;
       $this->mwl=$this->conf->CONFmin_word_lenght;
       $this->sw=$this->conf->CONFstop_words;
       $this->needlog=$this->conf->CONFindexerlog;

       // http class init
       $h=new chttp;

       // url parse
       $p=parse_url($host);

       if ($p["path"]=="") $p["path"]="/";

       // query
       if ($p["query"]!="") $p["path"].="?".$p["query"];


       // check if in black urls list
       for ($b=0;$b<count($this->conf->badurls);$b++)
        {
          if (strstr($host,$this->conf->badurls[$b]))
           {
             $error="Host: $host is in bad urls list!";
             $this->Restart($host,1);
             return;
           }
        }

       //$error=$h->Open(array("HostName"=>$p["host"]));

       //$error=$h->OpenCurl(array("HostName"=>$p["host"]));



       		$params= array(	"HostName"=>$p["host"],
       						"RequestURI"=>$p["path"],
       						"POSTSecret"=>$conf->POSTSecret);
       		$fbody=$h->GetBody($params);
       		$fbody=preg_replace("~<script(.|\n)*?</script>~mi", "", $fbody);

       		if ($fbody!="") $error="";

          if ($error==""){

             // check if already indexed page
             if ($error=="")
                $error=$this->conf->DB->insMQuery($this->conf->insPageQuery,array("page"=>$host));


             if ($error==""){
             	$page_id=$this->conf->DB->insert_id;
                //echo "[".date("H:i:s d-m-Y")."] ".$host."<br>\n";

                $urls=$this->parseHtml($fbody, $this->host);

                $obody=str_replace("\n"," ",$fbody);
                if (preg_match("/<title>(.*?)<\/title>/i",$obody,$arr))
                 { $title=$arr[1];
                 }
                else
                 { $title=$this->conf->CONFuntitle;
                 }
                $title = ($title == "" ? $this->conf->CONFuntitle : $title);

                $tags=new ctags();

                // descr
                if (preg_match("/".$this->conf->CONFspecialbegin."(.*)/i",$obody,$arr))
                 { if (preg_match("/(.*)".$this->conf->CONFspecialend."/i",$arr[1],$arr))
                    {
                      $descr=substr($tags->ctags($arr[1]),0,252)."...";
                      //$descr=strip_tags(str_replace(">", "> ",$arr[1]));

                      $fbody=$arr[1];
                    }
                   else
                    {
                      $descr=substr($tags->ctags($arr[1]),0,252)."...";
                      $fbody=$arr[1];
                    }
                 }
                else{
                 $descr=substr($tags->ctags($obody),0,252)."...";
                }

                /*if(false !== ($pos = strpos($descr, "<!--noindex:begin"))){
                   $descr = preg_replace("/\<\!\-\-noindex\:begin\/\/ \-\-\>((.|\n)*?)\<\!\-\-noindex\:end\/\/ \-\-\>/", "", $descr);
                } */

                $this->log($page_id."|".$host."|".$title,0);                                                                                                                                                   //strip_tags(preg_replace("/<script.*?<\/script>/im", "", str_replace(array(">", "&nbsp;"), array("> ", " "),$obody))))
                $this->conf->DB->updMQuery($this->conf->updPageInfoQuery,array("id"=>$page_id,"title"=>$title,"descr"=>trim($descr),"status"=>200));

                //$words=$tags->ctags($descr);

                $words=strip_tags($fbody);
                unset($fbody);
                $words=str_replace("&nbsp;"," ",$words);
                $words=str_replace("&copy;","",$words);
                $words=str_replace("&reg;","",$words);
                $words=str_replace("\t"," ",$words);
                $words=str_replace("\n"," ",$words);
                $words=chop($words);
                //$words=split(" ",$words);
                $words=preg_split("~ ~",$words);

                for ($i=0;$i<count($words);$i++)
                 { $words[$i]=trim($words[$i]);
                   if (($words[$i]!="")&&(strlen($words[$i])>$this->mwl)&&(!in_array($words[$i],$this->sw)))
                    { $error=$this->conf->DB->insMQuery($this->conf->insWordQuery,array("word"=>$words[$i]));
                      if ($error!="")
                       { $w=$this->conf->DB->selMRow($this->conf->selWordQuery,array("word"=>$words[$i]));
                         $word_id=$w["id"];
                       }
                      else
                       $word_id=$this->conf->DB->insert_id;
                      $error=$this->conf->DB->insMQuery($this->conf->insWordToPageQuery,array("word_id"=>$word_id,"page_id"=>$page_id));
                      if ($error!="")
                       { $this->conf->DB->updMQuery($this->conf->updWordToPageQuery,array("word_id"=>$word_id,"page_id"=>$page_id));
                       }
                    }
                 }
                // href parsing and recursive call
                if (is_array($urls))
                 {
                   reset($urls);
                   while(list($k,$v)=each($urls))
                    { if ( (!strstr($v["HREF"],"mailto:")) && (!strstr($v["HREF"],"#")) )
                       { $v["HREF"]=str_replace("'","",$v["HREF"]);
                         $v["HREF"]=str_replace("\"","",$v["HREF"]);
                         $tpg=parse_url($v["HREF"]);


                         if ($tpg["host"]=="")
                          $v["HREF"]=$this->conf->CONFhost."/".$v["HREF"];

                         if (strstr($v["HREF"],$p["host"])){
                         //if (strstr($v["HREF"],$this->conf->CONFhost)){
                         	$this->conf->DB->insMQuery($this->conf->insUrlToProcessQuery,array("url"=>$v["HREF"]));
                         }
                       }
                    }
                 }
                $this->Restart($__host);
              }
             else
              {
                $this->Restart($__host);
                $h->Close();
                return;
              }
           }
          else
           { $h->Close();
             $this->log("[ERROR] Can't get \"".$p["host"].$p["path"]."\"!",1);
             $this->Restart($p["host"].$p["path"]);
             return;
           }
     }

    /*function cindexer($host,&$log, &$conf)
     {
       $__host = $host;
       //echo "Processing location: ".$__host."<br>";
       $this->conf = $conf;
       $host=str_replace("http://","http:::",$host);
       $host=str_replace("//","/",$host);
       $host=str_replace("//","/",$host);
       $host=str_replace("//","/",$host);
       $host=str_replace("http:::","http://",$host);

       $this->host=$host;
       $this->logger=$log;
       $this->mwl=$this->conf->CONFmin_word_lenght;
       $this->sw=$this->conf->CONFstop_words;
       $this->needlog=$this->conf->CONFindexerlog;


       // http class init
       $h=new chttp;

       // url parse
       $p=parse_url($host);

       if ($p["path"]=="")
        $p["path"]="/";
       // query
       if ($p["query"]!="")
        $p["path"].="?".$p["query"];


       // check if in black urls list
       for ($b=0;$b<count($this->conf->badurls);$b++)
        {
          if (strstr($host,$this->conf->badurls[$b]))
           {
             $error="Host: $host is in bad urls list!";
             $this->Restart($host,1);
             return;
           }
        }

       //$error=$h->Open(array("HostName"=>$p["host"]));

       $error=$h->OpenCurl(array("HostName"=>$p["host"]));



       if ($error==""){
       		//$error=$h->SendRequest(array("RequestURI"=>$p["path"],
            //                           "Headers"=>array("Host"=>$p["host"],
            //                           "User-Agent"=>"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT5.1;)",
            //                           "Pragma"=>"no-cache")));
            //
         	$error=$h->SendRequestCurl(array("RequestURI"=>$p["path"],
                                       "Headers"=>array("Host"=>$p["host"],
                                       "User-Agent"=>"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT5.1;)",
                                       "Pragma"=>"no-cache")));

          if ($error==""){

             if ($error==""){
                // check if already indexed page
                $error=$this->conf->DB->insMQuery($this->conf->insPageQuery,array("page"=>$host));
             }

             if ($error==""){
             	$page_id=$this->conf->DB->insert_id;
                //echo "[".date("H:i:s d-m-Y")."] ".$host."<br>\n";
                // getting  page header status
                $headers=array();
                $error=$h->ReadReplyHeaders(&$headers);
                if (is_array($headers)){
                	reset($headers);
                   $p=0;
                   while(list($k,$v)=each($headers))
                    {
                      if ((strstr($k,"404"))&&($p==0))
                       { $this->conf->DB->updMQuery($this->conf->updPageInfoQuery,array("id"=>$page_id,"title"=>"404 not found","descr"=>"","status"=>"404"));
                         //echo "<b>NOT FOUND</b> ".$this->host."<br><br>";
                         $this->Restart("");
                         return;
                       }
                      if ((strstr($k,"400"))&&($p==0))
                       { //$this->conf->DB->updMQuery($this->conf->updPageInfoQuery,array("id"=>$page_id,"title"=>"404 not found","descr"=>"","status"=>"404"));
                         //echo "<b>NOT FOUND</b> ".$this->host."<br><br>";
                         echo pr("222");$this->Restart("");
                         return;
                       }

                      if ($k=="location"){
                      	$tpg=parse_url($v);
                        if ($tpg["host"]=="")
                          $v=$this->conf->CONFhost."/".$v;
                         if (strstr($v,$this->conf->CONFhost)){

                          $I=new cindexer($v,$this->logger, &$this->conf);

                          $this->Restart($v);
                         }


                         return;
                       }
                      $p++;
                      //break;
                    }
                 }

                for(;;) // reading body
                 { $error=$h->ReadReplyBody(&$body,1000);
                   if ($error!="" || strlen($body)==0)
                    break;
                   $fbody.=$body;
                 }

                // connection close
                $h->Close();

                $urls=$this->parseHtml($fbody, $this->host);

                $obody=str_replace("\n"," ",$fbody);
                if (preg_match("/<title>(.*?)<\/title>/i",$obody,$arr))
                 { $title=$arr[1];
                 }
                else
                 { $title=$this->conf->CONFuntitle;
                 }
                $title = ($title == "" ? $this->conf->CONFuntitle : $title);

                $tags=new ctags();

                // descr
                if (preg_match("/".$this->conf->CONFspecialbegin."(.*)/i",$obody,$arr))
                 { if (preg_match("/(.*)".$this->conf->CONFspecialend."/i",$arr[1],$arr))
                    {
                      $descr=substr($tags->ctags($arr[1]),0,252)."...";
                      //$descr=strip_tags(str_replace(">", "> ",$arr[1]));
                      $fbody=$arr[1];
                    }
                   else
                    {
                      $descr=substr($tags->ctags($arr[1]),0,252)."...";
                      $fbody=$arr[1];
                    }
                 }
                else{
                 $descr=substr($tags->ctags($obody),0,252)."...";
                }

                if(false !== ($pos = strpos($descr, "<!--noindex:begin"))){
                   $descr = preg_replace("/\<\!\-\-noindex\:begin\/\/ \-\-\>((.|\n)*?)\<\!\-\-noindex\:end\/\/ \-\-\>/", "", $descr);
                }

                $this->log($page_id."|".$host."|".$title,0);
                $this->conf->DB->updMQuery($this->conf->updPageInfoQuery,array("id"=>$page_id,"title"=>$title,"descr"=>preg_replace("/(\s{1,})/", " ", strip_tags(preg_replace("/<script.*?<\/script>/im", "", str_replace(array(">", "&nbsp;"), array("> ", " "),$obody)))),"status"=>200));



                //$words=$tags->ctags($descr);
                $words=strip_tags($fbody);
                unset($fbody);
                $words=str_replace("&nbsp;"," ",$words);
                $words=str_replace("&copy;","",$words);
                $words=str_replace("&reg;","",$words);
                $words=str_replace("\t"," ",$words);
                $words=str_replace("\n"," ",$words);
                $words=chop($words);
                //$words=split(" ",$words);
                $words=preg_split("~ ~",$words);

                for ($i=0;$i<count($words);$i++)
                 { $words[$i]=trim($words[$i]);
                   if (($words[$i]!="")&&(strlen($words[$i])>$this->mwl)&&(!in_array($words[$i],$this->sw)))
                    { $error=$this->conf->DB->insMQuery($this->conf->insWordQuery,array("word"=>$words[$i]));
                      if ($error!="")
                       { $w=$this->conf->DB->selMRow($this->conf->selWordQuery,array("word"=>$words[$i]));
                         $word_id=$w["id"];
                       }
                      else
                       $word_id=$this->conf->DB->insert_id;
                      $error=$this->conf->DB->insMQuery($this->conf->insWordToPageQuery,array("word_id"=>$word_id,"page_id"=>$page_id));
                      if ($error!="")
                       { $this->conf->DB->updMQuery($this->conf->updWordToPageQuery,array("word_id"=>$word_id,"page_id"=>$page_id));
                       }
                    }
                 }
                // href parsing and recursive call
                if (is_array($urls))
                 {
                   reset($urls);
                   while(list($k,$v)=each($urls))
                    { if ( (!strstr($v["HREF"],"mailto:")) && (!strstr($v["HREF"],"#")) )
                       { $v["HREF"]=str_replace("'","",$v["HREF"]);
                         $v["HREF"]=str_replace("\"","",$v["HREF"]);
                         $tpg=parse_url($v["HREF"]);


                         if ($tpg["host"]=="")
                          $v["HREF"]=$this->conf->CONFhost."/".$v["HREF"];
                         if (strstr($v["HREF"],$this->conf->CONFhost))
                          {
                           $this->conf->DB->insMQuery($this->conf->insUrlToProcessQuery,array("url"=>$v["HREF"]));
                          }
                       }
                    }
                 }
                $this->Restart($__host);
              }
             else
              {
                $this->Restart($__host);
                $h->Close();
                return;
              }
           }
          else
           { $h->Close();
             $this->log("[ERROR] Can't get \"".$p["host"].$p["path"]."\"!",1);
             $this->Restart($p["host"].$p["path"]);
             return;
           }
        }
       else
        { $h->Close();
          $this->log("[ERROR] Can't connect to \"".$p["host"]."\"!",1);
          $this->Restart($p["host"]);
          return;
        }
     }*/

    function parseHtml ($str, $host)
     {
     echo "<hr><b>source html = .".$host.".</b><br>";
     $h = parse_url($host);
     $h_tmp_dirs = explode("/", $h["path"]);
     if(strpos($h_tmp_dirs[sizeof($h_tmp_dirs)-1],".") === false)
     $hfilename = "";
     else $hfilename = $h_tmp_dirs[sizeof($h_tmp_dirs)-1];

     if($hfilename != ""){
       $h_dirs="";
       for($i=0; $i<sizeof($h_tmp_dirs)-1;$i++)
         {
           $h_dirs .= $h_tmp_dirs[$i]."/";
         }
       $h["path"]=$h_dirs;

     }

     $str = str_replace(">", ">\n", $str);
     $str = explode("\n", $str);
     //$str=array($str);
       if (is_array($str))
        { while(list($k,$v)=each($str)) {


         if (preg_match_all("/<a(.+?)href=\"(.+?)\"/",$v,$arr)) {

                $sizeof = sizeof($arr[2]);
                for($_i=0; $_i<$sizeof; $_i++) {
                   $t[0] =  $arr[2][$_i];
                $t[0] = (substr($t[0],0,1)=="\""? substr($t[0],1):$t[0]);
                $t[0] = (substr($t[0],-1)=="\""? substr($t[0],0,-1):$t[0]);
                $p = parse_url($t[0]);

                if($p["host"] == "")
                {
                  $tmp_host = $h["host"];
                }
                else $tmp_host = $p["host"];

                if($p["path"] == ""){
                  //echo "#1 ->>)";
                  if($p["host"] == "")
                  $tmp_path = $h["path"];
                  else {
                    $tmp_path="";
                  }
                }
                else
                {

                  $_tmp_dirs = explode("/", $p["path"]);
                  if(strpos($_tmp_dirs[sizeof($_tmp_dirs)-1],".") === false)
                  $filename = "";
                  else $filename = $_tmp_dirs[sizeof($_tmp_dirs)-1];
                  if($filename != ""){
                     $_dirs="";
                     for($i=0; $i<sizeof($_tmp_dirs)-1;$i++)
                     {
                       $_dirs .= $_tmp_dirs[$i]."/";
                       }
                    $p["path"]=$_dirs;
                  }


                  if(substr($p["path"],0,1) == "/")
                  {
                   //echo "#3";
                   $tmp_path = $p["path"];
                  }
                  else{
                    if(substr($p["path"],0,1) != ".")
                     {
                       $tmp_path = $h["path"].(substr($h["path"],-1) == "/"? "":"/").$p["path"];

                     }
                    else{

                     $dirs = explode("/",$h["path"]);
                     $_tmp_path = "";
                     $cnt = ($filename == ""? 1:2);

                     for($i=0; $i<(sizeof($dirs)-$cnt); $i++)
                       {
                         $_tmp_path.=$dirs[$i]."/";
                         }
                     $tmp_path = $_tmp_path.substr($p["path"],3);
                     }
                   }


                }

                $url = "http://".$tmp_host.(substr($tmp_path,0,1)=="/"?"":"/").$tmp_path.(substr($p["query"],0,1) == "$filename?" ? "$filename":(strlen($p["query"]) == 0?"$filename":"$filename?")).$p["query"];

                 $__pos = strpos($url, "#");
                 if($__pos !== false){
                      $url = substr($url, 0, $__pos);
                 }
                 $urls[$url]=1;

                }
              }
            }
        }
        echo "<b>/end.</b><br><br><br>";
        if(!empty($urls)){
       foreach($urls as $url => $flag){
           $__urls[]["HREF"] = trim(str_replace(array("&&", "?&"), array("&", "?"),preg_replace("/PHPSESSID=[a-f0-9]+/", "",$url)),"?&");
       }} else {
          $__urls = array();
       }


       return $__urls;
     }


    function parseHtmlUnderConstruction($s_str)
     { $i_indicatorL = 0;
       $i_indicatorR = 0;
       $s_tagOption = "";
       $i_arrayCounter = 0;
       $a_html = array();

       // Search for a tag in string
       while( is_int(($i_indicatorL=strpos($s_str,"<",$i_indicatorR))) )
        { // Get everything into tag...
          $i_indicatorL++;
          $i_indicatorR = strpos($s_str,">", $i_indicatorL);
          $s_temp = substr($s_str, $i_indicatorL, ($i_indicatorR-$i_indicatorL) );
          $a_tag = explode( ' ', $s_temp );

          // Here we get the tag's name
          list( ,$s_tagName,, ) = each($a_tag);
          $s_tagName = strtoupper($s_tagName);

          // Well, I am not interesting in <br>, </font> or anything else like that...
          // So, this is false for tags without options.
          $b_boolOptions = is_array(($s_tagOption=each($a_tag))) && $s_tagOption[1];
          if ($b_boolOptions)
           { // Without this, we will mess up the array
             $i_arrayCounter = (int)count($a_html[$s_tagName]);

             // get the tag options, like src="htt://". Here, s_tagTokOption is 'src' and s_tagTokValue is '"http://"'
             do
              { $s_tagTokOption = strtoupper(strtok($s_tagOption[1], "="));
                $s_tagTokValue  = trim(strtok("="));
                $a_html[$s_tagName][$i_arrayCounter][$s_tagTokOption] = $s_tagTokValue;
                $b_boolOptions = is_array(($s_tagOption=each($a_tag))) && $s_tagOption[1];
              }
             while( $b_boolOptions );
           }
        }
       return $a_html;
     }

  }
?>