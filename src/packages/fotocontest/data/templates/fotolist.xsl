<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="no"  media-type="text/html"/>

    <!-- Project layout stylesheet -->
    <xsl:include href="layouts/default.xsl"/>
    <!--Banners display template -->
    <xsl:include href="controls/banners.xsl"/>
    <!--Content display template -->
    <xsl:include href="controls/content.xsl"/>  
    <!--Debug display include -->  
    <xsl:include href="blocks/debug.xsl"/>    


    <!--Cotests  include -->  
    <xsl:include href="controls/fotocontests.xsl"/>    

    <xsl:include href="controls/fotoslist.xsl"/>    


    <xsl:include href="controls/user_navigator.xsl"/>

    <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    <xsl:template match="content">


    <xsl:apply-templates select="fotocontests"/>

    <hr/>
    <xsl:apply-templates select="fotoslist"/>

    </xsl:template>
</xsl:stylesheet>