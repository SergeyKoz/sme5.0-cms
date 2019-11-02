<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<!-- template for calendar control -->
	<xsl:template match="calendar">

		<table cellpadding="3" cellspacing="0" border="0" width="160">
			<tr bgcolor="#999999">
				<xsl:for-each select="localization/weekdays/day[position()!=last()]">
					<td align="center" class="white upper">
						<xsl:value-of select="."/>
					</td>
				</xsl:for-each>
			</tr>

			<xsl:for-each select="week">
				<tr>
					<xsl:for-each select="day">
						<xsl:if test="position()!=last()">
						
						<xsl:variable name="_href" select="@href"/>
						<xsl:variable name="_day" select="@day"/>
						<xsl:variable name="url_flag">
						<xsl:for-each select="/page/content/cms_publications/calendarblock/urls/url">
							<xsl:variable name="_url" select="."/><xsl:if test="contains($_href, $_url)">1</xsl:if></xsl:for-each>
						</xsl:variable>
						
						<td align="center">
							<!-- @today=1 if current day is today -->
							<xsl:if test="@today=1">
								<xsl:attribute name="bgcolor">#999999</xsl:attribute>
							</xsl:if>
							<xsl:choose>
								<!-- @selected=1 if current day is selected -->
								<xsl:when test="@selected=1">
									<xsl:choose>
										<xsl:when test="$url_flag!=''">
											<a href="{/page/@url}{/page/@language}/{@href}" class="event un_line">
												<xsl:value-of select="."/>
											</a>
										</xsl:when>
										<xsl:otherwise>
											<font class="white un_line">
												<xsl:value-of select="."/>
											</font>
										</xsl:otherwise>
									</xsl:choose>
									
								</xsl:when>
								<xsl:otherwise>
									<xsl:choose>
										<!-- @outside=1 if current day not in current (selected) month -->
										<xsl:when test="@outside=1">
											<xsl:value-of select="."/>
										</xsl:when>
										<xsl:otherwise>

											<!-- day of current (selected) month -->
											<xsl:choose>
												<xsl:when test="$url_flag!=''">
													<a href="{/page/@url}{/page/@language}/{@href}" class="event un_line">
														<xsl:value-of select="."/>
													</a>
												</xsl:when>
												<xsl:otherwise>
													<div class="gray"><xsl:value-of select="."/></div>
											</xsl:otherwise>
										</xsl:choose>
										</xsl:otherwise>
									</xsl:choose>
								</xsl:otherwise>
							</xsl:choose>
						</td>
						</xsl:if>
					</xsl:for-each>
				</tr>
			</xsl:for-each>
		</table>

	</xsl:template>
</xsl:stylesheet>
