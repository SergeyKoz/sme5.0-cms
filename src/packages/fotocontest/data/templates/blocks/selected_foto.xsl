<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="UTF-8" omit-xml-declaration="yes" media-type="text/html"/>

<xsl:template name="selected_foto">

   <xsl:if test="/page/content/selected_foto/data">
    <xsl:for-each select="/page/content/selected_foto/data">
      <table>
        <tr>
            <td>
                <a href="{/page/@url}fotocontest/?contest_id={contest_id}"><xsl:value-of select="contest_caption"/></a>
            </td>
        </tr>

        <tr>
            <td>
                <a href="{/page/@url}fotocontest/foto/?contest_id={contest_id}&amp;foto_id={foto_id}"><img src="{/page/settings/filestorageurl}{foto_file_thumb}"/></a>
            </td>
        </tr>
        <tr>
            <td>
                <xsl:value-of select="caption"/>
            </td>
        </tr>
        <tr>
            <td>
                <xsl:value-of select="author"/>
            </td>
        </tr>


      </table>
    </xsl:for-each>

   </xsl:if>

</xsl:template> 

</xsl:stylesheet>