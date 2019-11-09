<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template name="sitemap_control">
		<ul class="sitemap" rel="SME:&amp;#123;'mode':'sitemap', 'item_id':''&amp;#125;">
			<xsl:for-each select="/page/content/cms_sitemap/item">
				<xsl:apply-templates select="." mode="sitemap"/>
			</xsl:for-each>
		</ul>
	</xsl:template>
	<xsl:template match="item" mode="sitemap">
		<li class="margin20">
			<a href="{/page/@url}{/page/@lng_url_prefix}{url}/">
				<xsl:if test="external=1">
					<xsl:attribute name="href"><xsl:value-of select="url"/></xsl:attribute>
				</xsl:if>
				<xsl:if test="point_type='blank'">
					<xsl:attribute name="target">_blank</xsl:attribute>
				</xsl:if>
				<xsl:value-of select="title"/>
			</a>
			<xsl:if test="item">
				<ul>
					<xsl:for-each select="item">
						<xsl:apply-templates select="." mode="sitemap"/>
					</xsl:for-each>
				</ul>
			</xsl:if>
		</li>
	</xsl:template>
</xsl:stylesheet>
