<?php
	$this->Import("web.editpage");
	/**
	 * Tests edit page class
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package	Publications
	 * @subpackage pages
	 * @access public
	 **/
	class TestsEditPage extends EditPage {
		// Class name
		var $ClassName = "TestsEditPage";
		// Class version
		var $Version = "1.0";

		/** Handler  page
		* @var string   $handler
		*/
		var $handler="testsedit";
		
		/** ListHandler  page
		* @var string   $handler
		*/		
		var $listHandler="testslist";

        /**    XSL template name
        * @var     string     $XslTemplate
        */
        //var $XslTemplate = "itemsedit";

      /**  Access to this page roles
        * @var     array     $access_role_id
        **/
        var $access_role_id = array("ADMIN");

	  /**
	  * Method executes on page load
	  * @access public
	  */
   function ControlOnLoad(){       
       //$this->Kernel->IncludeFile("modules.globals");
	   parent::ControlOnLoad();
       //echo pr($this->library_ID);
       $this->saved_library_ID = $this->library_ID;
       //echo pr($this->host_library_ID);

   }


  /**
    * Method executes when user change template using template combobox
    * @access   public
    **/
    function onChangeTest() {
        
        $_item_id = $this->Request->Value("item_id");
        if (intval($_item_id)==0)   {
            $this->Request->SetValue("event","AddItem");
            if($this->saved_library_ID == "sitetests"){
                $this->SetTestInitDescription($this->Request->ToNumber("test_id"), 0);
            }
            
            $this->OnAddItem();
        }   else    {
            $this->Request->SetValue("event","EditItem");
            if($this->saved_library_ID == "sitetests"){
                $this->SetTestInitDescription($this->Request->ToNumber("test_id"), 0);
            }
            $this->OnEditItem(true);
        }
    }

    /**
    * Method sets description of chosen test init string
    * @param    int     $test_id    Test ID
    * @access   public  
    **/
    function SetTestInitDescription($test_id){
        DataFactory::GetStorage($this, "TestsTable", "testsStorage", true, "diagnostic");
        $test = $this->testsStorage->Get(array("test_id" => $test_id));
        //echo pr($test);
        if(!empty($test)){
            $this->Kernel->Localization->SetItem("sitetests", "init_hint", nl2br($test["init_description"]));
        }
    
    }

	  /** Method handles EditItem event
	  * @access public
	  */
	  function OnEditItem($state=null){
            if(($this->saved_library_ID == "sitetests") && ($state==null)){
                $this->_data = $this->Storage->Get(array($this->key_field => $this->item_id));                
                $this->SetTestInitDescription($this->_data["test_id"]);
            }
            parent::OnEditItem();
	  }
   

    
} //--end of class

?>