<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template name="poll_block_page">
		<xsl:for-each select="/page/content/poll_page[variants]">
			<xsl:choose>
				<!-- if user not voted on this vote-->
				<xsl:when test="voted = 0">
					<form action="{/page/@url}{/page/@lng_url_prefix}polls/" target="_self" method="POST" name="poll_page">
						<input type="hidden" name="event" value="poll"/>
						<input type="hidden" name="poll_var[poll]" value="{./id}"/>
						<b>
							<xsl:value-of select="caption"/>
						</b>
						<br/>
						<table cellpadding="0" cellspacing="0" border="0" width="100%">
							<xsl:for-each select="variants">
								<tr>
									<td valign="top">
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
									</td>
								</tr>
								<xsl:if test="your_variant=1">
									<tr>
										<td>
											<input type="text" name="input[{id}]"/>
										</td>
									</tr>
								</xsl:if>
							</xsl:for-each>
						</table>
						<div align="right">
							<input type="submit" value="{//localization/_answer_link}"/>
						</div>
					</form>
				</xsl:when>
				
				<xsl:otherwise>
					<b>
						<xsl:value-of select="caption"/>
					</b>
					<br/>
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
		
		
		
		<xsl:apply-templates select="/page/content/poll_page/navigator"/>
		<br/>
		<xsl:for-each select="/page/content/poll_page/polls_list/item">
			<a href="{/page/@url}{/page/@lng_url_prefix}polls/?poll_id={poll_id}">
				<xsl:value-of select="caption"/>
			</a>
			<br/>
			<xsl:if test="description!=''">
				<xsl:value-of select="description" disable-output-escaping="yes"/>
				<br/>
			</xsl:if>
			<br/>
		</xsl:for-each>
	</xsl:template>
</xsl:stylesheet>
