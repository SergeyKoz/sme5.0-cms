<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no"  media-type="text/html"/>

    <!-- Project layout stylesheet -->
    <xsl:include href="layouts/default.xsl"/>
    <!--Banners display template -->
    <xsl:include href="controls/banners.xsl"/>
    <!--Content display template -->
    <xsl:include href="controls/content.xsl"/>  
    <!--Debug display include -->
    <xsl:include href="blocks/debug.xsl"/>
    
    <xsl:include href="controls/navigator.xsl"/>
   
    <xsl:include href="blocks/poll_block_page.xsl"/> 
    
    <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    	<xsl:template match="content">
        <xsl:call-template name="poll_block_page"/>
    </xsl:template>
</xsl:stylesheet>