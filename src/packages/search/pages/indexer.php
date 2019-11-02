<?php
 $this->ImportClass("module.web.backendpage", "BackendPage");



 /** Indexer page class
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @version 1.0
   * @package  Search
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
     $indexer_path = $this->Kernel->Package->Settings->GetItem("INDEXER", "IndexerPath")."indexer.phtml";

     if(file_exists($indexer_path)){
        ob_start();
        $u=$this->Auth->userData;
        $POSTSecret = base64_encode($u["user_id"].":".$u["user_login"].":".$u["user_password"]);
        $secure_signature = md5($this->Kernel->Package->Settings->GetItem("INDEXER", "SecureSignature"));
        $SMESettings=&$this->Kernel->Package->Settings;
        $res = include($indexer_path);
        $buffer = ob_get_contents();
        ob_end_clean();
        echo pr($buffer); die();
        echo str_replace("{/page/@url}", $this->Kernel->Settings->GetItem("Module", "SiteURL"), $buffer);

     }
  }


    /**
 *  Method builds rows of a list
 * @param  XMLWriter   $xmlWriter  instance of XMLWriter
 * @access private
 **/
      function XmlControlOnRender(&$xmlWriter)  {
            parent::XmlControlOnRender(&$xmlWriter);
            $secure_signature = md5($this->Kernel->Package->Settings->GetItem("INDEXER", "SecureSignature"));
            $xmlWriter->WriteElementString("url", "?package=search&amp;page=indexer&amp;event=index&amp;s=".md5($secure_signature));
      }
}
?>
