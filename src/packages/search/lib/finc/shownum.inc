<?
 /**
   * @package Search
   * @access  public
   * @subpackage lib.finc
   **/

  
  function w_wrapper($word){
    return "".$word."";
  }
  
  function GetDescription($words, $body, $padding=50, $count=5){
    $pattern = "/.{0,".$padding."}(".implode("|", array_map("w_wrapper", $words)).").{0,".$padding."}/im";
    //echo pr($pattern);
    
    preg_match_all($pattern, $body, $matches);
    //echo pr($matches);

    $m = array_slice($matches[0], 0, $count);

    for($i=0, $size=count($m); $i<$size; $i++){
        $m[$i] = preg_replace("/(".implode("|", array_map("w_wrapper", $words)).")/im", "<b>\\1</b>", $m[$i]);
    }
    $m[]="";
  
    return implode("...&nbsp;&nbsp;&nbsp;&nbsp;", $m);
  }


  function ShowNum($Total,$PageSize,$OffSet,$ScriptName,$query)
    { 
      if ($Total > 0)
       { 
          if ($PageSize > $Total)
           { 
//       echo "Всего ".$Total;
             return;
           }
           echo "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr>
<td valign=\"top\" class=\"content\"><nobr><img src=\"{/page/@url}img/1x1.gif\" width=\"17\" height=\"1\"/>
Результыты поиска:</nobr><img src=\"{/page/@url}img/1x1.gif\" width=\"7\" height=\"1\"/>
</td>
<td valign=\"top\">
";
       } 
       else
        { // echo "Хитов в этот день не было";
          return;
        }
       $pnum=$Total;//9;
       if ((($OffSet-((int)($pnum/2)*$PageSize)) > 0) && ($start+$pnum*$PageSize < $Total))  //do offset
         { $start=($OffSet-((int)($pnum/2)*$PageSize));
         } else
         { $start=0;                //do not do
           $end=$start+$pnum*$PageSize;  // to small
         }
         if (($OffSet+((int)($pnum/2)*$PageSize) < $Total) && ($pnum*$PageSize < $Total))
          {
           $end=$start+$pnum*$PageSize;
          } else
          {
           $end=$Total;
            if (((($end-($end%$PageSize))-($pnum-1)*$PageSize) > 0) )
             $start=($end-($end%$PageSize))-($pnum-1)*$PageSize;         
          }
       /*
        if ($start > 0)
         { if (($start-$PageSize) < 0)
             $no = 0;
           else
             $no = ($start-$PageSize);
           echo "<nobr class=\"content\"><img src=\"{/page/@url}img/1x1.gif\" width=\"7\" height=\"1\"/><a href=\"".$ScriptName."?offset=0".$query."\">&lt</a><img src=\"{/page/@url}img/1x1.gif\" width=\"7\" height=\"1\"></nobr>&nbsp;&nbsp;<a href=\"".$ScriptName."?offset=".$no.$query."\">&lt;&lt;</a>&nbsp;&nbsp;";

         }
        */
       for ($i=$start; $i < $end ; $i += $PageSize)
        {
          $e=$i+$PageSize;
          if ($e >= $Total)
            { $e1 = $Total;
              $noend=1;
            }  else
        $e1 = $e;
          $s=$i+1;
//           echo " ".$i.",".$OffSet;
          if ($i == $OffSet)
          echo  "<nobr class=\"content_selected\"><img src=\"{/page/@url}img/1x1.gif\" width=\"7\" height=\"1\"/><a href=\"".$ScriptName."?offset=".$i.$query."\" style=\"text-decoration:none\"><b>".($e/$PageSize)."</b></a><img src=\"{/page/@url}img/1x1.gif\" width=\"7\" height=\"1\"></nobr>";
          //"<b>".($e/$PageSize)."</b>&nbsp;&nbsp;";
          else
          echo "<nobr class=\"content\"><img src=\"{/page/@url}img/1x1.gif\" width=\"7\" height=\"1\"/><a href=\"".$ScriptName."?offset=".$i.$query."\">".($e/$PageSize)."</a><img src=\"{/page/@url}img/1x1.gif\" width=\"7\" height=\"1\"></nobr>";
        }

       /*
       if ( (!isset($noend)) || (!$noend) )
         {
           $endp=($Total-($Total%$PageSize)); 
           if ($endp == $Total)
            {
              $endp-=$PageSize;
            }
           echo "<a href=\"".$ScriptName."?offset=".($start+($PageSize*$pnum)).$query."\">&gt;&gt;</a>&nbsp;&nbsp;<a href=".$ScriptName."?offset=".$endp.$query.">&gt;</a>";
         }
       */
      if ($Total > 0){
        echo "</td></tr></table>";
      }
}
?>
