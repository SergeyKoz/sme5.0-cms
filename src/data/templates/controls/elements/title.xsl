<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template match="title">
		<xsl:choose>
			<xsl:when test="align = 'right'">
				<xsl:value-of select="separator" />
				<xsl:value-of select="caption" />
			</xsl:when>
			<xsl:otherwise>
				<xsl:value-of select="caption" />
				<xsl:value-of select="separator" />
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>

</xsl:stylesheet>