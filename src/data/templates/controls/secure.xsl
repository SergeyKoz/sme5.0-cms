<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">

    
    <xsl:template match="securecode">
        <xsl:param name="class"/>    
        <xsl:param name="size"/>    
        <xsl:param name="disabled"/>
        <table border="0">
        <tr><td valign="middle">
        <img src="?page=securecode&amp;sid={secureid}"/>
        </td>
        <td valign="middle">
        &amp;nbsp;


        <xsl:apply-templates select="text">
          
          <xsl:with-param name="class">
            <xsl:value-of select="$class"/>
          </xsl:with-param>
          
          <xsl:with-param name="size">
            <xsl:value-of select="10"/>
          </xsl:with-param>

          <xsl:with-param name="disabled">
            <xsl:value-of select="$disabled"/>
          </xsl:with-param>

        </xsl:apply-templates>
        </td></tr></table>
        <xsl:apply-templates select="hidden"/>

    </xsl:template>
</xsl:stylesheet>