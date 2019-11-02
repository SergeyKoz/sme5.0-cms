<?php
 $this->ImportClass("system.web.controls.select","selectcontrol");
 $this->ImportClass("system.web.controls.dbfield","dbfieldcontrol");
 $this->ImportClass("system.web.controls.dbtreepath","dbtreepathcontrol");
 $this->ImportClass("system.data.datamanipulator","datamanipulator");

/**  MenuTreeControl control
   * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
   * @version 1.0
   * @package Framework
   * @subpackage classes.system.web.controls
   * @access public
   */
  class MenuTreeControl extends DbFieldControl  {

    var $ClassName = "MenuTreeControl";
    var $Version = "1.0";

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
    parent::ControlOnLoad();
  }

   /**
   * Method builds tree data for option select
   * @param    array    &$data      Array with tree data
   * @param    int      $node_id    Current node ID
   * @param    int      $level      Current level of recurcy
   * @param    array    &$options   Array with result options data
   * @access  public
   */
   function BuildRecursiveTree(&$data, $node_id,  &$xmlWriter){
     for ($i=0; $i<count($data);$i++){
      if (is_array($data[$i]))  {
       if($data[$i][$this->parent_field_name] == $node_id){
         // drawing node
        $xmlWriter->WriteStartElement("node");
        $xmlWriter->WriteAttributeString("id", $data[$i][$this->key_field_name]);
        $xmlWriter->WriteElementString("caption", addslashes($data[$i][$this->caption_field_name]));
        $xmlWriter->WriteElementString("url", $data[$i][$this->url_name]);
                // drawing sub-nodes
        $xmlWriter->WriteStartElement("sub_node_list");
        $this->BuildRecursiveTree($data, $data[$i][$this->key_field_name], $xmlWriter);
        $xmlWriter->WriteEndElement();
        $xmlWriter->WriteEndElement();

       }
      }
     }
   }

   /**
   * MEthod sets data to draw by select control
   * @param    array   $data  Array with data
   * @access   public
   */
   function SetTreeData($data){
    $this->InitControl($data);

   }
   /**
   * MEthod sets data to draw by select control
   * @param    array   $data  Array with data
   * @access   public
   */
   function InitControl($data=array()){
      $_page_id=$this->Page->Request->globalValue("_page_id");
      $menuFile=&ConfigFile::GetInstance("menuIni",$this->Page->Kernel->Settings->GetItem("module","ResourcePath").$data["file"]);
      $this->parent_field_name="parentid";
      $this->caption_field_name="caption";
      $this->image_field_name="image";
      $this->key_field_name="id";
			$this->url_name="url";
      $this->root=$data["root"];
      $this->onelevel=$data["onelevel"];
      //create menu structure
      $i=1;
      $currentid=0;
      foreach ($menuFile->Sections as $name => $section)  {
          $section["id"] = $i;
          $section["parentid"] = 0;
          $section["caption"] = $section[sprintf("name_%s",$this->Page->Kernel->Language)];
          $section["image"] = $section["image"];
          $i++;
          if ($menuFile->HasItem($name,"parent"))  {
             $parentname=strtolower($menuFile->GetItem($name,"parent"));
             $section["parentid"]=$sections[$parentname]["id"];
          }
          //search in array current url
          if (!is_array($section["url"]))
            $section["url"]=array($section["url"]);
          if (in_array($this->Page->PageURI,$section["url"]) || $section["page_id"]==$_page_id)  $currentid=$section["id"];
          $section["url"]=$section["url"][0];
          $sections[$name]=$section;
      }
      $this->data["selected_value"]=$currentid;
      foreach($sections as $name => $section) $this->_list[]=$section;
   }


   /**
   *  Method Draws XML-content of a control
   *  @param XMLWriter    $xmlWriter  instance of XMLWriter
   *  @access private
   */
   function XmlControlOnRender(&$xmlWriter) {
    $xmlWriter->WriteStartElement("menu");
    $xmlWriter->WriteElementString("value",$this->data["selected_value"]);
	  if($this->data["selected_value"]!=0 || $this->root){
    	$_list=array();
      DataManipulator::BuildTreeFromBottom($this->_list, $this->data["selected_value"],$this->key_field_name,$this->parent_field_name,$_list);
      if (!$this->root) $root_node=array_pop($_list);
      //write image node
	    $_list=array();
	    DataManipulator::GetRecursiveNodeList($this->_list,$root_node[$this->key_field_name], $this->key_field_name, $this->parent_field_name,$_list);

      //--one level menu
      if ($this->onelevel)    {
			  foreach($_list as $key => $item)	{
      	  $item[$this->parent_field_name]=0;
      	  $_newlist[]= $item;
	      }
      }   else  {
        $_newlist=$_list;
      }
      $xmlWriter->WriteElementString("image",$root_node["image"]);
			$xmlWriter->WriteElementString("caption",$root_node["caption"]);
      $xmlWriter->WriteElementString("url",$root_node["url"]);
      $xmlWriter->WriteStartElement("categories");
	    $xmlWriter->WriteStartElement("sub_node_list");
  	  $this->BuildRecursiveTree($_list, 0, $xmlWriter);
    	$xmlWriter->WriteEndElement();
	  }
    $xmlWriter->WriteEndElement("menu");
  }


  }// class
?>