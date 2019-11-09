<?xml version="1.0" encoding="utf-8"?>
<!-- edited with XMLSPY v5 rel. 4 U (http://www.xmlspy.com) by user (company) -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">

    <xsl:template match="link">
        <xsl:param name="class"/>
        <xsl:param name="disabled"/>    
        <xsl:param name="bold"/>

        <xsl:variable name="href"><xsl:value-of select="href"/></xsl:variable>
        <xsl:variable name="target"><xsl:value-of select="target"/></xsl:variable>
        <xsl:variable name="alt"><xsl:value-of select="alt"/></xsl:variable>


        <!--xsl:for-each select="variables/pair">
              <xsl:variable name="data"><xsl:value-of select="$data"/><xsl:value-of select="name"/>=<xsl:value-of select="value"/>&amp;</xsl:variable>
        </xsl:for-each-->
     <xsl:choose>
       <xsl:when test="$bold != '' or bold !=''">
        <xsl:choose>
            <xsl:when test="disabled or $disabled ='yes'">
                <a>
                   <xsl:if test="$class != ''">
                     <xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
                   </xsl:if>
                <b>
                  <xsl:choose>  
                    <xsl:when test="cut_length">
                        <xsl:value-of select="substring(caption,1,cut_length)"/>
                        <xsl:if test="string-length(caption) &gt; number(cut_length)">...</xsl:if>
                    </xsl:when>
                    <xsl:otherwise>
                        <xsl:value-of select="caption" disable-output-escaping="yes"/>
                    </xsl:otherwise>
                  </xsl:choose>
                    
                </b>
                </a>
            </xsl:when>
            
            <xsl:otherwise>
                <a href="{$href}" target="{$target}" alt="{$alt}">
                   <xsl:if test="$class != ''">
                     <xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
                   </xsl:if>
                <b>
                  <xsl:choose>  
                    <xsl:when test="cut_length">
                        <xsl:value-of select="substring(caption,1,cut_length)"/>
                        <xsl:if test="string-length(caption) &gt; number(cut_length)">...</xsl:if>
                    </xsl:when>
                    <xsl:otherwise>
                        <xsl:value-of select="caption" disable-output-escaping="yes"/>
                    </xsl:otherwise>
                  </xsl:choose>
                    
                </b>
                </a>
            </xsl:otherwise>

        </xsl:choose>
       </xsl:when>      
       <xsl:otherwise>
        <xsl:choose>
            <xsl:when test="disabled or $disabled ='yes'">
                <a>
                   <xsl:if test="$class != ''">
                     <xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
                   </xsl:if>
                  <xsl:choose>  
                    <xsl:when test="cut_length">
                        <xsl:value-of select="substring(caption,1,cut_length)"/>
                        <xsl:if test="string-length(caption) &gt; number(cut_length)">...</xsl:if>
                    </xsl:when>
                    <xsl:otherwise>
                        <xsl:value-of select="caption" disable-output-escaping="yes"/>
                    </xsl:otherwise>
                  </xsl:choose>

                </a>
            </xsl:when>
            
            <xsl:otherwise>
                <a href="{$href}" target="{$target}" alt="{$alt}">
                   <xsl:if test="$class != ''">
                     <xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
                   </xsl:if>
                  <xsl:choose>  
                    <xsl:when test="cut_length">
                        <xsl:value-of select="substring(caption,1,cut_length)"/>
                        <xsl:if test="string-length(caption) &gt; number(cut_length)">...</xsl:if>
                    </xsl:when>
                    <xsl:otherwise>
                        <xsl:value-of select="caption" disable-output-escaping="yes"/>
                    </xsl:otherwise>
                  </xsl:choose>

                </a>
            </xsl:otherwise>

        </xsl:choose>

       </xsl:otherwise>
     </xsl:choose>

    </xsl:template>
</xsl:stylesheet>