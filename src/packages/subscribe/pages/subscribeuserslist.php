<?php
	$this->ImportClass("web.listpage", "ListPage");
	/**
	* Example class for  list pages.
	* @author Artem Mikhmel <amikhmel@activemedia.com.ua>
	* @version 1.0
	* @package        Libraries
	* @subpackage pages
	* @access public
	**/
	class SubscribeUsersListPage extends ListPage {
		// Class name
		var $ClassName = "SubscribeUsersListPage";
		// Class version
		var $Version = "1.0";
		/**    Self page name
		* @var     string     $self
		*/
		var $self="subscribeuserslist";

		/**    HAndler page name
		* @var     string     $handler
		*/
		var $handler="subscribeusersedit";

		var $listcontrol="subscribeadminlistcontrol";

		var $XslTemplate="itemslist";

	}
?>