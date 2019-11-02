<?php
  $this->ImportClass("web.listpage", "ListPage");
  /**
   * Press-releases  list page
   * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
   * @version 1.0
   * @package  Libraries
   * @access public
   **/
  class PollsAdminListPage extends ListPage {
    // Class name
    var $ClassName = "PollsAdminListPage";
    // Class version
    var $Version = "1.0";
    /**    Self page name
    * @var     string     $self
    */
    var $self="pollsadminlist";
    /**    HAndler page name
    * @var     string     $handler
    */
    var $handler="pollsadminedit";
    var $XslTemplate="itemslist";

  /**  Access to this page roles
   * @var     array     $access_role_id
   **/
    var $access_role_id = array("ADMIN","CONTENT_MANAGER", "CONTENT_EDITOR");


 }
?>