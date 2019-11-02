<?php
 Kernel::ImportClass("project", "ProjectPage");

  /** BizStat page class
   * @author Sergey Kozin <skozin@activemedia.com.ua>
   * @version 1.0
   * @package  BizStat
   * @access public
   **/
class CommentsVotePage extends ProjectPage  {

        var $ClassName="CommentsVotePage";
        var $Version="1.0";
        var $moder_page = false;
        var $default=true;

	function ControlOnLoad() {
		$comment_id=$this->Page->Request->ToNumber("comment_id", 0);
		$vote=$this->Page->Request->ToNumber("vote", 0);
		$UserId=$this->Auth->UserId;

		if ($comment_id>0 && ($vote==1 || $vote==-1) && $UserId>0){
            DataFactory::GetStorage($this, "CommentsTable", "commentsStorage");
            $record=$this->commentsStorage->Get(array("comment_id"=>$comment_id, "published"=>1));
            if ($record["comment_id"]==$comment_id){
                DataFactory::GetStorage($this, "CommentsVotesTable", "commentsVotesStorage");
                $count=$this->commentsVotesStorage->GetCount(array("comment_id"=>$comment_id, "user_id"=>$UserId));
                if ($count==0){
                 	//add vote
                 	$insert_data=array("comment_id"=>$comment_id, "user_id"=>$UserId, "vote"=>$vote);
                 	$this->commentsVotesStorage->Insert($insert_data);
                 	//get new rating
                 	$sql="SELECT SUM(vote) as rating FROM ".$this->commentsVotesStorage->getTable("CommentsVotesTable")." AS v WHERE v.comment_id=".$comment_id;
                 	$record=$this->commentsVotesStorage->Connection->ExecuteScalar($sql);
                    $rating='0';
                    if (!($record["rating"]=="")) $rating=$record["rating"];

                    die("[{'rating':'".$rating."', 'comment_id':'".$comment_id."'}]");
                }
            }
		}
		die();

	}
}
?>