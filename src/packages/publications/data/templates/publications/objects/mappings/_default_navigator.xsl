<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="yes" media-type="text/html"/>


<xsl:template name="_default_navigator">
       <!-- IF TOTAL PAGES COUNT MORE THAN FITS ON ONE PAGE-->
       <xsl:if test="total &gt; rpp">
       <!-- SAVING CURRENT MAPPING ID-->
       <xsl:variable name="mapping_id"><xsl:value-of select="../@id"/></xsl:variable>
       <!-- FOR EACH PAGING ELEMENT-->
       <xsl:for-each select="bar/element">
		<!-- PREPARING PAGING URL VARIABLE
			SKIPPING THOSE MAPPINGS WHICH HAS CURRENT PAGE=0
			AND SKIPPING CURRENT MAPPING 
		-->
          <xsl:variable name="url"><xsl:value-of select="./url"/><xsl:for-each select="../../../../paging_states/mapping_state[(@id != $mapping_id) and (. != 0)]">&amp;start[<xsl:value-of select="./@id"/>]=<xsl:value-of select="."/></xsl:for-each></xsl:variable>
		<!-- /PREPARING PAGING URL VARIABLE-->
          
          <xsl:choose>
             <!-- PRINTING SELETCED PAGING ELEMENT-->
             <xsl:when test="./@selected = 'yes'">
                <a href="{$url}">&amp;nbsp;<b>[<xsl:value-of select="./caption"/>]</b>&amp;nbsp;</a>&amp;nbsp;
             </xsl:when>
             <!-- /PRINTING SELETCED PAGING ELEMENT-->
             
             <!-- PRINTING OTHER ELEMENTS -->
             <xsl:otherwise>
                <a href="{$url}">&amp;nbsp;<xsl:value-of select="./caption"/>&amp;nbsp;</a>&amp;nbsp;
             </xsl:otherwise>
             <!-- /PRINTING OTHER ELEMENTS -->

          </xsl:choose>
       
       </xsl:for-each>
       <!-- /FOR EACH PAGING ELEMENT-->
       
      </xsl:if>
       <!-- /IF TOTAL PAGES COUNT MORE THAN FITS ON ONE PAGE-->


</xsl:template> 

</xsl:stylesheet>               
