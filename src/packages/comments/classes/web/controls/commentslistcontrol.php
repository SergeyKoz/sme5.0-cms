<?php
$this->ImportClass("system.web.xmlcontrol", "XMLControl");
$this->ImportClass("system.web.controls.navigationcontrol","NavigationControl");

    /** Comments control class
     * @author Artem Mikhmel <amikhmel@activemedia.com.ua>
     * @version 1.0
     * @package Banner
     * @subpackage classes.web.controls
     * @access public
     */
    class CommentsListControl extends XmlControl {
        var $ClassName = "CommentsListControl";
        var $Version = "1.0";

        var $p;
        var $ItemsList=array();

        /**
        * Method executes on control load
        * @access   public
        **/
        function ControlOnLoad(){
            DataFactory::GetStorage($this, "CommentsTable", "commentsStorage");
        }

        function CreateChildControls(){
        	parent::CreateChildControls();

        	$rpp=$this->Page->Kernel->AdminSettings["comments_pp"];

			$group=explode("_",$this->data["group"]);
			$group_id=$group[1];
			$p=$group[0].$this->data["item"];
			$enable_voting=$this->data["item"];

			$start = $this->Page->Request->ToNumber($p."start", 0);

			if ($start==0){
				$_start=$this->Page->Request->Value($p."start");
				$comment=$this->Page->Request->Value($p."comment");
				if ($comment>0 && !isset($_start)){
					$record=$this->commentsStorage->Get(array("comment_id"=>$comment));
					if ($record["_priority"]>0){
						$_raw_sql["where"]="_priority<=".$record["_priority"];
	                    $reader=$this->commentsStorage->GetList(array(	"article_id"=>$this->data["item"], "group_id"=>$group[0].$group_id, "published"=>1),
	                    												array("_priority"=>1), null, null, null, "c.", $_raw_sql);
	                    $position=$reader->RecordCount-1;
	                    if ($position>0) $start=floor($position/$rpp);
                    }
				}
			}

			$total = $this->commentsStorage->GetCount(array("article_id"=>$this->data["item"], "group_id"=>$group[0].$group_id, "published"=>1));

			if ($start*$rpp>=$total) $start = ceil($total/$rpp)-1;
       		if ($start<0) $start=0;


       		$uri=preg_replace("/\?{0,1}\&{0,1}MESSAGE\[\]=.*/","", $_SERVER["REQUEST_URI"]);

            $url="";
       		if (strpos($uri, "?")!==false){
       			$url=substr($uri, strpos($uri, "?"), strlen($uri)-strpos($uri, "?"));
       			if (strpos($url, "#")!==false)
       				$url=substr($url, 0, strpos($ulr, "#"));
       		} else{
       			$url="?";
       		}

       		$var_name=$p."start";

       		$this->AddControl(new NavigationControl("navigator","navigator"));
        	$this->Controls["navigator"]->SetData(array( "start"=>$start,
        												 "var_name"=>$var_name,
									                     "total"=>$total,
									                     "rpp"  =>$rpp,
									                     "url"  =>$url));

			$UsersTable=$this->commentsStorage->getTable("UsersTable");
			$CommentsTable=$this->commentsStorage->getTable("CommentsTable");

			if ($enable_voting){
				$voting_sql="(SELECT SUM(vote) FROM ".$this->commentsStorage->getTable("CommentsVotesTable")." AS v WHERE v.comment_id=c.comment_id) as rating,";
				$user_id=$this->Page->Auth->UserId;
				if ($user_id>0)
					$voting_sql.="IF( (SELECT count(vote) FROM ".$this->commentsStorage->getTable("CommentsVotesTable")." AS v WHERE v.comment_id=c.comment_id AND v.user_id=".$user_id.")>0, 0, 1) as enable_voting,";
				else
					$voting_sql.="0 as enable_voting, ";
			}

			$raw_sql["select"]="c.comment_id, c.level, c.comment, c.posted, c.parent_id,
                                $voting_sql
								c.author_name, (SELECT u.user_login FROM ".$UsersTable." AS u WHERE u.user_id=c.user_id) AS user_login,

								IF (c.parent_id>0,
								   IF ( (SELECT pc.user_id FROM ".$CommentsTable." AS pc WHERE pc.comment_id=c.parent_id)>0,
								      (SELECT pu.user_login FROM ".$UsersTable." AS pu WHERE pu.user_id=(SELECT pc.user_id FROM ".$CommentsTable." AS pc WHERE pc.comment_id=c.parent_id)),
								      ''),
								   '') as parent_user_login,

								IF (c.parent_id>0, (SELECT pc.author_name FROM ".$CommentsTable." AS pc WHERE pc.comment_id=c.parent_id),'') as parent_author_name
								";

			$reader=$this->commentsStorage->GetList(array("article_id"=>$this->data["item"], "group_id"=>$group[0].$group_id, "published"=>1), array("_priority"=>1),
           							$rpp, $start*$rpp, null, "c.", $raw_sql);

			for ($i=0; $i<$reader->RecordCount; $i++ ){
				$record=$reader->read();
                $record["posted"]=Component::dateconv($record["posted"], true);
				$this->ItemsList[]=$record;
				if (Engine::isPackageExists($this->Page->Kernel, "context")){
			        $context_parameters=array(	"item_id"=>$record["comment_id"],
			        							"storage"=>$this->commentsStorage);
					$this->Page->Controls["cms_context"]->AddContextMenu("comment", "comments", $context_parameters);
				}
			}

			$this->p=$p;
        }

        /**
        *  Method draws xml-content of control
        *  @param   XMLWriter   $xmlWriter   Instance of XMLWriter
        *  @access  public
        */
        function XmlControlOnRender(&$xmlWriter) {
        	$xmlWriter->WriteAttributeString("p", $this->p);
			$this->XmlTag="item";
			foreach ($this->ItemsList as $this->data)
				RecordControl::StaticXmlControlOnRender($this, $xmlWriter);
            parent::XmlControlOnRender($xmlWriter);
        }// function

} // class

?>