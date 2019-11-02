<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no"  media-type="text/html"/>

    <!-- User section layout stylesheet -->
    <!-- Administrator section layout stylesheet -->
  <xsl:include href="layouts/layout.xsl"/>
  <xsl:include href="blocks/errors.xsl"/>
    <xsl:include href="blocks/debug.xsl"/>


    <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    <xsl:template match="content">

        <br/><br/><br/>

    <table width="90%" align="center" class="sort-table">
    <tr>
    <td style="padding:10px;">
    <p style="font-size:14px;">
    <xsl:value-of select="//localization/_index_message1"/>
     <br/><xsl:value-of select="//localization/_index_message2"/>
     <br/>
    </p>

                <table cellspacing="0" cellpadding="0" border="0">
                <tr><td><input type="button" value="{//localization/_index_button}" onclick="window.open('{/page/content/url}','indexer','location=0,menubar=0,resizable=yes,status=0,menubar=no,width=730,height=700,scrollbars=yes')"/></td></tr>
                </table>

    </td>
    </tr>
    </table>
    </xsl:template>
</xsl:stylesheet>