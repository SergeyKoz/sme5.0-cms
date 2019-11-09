<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template match="navigator">
		<xsl:param name="class"/>
		<xsl:if test="total &gt; rpp">
			<div class="pager">
                <xsl:for-each select="bar/element">
                    <xsl:variable name="url">
                        <xsl:value-of select="./url"/>
                    </xsl:variable>
                    <xsl:choose>
                        <xsl:when test="./@selected = 'yes'">
                            <a href="javascript:;" class="on"><xsl:value-of select="./caption"/></a>
                        </xsl:when>
                                              
                        <!--xsl:when test="contains(caption, '&lt;&lt;')">
                           <a href="{$url}" class="rpage">Next</a>
                        </xsl:when>

                        <xsl:when test="contains(caption, '>>')">
                            <a href="{$url}" class="lpage">Prev</a>
                        </xsl:when-->
                        
                        <xsl:otherwise>
                            <a href="{$url}"><xsl:value-of select="./caption"/></a>
                        </xsl:otherwise>
                    </xsl:choose>
                    
                    
                </xsl:for-each>
                <ins></ins>
			</div>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
