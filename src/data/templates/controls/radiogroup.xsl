<?xml version="1.0" encoding="windows-1251"?>
<!-- edited with XMLSPY v5 rel. 4 U (http://www.xmlspy.com) by user (company) -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">

    
    <xsl:template match="radiogroup">
        <xsl:param name="class"/>    
        <xsl:param name="disabled"/>    
        
        <xsl:if test="radio">
          <xsl:for-each select="radio">
            <input type="radio" name="{./name}" value="{./value}">
                 <xsl:if test="$class != ''">                                                 
                   <xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
                 </xsl:if>                                                                    
        
                 <xsl:if test="./disabled = 'yes' or $disabled = 'yes'">                                                 
                   <xsl:attribute name="disabled"> </xsl:attribute>
                 </xsl:if>
        
                 <xsl:if test="./checked = 'yes'">                                                 
                   <xsl:attribute name="checked"> </xsl:attribute>
                 </xsl:if>
            </input>          
            <xsl:value-of select="./caption"/>
            <br/>
         </xsl:for-each>
         <br/>
       </xsl:if>

    </xsl:template>
</xsl:stylesheet>
