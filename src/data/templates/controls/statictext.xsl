<?xml version="1.0" encoding="utf-8"?>
<!-- edited with XMLSPY v5 rel. 4 U (http://www.xmlspy.com) by user (company) -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    
    <xsl:template match="statictext">
        <xsl:variable name="href"><xsl:value-of select="href"/></xsl:variable>
        <xsl:variable name="target"><xsl:value-of select="target"/></xsl:variable>
        <xsl:variable name="alt"><xsl:value-of select="alt"/></xsl:variable>
     

         <xsl:value-of select="content" disable-output-escaping="yes"/>
         <input type="hidden" name="{name}" value="{value}" />
             
    </xsl:template>
</xsl:stylesheet>