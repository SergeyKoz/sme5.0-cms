<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="yes" media-type="text/html"/>

<xsl:template match="fotodetails">
               
    <xsl:if test="foto">
        <table border="1">
           <tr>
                <td>
                    <xsl:value-of select="foto/caption"/>
                </td>
           </tr>

           <tr>
                <td>
                    <img src="{/page/settings/filestorageurl}{foto/foto_file}"/>
                </td>
           </tr>
           <tr>
                <td>
                    <table>
                        <tr>
                            <td>
                                <xsl:value-of select="foto/date_posted"/>
                            </td>

                            <td>
                                <xsl:value-of select="foto/author"/> 

                            </td>
                        <xsl:if test="foto/author_email != ''">
                            <td>
                                E-Mail:&amp;nbsp;<a href="mailto:{foto/author_email}"><xsl:value-of select="foto/author_email"/></a>
                            </td>
                        </xsl:if>
                        <xsl:if test="votes_enabled = 1">
                            <td>
                                <xsl:value-of select="//_caption_votes_count"/>:&amp;nbsp;
                                <xsl:value-of select="foto/votes_count"/>
                                
                            </td>
                            <td>
                                <xsl:if test="contest_finished = 0">
                                    <a href="#" onclick="document.fotovote.submit(); return false;"><xsl:value-of select="//_caption_foto_vote"/></a>
                                    <form action="{/page/@url}fotocontest/foto/" method="POST" name="fotovote" style="padding:0px; margin:0px;">
                                    <input type="hidden" name="contest_id" value="{contest_id}"/>
                                    <input type="hidden" name="foto_id" value="{foto/foto_id}"/>
                                    <input type="hidden" name="sort" value="{sort_order}"/>
                                    <input type="hidden" name="event" value="fotovote"/>
                                    </form>
                                    
                                </xsl:if>

                            </td>
                        </xsl:if>
                        </tr>
                    </table>

                </td>
           </tr>
           <tr>
                <td>
                    <xsl:value-of select="foto/description"/>
                </td>
           </tr>

           <tr>
                <td>
                     <table border="1" width="100%">
                        <tr>
                            <td width="50%" align="left">
                                <xsl:if test="prev">
                                    <a href="{/page/@url}fotocontest/foto/?contest_id={contest_id}&amp;foto_id={prev/foto_id}&amp;sort={sort_order}">
                                    <img src="{/page/settings/filestorageurl}{prev/foto_file_thumb}" title="{//_caption_foto_prev}"/>
                                    </a>
                                    <br/>
                                    <xsl:value-of select="prev/author"/>
                                    
                                </xsl:if>
                            </td>
                            <td width="50%" align="right">
                                <xsl:if test="next">
                                    <a href="{/page/@url}fotocontest/foto/?contest_id={contest_id}&amp;foto_id={next/foto_id}&amp;sort={sort_order}">
                                    <img src="{/page/settings/filestorageurl}{next/foto_file_thumb}" title="{//_caption_foto_next}"/>
                                    </a>
                                    <br/>
                                    <xsl:value-of select="next/author"/>
                                    
                                </xsl:if>

                            </td>

                        </tr>
                     </table>

                </td>
           </tr>



        </table>
    
    </xsl:if>



</xsl:template> 




</xsl:stylesheet>