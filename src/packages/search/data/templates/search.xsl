<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no"  media-type="text/html"/>

    <!-- User section layout stylesheet -->
    <!-- Project layout stylesheet -->
    <xsl:include href="layouts/default.xsl"/>
    <!--Banners display template -->
    <xsl:include href="controls/banners.xsl"/>
    <!--Content display template -->
    <xsl:include href="controls/content.xsl"/>  
    <!--Debug display include -->  
    <xsl:include href="blocks/debug.xsl"/>

    <!-- INCLUDING TEMPLATES FOR SEARCH RESULTS-->
    <xsl:include href="blocks/search_results.xsl"/>
    
    <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    <xsl:template match="content">
  
           
           <xsl:apply-templates select="search/search_results"/>

    </xsl:template>
</xsl:stylesheet>