<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no"  media-type="text/html"/>

    <xsl:include href="layouts/default.xsl"/>
    <xsl:include href="blocks/debug.xsl"/>

    <xsl:include href="controls/text.xsl"/>
    <xsl:include href="controls/textarea.xsl"/>

    <xsl:include href="blocks/feedbackcontrol.xsl"/>

    <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    <xsl:template match="content">
              <xsl:apply-templates select="edit"/>
    </xsl:template>
</xsl:stylesheet>