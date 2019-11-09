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

    <xsl:include href="controls/indicator.xsl"/>
    <xsl:include href="controls/text.xsl"/>
    <xsl:include href="controls/checkbox.xsl"/>
    <xsl:include href="controls/select.xsl"/>
    <xsl:include href="controls/navigator.xsl"/>

    <!-- include form -->
    <xsl:include href="blocks/searchform.xsl"/>
    <xsl:include href="blocks/searchlist.xsl"/>

    <xsl:template match="/"><xsl:apply-templates/>

    </xsl:template>
    <xsl:template match="content">
            <xsl:apply-templates select="search" />
            <xsl:apply-templates select="search/list" />

            <!-- PUBLICATIONS -->
            <xsl:if test="/page/content/cms_publications/mapping">
              <xsl:call-template name="_default_mapping"/>
            </xsl:if>
            <!-- /PUBLICATIONS -->
    </xsl:template>
</xsl:stylesheet>