<?php
  $this->ImportClass("system.web.controls.form","formcontrol");

/** File control
     * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
	 * @version 1.0
     * @package	Framework
     * @subpackage classes.system.web.controls
     * @access public
     */
    class FileControl extends FormControl {
		var $ClassName = "FileControl";
        var $Version = "1.0";

        /**
          * Initialization data array
          * structure:
          *           <ul>
          *           <li> <b>name</b>           - control name
          *           <li> <b>value</b>          - control value
          *           <li> <b>directory</b>      - relative path to current directory
          *           <li> <b>caption</b>        - field caption
          *           </ul>
          * @var    array   $data
          **/
          var $data = array();

 /**
    * Method sets initial data for control
    *  @param   array  $data  Array with initial data
    *  @access public
    */
    function SetData($data=array())
    {
      FormControl::SetData($data);
      $this->setControlParameter("size","Text_size",$data["size"]);
    }

 /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   **/
   function XmlControlOnRender(&$xmlWriter) {
		if (!(DataDispatcher::Get("tiny_filemanager_use")==1)){
			DataDispatcher::Set("tiny_filemanager_use", 1);
			$Settings=&$this->Page->Kernel->Settings;
			$tinymce_settings=$Settings->GetSection("TINYMCE");
			$this->data["tiny_url"]=$tinymce_settings["Dir"];
			if (!isset($_SESSION["TINY"])){
				$RootPath=$Settings->GetItem("Settings","FileStoragePath");
				$_SESSION["TINY"]["filesystem.rootpath"]=$RootPath;
				$_SESSION["TINY"]["filesystem.path"]=$RootPath;
				$_SESSION["TINY"]["preview.urlprefix"]=$Settings->GetItem("Settings","FileStorageURL");
				$_SESSION["TINY"]["preview.wwwroot"]=$RootPath;

				$_SESSION["isLoggedInSME"]=$this->Page->Auth->UserId>0;
			}
		}


         $xmlWriter->WriteStartElement("file");
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