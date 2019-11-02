<?php
	$this->ImportClass("system.web.xmlcontrol","xmlcontrol");
/** DirectoriesListControl control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class DirectoriesListControl extends XmlControl {
		var $ClassName = "DirectoriesListControl";
		var $Version = "1.0";
		/**   File storage
		* @var 		object    $_fileStorage
		*/
		var $_fileStorage;
   /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
		function XmlControlOnRender(&$xmlWriter) {

			$dirs = $this->_fileStorage->GetDirectories();
			$localPath = $this->_fileStorage->LocalPath;
			foreach ($dirs as $dir) {
				$xmlWriter->WriteStartElement("folder");
				$xmlWriter->WriteAttributeString("description", $dir);
				$xmlWriter->WriteAttributeString("path", $localPath . $dir);
				$xmlWriter->WriteAttributeString("quoted", addslashes($localPath . $dir));
				$xmlWriter->WriteString(urlencode($localPath . $dir));
				$xmlWriter->WriteEndElement();
				
			}			
		}

   /**
   * Method executes on colntrol load to  the parent
   * @access		public
   */
		function ControlOnLoad() {
			@$this->_fileStorage = &$this->Page->_fileStorage;
		}
	}	
?>