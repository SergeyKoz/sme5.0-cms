<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:template match="filter">
   <script>
   function changeMonth(){
       document.forms["filter"].event.value="daily";
       document.forms["filter"].submit();
   }
   </script>


       <form action="?" name="filter" method="GET">
       <input type="hidden" name="event" value="{event}"/>
       <input type="hidden" name="package" value="banner"/>
       <input type="hidden" name="page" value="bannerstats"/>
       <xsl:apply-templates select="banners"/>
       &amp;nbsp;&amp;nbsp;&amp;nbsp;
       <xsl:apply-templates select="pages"/>
       <br/><br/>
       <xsl:apply-templates select="places"/>
       &amp;nbsp;&amp;nbsp;&amp;nbsp;
       <xsl:apply-templates select="month"/>

       <xsl:if test="days/select">
       &amp;nbsp;-&amp;nbsp;
       <xsl:apply-templates select="days"/>
       </xsl:if>

       &amp;nbsp;&amp;nbsp;&amp;nbsp;
       <input type="submit" value="{//_caption_submit_filter}"/>
       <hr/>
       </form>


    </xsl:template>
</xsl:stylesheet>