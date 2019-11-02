<?php

/**
 * Class for render template content and send emails
 * @author Konstantin Matsebora <kmatsebora@activemedia.com.ua>
 * @version 1.0
 * @package Framework
 * @subpackage classes.system.mail
 **/
class EmailTemplate
{

    /**
     * From field value of all emails
     * var  string  $EmailFrom
     */
    var $EmailFrom = "";

    /**
     * Mail encoding
     * var string $Encoding
     */
    var $Encoding = "windows-1251";

    /**
     * Content type of emails
     * var string $ContentType
     */
    var $ContentType = "text/plain";

    var $MultipartContentType = "multipart/mixed";

    /**
     * Class constructor
     * @param  ConfigFile  Module config file
     * @param  string      Email from
     * @param  string      Encoding
     * @param  string      Content type
     */
    function EmailTemplate($appsettings = null, $emailfrom = null, $encoding = null,
        $contenttype = null)
    {
        if ($appsettings != null) {
            if ($appsettings->HasItem("email", "FROM"))
                $this->EmailFrom = $appsettings->GetItem("email", "FROM");
            if ($appsettings->HasItem("email", "ENCODING"))
                $this->Enconding = $appsettings->GetItem("email", "ENCODING");
            if ($appsettings->HasItem("email", "CONTENT-TYPE"))
                $this->ContentType = $appsettings->GetItem("email", "CONTENT-TYPE");
        }

        if ($emailfrom != null)
            $this->EmailFrom = $emailfrom;
        if ($encoding != null)
            $this->Encoding = $encoding;
        if ($contenttype != null)
            $this->ContentType = $contenttype;

    }

    /**
     * ����� ������� ���������� ���������
     *
     * @param    string  ���� � ���������
     * @return   string  ���������� ���������
     * @access   private
     */
    function Read_Template($fname = "")
    {
        $this->filename = $fname;
        if (strlen($this->filename) != 0) {
            $fp = @fopen($this->filename, "r");
            $this->content = @fread($fp, filesize($this->filename) + 1);
            @fclose($fp);
        }
        return $this->content;
    }

    /**
     * Method ���������� ������� �� ������ ������ � ���������
     *
     * @param array  $dataset ������ � �������
     * @param stirng $content ������� ���������
     * @param string $fname ���� � ����� (���������)
     * @access public
     */

    function Render($dataset, $content = "", $fname = "")
    {

        //read content from template
        if (strlen($fname) != 0) {
            $this->Read_Template($fname);
        }
        if ($content) {
            $this->content = $content;
        }
        foreach ($dataset as $param => $value) {
            $this->content = str_replace('{'.$param.'}', $value, $this->content);
        }

        $this->result = $this->content;
        return $this->result;
    }

    /**
     * ����� ���������� ������� (������) �� ������ ��������� � ������� ��������-�������
     *
     * @param   array   $bdataset  ������ ��������-�������
     * @param   array   $dataset  ������ ��� ������ � ������
     * @param   string  $fname    ���� � ���������
     * @return  string  $content  �������
     * @access public
     */
    function Render_List($bdataset = array(), $dataset = array(), $fname)
    {
        $tag_arr = $this->Get_Render_Tags(array(
            "header" , "footer" , "list"
        ), $fname);
        $this->result = "";
        // render header
        $this->result .= $this->Render_Tag($tag_arr["header"], $dataset);
        // render body
        $rendervar_arr = $this->Get_Tag_Variables($tag_arr["list"]);
        $i = 0;
        while (list ($k, $curitem) = each($bdataset)) {
            for ($j = 0; $j < sizeof($rendervar_arr) - 1; $j ++) {
                $this->result .= $rendervar_arr[$j]->before_content . $this->Generate_Variable_Content(trim($rendervar_arr[$j]->variable), $curitem, $i, sizeof($bdataset));
            }
            $this->result .= $rendervar_arr[sizeof($rendervar_arr) - 1]->after_content;
            $i ++;
        }
        // render footer
        $this->result .= $this->Render_Tag($tag_arr["footer"], $dataset);
        return $this->result;
    }

    /**
     *����� ������� �� ��������� ���������� ����� �����.
     *@param     array               ������ �������� �����
     *@param     string              ��� ����� ���������
     *@access    private
     */
    function Get_Render_Tags($tags, $fname)
    {
        $content = $this->Read_Template($fname);
        reset($tags);
        while (list ($key, $item) = each($tags))
            $tag_arr[$item] = $this->Get_TagContent_HTML($content, $item);
        return $tag_arr;
    }

    /**
     * ����� ������ ���������� ���� � ������� ������ � ���������� ���������� � ��������� �� ��������������
     * ��������� ������� ������� �� �������� ������� ����������, ������ ������� ����� ����������
     * @param    string  ���� ����
     * @return   array   ������ � ��������� ���������� � ���������, �� �������������� (�������� $rendervar_arr[0]->variable="itemid",$rendervar_arr[0]->before_content="<B>")
     * @access   private
     */
    function Get_Tag_Variables($tag)
    {
        $pos = 0;
        $i = 0;
        $rendervar_arr = array();
        while (strpos($tag, "{", $pos) !== false) {
            $startpos = strpos($tag, "{", $pos);
            $endpos = strpos($tag, "}", $pos);
            //get content before variable
            $rendervar_arr[$i]->before_content = substr($tag, $pos, $startpos - $pos);
            $curvar = substr($tag, $startpos + 1, $endpos - $startpos - 1);
            //get variable name
            $rendervar_arr[$i]->variable = trim($curvar);
            $pos = $endpos + 1;
            $i ++;
        }
        $rendervar_arr[]->after_content = substr($tag, $pos, strlen($tag));
        return $rendervar_arr;
    }

    /**
     *����� ���������� ������� (������) �� ������ ��������� � ������� ������.
     *������ �������� �������������� � �������� ��������  � ��� �� ������ ����
     *@param     array   $dataset_arr    ������ � ������� (�������� array("1","2")
     *@param     string  $fname          ���� � ���������
     *@param   object  $dataset    ������ � ����������� ��� ������ � ������
     * @return   string  $content    �������
     * @access public
     */
    function Render_Array_List($dataset_arr, $fname, $dataset = "")
    {
        $tag_arr = $this->Get_Render_Tags(array(
            "header" , "footer" , "list"
        ), $fname);
        $this->result = "";
        $this->result .= $this->Render_Tag($tag_arr["header"], $dataset);
        $rendervar_arr = $this->Get_Tag_Variables($tag_arr["list"]);
        while (list ($k, $curitem) = each($dataset_arr)) {
            $this->result .= $rendervar_arr[0]->before_content . $curitem;
            for ($j = 1; $j < sizeof($rendervar_arr) - 1; $j ++) {
                $this->result .= $rendervar_arr[$j]->before_content . $this->Generate_Variable_Content(trim($rendervar_arr[$j]->variable), $dataset, $i, sizeof($dataset));
            }
            $this->result .= $rendervar_arr[sizeof($rendervar_arr) - 1]->after_content;

        }
        $this->result .= $this->Render_Tag($tag_arr["footer"], $dataset);
        return $this->result;
    }

    /**
     * ����� ������� ���������� ����
     * @param    string  �������
     * @param    string  ��� ����
     * @return   string  ���������� ����
     * @access   private
     */
    function Get_TagContent_HTML($html, $tag)
    {
        $startpos = strpos($html, "<$tag>", 0);
        $endpos = strpos($html, "</$tag>", 0);
        $str = substr($html, $startpos + strlen($tag) + 2, $endpos - $startpos - strlen($tag) - 3);
        return $str;
    }

    /**
     * Method ���������� HTML ����
     *
     * @param   string   ������� � �����
     * @param   object   $dataset ������ � �������
     * @param   bool     $preserveNL ������ ��� ��� \n �� <br>

     * @return  HTML-��� ����
     * @access public
     */
    function Render_Tag($content, $dataset, $preserveNL = false)
    {
        //render content
        if (strpos($content, "{", $pos) !== false) {
            while (strpos($content, "{", $pos) !== false) {
                //get variable
                $startpos = strpos($content, "{", $pos);
                $endpos = strpos($content, "}", $pos);
                $result .= substr($content, $pos, $startpos - $pos);
                $curvar = substr($content, $startpos + 1, $endpos - $startpos - 1);
                //generate content


                $varvalue = $this->Generate_Variable_Content(trim($curvar), $dataset, 0, 0, $preserveNL);
                $result .= $varvalue;
                $pos = $endpos + 1;
            }
            $result .= substr($content, $endpos + 1, strlen($content) - $endpos);
        }
        else {
            $result = $content;
        }
        return $result;
    }
    /**
     * Method ���������� HTML-��� ����������
     *
     * @param   string      �������� ����������
     * @param   object      ������ � �������
     * @param   int       ����� ������ (������������ ��� ������������� �������)
     * @param   int       ���-�� �������
     * @return  string   HTML-��� ����������
     * @access  private
     */
    function Generate_Variable_Content($var, $dataset, $recordid = 0, $recordnum = 0,
        $preserveNL = false)
    {
        if (strpos($var, "_") !== false) {
            list ($keyword, $variable) = preg_split("/[_]/", $var, 2);
            switch ($keyword) {
                case "const":
                    $tmp = $variable;
                    //$evalstr.='$tmp='.$variable.";";
                    //eval($evalstr);
                    break;
                case "item":
                    if ($variable != "DESC") {
                        $tmp = $recordid + 1;
                    }
                    else {
                        $tmp = $recordnum - $recordid;
                    }
                    break;
                default:
                    $tmp = $dataset[trim($var)];
                    //$evalstr = '$tmp=$dataset["' .trim($var). '"];';
                    //eval($evalstr);
                    if (! $preserveNL) {
                        $tmp = $this->ParseForBR($tmp);
                    }
            }
        }
        else {
            $tmp = $dataset[trim($var)];
            //$evalstr = '$tmp=$dataset["' .trim($var).'"];';
            //eval($evalstr);
            if (! $preserveNL) {
                $tmp = $this->ParseForBR($tmp);
            }
        }
        return $tmp;
    }

    /**
     * ����� �������� \r\n �� BR
     * @param    string  �������� ������
     * @return   bool    ���������
     * @access public
     */
    function ParseForBR($str)
    {
        return str_replace(chr(10), "<BR>", $str);
    }

    function sendEmail($to = null, $subject = null, $body = null, $reply_to = null)
    {
        if ($reply_to === null) {
            $reply_to = $this->EmailFrom;
        }
        $headers = "MIME-Version: 1.0\n";
        if (! count($this->attachment)) {
            $headers .= "Content-type: {$this->ContentType}; charset={$this->Encoding}\n";
        }
        else {
            $boundary = "b" . md5(uniqid(time()));
            $headers .= "Content-type: {$this->MultipartContentType}; boundary = {$boundary}\n";
        }
        $headers .= "From: {$this->EmailFrom}\n";
        $headers .= "Reply-To: $reply_to <$reply_to>\n";
        $headers .= "Return-Path: $reply_to\n";
        $headers .= $this->BuildAttachment($boundary, $body);

        $result = mail($to, sprintf('=?%s?B?%s?=', $this->Encoding, base64_encode($subject)), $body, $headers);
        return $result;

    }

    function AddAttachment($message, $name = "", $ctype = "application/octet-stream", $charset = "")
    {
        $this->attachment[] = array(
            "ctype" => $ctype , "message" => $message , "encode" => $encode , "name" => $name , "charset" => $charset
        );
    }

    function BuildAttachment($boundary, $body)
    {
        $ret = "";
        if (count($this->attachment)) {
            $this->AddAttachment($body, "", $this->ContentType, $this->Encoding);
            $ret .= "\nThis is a MIME encoded message.\n";
            $ret .= "\n--$boundary";
            $this->attachment = array_reverse($this->attachment);
            foreach ($this->attachment as $attachment) {
                $message = chunk_split(base64_encode($attachment["message"]));
                $encoding = "base64";
                $ret .= "\nContent-type: " . $attachment["ctype"] . ($attachment["name"] ? "; name = \"" . $attachment["name"] . "\"" : "") . ($attachment["charset"] ? "; charset = \"" . $attachment["charset"] . "\"" : "");
                $ret .= "\nContent-Transfer-Encoding: $encoding\n\n$message\n";
                $ret .= "--$boundary";
            }
            $ret .= "--";
        }
        return $ret;
    }

    function RenderFlags(&$data, &$template){
    	preg_match_all("~</(.*?)>~m", $template, $tags);
        foreach ($tags[1] as $tag){
        	if (isset($data[$tag])){
	        	if ($data[$tag]==0)
	     			$template=preg_replace("~(<".$tag.">(.|\n)*?</".$tag.">)~m" , "", $template);
	    		else
	                $template=preg_replace("~(<(.*?)".$tag.">)~m" , "", $template);
      		}
      	}
      	return $template;
   	}

//end of class
}
?>
