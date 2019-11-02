<?
 /**
   * Configuration file
   * @package Search
   * @access  public
   * @subpackage  lib.iinc
   **/


 // default email
 //$conf->CONFemail="amikhmel@activemedia.com.ua";

 // language array
 $conf->languages[1]="russian";
 //$languages[2]="russian";

 // check if language is in array of avaliable languages
 // and reset it to default if doesn't
 $ok=false;
 if (isset($LANG_ID))
  {
    while(list($k,$v)=each($conf->languages))
     {
       if ($LANG_ID==$k)
        {
          $ok=true;
          break;
        }
     }
    reset($conf->languages);
  }
 if (!$ok)
  $LANG_ID=1;

// session_register("LANG_ID");

$_SESSION["LANG_ID"]=$LANG_ID;

$connectionString = $this->Page->Kernel->Settings->GetItem("database", "ConnectionString");
$tablesPrefix = $this->Page->Kernel->Settings->GetItem("database","TablesPrefix");

if (!preg_match(CONNECTION_STRING_PATTERN, $connectionString, $matches)) {
                // Error handling: to be done
                die("No valid connection string defined: <br><b>".$connectionString."</b>");
}

$params = explode("&", $matches[8]);
foreach ($params as $param) {
    $pair = explode("=", $param);
    if (strlen($pair[0]))
        $props[$pair[0]] = trim($pair[1]);
}


 // database host
 $conf->CONFdbhost=$matches[2];
 // database user
 $conf->CONFdbuser=$props["user"];
 // database user password
 $conf->CONFdbpass=$props["password"];
 // database name
 $conf->CONFdbdatabase=$props["database"];

 // debug for mysql queries
 $conf->CONFmysqldebug=0;
 // llogging for mysql
 $conf->CONFmysqllog=0;
 // mysql log file name
 //$log_path = $this->_search_package_settings->GetItem("INDEXER", "LoggingPath");
 //$SMESettings=&$this->Kernel->Package->Settings;
 $log_path = $SMESettings->GetItem("INDEXER", "LoggingPath");
 //echo $log_path;
 $conf->CONFmysqllogfile=$log_path."mysql.log";
 // auth log file
 $conf->CONFauthlogfile=$log_path."auth.log";
 // write log for indexer?
 $conf->CONFindexerlog=true;
 // log file name for indexer
 $conf->CONFindexerlogfile=$log_path."indexer.log";

 //indexer
 $conf->CONFhost=$SMESettings->GetItem("INDEXER", "IndexindEntryPoint");
 $conf->CONFuntitle=$SMESettings->GetItem("INDEXER", "NoTitle"); // default title, used if document have no <title> section
 $conf->CONFspecialbegin=$SMESettings->GetItem("INDEXER", "StartIndexingFrom");//begin of indexing description sectinon
 $conf->CONFspecialend=$SMESettings->GetItem("INDEXER", "EndIndexingTo");// end of indexing description section
 $conf->CONFmin_word_lenght=2; // min lenght of word for indexing
 $conf->CONFstop_words=array("and","or","no","in","on"); // stop words

 //path to script
 $conf->CONFpath=$SMESettings->GetItem("INDEXER", "IndexerPath");

 // tables
 $conf->TBLwords=$conf->CONFdbdatabase.".".$tablesPrefix."search_words";
 $conf->TBLwordso=$conf->CONFdbdatabase.".".$tablesPrefix."search_todo_words";
 $conf->TBLwordst=$conf->CONFdbdatabase.".".$tablesPrefix."o_words";
 $conf->TBLwordspages=$conf->CONFdbdatabase.".".$tablesPrefix."search_words_urls";
 $conf->TBLwordspageso=$conf->CONFdbdatabase.".".$tablesPrefix."search_t_words_urls";
 $conf->TBLwordspagest=$conf->CONFdbdatabase.".".$tablesPrefix."search_o_words_urls";
 $conf->TBLpages=$conf->CONFdbdatabase.".".$tablesPrefix."search_urls";
 $conf->TBLpageso=$conf->CONFdbdatabase.".".$tablesPrefix."search_t_urls";
 $conf->TBLpagest=$conf->CONFdbdatabase.".".$tablesPrefix."search_o_urls";
 $conf->TBLtodo=$conf->CONFdbdatabase.".".$tablesPrefix."search_todo_urls";

 // ignore part of urls
 // can be:
 // - /invisible_for_searc/ (all of directory content will be ignored)
 // - .html (*.html will be ignored)
 // - my_ (all files/dirs with "my_" part in it names will be ignored
 $conf->badurls=$SMESettings->GetItem("URLS", "BadUrl"); //array(".gif",".jpg",".swf",".zip",".psd", "/extranet/", "/forum/");
 $conf->POSTSecret=$POSTSecret;
 $conf->Signature=$secure_signature;
?>