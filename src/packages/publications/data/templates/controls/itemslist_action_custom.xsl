<?xml version="1.0" encoding="windows-1251"?>
<!-- edited with XMLSPY v5 rel. 4 U (http://www.xmlspy.com) by user (company) -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
  <xsl:template name="list_action_custom">
      <xsl:if test="handler/library='publications_modified'">
          <td><xsl:value-of select="//localization/_caption_publications_approve"/></td>
          <td><xsl:value-of select="//localization/_caption_publications_decline"/></td>
      </xsl:if>
  </xsl:template>
  
  <xsl:template name="item_action_custom">
        <xsl:if test="../handler/library='publications_modified'">
            <td align="center"><input type="checkbox" name="approve[]" value="{./@id}"/></td>
            <td align="center"><input type="checkbox" name="decline[]" value="{./@id}"/></td>                                           
        </xsl:if>
  </xsl:template>
</xsl:stylesheet>