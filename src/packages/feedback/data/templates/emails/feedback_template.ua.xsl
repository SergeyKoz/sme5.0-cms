<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="no"  media-type="text/html"/>

    <xsl:include href="layouts/email_default.xsl"/>
    <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    <xsl:template match="content">

    <table width="500" border="0">
    <tr>
      <td>Кому:
      </td>
      <td><xsl:value-of select="department"/>
      </td>
    </tr>
    <tr>
      <td>От:
      </td>
      <td><xsl:value-of select="from"/>
      </td>
    </tr>
    
    <tr>
      <td>Тема:
      </td>
      <td><xsl:value-of select="subject"/>
      </td>
    </tr>
    <tr>
      <td>Дата:
      </td>
      <td><xsl:value-of select="date"/>
      </td>
    </tr>
    </table>
    
    <table width="500" border="0">
     <tr><td><hr/></td></tr>
    </table>

    <table width="500" border="0">
     <xsl:for-each select="fields/field">
     <tr><td><b><xsl:value-of select="caption"/></b></td></tr>
     <tr><td><i><xsl:value-of select="value"/></i></td></tr>
     <tr><td><br/></td></tr>
     </xsl:for-each>
    </table>

    <table width="500" border="0">
     <tr><td><hr/></td></tr>
    </table>

    <xsl:value-of select="site"/>     

    </xsl:template>
</xsl:stylesheet>