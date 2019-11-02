<?php
 $this->ImportClass("system.web.controls.select","selectcontrol");

/** DbFieldControl control
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Framework
     * @subpackage classes.system.web.controls
     * @access public
     */
    class DbFieldControl extends FormControl {
        var $ClassName = "DbFieldControl";
        var $Version = "1.0";
        /**  Phonetypes table object
        * @var  PhoneTypesLibTable   $Storage
        */
        var $Storage;
        /**  Array with phonetypes
        * @var    array   $types
        */
        var $list;

    /**
     * Method  Executes on control load to the parent
     * @access  private
     */
    function ControlOnLoad(){
      //parent::ControlOnLoad();
    }

   /**
   * Method sets control with initial data
   * @access public
   */
   function InitControl($data=array()){

      $this->data = $data;
      $this->data["name"] = $data["name"];
      $this->data["selected_value"] = $data["selected_value"];
      $this->data["table"] = $data["table"];
      $this->data["caption_field"] = $data["caption_field"];
      $this->data["caption"] = $data["caption"];
      $method = ($data["method"]==""? "GetList":$data["method"]);
      $this->data["query_data"] = ($data["query_data"]==""? null:$data["query_data"]);
      $this->data["orders"] = ($data["orders"]==""? null:$data["orders"]);
      $this->Page->Kernel->ImportClass("data.".strtolower($this->data["table"]), $this->data["table"]);
      if(!isset($this->data["library"])){
         $this->data["library"] = $this->Page->library_ID;
      }
      $this->Storage =  new $this->data["table"] ($this->Page->Kernel->Connection, $this->Page->Kernel->Settings->GetItem("database",$this->data["table"]));

      $list = $this->Storage->$method($this->data["query_data"],$this->data["orders"]);
      $this->list = array();
      if(is_array($list)){
          $this->list = $list;
      } else {
          for($i=0; $i<$list->RecordCount; $i++){
                $this->list[] = $list->Read();
          }
      }
      $keyField = $this->Storage->getKeyColumns();
      if($data["use_root_caption"]){
         $option = array();
         $option["caption"]  = $this->Page->Kernel->Localization->GetItem(strtoupper($this->data["library"]), strtolower($data["name"])."_caption_tree_root");
         $option["value"]  = "";
         $option["selected"] = "";
         $this->data["options"][] = $option;
      }

      for($i=0; $i<sizeof($this->list); $i++){
         $option = array();
         $option["caption"]  = $this->list[$i][$this->data["caption_field"]];
         $option["value"]  = $this->list[$i][$keyField[0]["name"]];
         $this->data["options"][] = $option;
      }
      if ($data["multiple"] && $this->Page->Event=="EditItem") {
              $Table=$this->Page->listSettings->GetItem("FIELD_".$data["number"],"RELATIONS_TABLE");
              $this->Page->Kernel->ImportClass("data.".strtolower($Table), $Table);
              $Storage =  new $Table ($this->Page->Kernel->Connection, $this->Page->Kernel->Settings->GetItem("database",$Table));
              $data=$Storage->$method(array($this->Page->key_field=>$this->Page->Request->Value("item_id")));
              $this->data["selected_value"]=array();
              while (!$data->isClosed())   {
                  $rec=$data->Read();
                  $this->data["selected_value"][]=$rec[$this->data["name"]];
              }


      }
   }

 /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
   function XmlControlOnRender(&$xmlWriter) {
   }


 }// class
?>