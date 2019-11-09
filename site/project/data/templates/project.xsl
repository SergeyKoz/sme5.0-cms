<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="no" media-type="text/html"/>
	<!-- Project layout stylesheet -->
	<xsl:include href="layouts/default.xsl"/>	
	
	<!--Debug display include -->
	<xsl:include href="blocks/debug.xsl"/>
	
	<xsl:template match="/">
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="content">

		<xsl:if test="/page/content/cms_publications/mapping">
			<xsl:if test="/page/content/cms_publications/mapping[@system_name = 'news_list' or @system_name = 'news']/publication">
				<xsl:call-template name="news_mapping"/>
			</xsl:if>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
