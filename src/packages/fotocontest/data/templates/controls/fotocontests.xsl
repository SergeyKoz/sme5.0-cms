<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="UTF-8" omit-xml-declaration="yes" media-type="text/html"/>

<xsl:template match="fotocontests">
               

   <!-- future contests-->
   <xsl:if test="agenda">
      <table border="1">  
        <xsl:for-each select="agenda/data">
          <tr>
            <td colspan="2">
            <table>
                <tr>
                    <td>
                        <xsl:value-of select="contest_starts"/> - <xsl:value-of select="contest_ends"/>
                    </td>
                    <td>
                       <a href="{/page/@url}fotocontest/?contest_id={contest_id}">
                       <xsl:if test="selected = 1">
                          <xsl:text disable-output-escaping="yes">&lt;b></xsl:text>  
                       </xsl:if>
                        <xsl:value-of select="caption"/>
                       <xsl:if test="selected = 1">
                          <xsl:text disable-output-escaping="yes">&lt;/b></xsl:text>  
                       </xsl:if>
                       </a>

                    </td>

                </tr>
            </table>
            
            </td>
           </tr>
           <tr>
            <xsl:if test="contest_logo != ''">
            <td><img src="{/page/settings/filestorageurl}{contest_logo}"/></td>
            </xsl:if>

            <td valign="top"><xsl:value-of select="description"/></td>
          </tr>
           <tr>
            <td colspan="2">
                        
            <table width="100%">
                <tr>
                    <td align="left">
                        <xsl:value-of select="//_caption_fotos_count"/> : <xsl:value-of select="cnt"/>
                    </td>
                    <td align="right">
                        <a href="{/page/@url}fotocontest/details/?contest_id={contest_id}" target="blank">
                            <xsl:choose>
                                <xsl:when test="contest_finished = 0">
                                    <xsl:value-of select="//_caption_contest_details"/>
                                </xsl:when>
                                <xsl:otherwise>
                                    <xsl:value-of select="//_caption_contest_results"/>
                                </xsl:otherwise>

                            </xsl:choose>
                        </a>
                    </td>

                </tr>
            </table>
                        
                       
            
            </td>
          </tr>

        </xsl:for-each>
      </table>

   
   </xsl:if>
   <!-- currently running contests-->

   <xsl:if test="now">
    <br/>
    <br/>

      <table border="1">  
        <xsl:for-each select="now/data">
          <tr>
            <td colspan="2">
            <table>
                <tr>
                    <td>
                        <xsl:value-of select="contest_starts"/> - <xsl:value-of select="contest_ends"/>
                    </td>
                    <td>
                       <a href="?contest_id={contest_id}">
                       <xsl:if test="selected = 1">
                          <xsl:text disable-output-escaping="yes">&lt;b></xsl:text>  
                       </xsl:if>
                        <xsl:value-of select="caption"/>
                       <xsl:if test="selected = 1">
                          <xsl:text disable-output-escaping="yes">&lt;/b></xsl:text>  
                       </xsl:if>
                       </a>

                    </td>

                </tr>
            </table>
            
            </td>
           </tr>
           <tr>
            <xsl:if test="contest_logo != ''">
            <td><img src="{/page/settings/filestorageurl}{contest_logo}"/></td>
            </xsl:if>

            <td valign="top"><xsl:value-of select="description"/></td>
          </tr>
           <tr>
            <td colspan="2">
                        
            <table width="100%">
                <tr>
                    <td align="left">
                        <xsl:value-of select="//_caption_fotos_count"/> : <xsl:value-of select="cnt"/>
                    </td>
                    <td align="right">
                        <a href="{/page/@url}fotocontest/details/?contest_id={contest_id}" target="blank">
                            <xsl:choose>
                                <xsl:when test="contest_finished = 0">
                                    <xsl:value-of select="//_caption_contest_details"/>
                                </xsl:when>
                                <xsl:otherwise>
                                    <xsl:value-of select="//_caption_contest_results"/>
                                </xsl:otherwise>

                            </xsl:choose>
                        </a>

                    </td>

                </tr>
            </table>
                        
                       
            
            </td>
          </tr>
        </xsl:for-each>
      </table>

   
   </xsl:if>

   <!-- ended contests-->
   <xsl:if test="history">
      <br/>
      <br/>

      <table border="1">  
        <xsl:for-each select="history/data">
          <tr>
            <td colspan="2">
            <table>
                <tr>
                    <td>
                        <xsl:value-of select="contest_starts"/> - <xsl:value-of select="contest_ends"/>
                    </td>
                    <td>
                       <a href="?contest_id={contest_id}">
                       <xsl:if test="selected = 1">
                          <xsl:text disable-output-escaping="yes">&lt;b></xsl:text>  
                       </xsl:if>
                        <xsl:value-of select="caption"/>
                       <xsl:if test="selected = 1">
                          <xsl:text disable-output-escaping="yes">&lt;/b></xsl:text>  
                       </xsl:if>
                       </a>
                    </td>

                </tr>
            </table>
            
            </td>
           </tr>
           <tr>
            <xsl:if test="contest_logo != ''">
            <td><img src="{/page/settings/filestorageurl}{contest_logo}"/></td>
            </xsl:if>

            <td valign="top"><xsl:value-of select="description"/></td>
          </tr>
           <tr>
            <td colspan="2">
                        
            <table width="100%">
                <tr>
                    <td align="left">
                        <xsl:value-of select="//_caption_fotos_count"/> : <xsl:value-of select="cnt"/>
                    </td>
                    <td align="right">
                        <a href="{/page/@url}fotocontest/details/?contest_id={contest_id}" target="blank">
                            <xsl:choose>
                                <xsl:when test="contest_finished = 0">
                                    <xsl:value-of select="//_caption_contest_details"/>
                                </xsl:when>
                                <xsl:otherwise>
                                    <xsl:value-of select="//_caption_contest_results"/>
                                </xsl:otherwise>

                            </xsl:choose>
                        </a>
                    </td>

                </tr>
            </table>
                        
                       
            
            </td>
          </tr>

        </xsl:for-each>
      </table>

   
   </xsl:if>



</xsl:template> 




</xsl:stylesheet>