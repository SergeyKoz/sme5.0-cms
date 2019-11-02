<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:template match="options">
       <xsl:for-each select="option">
        <xsl:variable name="selected"><xsl:value-of select="./@selected"/></xsl:variable>
        <option>
           <xsl:attribute name="value"><xsl:value-of select="value"/></xsl:attribute>
           <xsl:if test="./@selected != ''">
                <xsl:attribute name="selected"> </xsl:attribute>
           </xsl:if>
           <xsl:if test="./@class">
                <xsl:attribute name="class"><xsl:value-of select="./@class"/></xsl:attribute>
           </xsl:if>
           <xsl:if test="./@disabled != ''">
                <xsl:attribute name="disabled">1</xsl:attribute>
           </xsl:if>
           <xsl:value-of select="caption"/>
        </option>
       </xsl:for-each>
    </xsl:template>
</xsl:stylesheet>
