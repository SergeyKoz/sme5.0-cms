<?php
 $this->ImportClass("module.web.backendpage", "BackendPage");
 $this->ImportClass("system.mail.emailtemplate", "EmailTemplate");

   /** Indexer page class
   * @author Sergey Kozin <skozin@activemedia.com.ua>
   * @version 1.0
   * @package  mnoGoSearch
   * @subpackage pages
   * @access public
   **/
    class IndexerPage extends BackendPage  {

        var $ClassName="IndexerPage";
        var $Version="1.0";
        var $access_role_id = array("CONTENT_MANAGER", "STRUCTURE_MANAGER");
   /** Method creates child controls
   * @access public
   **/
   function CreateChildControls(){
        parent::CreateChildControls();
   }

  /**
  * Method calls indexing routines in response to Index event
  * @access public
  **/
  function OnIndex(){
     //gets vars from ini file
     $indexer_global=$this->Kernel->Package->Settings->GetSection("indexer_global");
     $indexer_url_control=$this->Kernel->Package->Settings->GetSection("indexer_url_control");
     $indexer_external=$this->Kernel->Package->Settings->GetSection("indexer_external");
     $indexer_aliases=$this->Kernel->Package->Settings->GetSection("indexer_aliases");
     $indexer_servers=$this->Kernel->Package->Settings->GetSection("indexer_servers");

     $indexer = array_merge(
                $indexer_global,
                $indexer_url_control,
                $indexer_external,
                $indexer_aliases,
                $indexer_servers
                );

     $bool_var= array("NewsExtensions", "ForceIISCharset1251", "CrossWords", "UseRemoteContentType",
                     "Robots", "DetectClones", "Index", "PopRankSkipSameSite", "PopRankFeedBack"
     );

     $OptionsCmd = $indexer["OptionsCmd"];
     $ConfigPath = $indexer["ConfigPath"];
     $PathToIndexer = $indexer["PathToIndexer"];
     $indexer["OptionsCmd"]="";
     $indexer["ConfigPath"]="";

     //prepare template data
     if ($indexer["DefaultLang"]=="")
        $indexer["DefaultLang"]= $this->Kernel->Languages[0];

     if ($indexer["VaryLang"]=="")
       for ($i=0; $i<count($this->Kernel->Languages); $i++)
          $indexer["VaryLang"]=$indexer["VaryLang"].$this->Kernel->Languages[$i]." ";
     $indexer["VaryLang"]=trim($indexer["VaryLang"]);
     $indexer["VaryLang"]="\"".$indexer["VaryLang"]."\"";
     if ($indexer["DBAddr"]==""){
        list($driverName, $con)=DataFactory::GetConnectionProperties($this->Kernel->Settings->GetItem("database", "ConnectionString"));
        $indexer["DBAddr"] = sprintf("%s://%s%s%s%s/%s/%s",
                                       $driverName,
                                       $con["user"],
                                       ($con["password"]!="" ? ":".$con["password"]:""),
                                       ($con["user"]!="" ? "@":""),
                                       $con["host"],
                                       $con["database"],
                                       $indexer["dbmode"]
                                       );
     }

     while (list($key, $val) = each($indexer)) {
            if (in_array($key, $bool_var)){
                if ($val=="1")
                   $indexer[$key]= $key." yes";
                if ($val=="0")
                   $indexer[$key]= $key." no";
            } else {
                if ($val!=""){
                    if (is_array($val)){
                       for ($i=0; $i<count($val); $i++){
                           $tmp=$tmp.$key." ".$val[$i]."\n ";
                       }
                       $indexer[$key]=$tmp;
                       $tmp="";
                    } else {
                       $indexer[$key]=$key." ".$val;
                    }
                }
            }
     }

     //Get template and generate indexer.conf file
     $xmlWriter = new XMLWriter($this->Kernel->TemplateDirs, null);
     $xmlWriter->getXSLT("conf/indexer",&$this->Kernel->Debug);
     $tpl = $xmlWriter->XSLT;
     $emailSender = &new EmailTemplate(null, null, null, null);
     $message = $emailSender->Render_Tag($tpl, $indexer, true);
     $f = fopen ($ConfigPath."indexer.conf", "w");
     fwrite($f, $message);
     fclose($f);

     if (file_exists($ConfigPath."indexer.conf"))
         @chmod($ConfigPath."indexer.conf", 0777);
     if (file_exists($ConfigPath."indexer.log"))
         @chmod($ConfigPath."indexer.log", 0777);

     //Start indexer
     $cmd=$PathToIndexer." ".$OptionsCmd." ".$ConfigPath."indexer.conf > ".$ConfigPath."indexer.log &";
     print_r($cmd);
     exec($cmd);
     die($this->Kernel->Localization->GetItem("main", "_message_indexation_started"));
  }

 /**
 *  Method builds rows of a list
 * @param  XMLWriter   $xmlWriter  instance of XMLWriter
 * @access private
 **/
      function XmlControlOnRender(&$xmlWriter)  {
            parent::XmlControlOnRender(&$xmlWriter);
            $xmlWriter->WriteElementString("url", "?package=mnogosearch&amp;page=indexer&amp;event=index&amp;s=".md5("qwerty"));
      }
}
?>