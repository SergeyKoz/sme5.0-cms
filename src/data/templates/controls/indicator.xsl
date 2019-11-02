<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template name="indicator">
		<xsl:if test="error_field or notnull">
			<font>
				<xsl:choose>
					<xsl:when test="error_field">
						<xsl:attribute name="color">red</xsl:attribute>
					</xsl:when>
					<xsl:otherwise>
						<xsl:attribute name="color">gray</xsl:attribute>
					</xsl:otherwise>
				</xsl:choose>
				&amp;nbsp;*
			</font>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
