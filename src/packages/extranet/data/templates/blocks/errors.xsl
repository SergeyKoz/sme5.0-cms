<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="yes"  media-type="text/html"/>
    <xsl:template name="errors">				               
        <xsl:if test="content/error-messages or content/warning-messages">
            <xsl:for-each select="content/error-messages/message">
                <table cellpadding="0" cellspacing="0" border="0" width="99%" class="error-table">
                <tr>
                	<td><img src="{/page/@framework_url}packages/extranet/img/ico_error.gif" width="48" height="48"/></td>
                	<td width="100%" style="padding:10px 0;"><b><xsl:value-of select="."/></b></td>
                </tr>
                </table>
            </xsl:for-each>
        </xsl:if>
        <xsl:if test="content/debug">
            <div align="right"><a href="{$request_uri}&amp;xml=1"><b>XML</b></a></div>
        </xsl:if>
    </xsl:template>
</xsl:stylesheet>               