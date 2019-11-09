<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="no" media-type="text/html"/>
	<!-- Project layout stylesheet -->
	<xsl:include href="layouts/default.xsl"/>
	<!--Banners display template -->
	<xsl:include href="controls/banners.xsl"/>
	<!--Content display template -->
	<xsl:include href="controls/content.xsl"/>
	<!--Debug display include -->
	<xsl:include href="blocks/debug.xsl"/>
	
	<xsl:include href="blocks/calendareventscontrol.xsl"/>

	<xsl:template match="/">
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="content">
		<xsl:if test="/page/content/events_filter">
			<xsl:call-template name="events_filter"/>
		</xsl:if>
		
		<xsl:if test="/page/content/events_list">
			<xsl:call-template name="events_list"/>
		</xsl:if>
		
		<xsl:if test="/page/content/event_detail">
			<xsl:call-template name="event_detail"/>
		</xsl:if>
		
		<xsl:if test="/page/content/events_default">
			<xsl:call-template name="events_default"/>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
