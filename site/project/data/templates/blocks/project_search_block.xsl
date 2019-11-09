<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template name="search_block">
		<form class="srch" action="{/page/@url}{/page/@lng_url_prefix}search/" target="_self" method="get" name="search">
			<!--xsl:value-of select="//localization/_caption_site_search"/-->
			<input class="txt" type="text" name="q"/>
			<input type="hidden" name="event" value="Search"/>
			<input class="btn" type="submit" value="{/page/content/localization/_caption_search}"/>
		</form>
	</xsl:template>
</xsl:stylesheet>
