<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template match="navigator">
		<xsl:param name="class"/>
        <xsl:if test="total &gt; rpp">
        	<div class="nav_links">
        		<xsl:for-each select="bar/element">
                	<xsl:variable name="url"><xsl:value-of select="./url"/></xsl:variable>
                    <xsl:choose>
                    	<xsl:when test="./@selected = 'yes'">
                        	<a href="{$url}" class="sort-table">&amp;nbsp;<b><xsl:value-of select="./caption"/></b>&amp;nbsp;</a>&amp;nbsp;
                        </xsl:when>
                        <xsl:otherwise>
                        	<a href="{$url}" class="sort-table-active">&amp;nbsp;<xsl:value-of select="./caption"/>&amp;nbsp;</a>&amp;nbsp;
                        </xsl:otherwise>
                    </xsl:choose>
                </xsl:for-each>
			</div>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
