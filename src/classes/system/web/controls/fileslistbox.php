<?php
  $this->ImportClass("system.web.controls.treeselectcontrol","treeselectcontrol");
  $this->ImportClass("system.io.filesystem","FileSystem");

/** Select control
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Framework
     * @subpackage classes.system.web.controls
     * @access public
     */
    class FilesListBoxControl extends TreeSelectControl {
        var $ClassName = "TreeSelectControl";
        var $Version = "1.0";
        /**  Array with tree data
        * @var      array    $tree
        */
        var $tree;
        /**  Name of key field
        * @var    string   $key_field_name
        */
        var $key_field_name;
        /**  Name of parent field
        * @var    string    $parent_field_name
        */
        var $parent_field_name;
        /**  Name of caption field
        * @var    string    $caption_field_name
        */
        var $caption_field_name;

   /**
   * Method builds tree data for option select
   * @param    array    &$data    Array with tree data
   * @param        int        $node_id   Current node ID
   * @param        int        $level        Current level of recurcy
   * @param        array    &$options   Array with result options data
   * @access    public
   */
   function BuildRecursiveFilesTree(&$data, $node_id, $level, &$options){
       for($i=0; $i<sizeof($data); $i++){
           if($data[$i][$this->parent_field_name] == $node_id){

              $indent = "";
              $sub_indent = "";
              for($j=0; $j<$level; $j++){
                 $indent .= "&nbsp;&nbsp;&nbsp;";
                 $sub_indent = "&nbsp;&nbsp;&nbsp;";
              }
                 $has_children=0;
                 for($j=0; $j<sizeof($data); $j++){
                    if($data[$j][$this->parent_field_name] == $data[$i][$this->key_field_name]){
                      $has_children++;
                    }
                 }
                 if($has_children){
                    $indent .="[-]";
                    $sub_indent = "&nbsp;&nbsp;&nbsp;";
                 } else {
                   $indent.="&nbsp;&nbsp;&nbsp;&nbsp;";
                   $sub_indent = "&nbsp;&nbsp;&nbsp;&nbsp;";
                 }

        //build option (item) array
              $_tmp = $this->BuildItemData($data[$i],$indent);
              if($_tmp !== false){
                $options[] = $_tmp;
              }

                // using entries

              $this->BuildRecursiveFilesTree($data, $data[$i][$this->key_field_name], $level+1, $options);
           }
       }
   }

   /**
        * Method build item  data array
     * @param        array            $data                        input data
     * @param        string        $indent                    string indent
     * @return    array            item data array
     * @access    private
     **/
   function BuildItemData($data,$indent="")    {
        $option["caption"] = $indent.$data[$this->caption_field_name];
        $option["value"] = $data[$this->value_field_name];
        if($data["type"] == 0){
            if($this->data["show_files"]){
              $option["class"] = "category_class";
              if(!$this->data["dirs_select"]){
                unset($option["value"]);
              }
            }
            return $option;
        } else {
            if($this->data["show_files"]){
              $option["class"] = "entry_class";
               return $option;
            } else {
               return false;
            }
        }
   }

  /**
  * Method processes path and replaces some setings with its values
  * @param  string  $dir    PAth string to parse
  * @return string  Parsed path
  * @access public
  **/
  function ProcessDirectoryPath($dir){
           preg_match_all("/\{(.*?)\}/", $dir, $matches);
           $size = sizeof($matches[0]);
           for($i=0; $i<$size; $i++){
                if($this->Page->Kernel->Settings->HasItem("module", $matches[1][$i])){
                    $subject=$this->Page->Kernel->Settings->GetItem("module", $matches[1][$i]);
                } else {
                    $subject = $matches[0][$i];
                }
                $dir = str_replace($matches[0][$i], $subject, $dir);
           }
           return $dir;

  }

        /**
        * Method Inits data for control
        * @param    array   $data   Array with initial data
        * @access public
        **/
   function InitControl($data=array()){
           $this->data["name"] = $data["name"];
           $this->data["selected_value"] = $data["value"];
           $this->data["caption"] = $data["caption"];
           $this->data["directory"] =  $this->ProcessDirectoryPath( $data["directory"]);

           $this->caption_field_name = "caption";
           $this->parent_field_name = "parent";
           $this->key_field_name = "path";
           $this->value_field_name = "value";

           $this->data["multiple"] = $data["multiple"];

           $this->data["files_filter"] = ($data["files_filter"]==""? "/.*/":$data["files_filter"]);
           $this->data["dirs_filter"] = ($data["dirs_filter"]==""? "/.*/":$data["dirs_filter"]);

           $this->data["show_files"] = $data["show_files"];
           $this->data["dirs_select"] = $data["dirs_select"];
           $this->data["item_id"]=($data["item_id"]==""? 0:$data["item_id"]);
           $this->data["event"]=$data["event"];

      $options=array();
      if($data["use_root_caption"]){
         if (is_array($this->Page->library_ID))   {
             $library_keys = array_keys($this->Page->library_ID);
             $library_ID = $library_keys[0];
         }      else   {
             $library_ID = $this->Page->library_ID;
         }
        $option["caption"] = $this->Page->Kernel->Localization->GetItem(strtoupper($library_ID), strtolower($data["name"])."_caption_tree_root");
        $option["value"] = "";
        $option["selected"] = "";
        $options[] = $option;
      }

      if ($data["multiple"] && $this->Page->Event=="EditItem") {
              $Table=$this->Page->listSettings->GetItem("FIELD_".$data["number"],"RELATIONS_TABLE");
              $Storage = DataFactory::GetStorage($this, $Table);
              $data=$Storage->GetLst(array($this->Page->key_field=>$this->Page->Request->Value("item_id")));

              $this->data["selected_value"]=array();
              while (!$data->isClosed())   {
                  $rec=$data->Read();
                  $this->data["selected_value"][] = $rec[$this->data["name"]];

              }
      }


      $_init_data = array("path" => $this->data["directory"],
                          "show_files" => $this->data["show_files"],
                          "dirs_filter" => $this->data["dirs_filter"],
                          "files_filter" => $this->data["files_filter"],
                          "dirs_select" => $this->data["dirs_select"]
                          );
      FileSystem::GetRecursiveDirsList($_init_data, "", $list);
      $this->BuildRecursiveFilesTree($list, $this->data["directory"], 0, $options);
      $this->data["options"] = $options;

  }

}// class
?>