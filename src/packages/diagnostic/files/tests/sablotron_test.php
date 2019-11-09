<?php
ini_set("display_errors", "1");
function ProcessSablotron($xml, $xsl){
global $TEST_ID;
$xslt_data = $xsl;
$Stream = $xml;
$arg = array('/_xml' => $Stream, '/_xsl' => $xslt_data);
$xh = @xslt_create();
//@xslt_set_encoding ($xh, "utf-8");
$result = @xslt_process($xh, 'arg:/_xml', 'arg:/_xsl', NULL, $arg);
@xslt_free($xh);
if (!$result){
 echo"RES[".$TEST_ID."]:STATUS=0\n";
} else {
 echo "RES[".$TEST_ID."]:STATUS=1\n";
}
}
$xml='<?xml version="1.0" encoding="UTF-8" ?> 
<page>
<content>this is page content test xslt transform engine</content>
</page>
';
$xsl='<?xml version="1.0" encoding="UTF-8" ?> 
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="UTF-8" omit-xml-declaration="no" media-type="text/html" /> 
<xsl:template match="/">
<xsl:apply-templates /> 
</xsl:template>
<xsl:template match="content">
<xsl:value-of select="/page/content"/>
</xsl:template>
</xsl:stylesheet>
';
ProcessSablotron($xml, $xsl);
phpinfo();
?>