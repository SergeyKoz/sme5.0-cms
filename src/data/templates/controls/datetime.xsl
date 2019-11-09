<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    
    <xsl:template match="datetime">
        <xsl:param name="class"/>    
        <xsl:param name="disabled"/>    
        

        <xsl:if test="days">
            <select name="{days/name}_day">
                 <xsl:if test="$class != ''">                                                 
                   <xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
                 </xsl:if>                                                                    
            <xsl:if test="(disabled = 'yes') or (disabled = 1) or $disabled ='yes'">
               <xsl:attribute name="disabled"> </xsl:attribute>
            </xsl:if>
            <xsl:for-each select="days/day">
                <option value="{.}">
                   <xsl:if test="./@selected">
                     <xsl:attribute name="selected"> </xsl:attribute>
                   </xsl:if>
                   <xsl:value-of select="."/>
                </option>
            </xsl:for-each>
            </select>
            .
        </xsl:if>

        <xsl:if test="months">
            <select name="{months/name}_month">
                 <xsl:if test="$class != ''">                                                 
                   <xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
                 </xsl:if>                                                                    

            <xsl:if test="(disabled = 'yes') or (disabled = 1) or $disabled ='yes'">
               <xsl:attribute name="disabled"> </xsl:attribute>
            </xsl:if>
            <xsl:for-each select="months/month">
                <option value="{.}">
                   <xsl:if test="./@selected">
                     <xsl:attribute name="selected"> </xsl:attribute>
                   </xsl:if>
                   <xsl:value-of select="."/>
                </option>
            </xsl:for-each>
            </select>
            .
        </xsl:if>

        <xsl:if test="years">
            <select name="{years/name}_year">
                 <xsl:if test="$class != ''">                                                 
                   <xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
                 </xsl:if>                                                                    
            <xsl:if test="(disabled = 'yes') or (disabled = 1) or $disabled ='yes'">
               <xsl:attribute name="disabled"> </xsl:attribute>
            </xsl:if>
            <xsl:for-each select="years/year">
                <option value="{.}">
                   <xsl:if test="./@selected">
                     <xsl:attribute name="selected"> </xsl:attribute>
                   </xsl:if>
                   <xsl:value-of select="."/>
                </option>
            </xsl:for-each>
            </select>
        </xsl:if>
        <xsl:if test="hours">
        &amp;nbsp;
            <select name="{hours/name}_hour">
                 <xsl:if test="$class != ''">                                                 
                   <xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
                 </xsl:if>                                                                    

            <xsl:if test="(disabled = 'yes') or (disabled = 1) or $disabled ='yes'">
               <xsl:attribute name="disabled"> </xsl:attribute>
            </xsl:if>
            <xsl:for-each select="hours/hour">
                <option value="{.}">
                   <xsl:if test="./@selected">
                     <xsl:attribute name="selected"> </xsl:attribute>
                   </xsl:if>
                   <xsl:value-of select="."/>
                </option>
            </xsl:for-each>
            </select>
        </xsl:if>

        <xsl:if test="minutes">
        :
            <select name="{minutes/name}_minute">
                 <xsl:if test="$class != ''">                                                 
                   <xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
                 </xsl:if>                                                                    

            <xsl:if test="(disabled = 'yes') or (disabled = 1) or $disabled ='yes'">
               <xsl:attribute name="disabled"> </xsl:attribute>
            </xsl:if>
            <xsl:if test="disabled != ''">
               <xsl:attribute name="disabled"> </xsl:attribute>
            </xsl:if>
            <xsl:for-each select="minutes/minute">
                <option value="{.}">
                   <xsl:if test="./@selected">
                     <xsl:attribute name="selected"> </xsl:attribute>
                   </xsl:if>
                   <xsl:value-of select="."/>
                </option>
            </xsl:for-each>
            </select>
        </xsl:if>

        <xsl:if test="seconds">
        :
            <select name="{seconds/name}_second">
                 <xsl:if test="$class != ''">                                                 
                   <xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
                 </xsl:if>                                                                    

            <xsl:if test="(disabled = 'yes') or (disabled = 1) or $disabled ='yes'">
               <xsl:attribute name="disabled"> </xsl:attribute>
            </xsl:if>
            <xsl:if test="disabled != ''">
               <xsl:attribute name="disabled"> </xsl:attribute>
            </xsl:if>
            <xsl:for-each select="seconds/second">
                <option value="{.}">
                   <xsl:if test="./@selected">
                     <xsl:attribute name="selected"> </xsl:attribute>
                   </xsl:if>
                   <xsl:value-of select="."/>
                </option>
            </xsl:for-each>
            </select>
        </xsl:if>
    </xsl:template>
</xsl:stylesheet>
