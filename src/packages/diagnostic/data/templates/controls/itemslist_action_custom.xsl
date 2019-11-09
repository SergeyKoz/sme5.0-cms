<?xml version="1.0" encoding="utf-8"?>
<!-- edited with XMLSPY v5 rel. 4 U (http://www.xmlspy.com) by user (company) -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
  <xsl:template name="list_action_custom">
    <xsl:if test="handler/library = 'sites'">
      <td>&amp;nbsp;</td>
    </xsl:if>
  </xsl:template>
  
  <xsl:template name="item_action_custom">
    <xsl:if test="../handler/library = 'sites'">
      <td>
        <a href="?package=diagnostic&amp;page=status&amp;id={./@id}" target="_blank">EXECUTE TEST</a>
      </td>
    </xsl:if>
  </xsl:template>
</xsl:stylesheet>