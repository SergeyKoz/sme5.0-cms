<?php

   $this->ImportClass("web.controls.itemslistcontrol", "ItemsListControl");

  /**  Controll class for Participants module backend page
   * @author Sergey Kozin <skozin@activemedia.com.ua>
   * @version 1.0
   * @package BizStat
   * @access public
   **/
  class TemplatesListControl extends ItemsListControl {

    var $ClassName = "TemplatesListControl";
    var $Version = "1.0";

    function ProcessListSection(){
    	if (!Engine::isPackageExists($this->Page->Kernel, "tags"))
        		$this->RemoveFieldFromLibrary("enable_tags");
    	return parent::ProcessListSection();
    }

 }// class
?>