<?php
  $this->ImportClass("system.web.controls.select","selectcontrol");

/** ListSelectControl control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class ListSelectControl extends SelectControl {
		var $ClassName = "ListSelectControl";
		var $Version = "1.0";

   /**
   * MEthod sets data to draw by select control
   * @param    array   $data  Array with data
   * @access 	public
   */
   function InitControl($data=array()){
       $this->data = $data;
	   $this->data["name"]=$data["name"];
	   $this->data["section"]=$data["section"];
	   $this->data["items"]=$data["items"];
	   $this->data["scope"]=$data["scope"];
	   if($this->data["scope"]==1){
			   $list = $this->Page->Kernel->Settings->GetItem($this->data["section"], $this->data["items"]);
	   } else {
			   $list = $this->Page->Localization->GetItem($this->data["section"], $this->data["items"]);
	   }
	   if(is_array($list)){
		  for($i=0; $i<sizeof($list); $i++){
			 $option = array();
			 list($caption, $value) = explode("|",$list[$i]);
			 $option["caption"]  = $caption;
			 $value = ($value != ""? $value:$i);
			 $option["value"] = $value;

			 if($data["selected_value"] == $value){
				$option["selected"] = "yes";
			 }
			 $this->data["options"][] = $option;

		  }
	   } else {
			if($this->data["scope"]==1){
				 $values = explode(",", $list);
				 for($i=0;$i<sizeof($values); $i++){
						$option = array();
					if(is_numeric($values[$i])){
					   $option["caption"]=$values[$i];
					   $option["value"]=$values[$i];
					   if($data["selected_value"] == $values[$i]){
							$option["selected"] = "yes";
					   }
					   $options[] = $option;
					} else {
					   list($start, $end) = explode("..", $values[$i]);
					   for($j=$start; $j<=$end; $j++){
                           $option = array();
						   $option["caption"]=$j;
						   $option["value"]=$j;
						   if($data["selected_value"] == $j){
								$option["selected"] = "yes";
						   }
						   $options[] = $option;
					   }
					}
				 }// for
				 $this->data["options"] = $options;
			}
	   }
   }

   /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
   function XmlControlOnRender(&$xmlWriter) {
		   parent::XmlControlOnRender($xmlWriter);
   }


   }// class
?>