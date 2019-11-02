<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:template match="detailed">
       <a href="?page=bannerstats&amp;package=banner&amp;banner_id={../filter/banner_id}&amp;page_id={../filter/page_id}&amp;place_id={../filter/place_id}&amp;month_id={../filter/month_id}&amp;event=daily">
       <b><xsl:value-of select="//_caption_daily_report"/></b>
       </a>
       <br/><br/>
       <table border="0" cellpadding="5" cellspacing="0" class="sort-table">
         <thead>
           <tr>
               <td width="100"><b><xsl:value-of select="//_caption_banner_title"/></b>
               </td> 
               <td width="100" align="right"><b><xsl:value-of select="//_caption_views"/></b>
               </td> 
               <td width="100" align="right"><b><xsl:value-of select="//_caption_clicks"/></b>
               </td> 
               <td width="100" align="right"><b><xsl:value-of select="//_caption_ctr"/></b>
               </td> 

           </tr>
         </thead>

         <xsl:for-each select="banner">
           <tr>
           <xsl:choose>
                <xsl:when test="position() mod 2 = 1">
                    <xsl:attribute name="bgcolor">#FFFFFF</xsl:attribute>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:attribute name="bgcolor">#F0F0F0</xsl:attribute>
                </xsl:otherwise>
           </xsl:choose>
           
               <td>
               <b><xsl:value-of select="caption"/></b>
               </td> 
               <td align="right"><xsl:value-of select="views"/>
               </td> 
               <td align="right"><xsl:value-of select="clicks"/>
               </td> 
               <td align="right">
               <xsl:choose>
                <xsl:when test="views > 0">
                  <xsl:value-of select="format-number(number((100*clicks) div views), '##0.000')"/>
                </xsl:when>
                <xsl:otherwise>0.000
                </xsl:otherwise>
               </xsl:choose>
               %
               </td> 

           </tr>

         
         </xsl:for-each>
         </table>

    </xsl:template>
</xsl:stylesheet>