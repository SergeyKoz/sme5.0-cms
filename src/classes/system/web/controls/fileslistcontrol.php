<?php
	$this->ImportClass("system.web.xmlcontrol","xmlcontrol");
/** FilesListControl control
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package Framework
	 * @subpackage classes.system.web.controls
	 * @access public
	 */
	class FilesListControl extends XmlControl {
		var $ClassName = "FilesListControl";
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
			$files = $this->_fileStorage->GetFiles();
			$localPath = $this->_fileStorage->LocalPath;
			foreach ($files as $file) {
				$xmlWriter->WriteStartElement("file");
				$xmlWriter->WriteAttributeString("description", $file);
				$xmlWriter->WriteAttributeString("md5filename", md5($file));
				$xmlWriter->WriteString($localPath . $file);
				$xmlWriter->WriteEndElement();
			}
		}
	}
?>