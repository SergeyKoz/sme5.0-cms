<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:include href="elements/title.xsl" />

    
    <xsl:template match="text">
    
        <xsl:param name="class"/>
        <xsl:param name="size"/>
        <xsl:param name="style"/>
        <xsl:param name="id"/>
        <xsl:param name="disabled"/>

        <xsl:variable name="name"><xsl:value-of select="name"/></xsl:variable>
        <xsl:variable name="maxlength"><xsl:value-of select="maxlength"/></xsl:variable>
        <xsl:variable name="value"><xsl:value-of select="value"/></xsl:variable>
        <xsl:if test="title">
             <xsl:if test="title/align != 'right'">
                 <xsl:apply-templates select="title"/>
             </xsl:if>
        </xsl:if>
        <input type="text" name="{$name}" value="{$value}" disable-output-escaping="yes">
           <xsl:if test="$class != ''">                                                 
             <xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
           </xsl:if>                                                                    
           <xsl:if test="$style != ''">                                                 
             <xsl:attribute name="style"><xsl:value-of select="$style"/></xsl:attribute>
           </xsl:if>                                                                    

           <xsl:if test="$disabled = 'yes'">
             <xsl:attribute name="disabled"> </xsl:attribute>
           </xsl:if>
           
          <xsl:if test="$id != ''">                                                 
             <xsl:attribute name="id"><xsl:value-of select="$id"/></xsl:attribute>
           </xsl:if>
           
           <xsl:if test="maxlength != ''">
             <xsl:attribute name="maxlength">
                <xsl:value-of select="maxlength"/>
             </xsl:attribute>
           </xsl:if>
           <xsl:if test="size != ''">
             <xsl:attribute name="size">
                <xsl:value-of select="size"/>
             </xsl:attribute>
           </xsl:if>
           <xsl:if test="$size != ''">
             <xsl:attribute name="size">
                <xsl:value-of select="$size"/>
             </xsl:attribute>
           </xsl:if>

        </input>
      
        <xsl:if test="title">
             <xsl:if test="title/align = 'right'">
                 <xsl:apply-templates select="title"/>
             </xsl:if>
        </xsl:if>

    </xsl:template>
</xsl:stylesheet>