<?php
$this->ImportClass ( "system.web.xmlcontrol", "XMLControl" );

$this->ImportClass ( "system.cache.cache", "Cache" );

$this->ImportClass ( "system.web.controls.recordcontrol", "RecordControl" );
$this->ImportClass ( "system.web.controls.navigationcontrol", "NavigationControl" );
$this->ImportClass ( "web.helper.publicationhelper", "PublicationHelper", "publications" );

/** Publication control class
 * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
 * @version 1.0
 * @package Publications
 * @subpackage classes.web.controls
 * @access public
 */
class PublicationControl extends XmlControl {
	var $ClassName = "PublicationControl";
	var $Version = "1.0";

	/**
	 * Method executes on control load
	 * @access   public
	 **/
	function ControlOnLoad() {
		// getting storages
		DataFactory::GetStorage ( $this, "ContentTable", "contentStorage", true, "content" );
		DataFactory::GetStorage ( $this, "MappingTable", "mappingStorage", true, "publications" );
		DataFactory::GetStorage ( $this, "PublicationsTable", "publicationsStorage", true, "publications" );
		DataFactory::GetStorage ( $this, "TemplatesTable", "templatesStorage", true, "publications" );

		$this->UseContext=Engine::isPackageExists($this->Page->Kernel, "context");

		$this->UseTags=Engine::isPackageExists($this->Page->Kernel, "tags");
		if ($this->UseTags){
           DataFactory::GetStorage ( $this, "TagsTable", "tagsStorage", true );
  		}

  		$this->UseComments = Engine::isPackageExists ( $this->Page->Kernel, "comments" );

		// Getting mappings list
		$this->GetMappings();

		$this->GetPublications();
		// instantiating navigator
		$this->Navigator = new NavigationControl ( "navigator", "navigator" );
		$this->Navigator->Page = & $this->Page;
	}

	/**
	 * Method returns mappings array depending on http query data
	 * @access   public
	 **/
	function GetMappings() {
        $this->pid = $this->Page->Request->ToNumber ( "pid", 0 );
        $page_id=DataDispatcher::Get ( "page_id" );

		$filename = $this->Page->Kernel->Settings->GetItem ( "Module", "SitePath" ) . "CACHE/mappings/publication_".$page_id."_".$this->pid;
		if (CACHE::hasValidCache ( $filename, 3600 )) {
			$this->mappings = CACHE::GetCachedContent ( $filename );
		} else {

			$this->mappings = array ();


			if ($this->pid == 0) {
				// if no Publication ID passed
				$_reader = $this->mappingStorage->GetMappingList ( $page_id );
				for($i = 0; $i < $_reader->RecordCount; $i ++) {
					$_tmp = $_reader->Read ();
					if ($_tmp ["target_entry_point"]) {
						$page=$this->contentStorage->Get(array ("id" => $_tmp ["target_entry_point"] ));
						$_tmp ["target_entry_point_url"]= $page["path"].($page["path"]!="" ? "/" : "");
					}
					if ($this->UseComments) $this->GetCommentsGroup($_tmp);
					$this->mappings [] = $_tmp;
				}
			} else {
				// if there is a publication id
				// Getting recursively maping list
				$_publication = $this->publicationsStorage->Get ( array ("publication_id" => $this->pid ) );
				$_template = $this->templatesStorage->Get ( array ("template_id" => $_publication["template_id"] ) );
				$_reader = $this->mappingStorage->GetRecursiveMappingList ( $page_id, $this->pid );
				for($i = 0; $i < $_reader->RecordCount; $i ++) {
					$_tmp = $_reader->Read ();
					// making publication id substitution
					$_tmp ["publication_id_fix"] = $_tmp ["publication_id"];
					$_tmp ["publication_id"] = $this->pid;
					if ($_tmp ["target_entry_point"]) {
						$page=$this->contentStorage->Get(array ("id" => $_tmp ["target_entry_point"] ));
						$_tmp ["target_entry_point_url"]= $page["path"].($page["path"]!="" ? "/" : "");
					}

					if ($this->UseComments) $this->GetCommentsGroup($_tmp);

					$_tmp ["disable_comments"] = $_publication ["disable_comments"];
					$_tmp ["owner_id"] = $_publication ["_created_by"];
                    $_tmp ["is_category"] = $_template ["is_category"];
					$this->mappings [] = $_tmp;
				}

				if ($this->UseTags && empty($this->mappings)){
                   $record=$this->templatesStorage->Get(array("template_id"=>$_publication["template_id"], "enable_seo_params"=>1));
                   if ($record["base_mapping_tags"]>0){
                   	   	$_reader = $this->mappingStorage->GetRecursiveMappingListTags($this->pid);
						for($i = 0; $i < $_reader->RecordCount; $i ++) {
							$_tmp = $_reader->Read ();
							$_tmp ["publication_id_fix"] = $_tmp ["publication_id"];
							$_tmp ["publication_id"] = $this->pid;
							if ($_tmp ["target_entry_point"]) {
								$page=$this->contentStorage->Get(array ("id" => $_tmp ["target_entry_point"] ));
								$_tmp ["target_entry_point_url"]= $page["path"].($page["path"]!="" ? "/" : "");
							}
							if ($this->UseComments) $this->GetCommentsGroup($_tmp);
							$_tmp ["disable_comments"] = $_publication ["disable_comments"];
							$_tmp ["owner_id"] = $_publication ["_created_by"];
							$_tmp ["is_category"] = $_template ["is_category"];
							$this->mappings [] = $_tmp;
						}
                   }
				}

				$_tmp = array ();
				$_reader = $this->mappingStorage->GetPermanentPageMappings ( $page_id );
				for($i = 0; $i < $_reader->RecordCount; $i ++) {
					$_tmp = $_reader->Read ();
					// making publication id substitution
					if ($_tmp ["target_entry_point"]) {
						$page=$this->contentStorage->Get(array ("id" => $_tmp ["target_entry_point"] ));
						$_tmp ["target_entry_point_url"]= $page["path"].($page["path"]!="" ? "/" : "");
					}
					if ($this->UseComments) $this->GetCommentsGroup($_tmp);

					$this->mappings [] = $_tmp;
				}

				if (empty ( $this->mappings ))
					$_reader_all = $this->mappingStorage->GetMappingList ( $page_id );
				else
					$_reader_all = $this->mappingStorage->GetMappingList ( 0 );

				for($i = 0; $i < $_reader_all->RecordCount; $i ++) {
					$_tmp = $_reader_all->Read ();
					if ($_tmp ["target_entry_point"]) {
						$page=$this->contentStorage->Get(array ("id" => $_tmp ["target_entry_point"] ));
						$_tmp ["target_entry_point_url"]= $page["path"].($page["path"]!="" ? "/" : "");
					}
					if ($this->UseComments) $this->GetCommentsGroup($_tmp);
					$this->mappings [] = $_tmp;
				}
			}

			if ($this->UseTags) PublicationHelper::GetMappingsTags($this, $this->mappings);

			CACHE::RenewCache ( $filename, $this->mappings );
		}

		if ($this->UseTags){
	        $tags = $this->Page->Request->Value("tag", REQUEST_ALL, false);
			if (count($tags))
				for($i = 0; $i < count($this->mappings); $i ++){
					$tag=trim($tags[$this->mappings[$i]["mapping_id"]]);
					if ($tag!='')$this->mappings[$i]["tag"]=$tag;
				}
		}

		if ($this->UseContext){
			foreach($this->mappings as $mapping){
                if ($mapping["publication_type"]==0){
                	$context_parameters=array(	"item_id"=>$mapping["publication_id"],
                								"parent_id"=>$mapping["publication_category"],
                								"language"=>$this->Page->Kernel->Language,
                								"storage"=>$this->publicationsStorage);
					$this->Page->Controls["cms_context"]->AddContextMenu("publication", "publications", $context_parameters);
                }else{
                    $context_parameters=array(	"item_id"=>$mapping["mapping_id"],
                								"publication_id"=>$mapping["publication_id"],
                								"storage"=>$this->mappingStorage);
					$this->Page->Controls["cms_context"]->AddContextMenu("mapping", "publications", $context_parameters);
                }
			}
		}
	}

	function GetCommentsGroup(&$mapping){
        if ($mapping["publication_type"]==0)
        	$mapping["comments_group_id"]=($mapping["publication_category"]>0 ? $mapping["publication_category"] : $mapping["publication_id"]);
	}

	function CreateChildControls() {
		parent::CreateChildControls ();

		//$page_id = DataDispatcher::Get ( "page_id" );

		//$point_url = $this->Page->Controls["cms_page"]->structure["point_url"];
		//$PageData = $this->Page->Controls["cms_page"]->structure["structure"] [$page_id];

		$reader = $this->templatesStorage->GetList(array("active" =>1, "is_category" =>1));
		$is_category_templates = array();
		for($i = 0; $i < $reader->RecordCount; $i++) {
			$tmp = $reader->read();
			$is_category_templates[] = $tmp["template_id"];
		}

		$pathes = DataDispatcher::Get("PATHES");
	    $titles = DataDispatcher::Get("page_titles");

		// Drawing navigation line
		foreach ( $this->mappings as $mapping ) {
			if ($mapping["navigation"] == 1 && $mapping["page_id"] != 0 && $mapping["publication_type"] == 1) {
				$TmpMap = $this->mappingStorage->Get ( array ("mapping_id" => $mapping ["mapping_id"] ) );
				if ($this->publications [$mapping ["mapping_id"]] [0] ["parent_id"] != $TmpMap["publication_id"]) {
					$node_path = array ();
					$this->GetRecursivePath($mapping ["publication_id"], $TmpMap ["publication_id"], $node_path );
					$node_path = array_reverse ( $node_path );
					for($i = 0; $i < count ($node_path ); $i ++){
						if (in_array ( $node_path[$i]["template_id"], $is_category_templates )) {
                            $title=$node_path[$i]["_sort_caption_".$this->Page->Kernel->Language];
                            $url=$mapping["target_entry_point_url"].$node_path[$i]["system"]."-publication/";
							$pathes[] = array("title" => $title, "url" => $url);
			       			$titles[] = $title;
						}
					}
				}
			}
		}

		foreach ($this->mappings as $mapping) {
			if ($mapping["navigation"]== 1 && $mapping["page_id"] != 0 && $mapping["publication_type"] == 0){
				$fields = $this->publications[$mapping["mapping_id"]];
				foreach ($fields as $field){
					if ($field["is_caption"] == 1 && $field["active"] == 1) {
						$title=$field["cur_value"];
						$url=$point_url."?pid=".$this->pid;
						$pathes[] = array("title"=>$title, "url"=>$url);
			       		$titles[] = $title;
					}
				}
			}
		} // foreach

		DataDispatcher::Set("PATHES", $pathes);
	    DataDispatcher::Set("page_titles", $titles);
	}

	function GetRecursivePath($publication_id, $to_publication, &$node_path) {
		$tmp = $this->publicationsStorage->Get ( array ("publication_id" => $publication_id ) );
		$node_path [] = $tmp;
		if ($tmp ["parent_id"] != $to_publication)
			$this->GetRecursivePath ( $tmp ["parent_id"], $to_publication, $node_path );
	}

	/**
	 * Method draws navigator for specified mapping
	 *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
	 *  @param   array   $_mapping   Mapping array
	 *  @param   int   $_total   Total number of records

	 *  @access  public
	 **/
	function DrawNavigator(&$xmlWriter, &$_mapping, $_total) {
		// setting up navigator data
		$pid=$this->Page->Request->Value("pid");
		$tag=($_mapping["tag"]!="" ? "tag[".$_mapping ["mapping_id"]."]=".urlencode($_mapping["tag"])."&" : "");
		$this->Navigator->SetData ( array (	"prefix" => "",
											"var_name" => ($pid>0 ? "pid=".$pid."&" :"").$tag."start[" . $_mapping ["mapping_id"] . "]",
											"start" => $this->Start [$_mapping ["mapping_id"]], "total" => $_total,
											"ppd" => $_mapping ["pages_per_decade"],
											"rpp" => $_mapping ["records_per_page"], "url" => "?" ) );
		// drawing navigator
		$xmlWriter->WriteStartElement ( "navigator" );
		$this->Navigator->XmlControlOnRender ( $xmlWriter );
		$xmlWriter->WriteEndElement ( "navigator" );

	}

	/**
	 * Method draws short publications list
	 *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
	 *  @param   array   $_mapping   Mapping array
	 *  @param   bool    $categories   true = extract categories list, fakse = extract publications list
	 *  @param   int     $in_list    Select only fields that has SHOW IN LIST flag set if 1, or all otherwise
	 *  @access  public
	 **/
	function DrawShortList(&$xmlWriter, &$_mapping, $categories, $in_list = 1) {
		// Total number of publications awailable
		$_counter = $this->publicationsStorage->GetPublicationsShortListCount ( $_mapping, $categories );

		$sizeof = sizeof ( $this->publications [$_mapping ["mapping_id"]] );

		for($i = 0; $i < $sizeof; $i ++) {
			$_tmp = $this->publications [$_mapping ["mapping_id"]] [$i];

			// Publication ID in array
			$_publications_id [] = $_tmp ["publication_id"];
			// Publications in array
			$_publications [] = $_tmp;

		}
		// Drawing publications
		PublicationHelper::DrawPublicationShortList ( $this, $xmlWriter, $_publications_id, $_publications, $this->parameters[$_mapping["mapping_id"]], $this->tags[$_mapping["mapping_id"]], $_mapping, $in_list );
		// Drawing navigator
		if ($_mapping ["records_per_page"] > 0) {
			$this->DrawNavigator ( $xmlWriter, $_mapping, $_counter );
		}
	}

	/**
	 * Method gets short publications list
	 *  @param   array   $_mapping   Mapping array
	 *  @param   bool    $categories   true = extract categories list, fakse = extract publications list
	 *  @param   int     $in_list    Select only fields that has SHOW IN LIST flag set if 1, or all otherwise
	 *  @access  public
	 **/
	function GetShortListData(&$_mapping, $categories, $in_list = 1) {
		// Getting Publications list
		$_reader = $this->publicationsStorage->GetPublicationsShortList($_mapping, $categories);
		$_publications = array ();
		for($i = 0; $i < $_reader->RecordCount; $i ++) {
			$_tmp = $_reader->Read ();
			// Publication ID in array
			$_publications_id [] = $_tmp ["publication_id"];
			// Publications in array
			$_publications [] = $_tmp;

			if ($this->UseContext && $in_list==0){
               	$context_parameters=array(	"item_id"=>$_tmp["publication_id"],
               								"parent_id"=>$_tmp["parent_id"],
               								"language"=>$this->Page->Kernel->Language,
               								"storage"=>$this->publicationsStorage);
				$this->Page->Controls["cms_context"]->AddContextMenu("publication", "publications", $context_parameters);
			}
		}

        if ($this->UseTags)
			$this->tags[$_mapping ["mapping_id"]]=PublicationHelper::GetPublicationTags($this, $_publications_id);

		// setting up parameters of publications
		$this->parameters [$_mapping ["mapping_id"]] = PublicationHelper::GetPublicationShortListData ( $this, $_publications_id, $_publications, $_mapping, $in_list );
		return $_publications;
	}

	/**
	 * Method gets page number for current mapping
	 * @param    int   $id   Mapping ID
	 * @return   int    Page number
	 * @access   public
	 **/
	function GetListPagesNumber($id) {
		$start_array = $this->Page->Request->Value ( "start", REQUEST_QUERYSTRING, false );
		if (! is_array ( $start_array )) {
			$_id = 0;
			$start_array [0] = $start_array;
		}
		$_start = 0;
		if (isset ( $start_array [$id] )) {
			if ($start_array [$id] >= 0) {
				$_start = $start_array [$id];
			}
		}
		return $_start;
	}

	/**
	 * Method adds paging indexes to current page
	 * @param     string    $id              Pagind index
	 * @param     int       $page_number     Pagind value
	 * @access    public
	 **/
	function AddPaging($id, $page_number) {
		$this->Start [$id] = $page_number;
	}

	/**
	 *  Method draws xml-content of control
	 *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
	 *  @access  public
	 */
	function GetPublications() {
		if (! empty ( $this->mappings )) {
			// for each mapping on the page
			foreach ( $this->mappings as $_mapping ) {
				// Starting getting of mapping data
				if ($_mapping ["publication_type"] == 0) {
					// Single publication
					$this->publications [$_mapping ["mapping_id"]] = PublicationHelper::GetSinglePublicationContent($this,$_mapping);
					if (($_mapping ["enable_comments"] == 1) && ($_mapping ["disable_comments"] == 0 && $this->UseComments)){
						DataDispatcher::Set ( "comments", $_mapping ["publication_id"], "a", "publications_".$_mapping ["comments_group_id"] );
					}
				} elseif ($_mapping ["publication_type"] == 1) {
					// Categories list
					$this->publications [$_mapping ["mapping_id"]] = $this->GetShortListData ( $_mapping, true );
				} elseif ($_mapping ["publication_type"] == 2) {
					// Short list of publications
					$this->publications [$_mapping ["mapping_id"]] = $this->GetShortListData ( $_mapping, false );
				} elseif ($_mapping ["publication_type"] == 3) {
					// Detailed list of publictiopns
					$this->publications [$_mapping ["mapping_id"]] = $this->GetShortListData ( $_mapping, false, 0 );
				}
			}
		}
	} // function


	/**
	 *  Method draws xml-content of control
	 *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
	 *  @access  public
	 */
	function XmlControlOnRender(&$xmlWriter) {
		if (! empty ( $this->mappings )) {
			// for eacj mapping on the page
			foreach ( $this->mappings as $_mapping ) {

				// Adding paging state of current mapping
				$this->AddPaging ( $_mapping ["mapping_id"], $this->GetListPagesNumber ( $_mapping ["mapping_id"] ) );

				// Extracting template to include in main template file
				PublicationHelper::ExtractPublicationTemplate ( $this->Page, $_mapping );

				// Starting drawing of mapping data
				$xmlWriter->WriteStartElement ( "mapping" );
				$xmlWriter->WriteAttributeString ( "id", $_mapping ["mapping_id"] );
				$xmlWriter->WriteAttributeString ( "publication_id", $_mapping ["publication_id"] );
				$xmlWriter->WriteAttributeString ( "publication_type", $_mapping ["publication_type"] );
				$xmlWriter->WriteAttributeString ( "system_name", $_mapping ["system_name"] );
				$xmlWriter->WriteAttributeString ( "enable_comments", $_mapping ["enable_comments"] );
				if (isset ( $_mapping ["target_entry_point_url"] )) {
					$xmlWriter->WriteAttributeString ( "target_entry_point_url", $_mapping ["target_entry_point_url"] );
				}
				$xmlWriter->writeElementString("caption", $_mapping['_sort_caption_'. $this->Page->Kernel->Language] );

				if ($_mapping ["publication_type"] == 0) {
					// Single publication drawing
					PublicationHelper::ProcessPublicationContent ( $this, $xmlWriter, $_mapping, $this->tags[$_mapping["mapping_id"]], $this->publications [$_mapping ["mapping_id"]] );
				} elseif ($_mapping ["publication_type"] == 1) {
					// Categories list drawing
					$this->DrawShortList ( $xmlWriter, $_mapping, true );
				} elseif ($_mapping ["publication_type"] == 2) {
					// Short list of publications drawing
					$this->DrawShortList ( $xmlWriter, $_mapping, false );
				} elseif ($_mapping ["publication_type"] == 3) {
					// Detailed list of publictiopns drawing
					$this->DrawShortList ( $xmlWriter, $_mapping, false, 0 );
				}
				if ($this->UseTags)
					PublicationHelper::DrawPublicationTags($xmlWriter, $_mapping["tags"], $this);
				$xmlWriter->WriteEndElement ( "mapping" );
			}
		}
		//$this->DrawPagingState ( &$xmlWriter );
	} // function


} // class


?>