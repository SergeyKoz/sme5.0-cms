<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template name="project_bottom_menu">
	
		<xsl:if test="/page/content/cms_menu/bottom_menu">
			<div rel="SME:&amp;#123;'mode':'menu', 'item_id':'bottom_menu'&amp;#125;">
				<xsl:if test="/page/content/cms_menu/bottom_menu/item">
					<ul>
						<xsl:for-each select="/page/content/cms_menu/bottom_menu/item">
							<xsl:apply-templates select="." mode="bottom"/>
						</xsl:for-each>
					</ul>
				</xsl:if>
			</div>
		</xsl:if>
	</xsl:template>
	<xsl:template match="item" mode="bottom">
		<li>
			<xsl:choose>
				<xsl:when test="not(selected=1)">
					<a href="{/page/@url}{/page/@lng_url_prefix}{url}/">
						<xsl:if test="external=1">
							<xsl:attribute name="href"><xsl:value-of select="url"/></xsl:attribute>
						</xsl:if>
						<xsl:if test="point_type='blank'">
							<xsl:attribute name="target">_blank</xsl:attribute>
						</xsl:if>
						<xsl:value-of select="title"/>
					</a>
				</xsl:when>
				<xsl:otherwise>
					<b>
						<a href="{/page/@url}{/page/@lng_url_prefix}{url}/">
							<xsl:if test="external=1">
								<xsl:attribute name="href"><xsl:value-of select="url"/></xsl:attribute>
							</xsl:if>
							<xsl:if test="point_type='blank'">
								<xsl:attribute name="target">_blank</xsl:attribute>
							</xsl:if>
							<xsl:value-of select="title"/>
						</a>
					</b>
				</xsl:otherwise>
			</xsl:choose>
		</li>
	</xsl:template>
</xsl:stylesheet>
