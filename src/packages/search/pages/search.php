<?php
 $this->Import("project");
 $this->ImportClass("web.controls.searchcontrol", "NavigationControl", "search");

 /** Search page class
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @version 1.0
   * @package  Search
   * @subpackage classes.web
   * @access public
   **/
    class SearchPage extends ProjectPage  {

        var $ClassName="SearchPage";
        var $Version="1.0";
  /** Method creates child controls
      * @access public
      */
   function CreateChildControls(){
        parent::CreateChildControls();
        
        $this->AddControl(new SearchControl("search", "search"));
        
   }


   /**
   * method gets search content in buffer
   * @param     XMLWriter   $xmlWriter   XML Writer object
   * @access    public
   **/
  /* function GetSearchContent(&$xmlWriter){
     $lib_path = $this->Kernel->Package->Settings->GetItem("INDEXER", "IndexerPath");
     $search_path = $lib_path."search.phtml";
     $secure_signature = md5("qwerty");
     $res = require($search_path);
     return $total;
   }
*/
/**
 *  Method draws control content
 * @param  XMLWriter   $xmlWriter  instance of XMLWriter
 * @access private
 */
   /*     function XmlControlOnRender(&$xmlWriter){
            parent::XmlControlOnRender(&$xmlWriter);            
            $xmlWriter->WriteStartElement("search_results");
                $total = $this->GetSearchContent($xmlWriter);
                $xmlWriter->WriteElementString("total", $total);
                $xmlWriter->WriteElementString("keywords", $this->Request->Value("search"));

                $_rpp = $this->Kernel->Package->Settings->GetItem("MAIN", "RecordsPerPage");
                $this->AddControl(new NavigationControl("navigator","navigator"));
                $this->Controls["navigator"]->SetData(array(
                        "start"=>$this->Request->ToNumber("start", 0),
                        "total"=>$total,
                        "rpp"  =>$_rpp,
                        "url"  =>"?search=".rawurlencode($this->Request->Value("search")),
                        "order_by" =>  ""
                ));
            $xmlWriter->WriteEndElement("search_results");
        }
*/

}
?>