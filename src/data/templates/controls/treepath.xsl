<?xml version="1.0" encoding="utf-8"?>
<!-- edited with XMLSPY v5 rel. 4 U (http://www.xmlspy.com) by user (company) -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">

    <xsl:template match="treepath">
        <xsl:param name="class"/>
        <xsl:param name="disabled"/>    
        <xsl:param name="bold"/>

        <xsl:choose>
          <xsl:when test="not(treepath)">
            <xsl:variable name="href"><xsl:value-of select="href"/></xsl:variable>
            <xsl:variable name="target"><xsl:value-of select="target"/></xsl:variable>
            <xsl:variable name="alt"><xsl:value-of select="alt"/></xsl:variable>

            <xsl:for-each select="link">
             <xsl:apply-templates select=".">
               <xsl:with-param name="class" select="$class"/>
               <xsl:with-param name="bold" select="$bold"/>
               <xsl:with-param name="disabled" select="$disabled"/>
             </xsl:apply-templates>
             <xsl:if test="position() != count(../link)">
              /
             </xsl:if>
            </xsl:for-each>
          </xsl:when>
          <xsl:otherwise>
            <xsl:for-each select="treepath">
              <xsl:apply-templates select=".">
               <xsl:with-param name="class" select="$class"/>
               <xsl:with-param name="bold" select="$bold"/>
               <xsl:with-param name="disabled" select="$disabled"/>
              </xsl:apply-templates>
              <xsl:if test="position() &lt; count(../treepath)"><xsl:text disable-output-escaping="yes">, </xsl:text></xsl:if>
            </xsl:for-each>
          </xsl:otherwise>
        </xsl:choose>

    </xsl:template>
</xsl:stylesheet>