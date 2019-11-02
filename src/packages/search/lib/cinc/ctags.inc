<?
  /**
   * class to strip HTML tags
   * Copyright (c) 2001 Sergey Frolovithev (siteindexer@idesign.ru). All rights reserved.
   * @package Search
   * @subpackage lib.cinc
   * @access  public
   **/
 class ctags
  { var $text; // result of strip
    var $html; // html document
    var $search=array ("'<script[^>]*?>.*?</script>'si",
                       "'<style[^>]*?>.*?</style>'si",
                       "'<!--.*?-->'si",
                       "'<[\/\!]*?[^<>]*?>'si",
                       "'([\r\n])[\s]+'",
                       "'&(quote|#34);'i",
                       "'&(amp|#38);'i",
                       "'&(lt|#60);'i",
                       "'&(gt|#62);'i",
                       "'&(nbsp|#160);'i",
                       "'&(iexcl|#161);'i",
                       "'&(cent|#162);'i",
                       "'&(pound|#163);'i",
                       "'&(copy|#169);'i",
                       "'&#(\d+);'e");
    var $replace = array (" ",
                          " ",
                          " ",
                          " ",
                          " ",
                          " ",
                          " ",
                          " ",
                          " ",
                          " ",
                          " ",
                          " ",
                          " ",
                          " ",
                          " ");

  function ctags($document="")
   { if (trim(chop($document))=="")
      return;
     $this->html=$document;
     $this->text=preg_replace($this->search,$this->replace,$this->html);
     return $this->text;
   }
 }
?>
