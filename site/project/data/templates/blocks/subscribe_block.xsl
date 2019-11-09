<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template name="subscribe_block">
		<b>
			<xsl:value-of select="//localization/_subscribe_title_block"/>
		</b>
		<form action="{/page/@url}{/page/@lng_url_prefix}news_and_events/subscribe/" target="_self" method="post">
			<xsl:value-of select="/page/content/localization/_subscribe_input_title_block"/>
			<input class="" type="text" name="email"/>
			<input class="btn" type="submit" value="{/page/content/localization/_subscribe_submit_title_block}"/>
		</form>
	</xsl:template>
</xsl:stylesheet>
