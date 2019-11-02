<?xml version="1.0" encoding="windows-1251"?>
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
    
      <xsl:include href="publications/objects/mappings/search.xsl" /> 
  	<xsl:include href="publications/parameters/search_field.xsl" /> 
  	<xsl:include href="controls/navigator.xsl"/>
  	
  	<xsl:include href="controls/indicator.xsl"/>
    <xsl:include href="controls/text.xsl"/>
    <xsl:include href="controls/checkboxgroup.xsl"/>
    <xsl:include href="controls/select.xsl"/>
    <xsl:include href="controls/navigator.xsl"/>

    
        <!--Debug display include -->
    <xsl:include href="controls/publicationsearch.xsl"/>
        
    <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    <xsl:template match="content">
    		<xsl:apply-templates select="publicationsearch" />
    		
            <!-- PUBLICATIONS -->
            <!--xsl:if test="/page/content/cms_publications/mapping">
                      <xsl:call-template name="_default_mapping"/>
            </xsl:if-->
            <!-- /PUBLICATIONS -->
            
            <!-- PUBLICATIONS -->
            <xsl:if test="//page/content/publicationsearch/mapping">
              <xsl:call-template name="search"/>
            </xsl:if>
            <!-- /PUBLICATIONS -->
            
            
    </xsl:template>
</xsl:stylesheet>