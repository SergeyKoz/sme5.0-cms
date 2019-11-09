<?xml version="1.0" encoding="utf-8"?>
<!-- edited with XMLSPY v5 rel. 4 U (http://www.xmlspy.com) by user (company) -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:include href="elements/title.xsl" />

    
    <xsl:template match="radio">
        <xsl:param name="class"/>    
        <xsl:param name="disabled"/>   
        <xsl:param name="id"/> 
        
        <xsl:if test="title">
             <xsl:if test="title/align != 'right'">
                 <xsl:apply-templates select="title"/>
             </xsl:if>
        </xsl:if>
        
        <input type="radio" name="{name}" value="{value}">
             <xsl:if test="$class != ''">                                                 
               <xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
             </xsl:if>                                                                    

             <xsl:if test="disabled = 'yes' or $disabled = 'yes'">                                                 
               <xsl:attribute name="disabled"> </xsl:attribute>
             </xsl:if>

             <xsl:if test="checked = 'yes'">                                                 
               <xsl:attribute name="checked"> </xsl:attribute>
             </xsl:if>
              <xsl:if test="$id != ''">                                                 
	             <xsl:attribute name="id"><xsl:value-of select="$id"/></xsl:attribute>
	           </xsl:if>
        </input>

        <xsl:if test="title">
             <xsl:if test="title/align = 'right'">
                 <xsl:apply-templates select="title"/>
             </xsl:if>
        </xsl:if>

    </xsl:template>
</xsl:stylesheet>
