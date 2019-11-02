<?php

/** Class represents web control
* @author Sergey Grishko <sgrishko@reaktivate.com>
* @modified Artem Mikhmel <amikhmel@activemedia.com.ua>
* @version 1.0
* @package Framework
* @subpackage classes.system.web
* @access public
*/

/** @const WEB_CONTROL_CONSTRUCTED WEB CONTROL CONSTRUCTED Flag*/
define("WEB_CONTROL_CONSTRUCTED", 1);
/** @const WEB_CONTROL_INITIALIZED WEB CONTROL INITIALIZED Flag*/
define("WEB_CONTROL_INITIALIZED", 2);
/** @const WEB_CONTROL_LOADED WEB CONTROL LOADED Flag*/
define("WEB_CONTROL_LOADED", 3);

class Control extends Component {
    // Class information
    var $ClassName = "Control";
    var $Version = "1.0";

    // Public fields
    /**
    *Control name
    * @var string $Name
    * @access   public
    **/
    var $Name;

    /**
    * Child controls array
    * @var array $Controls
    * @access   public
    **/
    var $Controls = array();

    /**
    * Parent page object
    * @var Page $Page
    * @access   public
    **/
    var $Page = null;

    /**
    * Parent control
    * @var Control $Parent
    * @access   public
    **/
    var $Parent = null;


    // Private fields
    /**
    * Control state (see WEB_CONTROL constants)
    * @var int  $_state
    * @access   private
    **/
    var $_state = WEB_CONTROL_CONSTRUCTED;

    /**
    * Constructor. Initializes a new instance of the Control class.
    * @param       string      $name   Name of web control
    * @access public
    */
    function Control($name = "") {
        $this->Name = $name;
        $this->_state = WEB_CONTROL_CONSTRUCTED;
    }

    /**
    * Method Adds the specified Control object to the controls collection.
    * @param       (object structure)    $name   Object instance
    * @access public
    */
    function AddControl(&$object) {
        if (!is_object($object))  {
            return;
        }
        //if (is_object($object->Parent))
        //$object->Parent->RemoveControl($object);
        $object->Parent = &$this;
        $object->Page = &$this->Page;
        @$this->Controls[$object->Name] = &$object;
        if ($this->_state >= WEB_CONTROL_INITIALIZED) {
            $object->initRecursive();
            if ($this->_state >= WEB_CONTROL_LOADED)
            $object->loadRecursive();
        }
    }

    /**
    * Method Removes the specified Control object from the controls collection.
    * @param       (object structure)    $name   Object instance
    * @access public
    */
    function RemoveControl(&$object) {

    	//echo 'here';

        if (!is_object($object) || !is_object($this->FindControl($object->Name)))
        return;
        unset($object->Parent);
        unset($this->Controls[$object->Name]);
    }

    /**
    * Method finds control by its name
    * @param     string   $name   Object name
    * @return    mixed    Object instance on success, null otherwise
    * @access public
    */
    function &FindControl($controlName) {
        if (isset($this->Controls[$controlName]))
        return $this->Controls[$controlName];
        if ($this->HasControls()) {
            $keys = array_keys($this->Controls);
            for ($i = 0; $i < count($this->Controls); $i++) {
                @$control = &$this->Controls[$keys[$i]];
                if ($control->HasControls()) {
                    @$result = &$control->FindControl($controlName);
                    if (is_object($result))
                    return $result;
                }
            }
        }
        return null;
    }
    /**
    * Method checks if Instance has controls
    * @return    bool   True if has, false orherwise
    * @access public
    */
    function HasControls() {
        return (count($this->Controls) > 0);
    }


    /**
    * Method Processes recursive load of control and all of it's children.
    * @access private
    */
    function createChildrenRecursive() {
        $this->CreateChildControls();
        if ($this->HasControls()) {
            $keys = array_keys($this->Controls);
            $count = count($this->Controls);
            for ($i = 0; $i < $count; $i++) {
                @$control = &$this->Controls[$keys[$i]];
                $control->createChildrenRecursive();
            }
        }
        $this->initChildrenRecursive();
    }
    /**
    * Method Processes recursive set  of control data and all of it's children.
    * @access private
    **/
    function    initChildrenRecursive()  {
        $this->initChildControls();
        if ($this->HasControls()) {
            $keys = array_keys($this->Controls);
            $count = count($this->Controls);
            for ($i = 0; $i < $count; $i++) {
                @$control = &$this->Controls[$keys[$i]];
                $control->initChildrenRecursive();
            }
        }

    }
    /**
    * Method Processes recursive initialization of control and all of it's children.
    * @access private
    */
    function initRecursive() {
        if ($this->HasControls()) {
            $keys = array_keys($this->Controls);
            $count = count($this->Controls);
            for ($i = 0; $i < $count; $i++) {
                @$control = &$this->Controls[$keys[$i]];
                @$control->Page = &$this->Page;
                $control->initRecursive();
            }
        }
        $this->_state = WEB_CONTROL_INITIALIZED;
        $this->ControlOnInit();
    }

    /**
    * Method Processes recursive load of control and all of it's children.
    * @access private
    */
    function loadRecursive() {
        $this->ControlOnLoad();
        if ($this->HasControls()) {
            $keys = array_keys($this->Controls);
            $count = count($this->Controls);
            for ($i = 0; $i < $count ; $i++) {
                @$control = &$this->Controls[$keys[$i]];
                $control->loadRecursive();
            }
        }
        $this->_state = WEB_CONTROL_LOADED;
    }

    /**
    * Method Processes recursive unload of control and all of it's children.
    * @access private
    */
    function unloadRecursive() {
        if ($this->HasControls()) {
            $keys = array_keys($this->Controls);
            for ($i = 0; $i < count($this->Controls); $i++) {
                @$control = &$this->Controls[$keys[$i]];
                if(method_exists($control, "unloadRecursive")){
                    $control->unloadRecursive();
                }
                $control=null;
            }
        }
        $this->ControlOnUnload();
        $this->Controls=array();
    }

    /**
    * Method Processes events management of control and all of it's children.
    * @param   mixed     $Event    Event name or array of Events
    * @access private
    */
    function manageEventsRecursive($Event) {
        if ($Event)  {
            if (!is_array($Event)) $Event=array($Event);
            foreach ($Event as $key => $eventName)  {
                $methodName="On".$eventName;


                if (method_exists($this,$methodName)) {
                    $this->$methodName();
                    //return true;
                }
                if ($this->HasControls()) {
                    $keys = array_keys($this->Controls);
                    $count=  count($this->Controls);
                    for ($i = 0; $i < $count; $i++) {
                        @$control = &$this->Controls[$keys[$i]];
                        if ($control->manageEventsRecursive($eventName))  return true;
                    }
                }
                return false;
            }
        }
    }

    /**
    *   Notifies server controls that use composition-based implementation to
    *   create any child controls they contain in preparation for posting back
    *   or rendering.
    * @access public
    *
    *
    **/
    function CreateChildControls() {
    }

    /**
    *   Notifies server controls that use composition-based implementation to
    *   set data to child controls they contain in preparation for posting back
    *   or rendering.
    *  @access public
    *
    *
    **/
    function InitChildControls() {
    }
    /** Handles the OnInit event
    *  @access public
    */
    function ControlOnInit() {
    }

    /** Handles the OnLoad event
    *  @access public
    */
    function ControlOnLoad() {
    }

    /** Handles the OnUnload event
    * @access public
    */
    function ControlOnUnload() {
    }

    /** Sends server control content, which will be rendered on the client.
    *  @access public
    */
    function RenderChildren() {
        if ($this->HasControls()) {
            foreach($this->Controls as $control) {
                $control->Render();
            }
        }
    }

    /**
    * Sends server control content, which will be rendered on the client.
    *  @access public
    */
    function Render() {
        $this->RenderChildren();
    }

    function BuildImportClassName($name, $pattern="system.web.controls.template.%scontrol"){
        return sprintf($pattern, $name);
    }

}
?>