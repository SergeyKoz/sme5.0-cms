<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template name="poll_block">
		<xsl:if test="/page/content/cms_polls/variants">
			<xsl:for-each select="/page/content/cms_polls">
				
					<xsl:choose>
						<xsl:when test="voted = 0">
							<form action="{/page/@url}{/page/@lng_url_prefix}polls/" target="_self" method="POST" name="poll">
								<input type="hidden" name="poll_var[poll]" value="{./id}"/>
								<input type="hidden" name="event" value="poll"/>
								<b>
									<xsl:value-of select="caption"/>
								</b>
								<br/>
								<table cellpadding="0" cellspacing="0" border="0" width="100%">
									<xsl:for-each select="variants">
										<tr>
											<td>
												<input type="radio" name="poll_var[var]" value="{id}" id="r{id}">
													<xsl:choose>
														<xsl:when test="selected">
															<xsl:attribute name="checked"/>
														</xsl:when>
														<xsl:otherwise>
															<xsl:if test="position()=1">
																<xsl:attribute name="checked"/>
															</xsl:if>
														</xsl:otherwise>
													</xsl:choose>
												</input>
												<label for="r{id}">
													<xsl:value-of select="caption"/>
												</label>
												<br/>
												<xsl:if test="your_variant=1">
													<input type="text" name="input[{id}]"/>
												</xsl:if>
											</td>
										</tr>										
									</xsl:for-each>
								</table>
								<input type="submit" value="{/page/content/localization/_answer_link}"/>
							</form>
						</xsl:when>

						<xsl:otherwise>
							<b>
								<xsl:value-of select="caption"/>
							</b>
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<xsl:for-each select="variants">
									<tr>
										<td>
											<xsl:value-of select="caption"/>
										</td>
									</tr>
									<tr>
										<td>
											<table cellspacing="0" cellpadding="0" border="0" width="100%">
												<tr>
													<td>
														<xsl:choose>
															<xsl:when test="max">
																<img src="{/page/@url}img/1x1r.gif" width="{number(votes)}" height="10"/>
															</xsl:when>
															<xsl:otherwise>
																<img src="{/page/@url}img/1x1g.gif" width="{number(votes)}" height="10"/>
															</xsl:otherwise>
														</xsl:choose>
													</td>
													<td>
														<xsl:value-of select="votes"/>%
													</td>
													<td width="100%"/>
												</tr>
											</table>
										</td>
									</tr>
								</xsl:for-each>
							</table>
						</xsl:otherwise>
					</xsl:choose>

			</xsl:for-each>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
