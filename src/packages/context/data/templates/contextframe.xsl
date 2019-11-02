<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no" media-type="text/html"/>
	<xsl:template match="/">
		<script type="text/javascript">
			<xsl:choose>
				<xsl:when test="/page/content/mode='close'">
					window.top.closeframe();
				</xsl:when>
				<xsl:when test="/page/content/mode='refresh'">
					window.top.refreshpage(<xsl:if test="/page/content/messages/message">[<xsl:for-each select="/page/content/messages/message">'<xsl:value-of select="."/>'<xsl:if test="position()!=last()"> ,</xsl:if></xsl:for-each>]</xsl:if>);
				</xsl:when>
			</xsl:choose>
		</script>
	</xsl:template>
</xsl:stylesheet>
