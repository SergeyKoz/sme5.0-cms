<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template match="edit">
		<xsl:if test="langversion/control and /page/content/subscribeselect/themes/checkbox">
			<form class="form" action="?" method="post" name="editform">
				<xsl:for-each select="hiddens">
					<xsl:apply-templates select="hidden"/>
				</xsl:for-each>
				<xsl:for-each select="langversion">
					
					<xsl:variable name="flast_name" select="control[*/name='last_name']"/>
					<xsl:variable name="ffirst_name" select="control[*/name='first_name']"/>
					<xsl:variable name="femail" select="control[*/name='email']"/>
					<xsl:variable name="forganization" select="control[*/name='organization']"/>
					<xsl:variable name="fpost" select="control[*/name='post']"/>
					
					<!-- email -->
					<xsl:choose>
						<xsl:when test="$femail/*/error_field">
							<span class="red">
								<xsl:value-of select="$femail/*/caption" disable-output-escaping="yes"/>&amp;nbsp;*
							</span>
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="$femail/*/caption" disable-output-escaping="yes"/>&amp;nbsp;*
						</xsl:otherwise>
					</xsl:choose><br/>
					<xsl:apply-templates select="$femail">
						<xsl:with-param name="class"></xsl:with-param>
					</xsl:apply-templates><br/>
						
					<!-- first name -->
					<xsl:value-of select="$ffirst_name/*/caption" disable-output-escaping="yes"/><br/>
					<xsl:apply-templates select="$ffirst_name">
						<xsl:with-param name="class">txt</xsl:with-param>
					</xsl:apply-templates><br/>						
						
					<!-- last name -->
					<xsl:value-of select="$flast_name/*/caption" disable-output-escaping="yes"/><br/>					
					<xsl:apply-templates select="$flast_name">
						<xsl:with-param name="class"></xsl:with-param>
					</xsl:apply-templates><br/>
						
					<!-- organization -->
					<xsl:value-of select="$forganization/*/caption" disable-output-escaping="yes"/><br/>
					<xsl:apply-templates select="$forganization">
						<xsl:with-param name="class"></xsl:with-param>
					</xsl:apply-templates><br/>
						
					<!-- position -->
					<xsl:value-of select="$fpost/*/caption" disable-output-escaping="yes"/><br/>
					<xsl:apply-templates select="control[5]">
						<xsl:with-param name="class"></xsl:with-param>
					</xsl:apply-templates><br/>
					
				</xsl:for-each>
				<!-- theme select -->
				<xsl:for-each select="/page/content/subscribeselect">
					<xsl:choose>
						<xsl:when test="/page/content/themes_error=1">
							<span class="red">
								<xsl:value-of select="/page/content/localization/_subscribe_theme_caption"/> *
							</span>
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="/page/content/localization/_subscribe_theme_caption"/> *
						</xsl:otherwise>
					</xsl:choose><br/>
					<br/>
					<table border="1">
						<xsl:if test="/page/@lng_url_prefix!=''">
							<tr>
								<td/>
								<xsl:for-each select="/page/languages/language">
									<td><xsl:value-of select="shortname"/></td>
								</xsl:for-each>
							</tr>
						</xsl:if>
						<xsl:for-each select="themes/checkbox">
							<xsl:variable name="pos" select="position()"/>
							<tr>
								<td>
									<xsl:apply-templates select="."/>
									<xsl:value-of select="./caption" disable-output-escaping="yes"/>
								</td>
								<xsl:choose>
									<xsl:when test="/page/@lng_url_prefix!=''">
									
										<xsl:for-each select="../languages[position()=$pos]/radio">
											<td>
												<xsl:apply-templates select="."/>
											</td>
										</xsl:for-each>
																		
									</xsl:when>
									<xsl:otherwise>
										<input type="hidden" name="lang[{./value}]" value="{/page/@language}"/>
									</xsl:otherwise>
								</xsl:choose>

								
							</tr>
						</xsl:for-each>	
					</table>			
				</xsl:for-each>
				
				<!--input type="hidden" name="theme[1]" value="1"/>
				<input type="hidden" name="radio[1]" value="{/page/@language}"/-->
				
				<!-- security_code -->
				<xsl:if test="/page/@user_id=''">
					<xsl:choose>
						<xsl:when test="/page/content/securecode_error=1">
							<span class="red">
								<xsl:value-of select="/page/content/localization/_security_code"/> *</span>
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="/page/content/localization/_security_code"/>
						</xsl:otherwise>
					</xsl:choose><br/>
					
					<img align="absmiddle" src="{/page/@url}scripts/securecode.php"/>
						
					<input class="txt" type="text" name="securecode" value=""/><br/>
				</xsl:if>
				*&amp;nbsp;
				<xsl:value-of select="/page/content/localization/_fields"/><br/>
				<!-- submit -->
				<input type="submit" value="{//_caption_button_submit_reg}"/>
				<input type="hidden" name="event" value="DoAddItem"/>
			</form>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
