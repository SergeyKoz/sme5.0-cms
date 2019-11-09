<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="no" media-type="text/html"/>
	<xsl:template match="filterform">
		<xsl:if test="control and (((../handler/last_level !='yes') or not (../handler/last_level)) and (../handler/disable_lastlevel_list='no'))">
			<BR/>
			<table border="0" width="50%" align="center" class="sort-table">
				<form name="listform_{../handler/library}_filter" method="GET" action="?">
					<input type="hidden" name="PHPSESSID" value="{/page/@session_id}"/>
					<xsl:for-each select="hiddens/hidden">
						<xsl:apply-templates select="."/>
					</xsl:for-each>
					<xsl:for-each select="control">
						<xsl:choose>
							<!-- Range control -->
							<xsl:when test="range">
								<tr>
									<td>
										<xsl:value-of select="range/caption"/>
									</td>
									<td>
										<xsl:value-of select="control[1]/text/caption"/>
										<xsl:apply-templates select="control[1]"/>&amp;nbsp<xsl:value-of select="control[2]/text/caption"/>&amp;nbsp<xsl:apply-templates select="control[2]"/>
										<BR/>
										<font size="-5">
											<xsl:value-of select="range/hint"/>
										</font>
									</td>
								</tr>
							</xsl:when>
							<!--/ Range control -->
							<!-- Other control -->
							<xsl:otherwise>
								<tr>
									<td>
										<xsl:value-of select="./*[1]/caption"/>
									</td>
									<td>
										<xsl:apply-templates select="."/>
									</td>
								</tr>
							</xsl:otherwise>
							<!--/ Other control -->
						</xsl:choose>
					</xsl:for-each>
					<tr>
						<td colspan="2" align="center">
							<input type="submit" value="{//localization/_caption_filter}"/>
						</td>
					</tr>
				</form>
			</table>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
