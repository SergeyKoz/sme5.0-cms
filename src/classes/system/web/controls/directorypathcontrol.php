<?php
	$this->ImportClass("system.web.xmlcontrol","xmlcontrol");
/** DirectoryPathControl control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class DirectoryPathControl extends XmlControl {
		var $ClassName = "DirectoryPathControl";
		var $Version = "1.0";
		/**   File storage
		* @var 		object    $_fileStorage
		*/
		var $_fileStorage;

   /**
   * Method executes on colntrol load to  the parent
   * @access		public
   */
		function ControlOnLoad() {
			@$this->_fileStorage = &$this->Page->_fileStorage;
		}
   /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
		function XmlControlOnRender(&$xmlWriter) {
			$xmlWriter->WriteStartElement("folder");
			$xmlWriter->WriteAttributeString("description", "ROOT");
			$xmlWriter->WriteEndElement();
			if (strlen($this->_fileStorage->LocalPath)) {
				$curPath = "";
				$parts = preg_split("~".DIRECTORY_SEPARATOR_CHAR."~", $this->_fileStorage->LocalPath);
				for ($i = 0; $i < count($parts); $i++) {
					if (!strlen($parts[$i]))
						continue;
					if (strlen($curPath))
						$curPath .= "/";
					$curPath .= $parts[$i];
					$xmlWriter->WriteStartElement("folder");
					$xmlWriter->WriteAttributeString("description", $parts[$i]);
					$xmlWriter->WriteString(urldecode($curPath));
					$xmlWriter->WriteEndElement();
				}
			}
		}
	}
?>