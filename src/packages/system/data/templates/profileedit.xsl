<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" omit-xml-declaration="no"  indent="yes" media-type="text/html"/>

     <xsl:include href="layouts/default.xsl"/>
    <xsl:include href="blocks/debug.xsl"/>
    <xsl:include href="blocks/errors.xsl"/>  
    <!--Banners display template -->
    <xsl:include href="controls/banners.xsl"/>
    <!--Content display template -->
    <xsl:include href="controls/content.xsl"/>  
        <!-- Include controls -->
        <!-- Include controls -->
   <xsl:include href="controls/indicator.xsl"/>
   <xsl:include href="controls/text.xsl"/>
   <xsl:include href="controls/textarea.xsl"/>
    <xsl:include href="controls/hidden.xsl"/>
   <xsl:include href="controls/checkbox.xsl"/>
    <xsl:include href="controls/select.xsl"/>
    <xsl:include href="controls/statictext.xsl"/>
    <xsl:include href="controls/password.xsl"/>
    
     <xsl:include href="blocks/profileeditcontrol.xsl"/>

    <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    <xsl:template match="content">
        <xsl:if test="edit">
           <xsl:apply-templates select="edit"/>
        </xsl:if>
               
    </xsl:template>
</xsl:stylesheet>