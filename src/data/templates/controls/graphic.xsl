<?xml version="1.0" encoding="windows-1251"?>
<!-- edited with XMLSPY v5 rel. 4 U (http://www.xmlspy.com) by user (company) -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">

    <xsl:template match="graphic">
 
 <xsl:param name="prefix"/>
	

<script type="text/javascript">
document.write('<table border="0" cellpadding="0" cellspacing="0"><tr><td>');
writePrice("<xsl:for-each select="char">
       <xsl:choose>
        <xsl:when test=". = 'dot'">","</xsl:when>
					<xsl:when test=". = 'minus'">","<xsl:value-of select="$prefix"/>"); 
		
		
		document.write('<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td align="right"><img src="{/page/@url}img/price/minus.gif" width="7" height="6"/></td></tr></table>');
		
		
		writePrice("</xsl:when>
        <xsl:otherwise><xsl:value-of select="."/></xsl:otherwise>
       </xsl:choose>
     </xsl:for-each>","<xsl:value-of select="$prefix"/>");
document.write("</td></tr></table>");
</script>

</xsl:template>
</xsl:stylesheet>