<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="yes"  media-type="text/html"/>

<xsl:template name="errors">
              <xsl:if test="/page/content/error-messages or content/warning-messages">
                  <xsl:for-each select="/page/content/error-messages/message">
                     <!--<xsl:value-of select="@section"/>: -->

                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                <td align="center">
                	<p class="erlog"><xsl:value-of select="."/><br/></p>
                </td></tr>
                </table>

                  </xsl:for-each>
                </xsl:if>
                <xsl:if test="/page/content/debug">
                 <div align="right">
                 <!--
                   <a href="{/page/@url}/extranet/{$request_uri}&amp;xml=1"><b>XML</b></a><BR/>
                 -->
                   <a href="{/page/@sources_url}debug/page.xml" target="_blank"><b>XML dump</b></a>
                </div>
              </xsl:if>
</xsl:template> 

</xsl:stylesheet>               
