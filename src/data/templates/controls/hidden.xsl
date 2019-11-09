<?xml version="1.0" encoding="utf-8"?>
<!-- edited with XMLSPY v5 rel. 4 U (http://www.xmlspy.com) by user (company) -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:template match="hidden">
        <xsl:variable name="name"><xsl:value-of select="name"/></xsl:variable>
        <xsl:variable name="value"><xsl:value-of select="value"/></xsl:variable>
        <input type="hidden" name="{$name}" value="{$value}"/>
    </xsl:template>
</xsl:stylesheet>
