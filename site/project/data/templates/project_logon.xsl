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
	<xsl:template match="/">
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="content">
		<form class="form logon" action="?" method="post">
			<input type="hidden" name="event" value="Process"/>
			<input type="hidden" name="camefrom" value="{camefrom}"/>
			<input type="hidden" name="query" value="{query}"/>
			<div>
				<label for="form-logon-f1"><xsl:value-of select="/page/content/localization/fieldname_login"/>:*</label>
				<input id="form-logon-f1" class="txt" type="text" name="login" value="" maxlength="100"/>
			</div>
			<div>
				<label for="form-logon-f2"><xsl:value-of select="/page/content/localization/fieldname_password"/>:*</label>
				<input id="form-logon-f2" class="txt" type="password" name="password"/>
			</div>
			<div class="btn"><input class="btn" type="submit" value="{/page/content/localization/_caption_logon}"/></div>
		</form>
	</xsl:template>
</xsl:stylesheet>
