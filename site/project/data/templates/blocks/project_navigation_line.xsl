<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template name="project_navigation_line">
		<div class="navline">
		<a href="{/page/@url}">
			<xsl:value-of select="/page/content/localization/_main_page_title"/>
		</a>
		&amp;nbsp;/&amp;nbsp;
		<xsl:choose>
			<xsl:when test="/page/content/cms_structure/pathes/path">
				<!--Navigation line:-->
				<xsl:for-each select="/page/content/cms_structure/pathes/path">
					<xsl:choose>
						<xsl:when test=" position()!= last()">
							<xsl:apply-templates select="."/>
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="title"/>
						</xsl:otherwise>
					</xsl:choose>
				</xsl:for-each>
			</xsl:when>
			<xsl:otherwise>
				<b>
					<xsl:value-of select="//cms_page/title"/>
				</b>
			</xsl:otherwise>
		</xsl:choose>
		</div>
	</xsl:template>
	
	<xsl:template match="path">
		<a href="{/page/@url}{/page/@lng_url_prefix}{url}">
			<xsl:if test="type='blank'">
				<xsl:attribute name="target">_blank</xsl:attribute>
			</xsl:if>
			<xsl:value-of select="title"/>
		</a>
		&amp;nbsp;/&amp;nbsp;
	</xsl:template>
</xsl:stylesheet>
