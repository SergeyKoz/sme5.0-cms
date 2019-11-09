<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:template match="search_results">
<!-- Форма поиска -->
                        <table cellspacing="0" cellpadding="0" border="0">
                            <tr><td></td><td colspan="3" class="titlesearch" nowrap=""><xsl:value-of select="//_caption_site_search"/>:</td></tr>
                            <tr><td><img src="{/page/@url}img/1x1.gif" width="1" height="4"/></td></tr>
                            <form action="?" method="GET">
                            <tr><td><img src="{/page/@url}img/1x1.gif" width="17" height="1"/></td><td class="search"><input value="{keywords}" type="text" name="search" size="80"/></td><td><img src="img/1x1.gif" width="9" height="1"/></td><td><input type="submit" alt="{//_caption_search}" value="{//_caption_search}"/></td></tr>
                            </form>
                        </table>
<!-- Конец Форме поиска -->
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr><td><img src="{/page/@url}img/1x1.gif" width="1" height="26"/></td></tr>
                            <tr><td bgcolor="#c91432"><img src="img/1x1.gif" width="1" height="1"/></td></tr>
                            <tr><td><img src="{/page/@url}img/1x1.gif" width="1" height="15"/></td></tr>
                        </table>



       <xsl:if test="row">
       <xsl:apply-templates select="../navigator"/>

          <xsl:for-each select="row">
 <table cellspacing="0" cellpadding="0" border="0" width="100%">
     <tr><td><img src="{/page/@url}img/1x1.gif" width="1" height="25"/></td></tr>
 </table>
 <table cellspacing="0" cellpadding="0" border="0" width="100%">
     <tr>
         <td><img src="{/page/@url}img/1x1.gif" width="17" height="1"/></td>
         <td class="content"><img src="img/1x1.gif" width="17" height="1"/><br/><xsl:value-of select="number"/></td>
         <td width="100%" class="titleannounce"><a href="{url}" target="_blank"><xsl:value-of select="title"/></a></td>
     </tr>
     <tr>
         <td><img src="{/page/@url}img/1x1.gif" width="1" height="3"/></td>
     </tr>
     <tr>
         <td></td>
         <td></td>
         <td width="100%" class="searchcontent"><xsl:value-of select="description" disable-output-escaping="yes"/></td>
     </tr>
 </table>



          </xsl:for-each>

 <table cellspacing="0" cellpadding="0" border="0" width="100%">
     <tr><td><img src="{/page/@url}img/1x1.gif" width="1" height="25"/></td></tr>
 </table>

       <xsl:apply-templates select="../navigator"/>


 <table cellspacing="0" cellpadding="0" border="0" width="100%">
     <tr><td><img src="{/page/@url}img/1x1.gif" width="1" height="10"/></td></tr>
 </table>
 <table cellspacing="0" cellpadding="0" border="0" width="100%">
     <tr><td class="searchcontent"><xsl:value-of select="//_caption_total_found"/>: <xsl:value-of select="total"/></td></tr>
 </table>

       
       </xsl:if>

    </xsl:template>
</xsl:stylesheet>