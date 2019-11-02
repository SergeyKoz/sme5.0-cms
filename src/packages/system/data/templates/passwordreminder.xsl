<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" omit-xml-declaration="no" media-type="text/html"/>
	<!-- Project layout stylesheet -->
	<xsl:include href="layouts/default.xsl"/>
	<!--Banners display template -->
	<xsl:include href="controls/banners.xsl"/>
	<!--Content display template -->
	<xsl:include href="controls/content.xsl"/>
	<!--Debug display include -->
	<xsl:include href="blocks/debug.xsl"/>
	
	<xsl:include href="blocks/passwordremindercontrol.xsl"/>
	
	<xsl:template match="/">
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="content">
		<xsl:call-template name="passwordremindercontrol"/>
	</xsl:template>
</xsl:stylesheet>
