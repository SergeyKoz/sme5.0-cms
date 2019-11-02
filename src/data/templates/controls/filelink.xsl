<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:include href="elements/title.xsl" />


    <xsl:template match="file">
        <xsl:param name="class"/>
        <xsl:variable name="name"><xsl:value-of select="name"/></xsl:variable>
        <xsl:variable name="directory"><xsl:value-of select="directory"/></xsl:variable>
        <xsl:variable name="maxlength"><xsl:value-of select="maxlength"/></xsl:variable>
        <xsl:variable name="value"><xsl:value-of select="value"/></xsl:variable>
        <xsl:choose>
            <xsl:when   test="value!=''">
            <a href="javascript:fileWindow('{/page/settings/filestorageurl}','{value}');"><img src="{/page/@framework_url}packages/libraries/img/ico_preview.gif" width="21" height="17" border="0" alt="{//_caption_file_preview}"/></a>
                    </xsl:when>
          <xsl:otherwise>
          N/A
          </xsl:otherwise>
        </xsl:choose>
    </xsl:template>
</xsl:stylesheet>