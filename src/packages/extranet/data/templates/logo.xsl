<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="no"  media-type="text/html"/>

    <!-- Administrator section layout stylesheet -->
  <xsl:include href="layouts/layout.xsl"/>
  <xsl:include href="blocks/errors.xsl"/>
  <xsl:include href="blocks/debug.xsl"/>


    <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    

    <xsl:template match="content">
                <!-- FRAME 1  begin -->
<table height="100%" width="100%" class="logoframe" border="0">
<tr><td align="center"><a href="http://www.activemedia.ua/ru/services/smengine/" target="_blank"><img src="{/page/package/@url}img/logo.png" border="0" /></a></td></tr>
</table>
                <!-- FRAME 1  end -->
        
        <div id="adminmenushadow"></div>
    </xsl:template>
    
</xsl:stylesheet>
