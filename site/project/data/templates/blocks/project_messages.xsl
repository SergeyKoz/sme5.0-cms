<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="UTF-8" omit-xml-declaration="yes" media-type="text/html"/>
	<xsl:template name="project_messages">
		<xsl:if test="/page/content/error-messages or /page/content/warning-messages">
			<table class="error_message" cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr>
					<td valign="top">
						<img src="{/page/@url}img/ico_error.png"/>
					</td>
					<td width="99%" valign="center">
						<xsl:for-each select="/page/content/error-messages/message">
							<!--<xsl:value-of select="@section"/>: -->
							<p>
								<b>
									<xsl:value-of select="."/>
								</b>
							</p>
						</xsl:for-each>
						<xsl:for-each select="/page/content/warning-messages/message">
							<!--<xsl:value-of select="@section"/>: -->
							<p>
								<b>
									<xsl:value-of select="."/>
								</b>
							</p>
						</xsl:for-each>
					</td>
				</tr>
			</table>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
