<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="UTF-8" omit-xml-declaration="yes" media-type="text/html"/>

<xsl:template match="fotoslist">
               
   <xsl:if test="not(list/row)">
    <table> 
        <tr>
            <td>    
                <xsl:value-of select="//_caption_no_fotos"/>
            </td>
        </tr>
    </table>
   </xsl:if>
   
   <xsl:if test="list/row">
           <xsl:if test="navigator/bar/element">
               <xsl:apply-templates select="navigator"/>
           </xsl:if>
        <xsl:if test="sort_enabled = 1">
           
           <xsl:value-of select="//_caption_sort_by"/>:           

           <a href="{/page/@url}fotocontest/?contest_id={contest_id}&amp;sort=0">
             <xsl:if test="sort_order = 0">
                <xsl:attribute name="style">font-weight:bold</xsl:attribute>
             </xsl:if>
             <xsl:value-of select="//_caption_sort_by_date"/>
             
           </a>
           
           &amp;nbsp;|&amp;nbsp;
            
           <a href="{/page/@url}fotocontest/?contest_id={contest_id}&amp;sort=1">
            <xsl:if test="sort_order = 1">
                <xsl:attribute name="style">font-weight:bold</xsl:attribute>
            </xsl:if>

           <xsl:value-of select="//_caption_sort_by_votes"/>
           </a>

          
        </xsl:if>
        <table>
            <tr>
             <xsl:for-each select="list/row">
                <td>
                  <table border="1">
                    <tr>
                        <td colspan="3">
                            <a href="{/page/@url}fotocontest/foto/?contest_id={contest_id}&amp;foto_id={foto_id}&amp;sort={../../sort_order}"><image src="{/page/settings/filestorageurl}{foto_file_thumb}"/></a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <a href="{/page/@url}fotocontest/foto/?contest_id={contest_id}&amp;foto_id={foto_id}&amp;sort={../../sort_order}"><xsl:value-of select="caption"/></a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <xsl:value-of select="date_posted"/>
                        </td>

                     <xsl:if test="../../sort_enabled = 1">
                        <td>
                            <xsl:value-of select="//_caption_votes_count"/>:&amp;nbsp;
                            <xsl:value-of select="votes_count"/>
                        </td>
                     </xsl:if>

                        
                        <td>
                            <xsl:value-of select="author"/>
                        </td>
                    </tr>

                  </table>
                </td>

                <xsl:if test="(position() mod 3) = 0">
                    <xsl:text disable-output-escaping="yes">
                        &lt;/tr>&lt;tr>
                    </xsl:text>
                </xsl:if>

             </xsl:for-each>   
            </tr>
        </table>

           <xsl:if test="navigator/bar/element">
               <xsl:apply-templates select="navigator"/>
           </xsl:if>

   </xsl:if>
   


</xsl:template> 




</xsl:stylesheet>