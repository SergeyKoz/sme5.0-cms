<?php

 /**
     * Session handling class
     * @author Sergey Grishko <sgrishko@reaktivate.com>
     * @version 1.0
     * @package Framework
     * @subpackage classes.module.web
     * @access public
     **/
     
class ControlSession {
    //Session name
    var $SessionName;
    //Session data array
    var $SessionData = array();
    //Cookie name
    var $CookieName = "session_id";
    //Flag of change session data
    var $_IS_DATA_CHANGE = false;
    //Table object
    var $_table;
    //Page object
    var $_page;
  //Class data array
    var $_data;

   /**
     * Class constructor
     *@param  int       pointer to page class
     *@param  string  name of cookie
     */
    function ControlSession(&$page, $CookieName) {
        session_start();
        if ($CookieName)
            $this->CookieName = $CookieName;
    
        @$this->_page = $page;
        $this->SessionName = session_id();//$page->Request->Value($this->CookieName, REQUEST_COOKIES);

    }

 /**
     * Method get session variable value
     * @param       string    name of variable
     * @return  mixed    variable value
     * @access  public
     */
    function Get($name) {
        $result = "";
        if (isset($this->SessionData[$name])){
            $result = $this->SessionData[$name];
        } else {        
        
        //global $_SESSION;
        $result = $_SESSION[$name];
        }
        return $result;
    }

 /**
     * Method set session variable value
     * @param       string    name of variable
     * @param   mixed       value of variable
     * @access  public
     */
    function Set($name, $value) {
        $this->SessionData[$name] = $value;
        $this->_IS_DATA_CHANGE = true;
        //global $_SESSION;
        $_SESSION[$name]=$value;
    }

   /**
     * Method get session ID
     * @return      string      Session ID
     * @access public
     **/
   function SessionID() {
      return $this->SessionName;
   }

 /**
     * Method remove variable from session
     * @param       string    name of variable
     * @access  public
     */
    function Remove($name) {
        unset($this->SessionData[$name]);
        $this->_IS_DATA_CHANGE = true;
    }

 /**
     * Method close session
     * @access  public
     */
    function Close() {
        if ($this->_IS_DATA_CHANGE) {
            if (count($this->_data)) {
                $this->_data["SessionData"] = serialize($this->SessionData);
                //$this->_table->Update($this->_data);
            }
            else {
                $this->_data["SessionName"] = $this->SessionName;
                $this->_data["RemoteAddr"] = $this->_page->Request->Value("REMOTE_ADDR", REQUEST_SERVERVARIABLES);
                $this->_data["SessionTime"] = AbstractTable::FormatDateTime(time());
                $this->_data["SessionData"] = serialize($this->SessionData);
                //$this->_table->Insert($this->_data);
            }
        }
    }


 /**
     * Method delete session data from database
     * @access  public
     */
    function Delete() {
        if (count($this->_data)) {
            //$this->_table->Delete($this->_data);
            $this->_data = array();
        }
        setcookie($this->CookieName);
    }
    /**
     * Method destroy session
     * @access  public
     */
    function Destroy()  {
        session_destroy();
    }    
}
?>