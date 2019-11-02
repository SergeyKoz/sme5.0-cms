<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:template match="dbeditblock">
        <xsl:param name="class"/>    
        <xsl:param name="disabled"/>    
        
        <xsl:variable name="row_id"><xsl:value-of select="../../@id"/></xsl:variable>
        
        <xsl:for-each select="options/option">
            <xsl:if test="position() &gt; 1">
                <br />
            </xsl:if>
            <b>
            <xsl:choose>
                <xsl:when test="error='1'">
                    <font color="#FF0000"><xsl:value-of select="caption"/></font>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:value-of select="caption"/>
                </xsl:otherwise>
            </xsl:choose>
            </b>
            <br />
            <input type="text" name="_sprice[{$row_id}][{site_id}]" value="{value}">
                <xsl:if test="(../disabled = 'yes') or (../disabled = 1) or $disabled = 'yes'">
                    <xsl:attribute name="disabled"></xsl:attribute>
                </xsl:if>
                <xsl:if test="./@class">
                    <xsl:attribute name="class"><xsl:value-of select="./@class"/></xsl:attribute>
                </xsl:if>
            </input>
            <xsl:if test="error='1'">
            </xsl:if>
        </xsl:for-each>
    </xsl:template>
</xsl:stylesheet>