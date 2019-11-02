<?
 /**
   * Class for mysql connection, query, debug and logging(using clog)
   * Copyright (c) 2001 Sergey Frolovithev (siteindexer@idesign.ru). All rights reserved.
   * @package Search
   * @subpackage lib.cinc
   * @access  public
   **/
 class cMySQL
  { var $Conn;
    var $DBase;
    var $needdebug;
    var $needlog;
    var $log;
    var $User;
    var $Host;
    var $Pass;
    var $error;
    var $Base;
    var $insert_id;
    var $affected;

    function cMySQL($host,$user,$pass,$base,$log, $conf)
     { //global $conf->CONFmysqllog,$conf->CONFmysqldebug;

       $this->needdebug=$conf->CONFmysqldebug;
       $this->needlog=$conf->CONFmysqllog;
       $this->log=$log;
       $this->Base=$base;
       $this->Host=$host;
       $this->User=$user;
       $this->Pass=$pass;
       $this->Conn=mysql_pconnect($host,$user,$pass);
       if (!$this->Conn)
        { $this->display("Connection error","Error establishing connection to <b>$host</b>");
          $this->logger("Error establishing connection to <$host>",1);
          header("Location: stopped.phtml");
          die();
        }

       $this->display("Connection established","");
       $this->logger("Connection to <$host> established");

       $this->DBase=@mysql_select_db($base,$this->Conn);
       if (!$this->DBase)
        { $this->display("Database not found","Error selecting database <b>$base</b>");
          $this->logger("Error selecting database <b>$base</b>",1);
          header("Location: stopped.phtml");
          die();
        }

       $this->display("Database $base selected","");
       $this->logger("Database $base selected");

     }

    function insQuery($query)
     { $ins=mysql_query($query,$this->Conn);
       $this->display($query,mysql_error());
       if (@mysql_error()!="")
        $ty=1;
       else
        $ty=0;
       $this->logger($query." (".mysql_error().")",$ty);
       if (mysql_error()!="")
        { $this->error=mysql_error();
          return mysql_error();
        }
       $this->error="";
       $this->insert_id=mysql_insert_id();

     }


    function updQuery($query)
     { $upd=mysql_query($query,$this->Conn) or die("Error in <b>".$query."</b><br>".mysql_error($this->Conn));
       $this->affected=mysql_affected_rows($this->Conn);

       $this->display($query,mysql_error());
       if (mysql_error()!="")
        $ty=1;
       else
        $ty=1;
       $this->logger($query,$ty);
       return mysql_error();
     }

    function selQuery($query){
      $return=array();
       $qwr=mysql_query($query,$this->Conn);
       if ($qwr){
	       $num=mysql_num_rows($qwr);



	       for ($i=0;$i<$num;$i++)
	        { $arr=mysql_fetch_array($qwr);
	          $return[]=$arr;
	        }
	       $this->display($query."<br><b>Count:</b> ".$num,mysql_error());
	       if (mysql_error()!="")
	        $ty=1;
	       else
	        $ty=0;
	       $this->logger($query." (".mysql_error().")",$ty);
       }
       return $return;
     }

    function insMQuery($query,$arr)
     { if (is_array($arr))
        { while(list($k,$v)=each($arr))
           $query=str_replace("#".$k."#",str_replace("'","`",$v),$query);
        }
       $ret=$this->insQuery($query);
       return $ret;
     }

    function updMQuery($query,$arr)
     { if (is_array($arr))
        { while(list($k,$v)=each($arr))
           $query=str_replace("#".$k."#",str_replace("'","`",$v),$query);
        }
       $ret=$this->updQuery($query);
       return $ret;
     }

    function selMQuery($query,$arr)
     {
      if (is_array($arr))
        { while(list($k,$v)=each($arr))
           $query=str_replace("#".$k."#",str_replace("'","`",$v),$query);
        }
       $ret=$this->selQuery($query);
       return $ret;
     }

    function selMRow($query,$arr)
     { echo $arr[r_id];
       if (is_array($arr))
        { while(list($k,$v)=each($arr))
           $query=str_replace("#".$k."#",str_replace("'","`",$v),$query);
        }

       $ret=$this->selQuery($query);
       return $ret[0];
     }

    function logger($message,$type=0)
     { if ($this->needlog==1)
        $this->log->write($message,$type);
     }

    function Display($qwr,$err)
     { if ($this->needdebug==0)
        return;
       echo "<table border=0 cellspacing=0 cellpadding=1 bgcolor=#dcdcdc width=99%>\n";
       echo "<tr>\n";
       echo "  <td>\n";
       echo "    <table border=0 cellspacing=0 cellpadding=2 bgcolor=#ffffff width=100%>\n";
       echo "    <tr>\n";
       echo "      <td width=1%><nobr><font size=-1 color=#000099><b>Host:</b> ".$this->Host."</nobr></td>\n";
       echo "      <td width=99% rowspan=2 valign=top><b>Query:</b> ".$qwr."</td>\n";
       echo "    </tr>\n";
       echo "    <tr>\n";
       echo "      <td><nobr><font size=-1 color=#000099><b>User:</b> ".$this->User."</nobr></td>\n";
       echo "    </tr>\n";
       echo "    <tr>\n";
       echo "      <td><nobr><font size=-1 color=#000099><b>Pass:</b> ".$this->Pass."</nobr></td>\n";
       echo "    </tr>\n";
       echo "    <tr>\n";
       echo "      <td><nobr><font size=-1 color=#000099><b>Base:</b> ".$this->Base."</nobr></td>\n";
       echo "      <td><font color=#ff0000><b>".$err."</b></font></td>\n";
       echo "    </tr>\n";
       echo "    </table>\n";
       echo "  </td>\n";
       echo "</tr>\n";
       echo "</table><br>\n";
     }

  }
?>