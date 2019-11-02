<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no" indent="yes" media-type="text/html"/>
	<xsl:include href="layouts/default.xsl"/>
	<xsl:include href="blocks/debug.xsl"/>
	<xsl:include href="blocks/errors.xsl"/>
	<!--Banners display template -->
	<xsl:include href="controls/banners.xsl"/>
	<!-- Include controls -->
	<xsl:include href="controls/indicator.xsl"/>
	<xsl:include href="controls/text.xsl"/>
	<xsl:include href="controls/hidden.xsl"/>
	<xsl:include href="controls/checkbox.xsl"/>
	<xsl:include href="controls/radio.xsl"/>
	<!-- подключение формы -->
	<xsl:include href="blocks/subscribeuserform.xsl"/>
	<xsl:template match="/">
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="content">
		<xsl:if test="edit">
			<xsl:apply-templates select="edit"/>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
