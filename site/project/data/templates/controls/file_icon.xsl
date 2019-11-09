<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="UTF-8" omit-xml-declaration="yes" media-type="text/html"/>


<xsl:template name="_file_icon">
    <xsl:param name="ext"/>
    <xsl:param name="caption"/>
     <xsl:choose>
         <xsl:when test="$ext='ppt'"><img src="{/page/@url}img/icons/log_ppt.gif" border="0" alt="{$caption}" align="absmiddle" vspace="5" />
         </xsl:when>
         <xsl:when test="$ext='zip'"><img src="{/page/@url}img/icons/log_zip.gif" border="0" alt="{$caption}" align="absmiddle" vspace="5" />
         </xsl:when>
         <xsl:when test="$ext='doc'"><img src="{/page/@url}img/icons/log_wrd.gif" border="0" alt="{$caption}" align="absmiddle" vspace="5" />
         </xsl:when>
         <xsl:when test="$ext='pdf'"><img src="{/page/@url}img/icons/log_pdf.gif" border="0" alt="{$caption}" align="absmiddle" vspace="5" />
         </xsl:when>

         <xsl:when test="$ext='amp'"><img src="{/page/@url}img/icons/log_amp.gif" border="0" alt="{$caption}" align="absmiddle" vspace="5" />
         </xsl:when>
         <xsl:when test="$ext='exe'"><img src="{/page/@url}img/icons/log_exe.gif" border="0" alt="{$caption}" align="absmiddle" vspace="5" />
         </xsl:when>
         <xsl:when test="$ext='rar'"><img src="{/page/@url}img/icons/log_rar.gif" border="0" alt="{$caption}" align="absmiddle" vspace="5" />
         </xsl:when>
         <xsl:when test="($ext='htm') or ($ext='html')"><img src="{/page/@url}img/icons/log_htm.gif" border="0" alt="{$caption}" align="absmiddle" vspace="5" />
         </xsl:when>
         <xsl:when test="$ext='rtf'"><img src="{/page/@url}img/icons/log_rtf.gif" border="0" alt="{$caption}" align="absmiddle" vspace="5" />
         </xsl:when>
         <xsl:when test="$ext='xls'"><img src="{/page/@url}img/icons/log_xls.gif" border="0" alt="{$caption}" align="absmiddle" vspace="5" />
         </xsl:when>
         <xsl:when test="$ext='txt'"><img src="{/page/@url}img/icons/log_txt.gif" border="0" alt="{$caption}" align="absmiddle" vspace="5" />
         </xsl:when>

         <xsl:otherwise><img src="{/page/@url}img/icons/ico_blank.gif" width="16" height="16" border="0" alt="{$caption}" align="absmiddle" vspace="5" />
         </xsl:otherwise>
     </xsl:choose>
</xsl:template> 

</xsl:stylesheet>               
