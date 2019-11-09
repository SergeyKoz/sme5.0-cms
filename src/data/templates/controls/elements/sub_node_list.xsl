<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:template match="sub_node_list">
       <xsl:param name="url"/>
       <xsl:param name="var_name"/>
       <xsl:for-each select="node">
       [{"id":<xsl:value-of select="./@id"/>},'<xsl:value-of select="caption"/>', "<xsl:if test="$url != ''"><xsl:value-of select="$url"/>&amp;</xsl:if><xsl:if test="$url=''">?</xsl:if><xsl:value-of select="$var_name"/>=<xsl:value-of select="./@id"/>", null<xsl:if test="sub_node_list/node">,</xsl:if>
         <xsl:choose>
           <xsl:when test="sub_node_list">
               <xsl:apply-templates select="sub_node_list">
               <xsl:with-param name="url"><xsl:value-of select="$url"/></xsl:with-param>
               <xsl:with-param name="var_name"><xsl:value-of select="$var_name"/></xsl:with-param>
               </xsl:apply-templates>
           </xsl:when>
           <xsl:otherwise>
               ],
           </xsl:otherwise>
         </xsl:choose>
         <xsl:if test="sub_node_list">]</xsl:if><xsl:if test="position() &lt; count(../node)">,</xsl:if>
         
        </xsl:for-each>
    </xsl:template>
</xsl:stylesheet>
