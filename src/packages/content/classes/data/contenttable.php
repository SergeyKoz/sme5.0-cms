<?php
$this->ImportClass("system.data.abstracttable", 'AbstractTable');
$this->ImportClass("web.helper.packagehelper", 'PackageHelper');

class ContentTable extends AbstractTable
{
  var $ClassName = "ContentTable";
  var $Version = "1.0";

/**
 * Class constructor
 * @author Alexandr Degtiar <adegtiar@activemedia.com.ua>
 * @param  MySqlConnection   $Connection Connection object
 * @param  string    $TableName    Table name
 * @access public
 */
    function ContentTable(&$Connection, $TableName) {
        AbstractTable::AbstractTable($Connection, $TableName);
    }

    function prepareColumns(){
        $this->columns[] = array("name" => "id",            "type" => DB_COLUMN_NUMERIC, "key" => true, "incremental" => true);
        $this->columns[] = array("name" => "parent_id",     "type" => DB_COLUMN_NUMERIC);
        $this->columns[] = array("name" => "name",          "type" => DB_COLUMN_STRING);

        $this->columns[] = array("name" => "active",        "type" => DB_COLUMN_NUMERIC);
        $this->columns[] = array("name" => "active_%s",     "type" => DB_COLUMN_NUMERIC);
        $this->columns[] = array("name" => "content_%s",    "type" => DB_COLUMN_STRING);
		$this->columns[] = array("name" => "title_%s",      "type" => DB_COLUMN_STRING, "notnull"=>1);
        $this->columns[] = array("name" => "show_in_top_menu",      "type" => DB_COLUMN_NUMERIC);
        $this->columns[] = array("name" => "show_in_page_menu",     "type" => DB_COLUMN_NUMERIC);
        $this->columns[] = array("name" => "show_in_bottom_menu",   "type" => DB_COLUMN_NUMERIC);
        $this->columns[] = array("name" => "show_in_sitemap",       "type" => DB_COLUMN_NUMERIC);
        $this->columns[] = array("name" => "order_num",             "type" => DB_COLUMN_NUMERIC);

        $this->columns[] = array("name" => "path",                  "type" => DB_COLUMN_STRING);
        $this->columns[] = array("name" => "point_page",            "type" => DB_COLUMN_STRING);
        $this->columns[] = array("name" => "point_type",            "type" => DB_COLUMN_STRING);
        $this->columns[] = array("name" => "point_php_code",        "type" => DB_COLUMN_STRING);
        $this->columns[] = array("name" => "level",             "type" => DB_COLUMN_NUMERIC);

        $this->columns[] = array("name" => "meta_title_%s",    "type" => DB_COLUMN_STRING);
        $this->columns[] = array("name" => "meta_keywords_%s",    "type" => DB_COLUMN_STRING);
        $this->columns[] = array("name" => "meta_description_%s",    "type" => DB_COLUMN_STRING);

		$this->columns[] = array("name" => "enable_comments",        "type" => DB_COLUMN_NUMERIC);

    }

    /**
     * Get IDs of childs
     *
     * @param array $data Array with tree data
     * @param int $start_node Parent node
     * @return array Array of child nodes
     */
    function GetChildNodesId($data, $start_node, $start = 1){
        static $nodes = array();
        if ($start){
            $nodes = array();
        }

        if (!count($nodes)){
            $nodes[] = $start_node;
        }
        foreach ($data as $item_id => $item){
            if ($item['parent_id'] == $start_node){
                $nodes[] = $item_id;
                $this->GetChildNodesId($data, $item_id, 0);
            }
        }
        return $nodes;
    }

    // get prior page in current level
    function GetPriorPageRecord($page_id){
        if ($current = $this->Get(array('id' => $page_id))){
            $reader = $this->GetList(null, array('order_num' => 1), null, null, null, null, array(
                'where' => sprintf(
                    "order_num>%d AND parent_id=%d",
                    $current['order_num'],
                    $current['parent_id']
                )
            ));
            if ($row = $reader->Read()){
                // $row['order_num'] - prior page in order
                return array('current' => $current, 'prior' => $row);
            }
        }
        return array();
    }

    // get next page in current level
    function GetNextPageRecord($page_id){
        if ($current = $this->Get(array('id' => $page_id))){
            $reader = $this->GetList(null, array('order_num' => 0), null, null, null, null, array(
                'where' => sprintf(
                    "order_num<%d AND parent_id=%d",
                    $current['order_num'],
                    $current['parent_id']
                )
            ));
            if ($row = $reader->Read()){
                // $row['order_num'] - prior page in order
                return array('current' => $current, 'prior' => $row);
            }
        }
        return array();
    }


    function GetRequestedPageData(){
        $page_data = array();
        $url = trim($this->Connection->Kernel->GetPagePath());

        //--remove first slashes
        while (strpos($url,"/") == 0 && strpos($url,"/") !== false) {
           $url = substr($url,1,strlen($url));
        }

        //-- remove lang prefix
        if ($this->Connection->Kernel->MultiLanguage){
	        foreach ($this->Connection->Kernel->Languages as $language){
	        	if (strpos($url, $language."/") !== false){
	        		$url = substr($url, strlen($language)+1, strlen($url));
	       		}
	    	}
	    }

        // delete last slash
        if (substr($url, -1, 1) == '/'){
            $url = substr($url, 0, strlen($url) - 1);
        }

		if ( !defined('NO_ENGINE_CACHE') || (NO_ENGINE_CACHE == 0)){
            $cacheFile=CACHE_ROOT.'engine/sef_classes';
            if (is_readable($cacheFile) && (time() - filemtime($cacheFile)) < 604800){
            	$SEFClasses=unserialize_file($cacheFile);
            }else{
                $SEFClasses=$this->GetSEFClasses();
            }
		}else{
			$SEFClasses=$this->GetSEFClasses();
		}

		foreach ($SEFClasses as $package => $HelperClassName){
           	$this->Connection->Kernel->ImportClass(strtolower($HelperClassName), $HelperClassName, $package);
           	$SEFHelper = new $HelperClassName;
           	$page_data=$SEFHelper->GetPageData($url, $this);
           	if (!empty($page_data)){
           		return $page_data;
           	}
		}

        //$SQL=sprintf("SELECT * FROM %s WHERE active =1 AND %s ORDER BY level",
        //			$this->defaultTableName, ($url!="" ? "path LIKE '".$url."'" : "path=''"));

        //$page_data=$this->Connection->ExecuteScalar($SQL);

        return $page_data;
    }

  	function GetSEFClasses(){
  		$SEFClasses=array();
		$packages=array_keys($this->Connection->Kernel->Settings->GetSection("PACKAGES"));
		foreach ($packages as $package){
			$HelperClassName=ucfirst($package)."SEFHelper";
			$currenTpackage = Engine::GetPackage($this->Connection->Kernel, $package);
			if (file_exists(Path::buildPathString(strtolower($HelperClassName), $currenTpackage->ClassesDirs, $this->Connection->Kernel->ClassExt)))
				$SEFClasses[$package]=$HelperClassName;
		}
		if ( !defined('NO_ENGINE_CACHE') || (NO_ENGINE_CACHE == 0)){
			$cacheFile=CACHE_ROOT.'engine/sef_classes';
			serialize_data($cacheFile, $SEFClasses);
		}
		return $SEFClasses;
  	}

 /**
 * Method returns path to currently running page in structure tree
 * @return  array   Array of pages information
 * @access  public
 **/
	function GetPage(){
		$_page = array();
		$_page = $this->GetRequestedPageData();
		if (!$_page){
			return array();
		}

		$point_page=trim($_page["point_page"]);
		if ($point_page==""){
			$_page['point_page'] = 'project';
		} else {
			$point_page=explode("|", $point_page);
			$_page['point_page']=$point_page[1];
			if ($point_page[0]=="project"){
				$point_page[0]="";
			}
			$_page['point_package']=$point_page[0];
		}

		$_page['point_template'] = '';
		$_page['page_id'] = $_page['id'];
		DataDispatcher::Set('PAGE_DATA', $_page);

		return $_page;
	}

    function _RebuildPagesPath(&$structure, $start_node, $_start = true, $level){
        static $pages_stack = array();
        if ($_start) $pages_stack = array();
        $level++;
        for($i=0; $i<count($structure); $i++){
            if ($structure[$i]['parent_id'] == $start_node){
            	$structure[$i]["level"]=$level;
                if (PackageHelper::CheckName($structure[$i]['name'])){
	            	$name=$structure[$i]['name'];
	            	preg_match("~^(.*?)(\?|\/\?|$)(.*?)$~", $name, $matches);
	            	$name=$matches[1];
	            	$get = (trim($matches[3])!="" ? $matches[2].$matches[3] : "");
                    if ($name!="")array_push($pages_stack, $name);
	                $structure[$i]['path'] = implode('/', $pages_stack).$get;
	                $this->_RebuildPagesPath($structure, $structure[$i]['id'], false, $level);
	                array_pop($pages_stack);
                } else {
	                $structure[$i]['path'] = $structure[$i]['name'];
	                $this->_RebuildPagesPath($structure, $structure[$i]['id'], false, $level);
                }
            }
        }
    }

    function RebuildPagesPath(){
        $reader = $this->GetList();
        $structure = array();
        while($row = $reader->Read())
            $structure[] = $row;

        $this->_RebuildPagesPath($structure, 0, true, 0);

        foreach ($structure as $item)
            $this->Update($item);
    }

    function GetChangeMenuList($data = null, $orders = null, $limitCount = null, $limitOffset = null, $ids = null, $table_alias = "", $raw_sql = array()){
        if (!isset($orders)){
        	$data["show_in_".$this->Connection->Kernel->Page->MenuType]=1;
            $raw_sql["select"]="id AS page_id";
        }
        return $this->GetList($data, $orders, $limitCount, $limitOffset, $ids, $table_alias, $raw_sql);
    }

    function GetStructurePages($data = null, $orders = null, $limitCount = null, $limitOffset = null, $ids = null, $table_alias = "", $raw_sql = array()){
        $l=$this->Connection->Kernel->Language;
        $fields=array(	"id",
        				"parent_id",
        				"active",
        				"name",
        				"title_".$l,
        				"show_in_top_menu",
        				"show_in_page_menu",
        				"show_in_bottom_menu",
        				"show_in_sitemap",
        				"order_num",
        				"point_page",
        				"point_type",
        				"point_php_code",
        				"path",
        				"level",
        				"active_".$l,
        				"enable_comments",
        				"_lastmodified");

        $raw_sql["select"]=implode(", ", $fields);
        return $this->GetList($data, $orders, $limitCount, $limitOffset, $ids, $table_alias, $raw_sql);
    }
}

?>