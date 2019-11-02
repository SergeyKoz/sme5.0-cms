<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");
$this->ImportClass("system.web.controls.recordcontrol", "RecordControl");
$this->ImportClass("system.web.controls.navigationcontrol", "NavigationControl");
    /** Search control class
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Search
     * @subpackage classes.web.controls
     * @access public
     */
    class SearchControl extends XmlControl {
        var $ClassName = "SearchControl";
        var $Version = "1.0";

  /** Method creates child controls
      * @access public
      */
   function CreateChildControls(){
       $this->paging_var_name = "start";
       $this->keywords_var_name = "search";
       $this->page_number = $this->Page->Request->ToNumber($this->paging_var_name, 0);
       $this->keywords = $this->Page->Request->ToString($this->keywords_var_name, "");
   }


   /**
   * Method prepares keywords for further processing
   * @access    public
   **/
   function PrepareKeywords(){
      $this->keywords = preg_replace("/\s+/", " ", trim($this->keywords));
   }

   /**
   * method gets search content in buffer
   * @param     XMLWriter   $xmlWriter   XML Writer object
   * @access    public
   **/
   function GetSearchContent(&$xmlWriter){
     $this->_search_package_settings = Engine::getPackageSettings($this->Page->Kernel, "search");
     $SMESettings=&$this->_search_package_settings;
     $lib_path = $SMESettings->GetItem("INDEXER", "IndexerPath");

     $search_path = $lib_path."search.phtml";
     $secure_signature = md5($SMESettings->GetItem("INDEXER", "SecureSignature"));
     $res = require($search_path);
     return $total;
   }

   /**
    * Method sets control initial data
    * @param    array   $data   Array with initial data
    *       keywords_var_name - Name of request var to take keywords from (optional)
    *       paging_var_name   - Name of paging var to take pade number from (optional)
    *       page_number       - Value of page number variable. Overrides by request variable (optional)
    *       keywords          - Value of keywords variable. Overrides by request variable (optional)
    *
    * @access   public
    **/
    function InitControl($data = array()){

        if(isset($data["paging_var_name"])){
            $this->paging_var_name = $data["paging_var_name"];
            $this->page_number = $this->Page->Request->ToNumber($this->paging_var_name, 0);
        } elseif(isset($data["page_number"])) {
            $this->page_number = $data["page_number"];
        }


        if(isset($data["keywords_var_name"])){
            $this->keywords_var_name = $data["keywords_var_name"];
            $this->keywords = $this->Page->Request->ToString($this->keywords_var_name, "");
        } elseif(isset($data["keywords"])) {
            $this->keywords = $data["keywords"];
        }
    }

        /**
        *  Method draws xml-content of control
        *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
        *  @access  public
        */
        function XmlControlOnRender(&$xmlWriter) {
            $this->PrepareKeywords();
            $xmlWriter->WriteStartElement("search_results");
                $total = $this->GetSearchContent($xmlWriter);
                $xmlWriter->WriteElementString("total", $total);
                $xmlWriter->WriteElementString("keywords", $this->keywords);
                $xmlWriter->WriteElementString("keywords_var_name", $this->keywords_var_name);

                $_rpp = $this->_search_package_settings->GetItem("MAIN", "RecordsPerPage");
                $this->AddControl(new NavigationControl("navigator","navigator"));
                $this->Controls["navigator"]->SetData(array(
                        "start"=>$this->page_number,
                        "total"=>$total,
                        "rpp"  =>$_rpp,
                        "url"  =>"?search=".rawurlencode($this->keywords),
                        "order_by" =>  "",
                        "var_name" => $this->paging_var_name
                ));
            $xmlWriter->WriteEndElement("search_results");
        }// function

} // class

?>