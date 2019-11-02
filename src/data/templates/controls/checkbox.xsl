<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <!--  xsl:include href="elements/title.xsl" / -->

    <xsl:template match="checkbox">
        <xsl:param name="class"/>
        <xsl:param name="disabled"/>
        <xsl:param name="id"/>

        <xsl:variable name="name"><xsl:value-of select="name"/></xsl:variable>
        
        <input type="checkbox" name="{$name}" id="inp{../@id}">
          <xsl:if test="value != ''">
             <xsl:attribute name="value"><xsl:value-of select="value" /></xsl:attribute>
          </xsl:if>
          <xsl:if test="value = ''">
             <xsl:attribute name="value">1</xsl:attribute>
          </xsl:if>
          <xsl:if test="checked = 'yes'">
             <xsl:attribute name="checked"> </xsl:attribute>
          </xsl:if>
          <xsl:if test="disabled = 'yes' or $disabled = 'yes'">
             <xsl:attribute name="disabled"> </xsl:attribute>
          </xsl:if>
          <xsl:if test="$class != ''">                                                 
            <xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
          </xsl:if>     
            <xsl:if test="$id != ''">                                                 
             <xsl:attribute name="id"><xsl:value-of select="$id"/></xsl:attribute>
           </xsl:if>                                                               
          
        </input>
    </xsl:template>
</xsl:stylesheet>
