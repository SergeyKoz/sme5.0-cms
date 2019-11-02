<?php
$this->ImportClass("system.web.controls.listcontrol", "ListControl");
$this->ImportClass("system.web.controls.link", "LinkControl");
$this->ImportClass("system.web.controls.text", "TextControl");
$this->ImportClass("system.web.controls.graphicprice", "GraphicPriceControl");
$this->ImportClass("system.web.controls.checkbox", "CheckboxControl");
$this->ImportClass("system.web.controls.radio", "RadioControl");
$this->ImportClass("system.web.controls.hidden", "HiddenControl");
$this->ImportClass("system.web.controls.file", "FileControl");
$this->ImportClass("system.web.controls.file2", "File2Control");
$this->ImportClass("system.web.controls.dbtext", "DbTextControl");
$this->ImportClass("system.web.controls.dbeditblock", "DbEditBlockControl");
$this->ImportClass("system.web.controls.dbtreepath", "DbTreePathControl");
$this->ImportClass("system.web.controls.navigationcontrol", "NavigationControl");
$this->ImportClass("system.web.controls.treeselectcontrol", "TreeSelectControl");
$this->ImportClass("system.web.controls.select", "SelectControl");

$this->ImportClass("system.data.abstracttable", "AbstractTable");
$this->ImportClass("web.listcontroldrawer", "ListControlDrawer");
$this->ImportClass("web.controls.listfilterformcontrol", "ListFilterControl");
$this->ImportClass("xml.xmlhelper", "XmlHelper");

/** List control
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package Libraries
 * @subpackage classes.web.controls
 * @access public
 */
class ItemsListControl extends XmlControl{
    var $ClassName = "ItemsListControl";
    var $Version = "1.0";
    /**    Data storage
     * @var   AbstractTable     $Storage
     */
    var $Storage;
    /**    Sorting order
     * @var   string     $order
     */
    var $order;
    /**    Sorting direction
     * @var   string     $attribute
     */
    var $attribute;
    /**    Fields array
     * @var   array     $fields
     */
    var $fields;
    /**    Navigator url
     * @var   string     $self
     */
    var $self;
    /**   Editor url
     * @var   string     $edit_url
     */
    var $edit_url;
    /**   Key field name
     * @var   string     $key_field
     */
    var $key_field;
    /**   Caption field name
     * @var   string     $caption_field
     */
    var $caption_field;
    /**   Parent field name
     * @var   string
     */
    var $start;
    /** Sorting order
     * @var string  $order_by
     */
    var $order_by;
    /** Library ID
     * @var string  $library_ID
     */
    var $library_ID;
    /** Host Library ID
     * @var string  $host_library_ID
     */
    var $host_library_ID;

    /**    Data selection array
     * @var   array     $data
     */
    var $data;
    /**    Data extractor user-defined function  name
     * @var   string     $data_extractor
     */
    var $data_extractor;
    /**    Flag if using external data exrtaction
     * @var   bool     $use_data_extractor
     */
    var $use_data_extractor;
    /**  Settings object
     * @var   ConfigFile     $listSettings
     */
    var $listSettings = null;
    /**   Multilevel flag
     * @var   bool   $multilevel
     */
    var $multilevel;
    /**   Name of field with parent index
     * @var  string
     */
    var $parent_field;
    /**   Value of parent ID
     * @var  int   $parent_id
     */
    var $parent_id;
    /**   Tree control
     * @var  object   $tree_control
     */
    var $tree_control;
    /**   Value of parent ID of upper level
     * @var  int   $upper_level_parent_id
     */
    var $upper_level_parent_id;
    /**   Flag defines if sub-categories is in use
     * @var  int   $use_sub_categories
     */
    var $use_sub_categories;
    /**   Flag defines if mega delete of all nodes enabled
     * @var  int   $mega_delete
     */
    var $mega_delete;
    /**   Flag defines if move of selected nodes enabled
     * @var  int   $node_move
     */
    var $node_move;
    /**   Number of subcategories
     * @var  int   $sub_categories_count
     */
    var $sub_categories_count;
    /**   Array with list of assosiated subcategories
     * @var  array   $sub_categories
     */
    var $sub_categories;
    /**   Value of custom variable passed to editor
     * @var  int   $custom_val
     */
    var $custom_val;
    /**   Name of custom variable passed to editor
     * @var  string   $custom_var
     */
    var $custom_var;
    /**   Custom query string for category identifying
     * @var  string   $custom_str
     */
    var $custom_str;
    /**   Inherited Move flag
     * @var  bool      $parent_move
     */
    var $parent_move;
    /**   Flag defines if delete of selected records enabled
     * @var  int   $disabled_delete
     */
    var $disabled_delete;
    /**   Flag defines if edit of selected records enabled
     * @var  int   $disabled_edit
     */
    var $disabled_edit;
    /**   Flag defines if add of selected records enabled
     * @var  int   $disabled_add
     */
    var $disabled_add;

    /**   Flag defines if view of selected records enabled
     * @var  int   $disabled_add
     */
    var $disabled_view;

    /**   Flag defines if apply of selected records enabled
     * @var  int   $disabled_add
     */
    var $disabled_apply;

    /**   Flag defines if copy of selected records enabled
     *   @var  int   $disabled_copy
     **/
    var $disabled_copy;

    /**   Flag defines if move of selected records enabled
     *   @var  int   $disabled_copy
     **/
    var $disabled_move;

    /**  Field used for move records
     *   @var  string    $move_field
     **/
    var $move_field = "";

    /**  Key field value of  a next list first record
     *   @var  int    $list_next_id
     **/
    var $list_next_id = 0;

    /**  Key field value of  a previous list last record
     *   @var  int    $list_prev_id
     **/
    var $list_prev_id = 0;

    /**   Flag defines readonly state for library
     *   @var  int   $read_only
     **/
    var $read_only;
    /**   Max nested level
     * @var  int   $max_node_level
     */
    var $max_node_level;
    /**   Flag shows if current level is the last
     * @var  bool   $is_last_level
     */
    var $is_last_level;
    /**  Array with node levels of current node
     * @var    array     $node_levels
     */
    var $node_levels;

    /**  String that will be appended to all hrefs
     * @var    string     $append_hrefs
     */
    var $append_hrefs = "";
    /**
     * Library icon file
     * @var string  $icon_file
     * @access public
     **/
    var $icon_file = "";

    /**
     * Use abstract table class as storage flag
     * @var boolean $use_abstracttable
     * @access public
     **/
    var $use_abstracttable = false;

    /** Constructor. Initializes a new instance of the Control class.
     * @param     string    $name   Name of  control
     * @param     string    $xmlTag  NAme of XML Tag
     * @param     object    $storage  Storage object
     * @access    public
     */
    var $disable_tree_select = true;

    function ItemsListControl($name, $xmlTag, &$storage){
        parent::XmlControl($name, $xmlTag, null);
        @$this->Storage = &$storage;
    }
    /**
     * Method initialize data for control
     *  @param   array   $data   Initial data
     * @access   public
     */
    function InitControl($data=array())
    {
        $this->LibrariesRoot = $this->Page->Kernel->Package->Settings->GetItem("main", "LibrariesRoot");

        if (! isset($data["host_library_ID"]))
            $data["host_library_ID"] = "";
        $this->library_ID = $data["library_ID"];
        $this->host_library_ID = $data["host_library_ID"];
        $this->data = $data["data"];
        if (empty($this->data)) {
            $this->data = null;
        }
        $this->data_extractor = $data["data_extractor"];
        $this->use_data_extractor = (strlen($this->data_extractor) && method_exists($this->Storage, $this->data_extractor));
        $this->self = $data["self"];
        if (! isset($data["key_field"]))
            $data["key_field"] = "";
        $this->key_field = $data["key_field"];
        $this->handler = $data["handler"];
        $this->Package = $data["package"];
        if (! isset($data["extra_edit_url"]))
            $data["extra_edit_url"] = "";
        $this->edit_url = "?".($this->Package!="" ? "package=".$this->Package."&amp;" : "")."page=" . $this->handler . "&amp;event=EditItem" . $data["extra_edit_url"];
        $this->start = $data["start"];
        $this->order_by = $data["order_by"];
        $this->parent_id = $data["parent_id"];
        $this->tree_control = &$data["tree_control"];
        //$this->parent_move = (is_object($this->tree_control) ? 1 : 0);
        $this->append_hrefs = rawurldecode($data["append_hrefs"]);
        $this->custom_var = $data["custom_var"];
        $this->custom_val = $data["custom_val"];
        $this->custom_str = (strlen($this->custom_var) && strlen($this->custom_val) ? "&amp;custom_var=" . $this->custom_var . "&amp;custom_val=" . $this->custom_val : "");
        if (strlen($data["RPP"])) {
            $this->_RPP = $data["RPP"];
        }
        $this->_RPP = $this->Page->_RPP;
        if (strlen($data["PPD"])) {
            $this->_RPP = $data["PPD"];
        }
        //Set page title
        if (! $this->Page->Kernel->Localization->HasItem($this->Page->ClassName, "_PageTitle")) {
            if ($this->Page->Kernel->Localization->HasItem($this->library_ID, "_LIST_TITLE")) {
                $title = $this->Page->Kernel->Localization->GetItem($this->library_ID, "_LIST_TITLE");
                $this->Page->Kernel->Localization->SetItem($this->Page->ClassName, "_PageTitle", $title);
            }
        }
        $this->GetLibraryData();
        if ($this->multilevel) {
            $this->data[$this->parent_field]=$this->parent_id;
        }
        $this->sectionname = strtoupper($this->library_ID);
        if (! $this->error) {
            $this->PrepareData();
        }
        $this->CheckLibraryAccess();
    }

    /**
     * Method adds error messages
     * @param      string      $item_id    Error ID
     * @param      array       $data       Additional data for error description
     * @access     public
     */
    function AddListErrorMessage($item_id, $data = array())
    {
        $message = $this->Page->AddErrorMessage("LIBRARY", $item_id, array_merge(array(
            $this->library_ID
        ), $data), false, true);
        user_error($message, E_USER_ERROR);
        //$this->error++;
    }
    /**
     * Method returns subcategories if use_sub_categories flag is on
     * @return     mixed    false on error or no subcategories or array of subcategories otherwise
     * @access     public
     */
    function GetSubCategories()
    {
        if (($this->multilevel && ! $this->use_sub_categories) || ! sizeof($this->sub_categories) || $this->error || ! $this->multilevel) {
            return false;
        }
        else {
            return $this->sub_categories;
        }

    }
    /**
     * Method returns Treecontrol object to insert into other lists
     * @return      SelectTreeControl    Treecontrol object to insert into other lists
     * @access      public
     */
    function GetTreeControl()
    {
        return $this->FindControl("destination_nodes");
    }

    /**
     * Method returns array with levels of nodes from root to current
     * @return      array    array with levels of nodes from root to current
     * @access      public
     */
    function GetNodeLevels()
    {
        return $this->node_levels;
    }
    /**
     * Method appends extra data to self-string (for adding sorting orders of sub_categories)
     * @access public
     */
    function AppendSelfString($str)
    {
        $this->self .= $str;
    }
    /**
     * Method processes LIST get-data of library config
     * @access   public
     */
    function ProcessListGetData()
    {
        if ($this->listSettings->HasItem("LIST", "GET_DATA_FIELDS") && $this->listSettings->HasItem("LIST", "GET_DATA_VALUES")) {
            $data_fields = $this->listSettings->GetItem("LIST", "GET_DATA_FIELDS");
            if (! is_array($data_fields)) {
                $data_fields = array(
                    $data_fields
                );
            }
            $data_values = $this->listSettings->GetItem("LIST", "GET_DATA_VALUES");
            if (! is_array($data_values)) {
                $data_values = array(
                    $data_values
                );
            }

            for ($c = 0; $c < sizeof($data_fields); $c ++) {
                if (strpos($data_values[$c], "REQUEST:") === 0) {
                    $data_values[$c] = Request::Value(substr($data_values[$c], strlen("REQUEST:"), strlen($data_values[$c])));
                }
                if (strpos($data_values[$c], "|") !== false)
                    $data_values[$c] = explode("|", $data_values[$c]);

                if (! is_array($data_values[$c])) {
                    $this->data[sprintf($data_fields[$c], $this->Page->Kernel->Language)] = sprintf($data_values[$c], $this->Page->Kernel->Language);
                }
                else {
                    if (! empty($data_values[$c])) {
                        foreach ($data_values[$c] as $value) {
                            $this->data[sprintf($data_fields[$c], $this->Page->Kernel->Language)][] = sprintf($value, $this->Page->Kernel->Language);
                        }
                    }
                }
            }

        }
    }

    /**
     * Method processes LIST get-orders of library config
     * @access   public
     */
    function ProcessListGetOrders()
    {
        if ($this->listSettings->HasItem("LIST" . $i, "GET_ORDERS")) {
            $_order_fields = $this->listSettings->GetItem("LIST" . $i, "GET_ORDERS");
            if (! is_array($_order_fields)) {
                $_order_fields = array(
                    $_order_fields
                );
            }
            for ($c = 0; $c < sizeof($_order_fields); $c ++) {
                list ($_orderfield, $_ordervalue) = preg_split("/ /", $_order_fields[$c]);
                $_get_orders[sprintf($_orderfield, $this->Page->Kernel->Language)] = sprintf($_ordervalue, $this->Page->Kernel->Language);
            }
            $this->list_orders = $_get_orders;
        }
        else {
            $this->list_orders = array();
        }
    }
    /**
     * Method processes LIST section of library config
     * @access   public
     * @return   int     Number of fields
     */
    function ProcessListSection()
    {
        if ($this->listSettings->HasItem("LIST", "FIELDS_COUNT")) {
            $fields_count = $this->listSettings->GetItem("LIST", "FIELDS_COUNT");
        }
        else {
            $this->AddListErrorMessage("EMPTY_RECORDCOUNT_SETTINGS");
        }

        if ($this->listSettings->HasItem("LIST", "PAGES_PER_DECADE")) {
            $this->_PPD = $this->listSettings->GetItem("LIST", "PAGES_PER_DECADE");
        }
        if (isset($this->Page->_RPP)) {
            $this->_RPP = $this->Page->_RPP;
        }
        else {
            $this->_RPP = $this->listSettings->GetItem("LIST", "RECORDS_PER_PAGE");
        }

        $this->ProcessListGetData();
        $this->ProcessListGetOrders();

        return $fields_count;
    }

    /**
     * Method processes MAIN list-extractor section of library config
     * @access   public
     */
    function ProcessListExtractors()
    {

        if ($this->listSettings->HasItem("MAIN", "LIST_EXTRACTOR_METHOD")) {
            $this->extractor_method = $this->listSettings->GetItem("MAIN", "LIST_EXTRACTOR_METHOD");
            $this->data_extractor = $this->extractor_method;
            $this->use_data_extractor = true;
        }
        else {
            $this->extractor_method = "GetList";
        }
        if ($this->listSettings->HasItem("MAIN", "LIST_COUNTER_METHOD")) {
            $this->counter_method = $this->listSettings->GetItem("MAIN", "LIST_COUNTER_METHOD");
            $this->data_counter = $this->counter_method;
            $this->use_data_counter = true;
        }
        else {
            $this->counter_method = "GetCount";
        }
    }

    /**
     * Method processes library permissions
     * @access   public
     */
    function ProcessLibraryPermissions()
    {
        if ($this->listSettings->HasItem("MAIN", "DISABLED_DELETE")) {
            $this->disabled_delete = $this->listSettings->GetItem("MAIN", "DISABLED_DELETE");
        }
        else {
            $this->disabled_delete = 0;
        }
        if ($this->listSettings->HasItem("MAIN", "DISABLED_VIEW")) {
            $this->disabled_view = $this->listSettings->GetItem("MAIN", "DISABLED_VIEW");
        }
        else {
            $this->disabled_view = 0;
        }
        if ($this->listSettings->HasItem("MAIN", "DISABLED_APPLY")) {
            $this->disabled_apply = $this->listSettings->GetItem("MAIN", "DISABLED_APPLY");
        }
        else {
            $this->disabled_apply = 0;
        }

        if ($this->listSettings->HasItem("MAIN", "DISABLED_EDIT")) {
            $this->disabled_edit = $this->listSettings->GetItem("MAIN", "DISABLED_EDIT");
        }
        else {
            $this->disabled_edit = 0;
        }
        if ($this->listSettings->HasItem("MAIN", "DISABLED_ADD")) {
            $this->disabled_add = $this->listSettings->GetItem("MAIN", "DISABLED_ADD");
        }
        else {
            $this->disabled_add = 0;
        }
        if ($this->listSettings->HasItem("MAIN", "DISABLED_COPY")) {
            $this->disabled_copy = $this->listSettings->GetItem("MAIN", "DISABLED_COPY");
        }
        else {
            $this->disabled_copy = 0;
        }

        if ($this->listSettings->HasItem("MAIN", "DISABLED_MOVE")) {
            $this->disabled_move = $this->listSettings->GetItem("MAIN", "DISABLED_MOVE");
        }
        else {
            $this->disabled_move = 1;
        }

        //-- if move records up or down not disabled
        if (! $this->disabled_move) {
            if ($this->listSettings->HasItem("MAIN", "MOVE_FIELD")) {
                $this->move_field = $this->listSettings->GetItem("MAIN", "MOVE_FIELD");
            }
            else {
                if ($this->Storage->HasColumn("_priority") !== false) {
                    $this->move_field = "_priority";
                }
                else {
                    $_inc_column = $this->Storage->GetIncrementalColumn();
                    $this->move_field = $_inc_column["name"];
                }
            }
        }

        //-- check for readonly
        if ($this->listSettings->HasItem("MAIN", "IS_READONLY")) {
            $this->read_only = $this->listSettings->GetItem("MAIN", "IS_READONLY");
            if ($this->read_only) {
                $this->disabled_delete = 1;
                $this->disabled_edit = 1;
                $this->disabled_add = 1;
                $this->disabled_copy = 1;
                $this->disabled_move = 1;
            }
        }
        else {
            $this->read_only = 0;
        }

    }

    /**
     * Method processes custom list caption settings
     * @access   public
     */
    function ProcessCustomTreePathSettings()
    {
        if ($this->listSettings->HasItem("MAIN", "USE_CUSTOM_TREE_PATH")) {
            $this->use_custom_tree_path = $this->listSettings->GetItem("MAIN", "USE_CUSTOM_TREE_PATH");
            if ($this->use_custom_tree_path) {
                if ($this->listSettings->HasItem("MAIN", "CUSTOM_TREE_PATH_TABLE")) {
                    $this->custom_tree_path_table = $this->listSettings->GetItem("MAIN", "CUSTOM_TREE_PATH_TABLE");
                }
                else {
                    $this->AddListErrorMessage("EMPTY_CUSTOM_TREE_PATH_SETTINGS");
                }
                if ($this->listSettings->HasItem("MAIN", "HTTPVAR_NODE_HOLDER")) {
                    $this->httpvar_node_holder = $this->listSettings->GetItem("MAIN", "HTTPVAR_NODE_HOLDER");
                }
                else {
                    $this->AddListErrorMessage("EMPTY_CUSTOM_TREE_PATH_SETTINGS");
                }
                if ($this->listSettings->HasItem("MAIN", "CUSTOM_TREE_PATH_PARENT")) {
                    $this->custom_tree_path_parent = $this->listSettings->GetItem("MAIN", "CUSTOM_TREE_PATH_PARENT");
                }
                else {
                    $this->AddListErrorMessage("EMPTY_CUSTOM_TREE_PATH_SETTINGS");
                }
                if ($this->listSettings->HasItem("MAIN", "CUSTOM_TREE_PATH_CAPTION")) {
                    $this->custom_tree_path_caption = $this->listSettings->GetItem("MAIN", "CUSTOM_TREE_PATH_CAPTION");
                }
                else {
                    $this->AddListErrorMessage("EMPTY_CUSTOM_TREE_PATH_SETTINGS");
                }
            }
        }
        else {
            $this->use_custom_tree_path = 0;
        }
    }

    /**
     * Method processes custom list caption settings
     * @access   public
     */
    function ProcessCustomListCaptionSettings()
    {
        if ($this->listSettings->HasItem("MAIN", "USE_CUSTOM_LIST_CAPTION")) {
            $this->use_custom_list_caption = $this->listSettings->GetItem("MAIN", "USE_CUSTOM_LIST_CAPTION");
            if ($this->use_custom_list_caption) {
                if ($this->listSettings->HasItem("MAIN", "CUSTOM_LIST_CAPTION_TABLE")) {
                    $this->custom_list_caption_table = $this->listSettings->GetItem("MAIN", "CUSTOM_LIST_CAPTION_TABLE");
                }
                else {
                    $this->AddListErrorMessage("EMPTY_CUSTOM_LIST_CAPTION_SETTINGS");
                }
                if ($this->listSettings->HasItem("MAIN", "HTTPVAR_CAPTIONID_HOLDER")) {
                    $this->httpvar_captionid_holder = $this->listSettings->GetItem("MAIN", "HTTPVAR_CAPTIONID_HOLDER");
                }
                else {
                    $this->AddListErrorMessage("EMPTY_CUSTOM_LIST_CAPTION_SETTINGS");
                }
                if ($this->listSettings->HasItem("MAIN", "CUSTOM_LIST_CAPTIONID_FIELD")) {
                    $this->custom_list_captionid_field = $this->listSettings->GetItem("MAIN", "CUSTOM_LIST_CAPTIONID_FIELD");
                }
                else {
                    $this->AddListErrorMessage("EMPTY_CUSTOM_TREE_PATH_SETTINGS");
                }
                if ($this->listSettings->HasItem("MAIN", "CUSTOM_LIST_CAPTION")) {
                    $this->custom_list_caption = $this->listSettings->GetItem("MAIN", "CUSTOM_LIST_CAPTION");
                }
                else {
                    $this->AddListErrorMessage("EMPTY_CUSTOM_LIST_CAPTION_SETTINGS");
                }

            }
        }
        else {
            $this->use_custom_list_caption = 0;
        }

    }

    /**
     * Method processes settings of treepath-select get-orders
     * @access   public
     */
    function ProcessMultilevelTreeSelectOrders()
    {
        if ($this->listSettings->HasItem("MAIN", "GET_ORDERS")) {
            $tmp = $this->listSettings->GetItem("MAIN", "GET_ORDERS");
            if (! is_array($tmp)) {
                $tmp = array(
                    $tmp
                );
            }
            for ($kk = 0; $kk < sizeof($tmp); $kk ++) {
                $order_str = preg_split("/ /", $tmp[$kk]);
                $order_arr[sprintf($order_str[0], $this->Page->Kernel->Language)] = $order_str[1];
            }
            $this->tree_sortorder = $order_arr;
        }
        else {
            $this->tree_sortorder = null;
        }
        if ($this->listSettings->HasItem("MAIN", "TREE_SELECT_METHOD")) {
            $this->tree_select_method = $this->listSettings->GetItem("MAIN", "TREE_SELECT_METHOD");
        }
        else {
            $this->tree_select_method = "GetList";
        }
    }

    /**
     * Method processes multilevel sub-categories settings
     * @access   public
     */
    function ProcessMultilevelSubCategories()
    {
        if ($this->listSettings->HasItem("MAIN", "USE_SUB_CATEGORIES")) {
            $this->use_sub_categories = $this->listSettings->GetItem("MAIN", "USE_SUB_CATEGORIES");
        }
        else {
            $this->use_sub_categories = 0;
        }
        if ($this->use_sub_categories) {
            if ($this->listSettings->HasItem("MAIN", "SUB_CATEGORIES_COUNT")) {
                $this->sub_categories_count = $this->listSettings->GetItem("MAIN", "SUB_CATEGORIES_COUNT");
                for ($i = 0; $i < $this->sub_categories_count; $i ++) {
                    $sub_category = array();
                    if ($this->listSettings->HasItem("SUB_CATEGORY_" . $i, "APPLY_LIBRARY")) {
                        $sub_category["library"] = $this->listSettings->GetItem("SUB_CATEGORY_" . $i, "APPLY_LIBRARY");
                    }
                    else {
                        $this->AddListErrorMessage("EMPTY_SUB_CATEGORY_LIBRARY", array(
                            $i
                        ));
                    }
                    if ($this->listSettings->HasItem("SUB_CATEGORY_" . $i, "LINK_FIELD")) {
                        $sub_category["link_field"] = $this->listSettings->GetItem("SUB_CATEGORY_" . $i, "LINK_FIELD");
                    }
                    else {
                        $this->AddListErrorMessage("EMPTY_SUB_CATEGORY_LINK_FIELD", array(
                            $i
                        ));
                    }
                    if ($this->listSettings->HasItem("SUB_CATEGORY_" . $i, "ENABLED_NODE_LEVELS")) {
                        $enabled_levels = explode(",", $this->listSettings->GetItem("SUB_CATEGORY_" . $i, "ENABLED_NODE_LEVELS"));
                        $levels = array();
                        for ($k = 0; $k < sizeof($enabled_levels); $k ++) {
                            if (is_numeric($enabled_levels[$k])) {
                                $levels[] = $enabled_levels[$k];
                            }
                            else {
                                list ($start, $end) = explode("..", $enabled_levels[$k]);
                                if ($end == "*") {
                                    $end = $this->Page->Kernel->DEFAULT_MAX_NODE_LEVEL_EVER;
                                }
                                for ($l = $start; $l <= $end; $l ++) {
                                    $levels[] = $l;
                                }
                            }
                        }
                        $sub_category["levels"] = array_values($levels);
                    }
                    else {
                        $sub_category["levels"] = array();
                    }
                    $this->sub_categories[] = $sub_category;
                }

            }
            else {
                $this->AddListErrorMessage("EMPTY_SUB_CATEGORIES_COUNT");
            }
        } // use sub categor


    }
    /**
     * Method processes Multilevel settings of library config
     * @access   public
     */
    function ProcessMultilevel(){
        if ($this->listSettings->HasItem("MAIN", "USE_TREE_PATH")) {
            $this->use_tree_path = $this->listSettings->GetItem("MAIN", "USE_TREE_PATH");
        }
        else {
            $this->use_tree_path = 0;
        }
        if ($this->listSettings->HasItem("MAIN", "CAPTION_FIELD")) {
            $this->caption_field = sprintf($this->listSettings->GetItem("MAIN", "CAPTION_FIELD"), $this->Page->Kernel->Language);
        }
        else {
            $this->AddListErrorMessage("EMPTY_CAPTIONFIELD_SETTINGS");
        }
        if ($this->listSettings->HasItem("MAIN", "PARENT_FIELD")) {
            $this->parent_field = $this->listSettings->GetItem("MAIN", "PARENT_FIELD");
        }
        else {
            $this->AddListErrorMessage("EMPTY_PARENTFIELD_SETTINGS");
        }
        if ($this->listSettings->HasItem("MAIN", "MAX_NODE_LEVEL")) {
            $this->max_node_level = $this->listSettings->GetItem("MAIN", "MAX_NODE_LEVEL");
        }
        else {
            $this->max_node_level = 0;
        }
        if ($this->listSettings->HasItem("MAIN", "DISABLE_LASTLEVEL_LIST")) {
            $this->disable_lastlevel_list = $this->listSettings->GetItem("MAIN", "DISABLE_LASTLEVEL_LIST");
        }
        else {
            $this->disable_lastlevel_list = 0;
        }
        if ($this->listSettings->HasItem("MAIN", "DISABLE_LASTLEVEL_ENTRANCE")) {
            $this->disable_lastlevel_entrance = $this->listSettings->GetItem("MAIN", "DISABLE_LASTLEVEL_ENTRANCE");
        }
        else {
            $this->disable_lastlevel_entrance = 0;
        }

        $this->ProcessMultilevelTreeSelectOrders();
        $this->ProcessMultilevelSubCategories();

        if ($this->listSettings->HasItem("MAIN", "ENABLE_MEGA_DELETE")) {
            $this->mega_delete = $this->listSettings->GetItem("MAIN", "ENABLE_MEGA_DELETE");
        }
        else {
            $this->mega_delete = 0;
        }
        //if($this->listSettings->HasItem("MAIN","ENABLE_NODE_MOVE")){
    //  $this->node_move = $this->listSettings->GetItem("MAIN","ENABLE_NODE_MOVE");
    //} else {
    //  $this->node_move = 0;
    //}


    }
    /**
     * Method processes MAIN section of library config
     * @access   public
     */
    function ProcessMainSection()
    {
        if ($this->listSettings->HasItem("MAIN", "ICON_FILE")) {
            $this->icon_file = $this->listSettings->GetItem("MAIN", "ICON_FILE");
        }
        if ($this->listSettings->HasItem("MAIN", "KEY_FIELD")) {
            $this->key_field = $this->listSettings->GetItem("MAIN", "KEY_FIELD");
        }
        else {
            $this->AddListErrorMessage("EMPTY_KEYFIELD_SETTINGS");
        }
        if ($this->listSettings->HasItem("MAIN", "ALTERNATIVE_SUBLIST_HANDLER")) {
            $this->alt_sublist_handler = $this->listSettings->GetItem("MAIN", "ALTERNATIVE_SUBLIST_HANDLER");
        }
        else {
            $this->alt_sublist_handler = "";
        }
        if ($this->listSettings->HasItem("MAIN", "ENABLE_NODE_MOVE")) {
            $this->node_move = $this->listSettings->GetItem("MAIN", "ENABLE_NODE_MOVE");
        }
        else {
            $this->node_move = 0;
        }

		if($this->listSettings->HasItem("MAIN","DISABLE_TREE_SELECT")){
			$this->disable_tree_select = $this->listSettings->GetItem("MAIN","DISABLE_TREE_SELECT");
		} else {
			$this->disable_tree_select = 0;
		}

        $this->ProcessListExtractors();
        $this->ProcessLibraryPermissions();
        $this->ProcessCustomTreePathSettings();
        $this->ProcessCustomListCaptionSettings();

        if ($this->listSettings->HasItem("MAIN", "IS_MULTILEVEL")) {
            $this->multilevel = $this->listSettings->GetItem("MAIN", "IS_MULTILEVEL");
            if ($this->multilevel) {
                $this->ProcessMultilevel();
            }
        }
        else {
            $this->multilevel = 0;
        }

    }
    /**
     * Method adds field-specific settings for date control
     * @param        int     $i          Field number
     * @param        array   $_field     Array with field settings
     */
    function GetDateSettings($i, &$_field)
    {
        if ($this->listSettings->HasItem("FIELD_" . $i, "IS_UNIX_TIMESTAMP")) {
            $_field["is_unix_timestamp"] = $this->listSettings->GetItem("FIELD_" . $i, "IS_UNIX_TIMESTAMP");
        }
        else {
            $_field["is_unix_timestamp"] = 0;
        }
        if ($this->listSettings->HasItem("FIELD_" . $i, "FULLDATE")) {
            $_field["fulldate"] = $this->listSettings->GetItem("FIELD_" . $i, "FULLDATE");
        }
        else {
            $this->AddListErrorMessage("EMPTY_FULLDATE_SETTINGS", array(
                $i
            ));
        }
    }

    /**
     * Method adds field-specific settings for caption control
     * @param        int     $i          Field number
     * @param        array   $_field     Array with field settings
     */
    function GetCaptionSettings($i, &$_field)
    {
        if ($this->Page->Kernel->Localization->HasItem(strtoupper($this->library_ID), "OPTIONS_" . strtoupper($_field["field_name"]))) {
            $_field["options"] = $this->FromConfigOptionsToSelect($this->Page->Kernel->Localization->GetItem(strtoupper($this->library_ID), "OPTIONS_" . strtoupper($_field["field_name"])));
        }
        else {
            if ($this->listSettings->HasItem("FIELD_" . $i, "OPTIONS")) {
                $_field["options"] = $this->FromConfigOptionsToSelect($this->listSettings->GetItem("FIELD_" . $i, "OPTIONS"));
            }
            else {
                if ($this->listSettings->HasItem("FIELD_" . $i, "OPTIONS_FROM_INI_SECTION")) {
                    $section = $this->listSettings->GetItem("FIELD_" . $i, "OPTIONS_FROM_INI_SECTION");
                    $caption_items = $this->listSettings->GetItem("FIELD_" . $i, "OPTIONS_FROM_INI_CAPTIONS");
                    $value_items = $this->listSettings->GetItem("FIELD_" . $i, "OPTIONS_FROM_INI_VALUES");
                    if ($this->Page->Kernel->Settings->HasItem($section, $caption_items)) {
                        $captions = $this->Page->Kernel->Settings->GetItem($section, $caption_items, false, true);
                        $values = $this->Page->Kernel->Settings->GetItem($section, $value_items, false, true);
                    }
                    else {
                        $captions = $this->Page->Kernel->Localization->GetItem($section, $caption_items, false, true);
                        $values = $this->Page->Kernel->Localization->GetItem($section, $value_items, false, true);
                    }
                    $options = array();
                    for ($optionIndex = 0; $optionIndex < sizeof($captions); $optionIndex ++) {
                        $option["value"] = $values[$optionIndex];
                        $option["caption"] = $captions[$optionIndex];
                        $options[] = $option;
                    }
                    $_field["options"] = $options;
                }
                else {
                    $this->AddListErrorMessage("EMPTY_OPTIONS_SETTINGS", array(
                        $i
                    ));
                }
            }
        }
    }

    /**
     * Method adds field-specific settings for file control
     * @param        int     $i          Field number
     * @param        array   $_field     Array with field settings
     */
    function GetFileSettings($i, &$_field)
    {
        if ($this->listSettings->HasItem("FIELD_" . $i, "DIRECTORY")) {
            $_field["file_directory"] = $this->listSettings->GetItem("FIELD_" . $i, "DIRECTORY");
        }
        ;
    }

    /**
     * Method adds field-specific settings for checkbox and radio control
     * @param        int     $i          Field number
     * @param        array   $_field     Array with field settings
     */
    function GetCheckboxSettings($i, &$_field)
    {
        if ($this->listSettings->HasItem("FIELD_" . $i, "CHECKON")) {
            $_field["checkOn"] = $this->listSettings->GetItem("FIELD_" . $i, "CHECKON");
        }
        else {
            $this->AddListErrorMessage("EMPTY_CHECKON_SETTINGS", array(
                $i
            ));
        }
    }

    function GetDbEditBlockSettings($i, &$_field)
    {
        $_field["field_table"] = $this->listSettings->GetItem("FIELD_" . $i, "FIELD_TABLE");
        $_field["fieldvalue_name"] = sprintf($this->listSettings->GetItem("FIELD_" . $i, "FIELDVALUE_NAME"), $this->Page->Kernel->Language);
        $_field["fieldvalue_caption"] = sprintf($this->listSettings->GetItem("FIELD_" . $i, "FIELDVALUE_CAPTION"), $this->Page->Kernel->Language);
        $_field["link_to_field"] = sprintf($this->listSettings->GetItem("FIELD_" . $i, "LINK_TO_FIELD"), $this->Page->Kernel->Language);
        if ($this->listSettings->HasItem("FIELD_" . $i, "GET_METHOD")) {
            $_field["get_method"] = $this->listSettings->GetItem("FIELD_" . $i, "GET_METHOD");
        }
        else {
            $_field["get_method"] = "GetList";
        }
        if ($this->listSettings->HasItem("FIELD_" . $i, "GET_DATA_FIELDS")) {
            $_data_fields = $this->listSettings->GetItem("FIELD_" . $i, "GET_DATA_FIELDS");
            $_data_fieldvalues = $this->listSettings->GetItem("FIELD_" . $i, "GET_DATA_FIELDVALUES");
            if (! is_array($_data_fields))
                $_data_fields = array(
                    $_data_fields
                );
            if (! is_array($_data_fieldvalues))
                $_data_fieldvalues = array(
                    $_data_fieldvalues
                );
            for ($j = 0; $j < sizeof($_data_fields); $j ++) {
                $_get_data[sprintf($_data_fields[$j], $this->Page->Kernel->Language)] = sprintf($_data_fieldvalues[$j], $this->Page->Kernel->Language);
            }
            $_field["get_data"] = $_get_data;
        }
        else {
            $_field["get_data"] = null;
        }

        if ($this->listSettings->HasItem("FIELD_" . $i, "GET_ORDERS")) {
            $_order_fields = $this->listSettings->GetItem("FIELD_" . $i, "GET_ORDERS");
            for ($j = 0; $j < sizeof($_order_fields); $j ++) {
                list ($_orderfield, $_ordervalue) = preg_split("/ /", $_order_fields);
                $_get_orders[sprintf($_orderfield, $this->Page->Kernel->Language)] = sprintf($_ordervalue, $this->Page->Kernel->Language);
            }
            $_field["get_orders"] = $_get_orders;
        }
        else {
            $_field["get_orders"] = array(
                sprintf($_field["fieldvalue_caption"], $this->Page->Kernel->Language) => "ASC"
            );
        }
    }

    /**
     * Method adds field-specific settings for db-field controls
     * @param        int     $i          Field number
     * @param        array   $_field     Array with field settings
     */
    function GetDbFieldSettings($i, &$_field)
    {
        $_field["field_table"] = $this->listSettings->GetItem("FIELD_" . $i, "FIELD_TABLE");
        $_field["fieldvalue_name"] = sprintf($this->listSettings->GetItem("FIELD_" . $i, "FIELDVALUE_NAME"), $this->Page->Kernel->Language);
        $_field["fieldvalue_caption"] = sprintf($this->listSettings->GetItem("FIELD_" . $i, "FIELDVALUE_CAPTION"), $this->Page->Kernel->Language);
        if ($this->listSettings->HasItem("FIELD_" . $i, "GET_METHOD")) {
            $_field["get_method"] = $this->listSettings->GetItem("FIELD_" . $i, "GET_METHOD");
        }
        else {
            $_field["get_method"] = "Get";
        }
        if ($this->listSettings->HasItem("FIELD_" . $i, "GET_DATA_FIELDS")) {
            $_data_fields = $this->listSettings->GetItem("FIELD_" . $i, "GET_DATA_FIELDS");
            $_data_fieldvalues = $this->listSettings->GetItem("FIELD_" . $i, "GET_DATA_FIELDVALUES");
            if (! is_array($_data_fields))
                $_data_fields = array(
                    $_data_fields
                );
            if (! is_array($_data_fieldvalues))
                $_data_fieldvalues = array(
                    $_data_fieldvalues
                );
            for ($j = 0; $j < sizeof($_data_fields); $j ++) {
                $_get_data[sprintf($_data_fields[$j], $this->Page->Kernel->Language)] = sprintf($_data_fieldvalues[$j], $this->Page->Kernel->Language);
            }
            $_field["get_data"] = $_get_data;
        }
        else {
            $_field["get_data"] = null;
        }

        if ($this->listSettings->HasItem("FIELD_" . $i, "GET_ORDERS")) {
            $_order_fields = $this->listSettings->GetItem("FIELD_" . $i, "GET_ORDERS");
            for ($j = 0; $j < sizeof($_order_fields); $j ++) {
                list ($_orderfield, $_ordervalue) = preg_split("/ /", $_order_fields);
                $_get_orders[sprintf($_orderfield, $this->Page->Kernel->Language)] = sprintf($_ordervalue, $this->Page->Kernel->Language);
            }
            $_field["get_orders"] = $_get_orders;
        }
        else {
            $_field["get_orders"] = array(
                sprintf($_field["fieldvalue_caption"], $this->Page->Kernel->Language) => "ASC"
            );
        }
    }

    /**
     * Method adds field-specific settings for dbtreepath control
     * @param        int     $i          Field number
     * @param        array   $_field     Array with field settings
     */
    function GetDbTreePathSettings($i, &$_field)
    {
        $_field["field_table"] = $this->listSettings->GetItem("FIELD_" . $i, "FIELD_TABLE");
        $_field["fieldvalue_name"] = sprintf($this->listSettings->GetItem("FIELD_" . $i, "FIELDVALUE_NAME"), $this->Page->Kernel->Language);
        $_field["fieldvalue_caption"] = sprintf($this->listSettings->GetItem("FIELD_" . $i, "FIELDVALUE_CAPTION"), $this->Page->Kernel->Language);
        $_field["fieldvalue_parent"] = sprintf($this->listSettings->GetItem("FIELD_" . $i, "FIELDVALUE_PARENT"), $this->Page->Kernel->Language);
    }

    /**
     * Method adds field-specific settings for dbtreepath control
     * @param        int     $i          Field number
     * @param        array   $_field     Array with field settings
     */
    function GetTextSettings($i, &$_field)
    {
        $_field["size"] = $this->listSettings->GetItem("FIELD_" . $i, "SIZE");
    }

    /**
     * Method adds field-specific settings for combobox control
     * @param        int     $i          Field number
     * @param        array   $_field     Array with field settings
     */
    function GetComboSettings($i, &$_field)
    {
        $library = strtoupper($this->library_ID);

        $field = "OPTIONS_" . strtoupper($_field["field_name"]);
        $field_and_lang = $field . "_" . strtoupper($this->Page->Kernel->Language);
        if ($this->Page->Kernel->Localization->HasItem($library, $field_and_lang)) {
            $_field["options"] = $this->Page->FromConfigOptionsToSelect($this->Page->Kernel->Localization->GetItem($library, $field_and_lang));
        }
        elseif ($this->Page->Kernel->Localization->HasItem($library, $field)) {
            $_field["options"] = $this->Page->FromConfigOptionsToSelect($this->Page->Kernel->Localization->GetItem($library, $field));
        }
        elseif ($this->listSettings->HasItem("FIELD_" . $i, "OPTIONS")) {
            $_field["options"] = $this->Page->FromConfigOptionsToSelect($this->listSettings->GetItem("FIELD_" . $i, "OPTIONS"));
        }
        elseif ($this->listSettings->HasItem("FIELD_" . $i, "OPTIONS_FROM_INI_SECTION")) {
            $section = $this->listSettings->GetItem("FIELD_" . $i, "OPTIONS_FROM_INI_SECTION");
            $caption_items = $this->listSettings->GetItem("FIELD_" . $i, "OPTIONS_FROM_INI_CAPTIONS");
            $value_items = $this->listSettings->GetItem("FIELD_" . $i, "OPTIONS_FROM_INI_VALUES");
            if ($this->Page->Kernel->Settings->HasItem($section, $caption_items)) {
                $captions = $this->Page->Kernel->Settings->GetItem($section, $caption_items, false, true);
                $values = $this->Page->Kernel->Settings->GetItem($section, $value_items, false, true);
            }
            else {
                $captions = $this->Page->Kernel->Localization->GetItem($section, $caption_items, false, true);
                $values = $this->Page->Kernel->Localization->GetItem($section, $value_items, false, true);
            }
            $options = array();
            for ($optionIndex = 0; $optionIndex < sizeof($captions); $optionIndex ++) {
                $option["value"] = $values[$optionIndex];
                $option["caption"] = $captions[$optionIndex];
                $options[] = $option;
            }
            $_field["options"] = $options;
        }
        else {
            $this->AddListErrorMessage("EMPTY_OPTIONS_SETTINGS", array(
                $i
            ), array(), true);
        }
        if ($this->listSettings->HasItem("FIELD_" . $i, "MULTIPLE")) {
            $_field["multiple"] = $this->listSettings->GetItem("FIELD_" . $i, "MULTIPLE");
        }
    }

    /**
     * Method returns  field settings for each field
     * @param        int         Index of field
     * @return       array       Array with mandatory settings
     * @access       public
     */
    function GetFieldSettings($i)
    {
        $_field = array();
        if ($this->listSettings->HasItem("FIELD_" . $i, "FIELD_NAME")) {
            $_field["field_name"] = sprintf($this->listSettings->GetItem("FIELD_" . $i, "FIELD_NAME"), $this->Page->Kernel->Language);
        }
        else {
            $this->AddListErrorMessage("EMPTY_FIELDNAME_SETTINGS", array(
                $i
            ));
        }
        if ($this->listSettings->HasItem("FIELD_" . $i, "SORT")) {
            $_field["sort"] = $this->listSettings->GetItem("FIELD_" . $i, "SORT");
        }
        else {
            $this->AddListErrorMessage("EMPTY_SORT_SETTINGS", array(
                $i
            ));
        }
        if ($this->listSettings->HasItem("FIELD_" . $i, "CONTROL")) {
            $_field["control"] = $this->listSettings->GetItem("FIELD_" . $i, "CONTROL");
        }
        else {
            $this->AddListErrorMessage("EMPTY_CONTROL_SETTINGS", array(
                $i
            ));
        }
        if ($this->listSettings->HasItem("FIELD_" . $i, "ALIGN")) {
            $_field["align"] = $this->listSettings->GetItem("FIELD_" . $i, "ALIGN");
        }
        else
            $_field["align"] = "";
        if ($this->listSettings->HasItem("FIELD_" . $i, "CUT_LIST_LENGTH")) {
            $_field["cut_length"] = $this->listSettings->GetItem("FIELD_" . $i, "CUT_LIST_LENGTH");
        }
        if ($this->listSettings->HasItem("FIELD_" . $i, "BOLD")) {
            $_field["bold"] = $this->listSettings->GetItem("FIELD_" . $i, "BOLD");
        }
        else
            $_field["bold"] = "";
        if ($this->listSettings->HasItem("FIELD_" . $i, "ITALIC")) {
            $_field["italic"] = $this->listSettings->GetItem("FIELD_" . $i, "ITALIC");
        }
        else
            $_field["italic"] = "";

        if ($this->listSettings->HasItem("FIELD_" . $i, "CAPTION_PREFIX")) {
            $_field["caption_prefix"] = sprintf($this->listSettings->GetItem("FIELD_" . $i, "CAPTION_PREFIX"), $this->Page->Kernel->Language);
        }
        if ($this->listSettings->HasItem("FIELD_" . $i, "FIELD_PREPROCESSOR")) {
            $_field["field_preprocessor"] = $this->listSettings->GetItem("FIELD_" . $i, "FIELD_PREPROCESSOR");
            if ($this->listSettings->HasItem("FIELD_" . $i, "FIELD_PREPROCESSOR_DOMAIN")) {
                $_field["field_preprocessor_domain"] = $this->listSettings->GetItem("FIELD_" . $i, "FIELD_PREPROCESSOR_DOMAIN");
            }
            else {
                $_field["field_preprocessor_domain"] = "page";
            }

        }
        switch ($_field["control"]) {
            case "date":
                $this->GetDateSettings($i, $_field);
                break;
            case "caption":

                $this->GetCaptionSettings($i, $_field);
                break;
            case "text":
                $this->GetTextSettings($i, $_field);
                break;
            case "file":
                $this->GetFileSettings($i, $_field);
                break;
            case "file2":
                $this->GetFile2Settings($i, $_field);
                break;
            case "checkbox":
            case "radio":
                $this->GetCheckboxSettings($i, $_field);
                break;
            case "dbcombobox":
            case "dbtext":
                $this->GetDbFieldSettings($i, $_field);
                break;
            case "dbeditblock":
                $this->GetDbEditBlockSettings($i, $_field);
                break;
            case "dbtreepath":
                $this->GetDbTreePathSettings($i, $_field);
                break;
            case "combobox":
                $this->GetComboSettings($i, $_field);
                break;
        } // switch
        return $_field;

    }

    /** Method Gets data from library file
     * @access public
     */
    function GetLibraryData()
    {
        if (! strlen($this->library_ID)) {
            $this->library_ID = $this->Page->Kernel->Package->Settings->GetItem("main", "LibraryName");
            if (strlen($this->library_ID) == 0) {
                $this->AddListErrorMessage("EMPTY_LIBRARY_ID");
            }
        }
        else {
            if (! file_exists($this->LibrariesRoot . $this->library_ID . ".ini" . ".php")) {
                $this->AddListErrorMessage("FILE_NOT_FOUND", array(
                    $this->library_ID . ".ini" . ".php"
                ));
            }
        }

        if (! $this->error) {
            $_libconfig = $this->LibrariesRoot . $this->library_ID . ".ini" . ".php";

            $this->listSettings = Engine::getLibrary($this->Page->Kernel, $this->library_ID, "ListSettings_" . $this->library_ID);

        }
        else {
            $this->AddListErrorMessage("LIBRARY_ERROR");
        }
        if ($this->listSettings->GetCount()) {
            if ($this->listSettings->HasItem("MAIN", "TABLE")) {
                $this->Table = $this->listSettings->GetItem("MAIN", "TABLE");
            }
            else {
                $this->AddListErrorMessage("EMPTY_TABLE_SETTINGS");
            }
            if (! $this->error) {

                $use_db_columns = false;
                //--check if defined flag use database columns definition
                if ($this->listSettings->HasItem("MAIN", "DB_USE_COLUMNDEFINITION"))
                    $use_db_columns = $this->listSettings->GetItem("MAIN", "DB_USE_COLUMNDEFINITION");

                if ($this->listSettings->HasItem("MAIN", "DB_USE_ABSTRACTTABLE"))
                    $this->use_abstracttable = $this->listSettings->GetItem("MAIN", "DB_USE_ABSTRACTTABLE");

                //--get storage object
                if (! $this->use_abstracttable) { //--if dont use abstracttable class (use storage class)


                    $this->Storage = DataFactory::GetStorage($this, $this->Table);
                }
                else { //--else (use abstracttable class)
                    $this->Storage = new AbstractTable($this->Page->Kernel->Connection, $this->Page->Kernel->Settings->GetItem("database", $this->Table), true);
                }

                if ($use_db_columns)
                    TableHelper::prepareColumnsDB($this->Storage, true, false);
                $fields_count = $this->ProcessListSection();
                $this->ProcessMainSection();
                for ($i = 0; $i < $fields_count; $i ++) {
                    if ($this->CheckInListField("FIELD_" . $i)) {
                        $this->fields[] = $this->GetFieldSettings($i);
                    } // IN_LIST
                } // for
            } // !error
        }
        else {
            $this->AddListErrorMessage("EMPTY_LIBRARY_SETTINGS");
        }
        //define filter control
        $this->DefineFilterControl();
    }

    function CheckInListField($field){
    	$res==false;
    	if ($this->listSettings->HasItem($field, "IN_LIST"))
    		if ($this->listSettings->GetItem($field, "IN_LIST")==1)
    			if ($this->listSettings->HasItem($field, "PACKAGE")){
    				$pkg=$this->listSettings->GetItem($field, "PACKAGE");
        			if (Engine::isPackageExists($this->Page->Kernel, $pkg))
        				$res=true;
    			}else{
    				$res=true;
    			}
    	return $res;
    }

    /**
     * Method  Executes on control load to the parent
     * @access  private
     */
    function ControlOnLoad()
    {
    }

    /**
     * Method set range of current list (start, end position, records per page, total)
     * @access private
     **/
    function defineListRange()
    {

        if ($this->use_filter_form) {
            $whereSQL = $this->Storage->GetWhereClauseListFilter($this->Storage, $this->library_ID);
        }

        if (! strlen($this->_RPP)) {
            if ($this->Page->Kernel->Settings->HasItem($this->sectionname . "Page", "RecordsPerPage")) {
                $this->_RPP = $this->Page->Kernel->Settings->GetItem($this->sectionname . "Page", "RecordsPerPage");
            }
            else {
                $this->_RPP = $this->Page->Kernel->Settings->GetItem("MAIN", "RecordsPerPage");
            }
        }
        $this->_START = ($this->start == "" ? "0" : $this->start);

        if ($this->use_data_counter) {
            $counter = $this->data_counter;

            $this->_TOTAL = $this->Storage->$counter($this->data, "", array(
                "filter" => $whereSQL
            ));
        }
        else {

            $this->_TOTAL = $this->Storage->GetCount($this->data, "", array(
                "filter" => $whereSQL
            ));
        }
        if ($this->_START * $this->_RPP >= $this->_TOTAL) {
            $this->_START = ceil($this->_TOTAL / $this->_RPP) - 1;
        }
        if ($this->_START < 0)
            $this->_START = 0;
    }

    /**
     * Method get sort definition of current list using entry data (library data and initialization control data)
     * @return     array           Array of order definition (using in GetList or other function)
     * @access private
     **/
    function getOrderByDefinition()
    {
        list ($this->order, $this->attribute) = explode(":", $this->order_by);
        if (! empty($this->list_orders) && $this->order == "") { //--if in library set GET_ORDERS variables and order_by request value not set
            $orders = $this->list_orders;
            $order_field = array_keys($orders);
            $this->attribute = ($orders[$order_field[0]] == 0 ? "DESC" : "");
            $this->order = $order_field[0];
        }
        elseif ($this->order != "") { // -- if order_by request variable is set
            $orders[$this->order] = ($this->attribute == "DESC" ? false : true);
        }
        else { //-- if library dont have settings and order_by is not set
            if (! $this->disabled_move) { //--if library have a priority  field
                $orders[$this->move_field] = true;
                $this->order = $this->move_field;
            }
            else { //-- sort by first field in list
                $orders[$this->fields[0]["field_name"]] = true;
                $this->order = $this->fields[0]["field_name"];
            }
        }
        return $orders;
    }

    /**
     * Method get current list data (records) and previous, next record
     * set $this->_list variable using this data
     * @param     array   $orders     Order by definition array
     * @access    private
     **/
    function defineListData($orders = array())
    {

        if ($this->use_data_extractor) {
            $extractor = $this->data_extractor;
        }
        else {
            $extractor = "GetList";
        }

        if ($this->use_filter_form) {
            $whereSQL = $this->Storage->GetWhereClauseListFilter($this->Storage, $this->library_ID);
        }
        $_list = $this->Storage->$extractor($this->data, $orders, $this->_RPP, $this->_RPP * $this->_START, null, "", array(
            "filter" => $whereSQL
        ));
        //--if user can move records up or down get previous list
        //--last record and next list first ercord


        if (! $this->disabled_move) {
            if ($this->start != 0) {
                $prev_list = $this->Storage->$extractor($this->data, $orders, 1, ($this->_RPP * $this->_START) - 1);
                if ($prev_list->RecordCount != 0) {
                    $prev_record = $prev_list->Read();
                    $this->list_prev_id = $prev_record[$this->key_field];
                }
            }
            $next_list = $this->Storage->$extractor($this->data, $orders, 1, ($this->_RPP * ($this->_START + 1)));
            if ($next_list->RecordCount != 0) {
                $next_record = $next_list->Read();
                $this->list_next_id = $next_record[$this->key_field];
            }
        }
        if (is_object($_list)) {
            for ($i = 0; $i < $_list->RecordCount; $i ++) {
                $this->_list[] = $_list->Read();
            }
        }
        else {
            $this->_list = $_list;
        }
    }

    /**
     * Method define data for multilevel list
     * @access private
     **/
    function defineMultilevelData()
    {
        $_upper = $this->Storage->Get(array(
            $this->key_field => $this->parent_id
        ));

        $this->upper_level_parent_id = $_upper[$this->parent_field];
        $node_levels = $this->Storage->GetNodeLevels($this->parent_id, $this->parent_field);
        $this->node_levels = $node_levels;

        if (! empty($node_levels) && (($node_levels[$this->parent_id] + 1) >= $this->max_node_level) && ($this->max_node_level != 0)) {
            $this->is_last_level = 1;
            if ($this->disable_lastlevel_entrance) {
                $this->Page->Response->Redirect(str_replace("&amp;", "&", "?".($this->Package!="" ? "package=".$this->Package."&" : "")."page=" . $this->self . "&" . $this->library_ID . "_order_by=" . $this->order_by . "&lib=" . $this->library_ID . "&" . $this->library_ID . "_parent_id=" . $this->upper_level_parent_id . $this->append_hrefs));
            }
        }
    }

    /**
     * Method create tree select control for multilevel list
     * @access     private
     **/
    function createTreeSelect()
    {
        if (($this->node_move || $this->multilevel) && (! is_object($this->tree_control))) {
            $tree = $this->Storage->GetTreeData(null, $this->parent_field, $this->tree_sortorder, $this->tree_select_method);

            $this->AddControl(new TreeSelectControl("destination_nodes", "destinationtreeselect"));
            $this->Controls["destination_nodes"]->SetTreeData(array(
                "selectdata" => array(
                "name" => "destination" , "selected_value" => (string) $this->parent_id
            ) , "tree" => $tree , "key_field" => $this->key_field , "parent_field" => $this->parent_field , "caption_field" => $this->caption_field , "section" => $this->library_ID
            ));

        }
        else {
            if (is_object($this->tree_control)) {
                $this->AddControl($this->tree_control);
            }

        }
    }

    /**
     * Method  Prepares data for list-drawing
     * @access  private
     */
    function PrepareData()
    {
        //--define list range
        $this->defineListRange();

        //--get records list
        $this->defineListData($this->getOrderByDefinition());

        //--get multilevel list data
        if ($this->multilevel) {
            $this->defineMultiLevelData();
        }

        //create tree select
        if (! $this->disable_tree_select) {
            $this->createTreeSelect();
        }
    }

    /**
     *  Method builds rows of a list
     * @param  XMLWriter   $xmlWriter  instance of XMLWriter
     * @access private
     */
    function BuildRows(&$xmlWriter)
    {
        for ($i = 0; $i < sizeof($this->_list); $i ++) {
            $xmlWriter->WriteStartElement("row");
            $xmlWriter->WriteAttributeString("id", $this->_list[$i][$this->key_field]);
            //--if this is first record
            if ($i == 0 && $this->list_prev_id != 0) {
                $xmlWriter->WriteAttributeString("prev_id", $this->list_prev_id);
            }
            else {
                $xmlWriter->WriteAttributeString("prev_id", $this->_list[$i - 1][$this->key_field]);
            }

            //--if this is last record
            if ($i == (count($this->_list) - 1) && $this->list_next_id != 0) {
                $xmlWriter->WriteAttributeString("next_id", $this->list_next_id);
            }
            else {
                $xmlWriter->WriteAttributeString("next_id", $this->_list[$i + 1][$this->key_field]);
            }

            for ($j = 0, $size = sizeof($this->fields); $j < $size; $j ++) {
            	$this->BuildCell($i, $j, $xmlWriter);
                $xmlWriter->WriteStartElement("control");
                $xmlWriter->WriteAttributeString("position", $j);
                if (strlen($this->fields[$j]["align"])) {
                    $xmlWriter->WriteAttributeString("align", $this->fields[$j]["align"]);
                }
                if (isset($this->fields[$j]["field_preprocessor"])) {
                    $preprocessor = $this->fields[$j]["field_preprocessor"];
                    $domain = $this->fields[$j]["field_preprocessor_domain"];
                    if (($domain == "page") && method_exists($this->Page, $preprocessor)) {
                        $this->Page->$preprocessor($this->fields[$j], $this->_list[$i]);
                    }
                    elseif (($domain == "table") && method_exists($this->Storage, $preprocessor)) {
                        $this->Storage->$preprocessor($this->fields[$j], $this->_list[$i]);
                    }
                }

                switch ($this->fields[$j]["control"]) {
                    case "date":
                    case "string":
                    case "link":
                        ListControlDrawer::DrawLink($i, $j, $xmlWriter, $this);
                        break; //link,date,string
                    case "hidden":
                        ListControlDrawer::DrawHidden($i, $j, $xmlWriter, $this);
                        break; //hidden
                    case "dbeditblock":
                        ListControlDrawer::DrawDBEditBlock($i, $j, $xmlWriter, $this);
                        break;
                    case "graphicprice":
                        ListControlDrawer::DrawGraphic($i, $j, $xmlWriter, $this);
                        break; //graphicprice
                    case "caption":
                        ListControlDrawer::DrawCaption($i, $j, $xmlWriter, $this);
                        break; //caption
                    case "text":
                        ListControlDrawer::DrawText($i, $j, $xmlWriter, $this);
                        break; //editedcaption
                    case "checkbox":
                        ListControlDrawer::DrawCheckbox($i, $j, $xmlWriter, $this);
                        break; //checkbox
                    case "radio":
                        ListControlDrawer::DrawRadio($i, $j, $xmlWriter, $this);
                        break; //radio
                    case "dbtext":
                        ListControlDrawer::DrawDbText($i, $j, $xmlWriter, $this);
                        break; //dbtext
                    case "dbtreepath":
                        ListControlDrawer::DrawDbTreePath($i, $j, $xmlWriter, $this);
                        break; //dbtext
                    case "file":
                        ListControlDrawer::DrawFile($i, $j, $xmlWriter, $this);
                        break;
                    case "file2":
                        ListControlDrawer::DrawFile2($i, $j, $xmlWriter, $this);
                        break;
                    case "combobox":
                        ListControlDrawer::DrawComboBox($i, $j, $xmlWriter, $this);
                        break;
                } //switch
                $xmlWriter->WriteEndElement();
            } // for j
            $xmlWriter->WriteEndElement();
        } //for i
    }

    function BuildCell($i, $j, &$xmlWriter){
    }

    /**
     *  Method draws xml-content of control
     *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
     *  @access  public
     */
    function XmlControlOnRender(&$xmlWriter)
    {

        $_Localization = $this->Page->Kernel->Localization;
        if (! $this->error) {

            if (($this->multilevel && (((sizeof($this->node_levels) + 1) >= $this->max_node_level) && ! $this->disable_lastlevel_list) || ((sizeof($this->node_levels) + 1) < $this->max_node_level))

             or (! $this->multilevel)) {
                $disable_lastlevel_list = 0;
            }
            else {
                $disable_lastlevel_list = 1;
            }

            $xmlWriter->WriteElementString("_PageTitle", $_Localization->GetItem($this->sectionname, "_LIST_TITLE"));

            if ($this->multilevel && ($this->upper_level_parent_id != "")) {
                $this->AddControl(new LinkControl("up", "levelup_link"));
                $array = array(
                    "caption" => $_Localization->GetItem($this->sectionname, "_LIST_LEVEL_UP") , "href" => "?".($this->Package!="" ? "package=".$this->Package."&amp;" : "")."page=" . $this->self . "&amp;" . $this->library_ID . "_order_by=" . $this->order_by . "&amp;library=" . $this->library_ID . "&amp;" . $this->library_ID . "_parent_id=" . $this->upper_level_parent_id . $this->append_hrefs
                );
                $this->Controls["up"]->InitControl($array);
            }

            $this->AddControl(new LinkControl("link", "control"));
            $this->AddControl(new TextControl("edit", "control"));
            $this->AddControl(new GraphicPriceControl("graphicprice", "control"));
            $this->AddControl(new CheckboxControl("checkbox", "control"));
            $this->AddControl(new RadioControl("radio", "control"));
            $this->AddControl(new DbTextControl("dbtext", "control"));
            $this->AddControl(new DbTreePathControl("dbtreepath", "control"));
            $this->AddControl(new FileControl("file", "control"));
            $this->AddControl(new File2Control("file2", "control"));
            $this->AddControl(new DbEditBlockControl("dbeditblock", "control"));
            $this->AddControl(new HiddenControl("hidden", "control"));
            $this->AddControl(new SelectControl("select", "control"));

            if ($this->multilevel && $this->use_tree_path) {
                $this->AddControl(new DBTreePathControl("treepath", "treepath"));
                $this->Controls["treepath"]->InitControl(array(
                    "name" => "treepath" , "table" => $this->Table , "caption_field" => $this->caption_field , "parent_field" => $this->parent_field , "category_value" => $this->parent_id
                ));
            }
            else {

                if ($this->use_custom_tree_path) {
                    $this->AddControl(new DBTreePathControl("treepath", "treepath"));
                    $this->Controls["treepath"]->InitControl(array(
                        "name" => "treepath" , "table" => $this->custom_tree_path_table , "caption_field" => sprintf($this->custom_tree_path_caption, $this->Page->Kernel->Language) , "parent_field" => $this->custom_tree_path_parent , "category_value" => $this->Page->Request->ToNumber($this->httpvar_node_holder, 0)
                    ));

                }
            }

            if ($this->use_custom_list_caption) {
                $this->AddControl(new DbTextControl("custom_caption", "custom_caption"));
                $this->Controls["custom_caption"]->InitControl(array(
                    "name" => "custom_caption" , "table" => $this->custom_list_caption_table , "caption_field" => sprintf($this->custom_list_caption, $this->Page->Kernel->Language) , "query_data" => array(
                    $this->custom_list_captionid_field => $this->Page->Request->ToNumber($this->httpvar_captionid_holder, 0)
                )
                ));

            }

            $this->AddControl(new NavigationControl("navigator", "navigator"));
            $this->Controls["navigator"]->SetData(array(
                "prefix" => $this->library_ID . "_" , "start" => $this->_START , "total" => $this->_TOTAL , "ppd" => $this->_PPD , "rpp" => $this->_RPP , "url" => "?".($this->Package!="" ? "package=".$this->Package."&amp;" : "")."page=" . $this->self . "&amp;" . $this->library_ID . "_order_by=" . $this->order_by . "&amp;library=" . (strlen($this->host_library_ID) ? $this->host_library_ID : $this->library_ID) . ($this->multilevel ? "&amp;" . $this->library_ID . "_parent_id=" . $this->parent_id : "") . $this->append_hrefs , "order_by" => $this->order_by
            ));
            $xmlWriter->WriteStartElement("handler");
            $xmlWriter->WriteElementString("page", $this->handler);
            $xmlWriter->WriteElementString("self", $this->self);
            $xmlWriter->WriteElementString("package", $this->Package);
            $xmlWriter->WriteElementString("list_page", $this->Page->self);
            $xmlWriter->WriteElementString("library", $this->library_ID);
            $xmlWriter->WriteElementString("restore", rawurlencode(str_replace("&amp;", "&", "old_page=" . $this->self . $this->append_hrefs)));
            $xmlWriter->WriteElementString("append_hrefs", $this->append_hrefs);
            $xmlWriter->WriteElementString("parent_id", $this->parent_id);
            $xmlWriter->WriteStartElement("order_by");

            $xmlWriter->WriteElementString("field", $this->order);
            $xmlWriter->WriteElementString("direction", $this->attribute);
            $xmlWriter->WriteEndElement("order_by");
            if ($this->mega_delete) {
                $xmlWriter->WriteElementString("mega_delete", "yes");
            }
            if ($this->node_move || $this->parent_move) {
                $xmlWriter->WriteElementString("node_move", "yes");
            }
            if ($this->is_last_level) {
                $xmlWriter->WriteElementString("last_level", "yes");
            }

            if (strlen($this->custom_var) && strlen($this->custom_val)) {
                $xmlWriter->WriteElementString("custom_var", $this->custom_var);
                $xmlWriter->WriteElementString("custom_val", $this->custom_val);
            }
            if (strlen($this->host_library_ID)) {
                $xmlWriter->WriteElementString("host_library_ID", $this->host_library_ID);
            }
            if ($this->disabled_delete) {
                $xmlWriter->WriteElementString("disabled_delete", "yes");
            }
            else {
                $xmlWriter->WriteElementString("disabled_delete", "no");
            }
            if ($this->disabled_edit) {
                $xmlWriter->WriteElementString("disabled_edit", "yes");
            }
            else {
                $xmlWriter->WriteElementString("disabled_edit", "no");
            }
            if ($this->disabled_add) {
                $xmlWriter->WriteElementString("disabled_add", "yes");
            }
            else {
                $xmlWriter->WriteElementString("disabled_add", "no");
            }

            if ($this->disabled_copy) {
                $xmlWriter->WriteElementString("disabled_copy", "yes");
            }
            else {
                $xmlWriter->WriteElementString("disabled_copy", "no");
            }

            if ($this->disabled_move) {
                $xmlWriter->WriteElementString("disabled_move", "yes");
            }
            else {
                $xmlWriter->WriteElementString("disabled_move", "no");
                $xmlWriter->WriteElementString("move_field", $this->move_field);
            }

            if ($disable_lastlevel_list) {
                $xmlWriter->WriteElementString("disable_lastlevel_list", "yes");
            }
            else {
                $xmlWriter->WriteElementString("disable_lastlevel_list", "no");
            }

            if ($this->disabled_view) {
                $xmlWriter->WriteElementString("disabled_view", "yes");
            }
            else {
                $xmlWriter->WriteElementString("disabled_view", "no");
            }
            if ($this->disabled_apply) {
                $xmlWriter->WriteElementString("disabled_apply", "yes");
            }
            else {
                $xmlWriter->WriteElementString("disabled_apply", "no");
            }
            if (strlen($this->icon_file))
                $xmlWriter->WriteElementString("icon_file", $this->icon_file);
            $xmlWriter->WriteEndElement();

            $xmlWriter->WriteStartElement("headers");
            for ($i = 0; $i < sizeof($this->fields); $i ++) {
                if ($this->fields[$i]["control"] != "hidden") {
                    $xmlWriter->WriteStartElement("header");
                    $xmlWriter->WriteAttributeString("name", $this->fields[$i]["field_name"]);
                    $xmlWriter->WriteAttributeString("type", $this->fields[$i]["control"]);
                    if ($this->order == $this->fields[$i]["field_name"]) {
                        $xmlWriter->WriteAttributeString("selected", "1");
                        if ($this->attribute == "DESC") {
                            $xmlWriter->WriteAttributeString("direction", "1");
                        }
                        else {
                            $xmlWriter->WriteAttributeString("direction", "0");
                        }
                    }
                    $attribute = "";
                    if ($this->order == $this->fields[$i]["field_name"]) {
                        $attribute = ($this->attribute == "DESC" ? "" : ":DESC");
                    }

                    //get field title
                    if ($_Localization->HasItem($this->sectionname, $this->fields[$i]["caption_prefix"] . "_LIST_" . $this->fields[$i]["field_name"])) {
                        $caption = $this->Page->Kernel->Localization->GetItem($this->sectionname, $this->fields[$i]["caption_prefix"] . "_LIST_" . $this->fields[$i]["field_name"]);
                    }
                    else {
                        if ($_Localization->HasItem($this->sectionname, $this->fields[$i]["caption_prefix"] . $this->fields[$i]["field_name"])) {
                            $caption = $_Localization->GetItem($this->sectionname, $this->fields[$i]["caption_prefix"] . $this->fields[$i]["field_name"]);
                        }
                        else {
                            $caption = $_Localization->GetItem("main", $this->fields[$i]["caption_prefix"] . $this->fields[$i]["field_name"]);
                        }
                    }

                    $array = array(
                        "caption" => $caption , "href" => "?".($this->Package!="" ? "package=".$this->Package."&amp;" : "")."page=" . $this->self . "&amp;" . $this->library_ID . "_start=" . $this->_START . "&" . $this->library_ID . "_order_by=" . $this->fields[$i]["field_name"] . $attribute . "&amp;library=" . (strlen($this->host_library_ID) ? $this->host_library_ID . "&amp;" . $this->host_library_ID . "_parent_id=" . $this->parent_id : $this->library_ID . "&amp;" . $this->library_ID . "_parent_id=" . $this->parent_id) . $this->append_hrefs
                    );
                    if (! $this->fields[$i]["sort"]) {
                        $array["disabled"] = "yes";
                    }
                    $this->Controls["link"]->InitControl($array);
                    $this->Controls["link"]->XmlControlOnRender($xmlWriter);

                    //$xmlWriter->WriteString($caption);
                    $xmlWriter->WriteEndElement();
                    if (($this->fields[$i]["control"] == "checkbox") || ($this->fields[$i]["control"] == "radio")) {

                        $this->AddControl(new HiddenControl("hidden_" . $i, "hiddens"));
                        $this->Controls["hidden_" . $i]->InitControl(array(
                            "name" => "custom_vars[]" , "value" => $this->fields[$i]["field_name"]
                        ));

                    }
                    if (($this->fields[$i]["control"] == "text") || ($this->fields[$i]["control"] == "combobox")) {

                        $this->AddControl(new HiddenControl("hidden_" . $i, "hiddens"));
                        $this->Controls["hidden_" . $i]->InitControl(array(
                            "name" => "edit_custom_vars[]" , "value" => $this->fields[$i]["field_name"]
                        ));

                    }

                }
            }

            $xmlWriter->WriteEndElement();

            $this->BuildRows($xmlWriter);

            $this->AddControl(new HiddenControl("page", "hiddens"));
            $this->Controls["page"]->InitControl(array(
                "name" => "page" , "value" => $this->handler
            ));

            $this->AddControl(new HiddenControl("package", "hiddens"));
            $this->Controls["package"]->InitControl(array(
                "name" => "package" , "value" => $this->Package
            ));

            $this->AddControl(new HiddenControl("event", "hiddens"));
            $this->Controls["event"]->InitControl(array(
                "name" => "event" , "value" => "Apply"
            ));

            $this->AddControl(new HiddenControl("start", "hiddens"));
            $this->Controls["start"]->InitControl(array(
                "name" => $this->library_ID . "_start" , "value" => $this->start
            ));
            $this->AddControl(new HiddenControl("order_by", "hiddens"));
            $this->Controls["order_by"]->InitControl(array(
                "name" => $this->library_ID . "_order_by" , "value" => $this->order_by
            ));
            $this->AddControl(new HiddenControl("library", "hiddens"));
            $this->Controls["library"]->InitControl(array(
                "name" => "library" , "value" => $this->library_ID
            ));

            $this->AddControl(new HiddenControl("restore", "hiddens"));
            $this->Controls["restore"]->InitControl(array(
                "name" => "restore" , "value" => rawurlencode("old_page=" . $this->self)
            ));
            $this->AddControl(new HiddenControl("parent", "hiddens"));
            $this->Controls["parent"]->InitControl(array(
                "name" => $this->library_ID . "_parent_id" , "value" => $this->parent_id
            ));

            if ($this->Page->is_context_frame){
				$this->AddControl(new HiddenControl("contextframe", "hiddens"));
				$this->Controls["contextframe"]->InitControl(array(
					"name" => "contextframe" , "value" => "1"
				));
			}

            if (strlen($this->custom_var) && strlen($this->custom_val)) {
                $this->AddControl(new HiddenControl("custom_var", "hiddens"));
                $this->Controls["custom_var"]->InitControl(array(
                    "name" => "custom_var" , "value" => $this->custom_var
                ));
                $this->AddControl(new HiddenControl("custom_val", "hiddens"));
                $this->Controls["custom_val"]->InitControl(array(
                    "name" => "custom_val" , "value" => $this->custom_val
                ));
            } // if
            if (strlen($this->host_library_ID)) {
                $this->AddControl(new HiddenControl("host_library_ID", "hiddens"));
                $this->Controls["host_library_ID"]->InitControl(array(
                    "name" => "host_library_ID" , "value" => $this->host_library_ID
                ));

            } //if
        }
    }

    /**
     * Method check library access,redefine access variables of page
     * (use a ACCESS section definition) AND redirect WHEN access is denied
     * @access private
     **/
    function CheckLibraryAccess()
    {
        if ($this->listSettings->HasSection("ACCESS")) {
            if ($this->listSettings->HasItem("ACCESS", "GROUPS")) {
                $this->Page->access_id = explode(",", $this->listSettings->GetItem("ACCESS", "GROUPS"));

            }
            if ($this->listSettings->HasItem("ACCESS", "USERS")) {
                $this->Page->access_user_id = explode(",", $this->listSettings->GetItem("ACCESS", "USERS"));
            }
            if ($this->listSettings->HasItem("ACCESS", "ROLES")) {
                $this->Page->access_role_id = explode(",", $this->listSettings->GetItem("ACCESS", "ROLES"));
            }
            $this->Page->Auth->isLogged();
        }
    }

    /**
     * Method define filter control by ini-file definition
     * @access private
     **/
    function DefineFilterControl()
    {
        $filterconfig = $this->LibrariesRoot . $this->library_ID . ".filter.ini" . ".php";
        if (! file_exists($filterconfig))
            $filterconfig = $this->LibrariesRoot . $this->library_ID . ".filter.ini." . $this->Page->Kernel->Language . ".php";
        if (file_exists($filterconfig)) {
            $filterSettings = &ConfigFile::GetInstance("list_filter_" . $this->library_ID, $filterconfig);
            $fields_count = $filterSettings->GetItem("MAIN", "FIELDS_COUNT");
            $data = array();
            $this->use_filter_form = true;
            for ($i = 0; $i < $fields_count; $i ++) {
                $data[$i]["name"] = $filterSettings->GetItem("FIELD_" . $i, "FIELD_NAME");
                $data[$i]["table"] = $filterSettings->GetItem("FIELD_" . $i, "FIELD_TABLE");
                $data[$i]["id_name"] = $filterSettings->GetItem("FIELD_" . $i, "FIELD_ID_NAME");
                $data[$i]["caption_name"] = $filterSettings->GetItem("FIELD_" . $i, "FIELD_CAPTION_NAME");
                $data[$i]["type"] = $filterSettings->GetItem("FIELD_" . $i, "FIELD_TYPE");
                $data[$i]["value_type"] = $filterSettings->GetItem("FIELD_" . $i, "FIELD_VALUE_TYPE");
                if ($filterSettings->HasItem("FIELD_" . $i, "FIELD_EVENT")) {
                    $data[$i]["field_event"] = $filterSettings->GetItem("FIELD_" . $i, "FIELD_EVENT");
                }
                if ($filterSettings->HasItem("FIELD_" . $i, "FIELD_DYNAMIC_SELECT_CRITERIA")) {
                    $data[$i]["dynamic_select_criteria"] = $filterSettings->GetItem("FIELD_" . $i, "FIELD_DYNAMIC_SELECT_CRITERIA");
                }
                if ($filterSettings->HasItem("FIELD_" . $i, "FIELD_EXCLUDE_SQL")) {
                    $data[$i]["field_exclude_sql"] = $filterSettings->GetItem("FIELD_" . $i, "FIELD_EXCLUDE_SQL");
                }
                else {
                    $data[$i]["field_exclude_sql"] = 0;
                }

                if ($filterSettings->HasItem("FIELD_" . $i, "FIELD_APPLY_IF_SET")) {
                    $data[$i]["field_apply_if_set"] = $filterSettings->GetItem("FIELD_" . $i, "FIELD_APPLY_IF_SET", false, true);
                }
                else {
                    $data[$i]["field_apply_if_set"] = array();
                }

                if ($filterSettings->HasItem("FIELD_" . $i, "FIELD_OPTIONS")) {
                    $data[$i]["options"] = $filterSettings->GetItem("FIELD_" . $i, "FIELD_OPTIONS", false, true);
                }
                else {
                    $data[$i]["options"] = array();
                }

                if ($filterSettings->HasItem("FIELD_" . $i, "FIELD_CONSIDER_ZERO")) {
                    $data[$i]["consider_zero"] = $filterSettings->GetItem("FIELD_" . $i, "FIELD_CONSIDER_ZERO");
                }
                else {
                    $data[$i]["consider_zero"] = 0;
                }

                if ($filterSettings->HasItem("FIELD_" . $i, "FIELD_CUSTOM_GET_METHOD")) {
                    $data[$i]["field_custom_get_method"] = $filterSettings->GetItem("FIELD_" . $i, "FIELD_CUSTOM_GET_METHOD");
                }
                else {
                    $data[$i]["field_custom_get_method"] = null;
                }
                if ($filterSettings->HasItem("FIELD_" . $i, "FIELD_MULTIPLE")) {
                    $data[$i]["field_multiple"] = $filterSettings->GetItem("FIELD_" . $i, "FIELD_MULTIPLE");
                }
                else {
                    $data[$i]["field_multiple"] = 0;
                }
                if ($filterSettings->HasItem("FIELD_" . $i, "FIELD_IS_UNIX_TIMESTAMP")) {
                    $data[$i]["field_is_unix_timestamp"] = $filterSettings->GetItem("FIELD_" . $i, "FIELD_IS_UNIX_TIMESTAMP");
                }
                else {
                    $data[$i]["field_is_unix_timestamp"] = 0;
                }

                if ($data[$i]["type"] != "range") {
                    $data[$i]["current_value"] = ($data[$i]["consider_zero"] == 1 ? $this->Page->Request->Value($this->library_ID . "_filter_" . $data[$i]["name"]) : ($data[$i]["value_type"] == "int" ? $this->Page->Request->ToNumber($this->library_ID . "_filter_" . $data[$i]["name"], 0) : $this->Page->Request->Value($this->library_ID . "_filter_" . $data[$i]["name"])));
                }
                else {
                    $data[$i]["current_value"] = array(
                        "min" => $this->Page->Request->Value($this->library_ID . "_filter_" . $data[$i]["name"] . "_min") , "max" => $this->Page->Request->Value($this->library_ID . "_filter_" . $data[$i]["name"] . "_max")
                    );

                }
                $data[$i]["where_clause"] = $filterSettings->GetItem("FIELD_" . $i, "FIELD_WHERE_CLAUSE");
                if ($filterSettings->HasItem("FIELD_" . $i, "FIELD_SELECT_CRITERIA"))
                    $data[$i]["select_criteria"] = $filterSettings->GetItem("FIELD_" . $i, "FIELD_SELECT_CRITERIA");
                if ($this->Page->Kernel->Localization->HasItem($this->library_ID, "filter_" . $data[$i]["name"] . "_hint")) {
                    $data[$i]["hint"] = $this->Page->Kernel->Localization->GetItem($this->library_ID, "filter_" . $data[$i]["name"] . "_hint");
                }
            }
        }
        if (count($data)) {
            $this->AddControl(new ListFilterFormControl("filterform", "filterform", $data["settings"]));
            $this->Controls["filterform"]->InitControl($data);
        }
    }

    function RemoveFieldFromLibrary($field){
    	$fields_count = $this->listSettings->GetItem("LIST","FIELDS_COUNT");
    	for ($i=0; $i<$fields_count; $i++)
    		if ($this->listSettings->GetItem("FIELD_".$i, "FIELD_NAME")==$field ){
    			$this->listSettings->SetItem("FIELD_".$i, "CONTROL", "null");
    			$this->listSettings->SetItem("FIELD_".$i, "IN_LIST", 0);
    		}
    }

} // class


?>