<?php
function ProcessDomXSLT($xml, $xsl){
global $TEST_ID;
$xmldoc = @domxml_open_mem($xml);
$xsldoc = @domxml_xslt_stylesheet($xsl);
if(!is_object($xsldoc) || !is_object($xmldoc)){
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
ProcessDomXSLT($xml, $xsl);
?>
