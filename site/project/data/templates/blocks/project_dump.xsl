<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="UTF-8" omit-xml-declaration="yes" media-type="text/html"/>

<xsl:template name="dump">                               
                <xsl:if test="/page/content/debug">
                <div align="right">
                <a href="{/page/@sources_url}debug/page.xsl" target="_blank"><b>XSL dump</b></a><BR/>
                <a href="{/page/@sources_url}debug/page.xml" target="_blank"><b>XML dump</b></a>
                </div>
                </xsl:if>
</xsl:template> 

</xsl:stylesheet>               
