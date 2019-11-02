<?php
/**
  * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
  * @version 1.0
  * @package Stat
  * @access public
 **/

$this->ImportClass("system.web.xmlcontrol", "XMLControl");
$this->ImportClass("web.controls.structurecontrol", "StructureControl");
$this->ImportClass("module.web.modulepage", "ModulePage");

class StructurePage extends ModulePage  {

    var $ClassName = "StructurePage";
    var $Version = "1.0";
    var $self = 'structure';
    var $node_id;
    var $id = 0;
    var $structure = array();
    var $PageMode = "Backend";
    var $access_role_id = array("ADMIN", "STRUCTURE_MANAGER", "CONTENT_EDITOR");


    /** Method creates child controls
     * @access public
     */
    function ControlOnLoad()
    {
        parent::ControlOnLoad();
        $this->node_id = $this->Page->Request->ToNumber('id', 0);
        $this->is_context_frame = $this->Request->ToNumber("contextframe", "0");
        $this->AddControl(new StructureControl("structure_tree", "structure_tree"));
        DataFactory::GetStorage($this, "ContentTable", "contentStorage", true, "content");

        if ($this->Page->Request->ToString('event', '')!="")
             if(!$this->Auth->isRoleExists("ADMIN,STRUCTURE_MANAGER")){
             	$this->AddWarningMessage('MESSAGES', 'ACTIONS_FORBIDDEN');
             	$this->Page->Request->SetValue('event', '');
             }

        $event=$this->Page->Request->ToString('event', '');

        foreach ($this->Page->Kernel->Languages as $language){
        	if ($event=="act_".$language."_lng"){
        		$data = array(
                    'id' => $this->node_id,
                    'active_'.$language => 1
                );
                $this->contentStorage->Update($data);
                $this->AddWarningMessage('MESSAGES', 'PAGE_LANG_HAS_BEEN_ACTIVATED');
        	}

        	if ($event=="deact_".$language."_lng"){
                $data = array(
                    'id' => $this->node_id,
                    'active_'.$language => 0
                );
                $this->contentStorage->Update($data);
                $this->AddWarningMessage('MESSAGES', 'PAGE_LANG_HAS_BEEN_DEACTIVATED');
        	}
        }

        $this->ReadStructure();

        switch($event){
            case 'act_page':
                $data = array(
                    'id' => $this->node_id,
                    'active' => 1
                );
                $this->contentStorage->Update($data);
                $this->SetStructureMessage('PAGE_HAS_BEEN_ACTIVATED');
                break;
            case 'deact_page':

                $data = array(
                    'id' => $this->node_id,
                    'active' => 0
                );

                $this->contentStorage->Update($data);
                $this->SetStructureMessage('PAGE_HAS_BEEN_DEACTIVATED');
                break;

            case 'del_page':
                $page_props = $this->contentStorage->Get(array('id' => $this->node_id));
				$nodes=array($this->node_id);
				$this->GetChildNodesId($this->structure[$this->node_id]["_children"], $nodes);

				// delete banners links
				if (Engine::isPackageExists($this->Kernel,"banner")){
					DataFactory::GetStorage($this, "BannerPagesTable", "bannerPagesStorage", true, "banner");
					$this->bannerPagesStorage->GroupDelete("page_id", $nodes);
				}

				// delete page and subpages
				$this->contentStorage->GroupDelete("id", $nodes);
				$this->contentStorage->RebuildPagesPath();

				$this->SetStructureMessage('PAGE_HAS_BEEN_DELETED');

                break;
            case 'deact_pages':
                $nodes=array($this->node_id);
				$this->GetChildNodesId($this->structure[$this->node_id]["_children"], $nodes);

                $this->contentStorage->GroupUpdate('id', $nodes, array('active' => 0));
                $this->SetStructureMessage('PAGE_BRANCH_HAS_BEEN_DEACTIVATED');
            case 'act_pages':
                $nodes=array($this->node_id);
				$this->GetChildNodesId($this->structure[$this->node_id]["_children"], $nodes);

                $this->contentStorage->GroupUpdate(
                    'id', $nodes, array('active' => 1));

                $this->SetStructureMessage('PAGE_BRANCH_HAS_BEEN_DEACTIVATED');

            case 'move_up':
                if ($pages = $this->contentStorage->GetPriorPageRecord($this->node_id)){
                    $data = array(
                        'id' => $pages['current']['id'],
                        'order_num' => $pages['prior']['order_num']
                    );
                    $this->contentStorage->Update($data);
                    $data = array(
                        'id' => $pages['prior']['id'],
                        'order_num' => $pages['current']['order_num']
                    );
                    $this->contentStorage->Update($data);
                    $this->SetStructureMessage('PAGE_HAS_BEEN_MOVED');
                }
                break;
            case 'move_down':
                if ($pages = $this->contentStorage->GetNextPageRecord($this->node_id)){
                    $data = array(
                        'id' => $pages['current']['id'],
                        'order_num' => $pages['prior']['order_num']
                    );
                    $this->contentStorage->Update($data);
                    $data = array(
                        'id' => $pages['prior']['id'],
                        'order_num' => $pages['current']['order_num']
                    );
                    $this->contentStorage->Update($data);
                    $this->SetStructureMessage('PAGE_HAS_BEEN_MOVED');
                }
                break;
            case 'page_move':
                $page_props = $this->contentStorage->Get(array('id' => $this->node_id));

				$to_node = $this->Page->Request->ToNumber('to', 0);
				$nodes=array();
				$this->GetChildNodesId($this->structure[$this->node_id]["_children"], $nodes);

				if (in_array($to_node, $nodes)){
					$message="CANT_MOVE_PAGE_HERE";
				} else {
					$message="PAGE_HAS_BEEN_MOVED";
					$data = array(
						'parent_id' =>  $to_node,
						'id'        => $this->node_id
					);
					$this->contentStorage->Update($data);
				}
				$this->contentStorage->RebuildPagesPath();

				$this->SetStructureMessage($message);
                break;
        }

        $this->Controls['structure_tree']->structure = $this->structure;
    }

	function GetChildNodesId(&$data, &$nodes){
		if (is_array($data)){
			foreach ($data as $i=>$node){
                $nodes[]=$i;
				if (!empty($node["_children"])){
					$this->GetChildNodesId($node["_children"], $nodes);
				}
			}
		}
        return $nodes;
    }

    function ReadStructure(){
        $this->structure=$this->contentStorage->GetTreeData(array(), "parent_id", array("order_num"=>0));
    }

    function XmlControlOnRender(&$xmlWriter){
    	$restore=rawurlencode("&old_page=structure&package=content".($this->is_context_frame ? "&contextframe=1" : ""));
    	$xmlWriter->WriteElementString("restore", $restore);
    	parent::XmlControlOnRender($xmlWriter);
    }

    function SetStructureMessage($message){
    	$url="?&page=structure&package=content".($this->is_context_frame ? "&contextframe=1" : "")."&MESSAGE[]=".$message;
        $this->Response->Redirect($url);
    }

}

?>