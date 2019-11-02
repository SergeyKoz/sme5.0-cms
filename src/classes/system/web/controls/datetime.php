<?php
  $this->ImportClass("system.web.controls.select","selectcontrol");

/** DateTime control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class DateTimeControl extends SelectControl {
		var $ClassName = "DateTimeControl";
		var $Version = "1.0";
        /**
          * Initialization data array
          * structure:
          *           <ul>
          *           <li> <b>name</b>      - control name
          *           <li> <b>fulldate</b>  - control full date flag
          *           <li> <b>value</b>     - control value ( if full date format "Y-m-d h:I:s" else "Y-m-d"
          *           <li> <b>caption</b>   - control caption
          *           </ul>
          * @var    array   $data
          **/
          var $data = array();

          var $yearsBeforeCurrent=20;
          var $yearsAfterCurrent=10;
	/**
		* Method sets initial data for control
		*  @param 	array	$data	Array with initial data
		*  @access public
		*/
		function InitControl($data=array()){
		    $this->data = $data;

		if($this->data["value"]!="")
		{
		   if($this->data["mask"]==""){
			  $this->data["mask"]="Y,m,d";
		   }
		   //echo $this->data["mask"];
		   $_tmp = $this->data["value"];
		   list($_tmp, $_ttmp) = explode(" ", $_tmp);

		   $this->data["year"]=array();
		   $this->data["year"]["visible"] = true;

		   $this->data["month"]=array();
		   $this->data["month"]["visible"] = true;


		   $this->data["day"]=array();
		   $this->data["day"]["visible"] = true;

		   $this->data["year"]["value"] = substr($_tmp,0,4);
		   $this->data["month"]["value"] = substr($_tmp,5,2);
		   $this->data["day"]["value"] = substr($_tmp,8,2);
		   if(($_ttmp != "") || ($this->data["fulldate"]==1)){
			   $this->data["hours"]=array();
			   $this->data["hours"]["visible"] = true;
			   $this->data["minutes"]=array();
			   $this->data["minutes"]["visible"] = true;
			   $this->data["seconds"]=array();
			   $this->data["seconds"]["visible"] = true;

			   $this->data["hours"]["value"] = substr($_ttmp,0,2);
			   $this->data["minutes"]["value"] = substr($_ttmp,3,2);
			   $this->data["seconds"]["value"] = substr($_ttmp,6,2);

		   }


		}
		else{
		if(!is_array($this->data["year"])){
		   $_tmp = $this->data["year"];
		   $this->data["year"] = array();
		   $this->data["year"]["visible"] = true;
		   $this->data["year"]["value"] = ($_tmp=="" ? date("Y", time()):$_tmp);
		}
		if(!is_array($this->data["month"])){
		   $_tmp = $this->data["month"];
		   $this->data["month"] = array();
		   $this->data["month"]["visible"] = true;
		   $this->data["month"]["value"] = ($_tmp=="" ? date("m", time()):$_tmp);
		}
		if(!is_array($this->data["day"])){
		   $_tmp = $this->data["day"];
		   $this->data["day"] = array();
		   $this->data["day"]["visible"] = true;
		   $this->data["day"]["value"] = ($_tmp=="" ? date("d", time()):$_tmp);
		}
		   if($this->data["fulldate"]==1){

			if(!is_array($this->data["hours"])){
			   $_tmp = $this->data["hours"];
			   $this->data["hours"] = array();
			   $this->data["hours"]["visible"] = true;
			   $this->data["hours"]["value"] = ($_tmp=="" ? date("H", time()):$_tmp);
			}
			if(!is_array($this->data["minutes"])){
			   $_tmp = $this->data["minutes"];
			   $this->data["minutes"] = array();
			   $this->data["minutes"]["visible"] = true;
			   $this->data["minutes"]["value"] = ($_tmp=="" ? date("i", time()):$_tmp);
			}
			if(!is_array($this->data["seconds"])){
			   $_tmp = $this->data["seconds"];
			   $this->data["seconds"] = array();
			   $this->data["seconds"]["visible"] = true;
			   $this->data["seconds"]["value"] = ($_tmp=="" ? date("s", time()):$_tmp);
			}
		   }
		}

		}
		/**
		* Method draws year xml-content of control
		* @param   XMLWriter    $xmlWriter	XMLWriter Instance
		* @param   int          $data		Value
		*
		*/
		function  XwlWriteYear(&$xmlWriter, $data=0)  {
		  if($data == "")$data = date("Y", time());
		  $xmlWriter->WriteStartElement("years");
		  $xmlWriter->WriteElementString("name", $this->data["name"]);
		  $today = date("Y");
		   for($i=$today-$this->yearsBeforeCurrent; $i<=$today+$this->yearsAfterCurrent; $i++) {
			  $xmlWriter->WriteStartElement("year");
				 if($data == $i)  {
					$xmlWriter->WriteAttributeString("selected", "yes");
				 }
				 $xmlWriter->WriteString($i);
			  $xmlWriter->WriteEndElement();
		   }
		  $xmlWriter->WriteEndElement();
		}
		/**
		* Method draws month xml-content of control
		* @param   XMLWriter    $xmlWriter	XMLWriter Instance
		* @param   int          $data		Value
		*
		*/
		function  XwlWriteMonth(&$xmlWriter, $data=0)  {
		  if($data == "")$data = date("n", time());
		  $xmlWriter->WriteStartElement("months");
		  $xmlWriter->WriteElementString("name", $this->data["name"]);
		  for($i=1; $i<=12; $i++) {
				  $xmlWriter->WriteStartElement("month");
					 if($data == $i)  {
						$xmlWriter->WriteAttributeString("selected", "yes");
					 }
					 $xmlWriter->WriteString(($i< 10 ?"0".$i:$i));
				  $xmlWriter->WriteEndElement();
			   }
		  $xmlWriter->WriteEndElement();
		}
		/**
		* Method draws day xml-content of control
		* @param   XMLWriter    $xmlWriter	XMLWriter Instance
		* @param   int          $data		Value
		*
		*/
		function  XwlWriteDay(&$xmlWriter, $data=0)  {
		  if($data == "")$data = date("j", time());
		  $xmlWriter->WriteStartElement("days");
		  $xmlWriter->WriteElementString("name", $this->data["name"]);
			   for($i=1; $i<=31; $i++) {
				  $xmlWriter->WriteStartElement("day");
					 if($data == $i)  {
						$xmlWriter->WriteAttributeString("selected", "yes");
					 }
					 $xmlWriter->WriteString(($i< 10 ?"0".$i:$i));
				  $xmlWriter->WriteEndElement();
			   }
		  $xmlWriter->WriteEndElement();
		}
		/**
		* Method draws hour xml-content of control
		* @param   XMLWriter    $xmlWriter	XMLWriter Instance
		* @param   int          $data		Value
		*
		*/
		function  XwlWriteHour(&$xmlWriter, $data=0)  {
		  if($data == "")$data = date("H", time());
		  $xmlWriter->WriteStartElement("hours");
		  $xmlWriter->WriteElementString("name", $this->data["name"]);
			   for($i=0; $i<24; $i++) {
				  $xmlWriter->WriteStartElement("hour");
					 if($data == $i)  {
						$xmlWriter->WriteAttributeString("selected", "yes");
					 }
					 $xmlWriter->WriteString(($i< 10 ?"0".$i:$i));
				  $xmlWriter->WriteEndElement();
			   }
		  $xmlWriter->WriteEndElement();
		}
		/**
		* Method draws minutes xml-content of control
		* @param   XMLWriter    $xmlWriter	XMLWriter Instance
		* @param   int          $data		Value
		*
		*/
		function  XwlWriteMinute(&$xmlWriter, $data=0)  {
		  if($data == "")$data = date("i", time());
		  $xmlWriter->WriteStartElement("minutes");
		  $xmlWriter->WriteElementString("name", $this->data["name"]);
			   for($i=0; $i<60; $i++) {
				  $xmlWriter->WriteStartElement("minute");
					 if($data == $i)  {
						$xmlWriter->WriteAttributeString("selected", "yes");
					 }
					 $xmlWriter->WriteString(($i< 10 ?"0".$i:$i));
				  $xmlWriter->WriteEndElement();
			   }
		  $xmlWriter->WriteEndElement();
		}
		/**
		* Method draws seconds xml-content of control
		* @param   XMLWriter    $xmlWriter	XMLWriter Instance
		* @param   int          $data		Value
		*
		*/
		function  XwlWriteSecond(&$xmlWriter, $data=0)  {
		  if($data == "")$data = date("s", time());
		  $xmlWriter->WriteStartElement("seconds");
		  $xmlWriter->WriteElementString("name", $this->data["name"]);
			   for($i=0; $i<60; $i++) {
				  $xmlWriter->WriteStartElement("second");
					 if($data == $i)  {
						$xmlWriter->WriteAttributeString("selected", "yes");
					 }
					 $xmlWriter->WriteString(($i< 10 ?"0".$i:$i));
				  $xmlWriter->WriteEndElement();
			   }
		  $xmlWriter->WriteEndElement();
		}

   /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
		function XmlControlOnRender(&$xmlWriter) {

		 $xmlWriter->WriteStartElement("datetime");
		  $this->WriteLanguageVersion($xmlWriter);
			 $this->XmlGetErrorFields($xmlWriter);
			$xmlWriter->WriteElementString("name", $this->data["name"]);
			if($this->data["notnull"])
			$xmlWriter->WriteElementString("notnull", $this->data["notnull"]);
			if($this->data["error_field"])
			$xmlWriter->WriteElementString("error_field", $this->data["error_field"]);
			if($this->data["disabled"])
			$xmlWriter->WriteElementString("disabled", $this->data["disabled"]);
			if($this->data["caption"])
			$xmlWriter->WriteElementString("caption", $this->data["caption"]);
		   if($this->data["year"]["visible"])  {
			  $this->XwlWriteYear($xmlWriter, $this->data["year"]["value"]);
		   }
		   if($this->data["month"]["visible"])  {
			  $this->XwlWriteMonth($xmlWriter, $this->data["month"]["value"]);
		   }
		   if($this->data["day"]["visible"])  {
			  $this->XwlWriteDay($xmlWriter, $this->data["day"]["value"]);
		   }
		   if($this->data["hours"]["visible"])  {
			  $this->XwlWriteHour($xmlWriter, $this->data["hours"]["value"]);
		   }
		   if($this->data["minutes"]["visible"])  {
			  $this->XwlWriteMinute($xmlWriter, $this->data["minutes"]["value"]);
		   }
		   if($this->data["seconds"]["visible"])  {
			  $this->XwlWriteSecond($xmlWriter, $this->data["seconds"]["value"]);
		   }
		 $xmlWriter->WriteEndElement();
   }

 }// class
