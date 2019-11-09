<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:template match="textarea">
        <xsl:param name="class"/>
        <xsl:param name="style"/>
        <xsl:param name="cols"/>
        <xsl:param name="rows"/>
        <xsl:param name="disabled"/>
        <xsl:param name="id"/>

        <textarea  name="{name}"   rows="{rows}"  cols="{cols}" disable-output-escaping="yes">
           <xsl:if test="$class != ''">                                                 
             <xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
           </xsl:if>                                                                    

           <xsl:if test="$style != ''">                                                 
             <xsl:attribute name="style"><xsl:value-of select="$style"/></xsl:attribute>
           </xsl:if>                                                                    
           <xsl:if test="$cols != ''">                                                 
             <xsl:attribute name="cols"><xsl:value-of select="$cols"/></xsl:attribute>
           </xsl:if>                                                                    
           <xsl:if test="$rows != ''">                                                 
             <xsl:attribute name="rows"><xsl:value-of select="$rows"/></xsl:attribute>
           </xsl:if>                                                                    

           <xsl:if test="(readonly = 'yes') or (readonly = 1) or $disabled = 'yes'">
                <xsl:attribute name="readonly"> </xsl:attribute>
           </xsl:if>
           <xsl:if test="(disabled = 'yes') or (disabled = 1)">
                <xsl:attribute name="disabled"> </xsl:attribute>
           </xsl:if>
            <xsl:if test="$id != ''">                                                 
             <xsl:attribute name="id"><xsl:value-of select="$id"/></xsl:attribute>
           </xsl:if>

           <xsl:value-of select="content" disable-output-escaping="yes"/>
        </textarea>
    </xsl:template>
</xsl:stylesheet>