<?php
  $this->ImportClass("system.web.controls.textarea","textareacontrol");

/** HtmlEditorControl control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package  Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class HtmlEditorControl extends TextAreaControl {
		var $ClassName = "HtmlEditorControl";
		var $Version = "1.0";
         /**
          * Initialization data array
          * structure:
          *           <ul>
          *           <li> <b>name</b>           - control name
          *           <li> <b>content</b>        - field content
          *           <li> <b>maxlength</b>      - field max length
          *           <li> <b>caption</b>        - field caption
          *           <li> <b>rows</b>           -  textarea rows number
          *           <li> <b>cols</b>           -  textarea columns number
          *           </ul>
          * @var    array   $data
          **/
          var $data = array();
  /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
		function XmlControlOnRender(&$xmlWriter) {
		 if($this->data["cols"]==""){
			 if($this->Page->Kernel->Settings->HasItem($this->Page->ClassName, "Textarea_cols_".$this->data["name"])){
				$this->data["cols"] = $this->Page->Kernel->Settings->GetItem($this->Page->ClassName, "Textarea_cols_".$this->data["name"]);
			 } else {
				$this->data["cols"] = $this->Page->Kernel->Settings->GetItem("MAIN", "Textarea_cols");
			 }
		 }
		 if($this->data["rows"]==""){
			 if($this->Page->Kernel->Settings->HasItem($this->Page->ClassName, "Textarea_rows_".$this->data["name"])){
				$this->data["rows"] = $this->Page->Kernel->Settings->GetItem($this->Page->ClassName, "Textarea_rows_".$this->data["name"]);
			 } else {
				$this->data["rows"] = $this->Page->Kernel->Settings->GetItem("MAIN", "Textarea_rows");
			 }
		 }

		 $xmlWriter->WriteStartElement("htmleditor");
		  $this->WriteLanguageVersion($xmlWriter);
			 $this->XmlGetErrorFields($xmlWriter);
			$_keys = array_keys($this->data);
			for($i=0; $i<sizeof($_keys); $i++)
			   {
				  $xmlWriter->WriteStartElement($_keys[$i]);
					   $xmlWriter->WriteString($this->data[$_keys[$i]]);
				  $xmlWriter->WriteEndElement();
			   }

		 $xmlWriter->WriteEndElement();


   }


   }// class
?>