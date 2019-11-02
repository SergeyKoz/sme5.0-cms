<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="yes" media-type="text/html"/>

<xsl:template match="contestdetails">
               
    <xsl:if test="contest">
        <table>
            <tr>
                <td valign="top">
                    <table>
                        <tr>
                            <td>
                                <xsl:value-of select="contest/starts_from"/> - <xsl:value-of select="contest/ends_to"/>
                            </td>
                            <td>
                                <b><xsl:value-of select="contest/caption"/></b>
                            </td>
                         </tr>
                    </table>
                </td>
            </tr>

          <xsl:if test="contest/full_description != ''">
          <tr>
                <td valign="top" colspan="2"><h2><xsl:value-of select="//_caption_contest_full_description"/></h2></td>
          </tr>

              <tr>
                <td valign="top" colspan="2"><xsl:value-of select="contest/full_description" disable-output-escaping="yes"/></td>
              </tr>
          </xsl:if>

       <xsl:if test="contest/contest_finished = 1">
          <tr>
                <td valign="top" colspan="2"><h2><xsl:value-of select="//_caption_contest_results"/></h2></td>
          </tr>
          <xsl:if test="contest/results != ''">
              <tr>
                <td valign="top" colspan="2"><xsl:value-of select="contest/results" disable-output-escaping="yes"/></td>
              </tr>
          </xsl:if>

          <xsl:if test="result_list/row">
              <tr>
                <td valign="top" colspan="2">
                   <table border="1">
                      <xsl:for-each select="result_list/row">
                      <tr>
                        <td rowspan="2">
                            <xsl:value-of select="position()"/>
                        </td>
                        <td valign="top" rowspan="2">
                            <a href="{/page/@url}fotocontest/foto/?contest_id={contest_id}&amp;foto_id={foto_id}">
                            <img src="{/page/settings/filestorageurl}{foto_file_thumb}"/>
                            </a>
                            
                        </td>
                        <td>

                              <table>
                                  <tr>
                                      <td>
                                          <xsl:value-of select="date_posted"/>
                                      </td>
                                      <td>  
                                          <a href="{/page/@url}fotocontest/foto/?contest_id={contest_id}&amp;foto_id={foto_id}"><xsl:value-of select="caption"/></a>
                                      </td>
                                   </tr>


                            

                            
                                   <tr>
                                      <td>
                                         <xsl:value-of select="author"/>
                                      </td>
                                    <xsl:if test="author_email != ''">  
                                      <td>
                                          <a href="mailto:{author_email}"><xsl:value-of select="author_email"/></a>
                                      </td>
                                    </xsl:if>

                                   </tr>
                                   <xsl:if test="(../../contest/disable_voting = 0) or (../../contest/expert_voting = 1)">
                                   <tr>
                                      <td colspan="2">
                                      <xsl:value-of select="//_caption_votes_count"/>:&amp;nbsp;
                                         <xsl:value-of select="votes_count"/>
                                      </td>

                                   </tr>
                                   </xsl:if>
                              </table>


                        </td>
                      </tr>
                      <tr>
                        <td valign="top">
                            <xsl:value-of select="description"/>
                        </td>
                      </tr>
                      </xsl:for-each>
                   </table>
                
                
                
                </td>
              </tr>
          </xsl:if>
       </xsl:if>



        </table>
    
    </xsl:if>


</xsl:template> 




</xsl:stylesheet>