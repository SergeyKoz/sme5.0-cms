<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:template match="bannerplace">
       <xsl:param name="place_id"/>
       <xsl:for-each select="banner">
           <xsl:choose>
               <!-- EXTERNAL BANNER -->
               <xsl:when test="banner_type = 0">
                  <xsl:value-of select="banner_text" disable-output-escaping="yes"/>
               </xsl:when>

               <!-- INTERNAL IMAGE BANNER -->
               <xsl:when test="banner_type = 1">
                  <!-- CHECKING IF URL AND PICTURE SET -->
                  <xsl:if test="(banner_url != '') and (banner_file != '')">
                     <a>
                                     <xsl:if test="starts-with(banner_url, '#')">
                                       <xsl:attribute name="href">?</xsl:attribute>
                                     </xsl:if>
                                     <xsl:if test="not(starts-with(banner_url, '#'))">
                                       <xsl:attribute name="href"><xsl:value-of select="/page/@url"/>r.php?b_id=<xsl:value-of select="banner_id"/>&amp;p_id=<xsl:value-of select="/page/@id"/>&amp;pl_id=<xsl:value-of select="$place_id"/>&amp;l=<xsl:value-of select="/page/@language"/></xsl:attribute>
                                     </xsl:if>

                         <xsl:if test="target = 1">
                           <xsl:attribute name="target">_blank</xsl:attribute>
                         </xsl:if>
                         <img src="{/page/settings/filestorageurl}{banner_file}" border="0">
                             <xsl:if test="banner_alt != ''">
                               <xsl:attribute name="alt"><xsl:value-of select="banner_alt"/></xsl:attribute>
                             </xsl:if>
                             <xsl:if test="width &gt; 0">
                               <xsl:attribute name="width"><xsl:value-of select="width"/></xsl:attribute>
                             </xsl:if>
                             <xsl:if test="height &gt; 0">
                               <xsl:attribute name="height"><xsl:value-of select="height"/></xsl:attribute>
                             </xsl:if>

                         </img>
                     </a>
                  </xsl:if>
                  
               </xsl:when>

               <!-- INTERNAL FLASH BANNER -->
               <xsl:when test="banner_type = 2">
                  <!-- CHECKING IF FLASH FILE IS SET -->
                  <xsl:if test="(banner_file != '') and (width &gt; 0) and (height &gt; 0)">
        <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" 
            codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" 
            BORDER="0"
            WIDTH="{width}"
            HEIGHT="{height}"
            >
            <PARAM NAME="movie" VALUE="{/page/settings/filestorageurl}{banner_file}"/>
            <PARAM NAME="quality" VALUE="high"/>
            <PARAM NAME="background" VALUE="transparent"/>
            <EMBED src="{/page/settings/filestorageurl}{banner_file}" quality="high"
                WIDTH="{width}"
                HEIGHT="{height}"
                BORDER="1"
                TYPE="application/x-shockwave-flash"
                PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED>
        </OBJECT>
                  </xsl:if>
                  
               </xsl:when>

               <!-- INTERNAL TEXT BANNER -->
               <xsl:when test="banner_type = 3">
                  <!-- CHECKING IF URL AND PICTURE SET -->
                  <xsl:if test="(banner_url != '') and (banner_alt != '')">
                     <a href="{/page/@url}r.php?b_id={banner_id}&amp;p_id={/page/@id}&amp;pl_id={$place_id}&amp;l={/page/@language}">

                         <xsl:if test="target = 1">
                           <xsl:attribute name="target">_blank</xsl:attribute>
                         </xsl:if>
                         <xsl:value-of select="banner_alt" disable-output-escaping="yes"/>
                     </a>
                  </xsl:if>
                  
               </xsl:when>

           </xsl:choose>

       
       
       </xsl:for-each>


    </xsl:template>
</xsl:stylesheet>