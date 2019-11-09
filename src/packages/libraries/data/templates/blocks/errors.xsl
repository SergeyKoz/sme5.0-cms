<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="UTF-8" omit-xml-declaration="yes" media-type="text/html"/>
	<xsl:template name="errors">                               
        <xsl:if test="/page/content/error-messages or content/warning-messages">
            <table cellpadding="0" cellspacing="0" border="0" width="99%" class="error-table">
                <tr>
                    <td valign="top"><img src="{/page/@framework_url}packages/libraries/img/ico_message.png"/></td>
                    <td width="100%" valign="top" style="padding:10px 0px;">
                      <xsl:for-each select="/page/content/error-messages/message">            
                           <p><b><xsl:value-of select="." disable-output-escaping="yes"/></b></p>
                      </xsl:for-each>
                       <xsl:for-each select="/page/content/warning-messages/message">            
                           <p><b><xsl:value-of select="." disable-output-escaping="yes"/></b></p>
                      </xsl:for-each>
                    </td>
                </tr>
            </table>
        </xsl:if>
        <xsl:if test="/page/content/debug">
            <div align="right">
            	<a href="{/page/@sources_url}debug/page.xml" target="_blank"><b>XML dump</b></a><BR/>
            	<a href="{/page/@sources_url}debug/page.xsl" target="_blank"><b>XSL dump</b></a>
            </div>
        </xsl:if>
	</xsl:template>
</xsl:stylesheet>               
