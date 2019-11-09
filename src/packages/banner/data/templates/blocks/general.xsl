<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:template match="general">
       <table border="0" cellpadding="5" cellspacing="0" class="sort-table">
         <thead>
           <tr>
               <td width="100"><b><xsl:value-of select="//_caption_period"/></b>
               </td> 
               <td width="100" align="right"><b><xsl:value-of select="//_caption_views"/></b>
               </td> 
               <td width="100" align="right"><b><xsl:value-of select="//_caption_clicks"/></b>
               </td> 
               <td width="100" align="right"><b><xsl:value-of select="//_caption_ctr"/></b>
               </td> 

           </tr>
         </thead>

           <tr>
               <td><a href="?package=banner&amp;page=bannerstats&amp;event=detailed&amp;month_id={date/today_month}&amp;day={date/today}">
               <b><xsl:value-of select="//_caption_today"/></b>
               </a>
               </td> 
               <td align="right"><xsl:value-of select="views/today"/>
               </td> 
               <td align="right"><xsl:value-of select="clicks/today"/>
               </td> 
               <td align="right">
               <xsl:choose>
                <xsl:when test="views/today > 0">
                   <xsl:value-of select="format-number(number((100*clicks/today) div views/today), '##0.000')"/>
                </xsl:when>
                <xsl:otherwise>0.000
                </xsl:otherwise>
               </xsl:choose>
               %
               </td> 

           </tr>
           <tr>
               <td><a href="?package=banner&amp;page=bannerstats&amp;event=detailed&amp;month_id={date/yesterday_month}&amp;day={date/yesterday}">
               <b><xsl:value-of select="//_caption_yesterday"/></b></a>
               </td> 
               <td align="right"><xsl:value-of select="views/yesterday"/>
               </td> 
               <td align="right"><xsl:value-of select="clicks/yesterday"/>
               </td> 
               <td align="right">
               <xsl:choose>
                <xsl:when test="views/yesterday > 0">
                   <xsl:value-of select="format-number(number((100*clicks/yesterday) div views/yesterday),'##0.000')"/>
                </xsl:when>
                <xsl:otherwise>0.000
                </xsl:otherwise>
               </xsl:choose>
               %
               </td> 

           </tr>
           <tr>
               <td><a href="?package=banner&amp;page=bannerstats&amp;event=daily&amp;month_id={date/today_month}">
               <b><xsl:value-of select="//_caption_this_month"/></b></a>
               </td> 
               <td align="right"><xsl:value-of select="views/month"/>
               </td> 
               <td align="right"><xsl:value-of select="clicks/month"/>
               </td> 
               <td align="right">
               <xsl:choose>
                <xsl:when test="views/month > 0">
                   <xsl:value-of select="format-number(number((100*clicks/month) div views/month),'##0.000')"/>
                </xsl:when>
                <xsl:otherwise>0.000
                </xsl:otherwise>
               </xsl:choose>
               %
               </td> 

           </tr>

       </table>


    </xsl:template>
</xsl:stylesheet>