<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template match="list">
		<xsl:if test="found">
			<table cellpadding="0" cellspacing="0" border="1" width="100%">
				<tbody>
					<tr>
						<td><xsl:value-of select="/page/content/localization/_list_search"/>&amp;nbsp;<b>
								<xsl:value-of select="/page/content/search/control/text[name='q']/value"/>
							</b>&amp;nbsp;
					<xsl:value-of select="/page/content/localization/_list_res_search"/>
&amp;nbsp;<b>
								<xsl:value-of select="wordinfo"/>
							</b>&amp;nbsp;
					<xsl:value-of select="/page/content/localization/_list_out"/>&amp;nbsp;<b>
								<xsl:value-of select="first_doc"/>
							</b>-<b>
								<xsl:value-of select="last_doc"/>
							</b>&amp;nbsp;
					<xsl:value-of select="/page/content/localization/_list_from"/>&amp;nbsp;<b>
								<xsl:value-of select="found"/>
							</b>&amp;nbsp;
					<xsl:value-of select="/page/content/localization/_list_time"/><b>
								<xsl:value-of select="searchtime"/>
							</b>&amp;nbsp;<xsl:value-of select="/page/content/localization/_list_sec"/>
					</td>
					</tr>
					<tr>
						<td>
							<xsl:apply-templates select="/page/content/search/navigator"/>
						</td>
					</tr>
					<xsl:if test="found!=0">
						<xsl:for-each select="item">
							<tr>
								<td>
									<xsl:choose>
										<xsl:when test="/page/content/search/list/o=1">
											<xsl:value-of select="@ndoc"/>.&amp;nbsp;
										<a href="{url}" target="_blank">
												<xsl:value-of select="title" disable-output-escaping="yes"/>
											</a>
										&amp;nbsp;[<xsl:value-of select="@rating"/>]
										<br/>
											<br/>
										</xsl:when>
										<xsl:when test="/page/content/search/list/o=2">
											<xsl:value-of select="@ndoc"/>.&amp;nbsp;
										<a href="{url}" target="_blank">
												<xsl:value-of select="url" disable-output-escaping="yes"/>
											</a>
										&amp;nbsp;[<xsl:value-of select="@rating"/>]
										<br/>
											<br/>
										</xsl:when>
										<xsl:otherwise>
											<xsl:value-of select="@ndoc"/>.&amp;nbsp;
										<a href="{url}" target="_blank">
												<xsl:value-of select="title" disable-output-escaping="yes"/>
											</a>
										&amp;nbsp;[<xsl:value-of select="@rating"/>
										,&amp;nbsp;<xsl:value-of select="/page/content/localization/_list_popylarity"/>
										<xsl:value-of select="@pop_rank"/>]
										<br/>
											<xsl:value-of select="text" disable-output-escaping="yes"/>
											<UL type="disk">
												<li>
													<a href="{url}" target="_blank">
														<xsl:value-of select="url" disable-output-escaping="yes"/>
													</a>&amp;nbsp;(<b>
														<xsl:value-of select="contype"/>
													</b>)&amp;nbsp;<xsl:value-of select="lastmod"/>,&amp;nbsp;<b>
														<xsl:value-of select="@docsize"/>
													</b>&amp;nbsp;<xsl:value-of select="/page/content/localization/_list_bytes"/></li>
											</UL>
											<br/>
										</xsl:otherwise>
									</xsl:choose>
								</td>
							</tr>
						</xsl:for-each>
					</xsl:if>
					<tr>
						<td/>
					</tr>
				</tbody>
			</table>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
