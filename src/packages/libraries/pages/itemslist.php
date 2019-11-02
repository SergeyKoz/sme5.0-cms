<?php
	$this->ImportClass("web.listpage", "ListPage");
	/**
	 * Example class for  list pages.
	 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	 * @version 1.0
	 * @package	Libraries
	 * @subpackage pages
	 * @access public
	 **/
	class ItemsListPage extends ListPage {
		// Class name
		var $ClassName = "ItemsListPage";
		// Class version
		var $Version = "1.0";
		/**    Self page name
		* @var     string     $self
		*/
		var $self="itemslist";
		/**    HAndler page name
		* @var     string     $handler
		*/
		var $handler="itemsedit";

}
?>