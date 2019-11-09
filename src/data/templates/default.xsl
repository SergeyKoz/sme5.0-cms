<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="no"  media-type="text/html"/>

    <!-- Administrator section layout stylesheet -->
  <xsl:include href="layout.xsl"/>
  <xsl:include href="blocks/errors.xsl"/>
    <xsl:include href="blocks/debug.xsl"/>


    <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    

<xsl:template match="content">

</xsl:template>
    
</xsl:stylesheet>
