<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:template match="daily">
       <table border="0" cellpadding="5" cellspacing="0" class="sort-table">
         <thead>
           <tr>
               <td width="100"><b><xsl:value-of select="//_caption_day"/></b>
               </td> 
               <td width="100" align="right"><b><xsl:value-of select="//_caption_views"/></b>
               </td> 
               <td width="100" align="right"><b><xsl:value-of select="//_caption_clicks"/></b>
               </td> 
               <td width="100" align="right"><b><xsl:value-of select="//_caption_ctr"/></b>
               </td> 

           </tr>
         </thead>

         <xsl:for-each select="day">
           <tr>
           <xsl:choose>
                <xsl:when test="position() mod 2 = 1">
                    <xsl:attribute name="bgcolor">#FFFFFF</xsl:attribute>
                </xsl:when>
                <xsl:otherwise>
                    <xsl:attribute name="bgcolor">#F0F0F0</xsl:attribute>
                </xsl:otherwise>
           </xsl:choose>
           
               <td><a href="?package=banner&amp;page=bannerstats&amp;event=detailed&amp;page_id={/page/content/filter/page_id}&amp;banner_id={/page/content/filter/banner_id}&amp;place_id={/page/content/filter/place_id}&amp;month_id={/page/content/filter/month_id}&amp;day={day}">
               <b><xsl:value-of select="day"/></b>
               </a>
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