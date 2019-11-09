<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="no"  media-type="text/html"/>

    <!-- Administrator section layout stylesheet -->
  <xsl:include href="layouts/layout.xsl"/>
  <xsl:include href="blocks/errors.xsl"/>
  <xsl:include href="blocks/debug.xsl"/>


  <xsl:include href="controls/select.xsl"/>
  <xsl:include href="controls/indicator.xsl"/>


  <xsl:include href="blocks/general.xsl"/>
  <xsl:include href="blocks/daily.xsl"/>
  <xsl:include href="blocks/detailed.xsl"/>

  <xsl:include href="blocks/filter.xsl"/>


  <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    

<xsl:template match="content">
   
   <table>
    <tr><td width="20">&amp;nbsp;</td>
    <td>
    <xsl:apply-templates select="filter"/>
        

    <xsl:if test="general">
       <xsl:apply-templates select="general"/>
        <hr/>

    </xsl:if>

    <xsl:if test="daily">
       <xsl:apply-templates select="daily"/>
        <hr/>

    </xsl:if>

    <xsl:if test="detailed">
       <xsl:apply-templates select="detailed"/>
        <hr/>

    </xsl:if>



    </td>
    </tr>
   </table>

</xsl:template>
    
</xsl:stylesheet>
