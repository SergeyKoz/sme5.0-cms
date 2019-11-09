<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">


	<xsl:template name="tagscloudcontrol">
		<xsl:if test="/page/content/tags_cloud/tag">
			<xsl:for-each select="/page/content/tags_cloud/tag">
					<a class="tag{weightVal}" href="{/page/@url}{/page/@lng_url_prefix}tags/?tag={encodecaption}">
						<xsl:value-of select="caption"/>
					</a> &amp;nbsp;
			</xsl:for-each>
		</xsl:if>
	</xsl:template>
	
	<xsl:template name="tagscontrol">
		<xsl:if test="/page/content/tagslist/item">
			<xsl:for-each select="/page/content/tagslist/item">
				<a href="{/page/@url}{/page/@lng_url_prefix}{entry}"><xsl:value-of select="caption"/></a><br/>
				<xsl:if test="description">
					<xsl:value-of select="description"/><br/>
				</xsl:if>
				<xsl:variable name="id" select="item_id"/>
				
				<xsl:if test="/page/content/tagslist/tags[@item_id=$id]/tag">
					<xsl:value-of select="/page/content/localization/_tag_caption"/>:
					<xsl:for-each select="/page/content/tagslist/tags[@item_id=$id]/tag">
						<a href="{/page/@url}{/page/@lng_url_prefix}tags/?tag={tag_decode}"><xsl:value-of select="tag"/></a>
						<xsl:if test="position()!=last()">, </xsl:if>
					</xsl:for-each>
					<br/>
				</xsl:if>
				<br/>
			</xsl:for-each>
			<xsl:apply-templates select="/page/content/tagslist/navigator"/>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
