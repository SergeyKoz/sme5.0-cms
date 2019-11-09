<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="UTF-8" omit-xml-declaration="yes" media-type="text/html"/>
<!-- INCLUDING NAVIGATOR TEMPLATE-->
<xsl:include href="_default_navigator.xsl"/>

<xsl:template name="_default_mapping">

   <xsl:for-each select="/page/content/cms_publications/mapping[@system_name != 'all_focused_sites' and @system_name != 'all_last_sites']">
   <xsl:if test="publication">

      <!-- PRINTING OUT MAPPING INFO-->
      <font class="red"><b>&lt;!--</b></font>Mapping # <b><xsl:value-of select="./@id"/></b> start<font class="red"><b>--></b></font><br/>
      <hr/>
         Host publication ID: <xsl:value-of select="./@publication_id"/><br/>
         Publication Type : 
         <xsl:choose>
            <xsl:when test="./@publication_type=0"><font color="navy">Publication</font></xsl:when>
            <xsl:when test="./@publication_type=1"><font color="navy">Categories list</font></xsl:when>
            <xsl:when test="./@publication_type=2"><font color="navy">Publications short list</font></xsl:when>
            <xsl:when test="./@publication_type=3"><font color="navy">Publications detailed list</font></xsl:when>
         </xsl:choose>
         <br/>
     <!-- /PRINTING OUT MAPPING INFO-->

      <!-- PRINTING MAPPING HEADER DELIMITERS -->
      <xsl:if test="delimiters/header != ''">
         <xsl:value-of select="delimiters/header" disable-output-escaping="yes"/>
      </xsl:if>
      <!-- /PRINTING MAPPING HEADER DELIMITERS -->

      <!-- PRINTING SINGLE PUBLICATION -->
      <xsl:if test="./@publication_type=0">
         <xsl:call-template name="_default_publication"/>
      </xsl:if>
      <!-- /PRINTING SINGLE PUBLICATION -->
   
      <!-- PRINTING CATEGORIES LIST -->
      <xsl:if test="./@publication_type=1">
         <xsl:call-template name="_default_categories_list"/>
      </xsl:if>
      <!-- /PRINTING CATEGORIES LIST -->

      <!-- PRINTING SHORT PUBLICATIONS LIST -->
      <xsl:if test="./@publication_type=2">
         <xsl:call-template name="_default_publications_short_list"/>
      </xsl:if>
      <!-- /PRINTING SHORT PUBLICATIONS LIST -->

      <!-- PRINTING DETAILED PUBLICATIONS LIST -->
      <xsl:if test="./@publication_type=3">
         <xsl:call-template name="_default_publications_detailed_list"/>
      </xsl:if>
      <!-- /PRINTING DETAILED PUBLICATIONS LIST -->
   
      <!-- PRINTING PAGER NAVIGATOR -->
      <xsl:for-each select="navigator">
          <xsl:call-template name="_default_navigator"/>
      </xsl:for-each>
      <!-- /PRINTING PAGER NAVIGATOR -->
   
      <!-- PRINTING MAPPING FOOTER DELIMITERS -->
      <xsl:if test="delimiters/footer != ''">
         <xsl:value-of select="delimiters/footer" disable-output-escaping="yes"/>
      </xsl:if>
      <!-- /PRINTING MAPPING FOOTER DELIMITERS -->

      <hr/>
         <font class="red"><b>&lt;!--</b></font>/Mapping #<b><xsl:value-of select="./@id"/></b> end<font class="red"><b>--></b></font><br/>
         <br/><br/><br/>

   </xsl:if>
   
   </xsl:for-each>
   
   
</xsl:template> 

<!--TEMPLATE FOR SNGLE PUBLICATION -->
<xsl:template name="_default_publication">
      <br/>
      Publication:<br/>
      <!-- PRINTING PUBLICATION -->
      <xsl:for-each select="publication">
      
      <!-- PRINTING PUBLICATION HEADER DELIMITERS -->
      <xsl:if test="delimiters/header != ''">
         <xsl:value-of select="delimiters/header" disable-output-escaping="yes"/>
      </xsl:if>
      <!-- /PRINTING PUBLICATION HEADER DELIMITERS -->

      <!-- PRINTING FIELDS -->
          <xsl:for-each select="field">
               <xsl:call-template name="_default_field"/>
          </xsl:for-each>
      <!-- /PRINTING FIELDS -->

      <!-- PRINTING PUBLICATION FOOTER DELIMITERS -->
      <xsl:if test="delimiters/footer != ''">
         <xsl:value-of select="delimiters/footer" disable-output-escaping="yes"/>
      </xsl:if>
      <!-- /PRINTING OUBLICATION FOOTER DELIMITERS -->

      </xsl:for-each>
      <!-- /PRINTING PUBLICATION -->

</xsl:template>
<!--/TEMPLATE FOR SNGLE PUBLICATION -->

<!-- TEMPLATE FOR CATEGORIES LIST-->
<xsl:template name="_default_categories_list">
      <br/>
      Categories:<br/>
      <!-- PRINTING CATEGORIES -->
      <xsl:for-each select="publication">
      <!-- PRINTING PUBLICATION HEADER DELIMITERS -->
      <xsl:if test="delimiters/header != ''">
         <xsl:value-of select="delimiters/header" disable-output-escaping="yes"/>
      </xsl:if>
      <!-- /PRINTING PUBLICATION HEADER DELIMITERS -->


      <!-- PRINTING FIELDS -->
          <xsl:for-each select="field">
               <xsl:call-template name="_default_field"/>
          </xsl:for-each>
      <!-- /PRINTING FIELDS -->

      <!-- PRINTING PUBLICATION FOOTER DELIMITERS -->
      <xsl:if test="delimiters/footer != ''">
         <xsl:value-of select="delimiters/footer" disable-output-escaping="yes"/>
      </xsl:if>
      <!-- /PRINTING OUBLICATION FOOTER DELIMITERS -->
      </xsl:for-each>
      <!-- /PRINTING CATEGORIES -->

</xsl:template>
<!-- /TEMPLATE FOR CATEGORIES LIST-->

<!-- TEMPLATE FOR PUBLICATIONS SHORT LIST-->
<xsl:template name="_default_publications_short_list">
      <br/>
      Publications Short list:<br/>

      <!-- PRINTING NON-CATEGORIES -->
      <xsl:for-each select="publication">
      <!-- PRINTING PUBLICATION HEADER DELIMITERS -->
      <xsl:if test="delimiters/header != ''">
         <xsl:value-of select="delimiters/header" disable-output-escaping="yes"/>
      </xsl:if>
      <!-- /PRINTING PUBLICATION HEADER DELIMITERS -->

      <!-- PRINTING FIELDS -->
          <xsl:for-each select="field">
               <xsl:call-template name="_default_field"/>
          </xsl:for-each>
      <!-- /PRINTING FIELDS -->

      <!-- PRINTING PUBLICATION FOOTER DELIMITERS -->
      <xsl:if test="delimiters/footer != ''">
         <xsl:value-of select="delimiters/footer" disable-output-escaping="yes"/>
      </xsl:if>
      <!-- /PRINTING OUBLICATION FOOTER DELIMITERS -->
      </xsl:for-each>
      <!-- /PRINTING NON-CATEGORIES -->
</xsl:template>
<!-- TEMPLATE FOR PUBLICATIONS SHORT LIST-->

<!-- TEMPLATE FOR PUBLICATIONS DETAILED LIST-->
<xsl:template name="_default_publications_detailed_list">
      <br/>
      Publications Detailed list:<br/>

      <!-- PRINTING NON-CATEGORIES -->
      <xsl:for-each select="publication">
      <!-- PRINTING PUBLICATION HEADER DELIMITERS -->
      <xsl:if test="delimiters/header != ''">
         <xsl:value-of select="delimiters/header" disable-output-escaping="yes"/>
      </xsl:if>
      <!-- /PRINTING PUBLICATION HEADER DELIMITERS -->


      <!-- PRINTING FIELDS -->
          <xsl:for-each select="field">
               <xsl:call-template name="_default_field"/>
          </xsl:for-each>
      <!-- /PRINTING FIELDS -->

      <!-- PRINTING PUBLICATION FOOTER DELIMITERS -->
      <xsl:if test="delimiters/footer != ''">
         <xsl:value-of select="delimiters/footer" disable-output-escaping="yes"/>
      </xsl:if>
      <!-- /PRINTING OUBLICATION FOOTER DELIMITERS -->
      </xsl:for-each>
      <!-- /PRINTING NON-CATEGORIES -->
</xsl:template>
<!-- /TEMPLATE FOR PUBLICATIONS DETAILED LIST-->


</xsl:stylesheet>               
