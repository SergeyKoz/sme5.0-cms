<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template name="project_languages">
	<ul class="lng">
		<xsl:for-each select="/page/languages/language">
			<xsl:choose>
				<xsl:when test="/page/@language=prefix">
						<li class="act"><span><xsl:value-of select="shortname"/></span></li>
				</xsl:when>
				<xsl:otherwise>
					<xsl:variable name="language_url">
						<xsl:value-of select="/page/@url"/>
						<xsl:value-of select="prefix"/>/<xsl:value-of select="substring-before(/page/@request_uri, /page/@lng_url_prefix)"/>
						<xsl:value-of select="substring-after(/page/@request_uri,/page/@lng_url_prefix)"/>
					</xsl:variable>
					<li><a href="{$language_url}">
						<xsl:value-of select="shortname"/>
					</a></li>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:for-each>
		</ul>
	</xsl:template>
</xsl:stylesheet>
