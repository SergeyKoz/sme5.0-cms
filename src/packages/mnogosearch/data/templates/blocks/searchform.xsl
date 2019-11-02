<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template match="search">
		<xsl:if test="control">
			<form action="?" method="get" name="editform">
				<input type="hidden" name="event" value="Search"/>
				<br/>
				<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr>
						<td valign="top" colspan="4">
							<fieldset>
								<legend>
									<xsl:choose>
										<xsl:when test="control[1]/*[1]/error_field">
											<font class="red">
												<xsl:value-of select="control[1]/*[1]/caption" disable-output-escaping="yes"/>
											</font>
										</xsl:when>
										<xsl:otherwise>
											<xsl:value-of select="control[1]/*[1]/caption" disable-output-escaping="yes"/>
										</xsl:otherwise>
									</xsl:choose>
								</legend>
									<xsl:if test="control[1]/*[1]/hint != ''">
															<xsl:value-of select="control[1]/*[1]/hint" disable-output-escaping="yes"/>
									</xsl:if>
                                    <xsl:apply-templates select="control[1]">
                                        <xsl:with-param name="disabled">
                                            <xsl:value-of select="/page/content/disabled_edit"/>
                                        </xsl:with-param>
                                    </xsl:apply-templates>
                                    <input type="submit" value="{/page/content/localization/_search_button}"/>
							</fieldset>
						</td>
					</tr>
					<tr>
						<td valign="top">
							<fieldset>
								<legend>
									<xsl:choose>
										<xsl:when test="control[2]/*[1]/error_field">
											<font class="red">
												<xsl:value-of select="control[2]/*[1]/caption" disable-output-escaping="yes"/>
											</font>
										</xsl:when>
										<xsl:otherwise>
											<xsl:value-of select="control[2]/*[1]/caption" disable-output-escaping="yes"/>
										</xsl:otherwise>
									</xsl:choose>
								</legend>
									<xsl:if test="control[2]/*[1]/hint != ''">
                                        <xsl:value-of select="control[2]/*[1]/hint" disable-output-escaping="yes"/>
									</xsl:if>
                                    <xsl:apply-templates select="control[2]">
                                        <xsl:with-param name="disabled">
                                            <xsl:value-of select="/page/content/disabled_edit"/>
                                        </xsl:with-param>
                                    </xsl:apply-templates>
							</fieldset>
						</td>
						<td valign="top">
							<fieldset>
								<legend>
									<xsl:choose>
										<xsl:when test="control[3]/*[1]/error_field">
											<font class="red">
												<xsl:value-of select="control[3]/*[1]/caption" disable-output-escaping="yes"/>
											</font>
										</xsl:when>
										<xsl:otherwise>
											<xsl:value-of select="control[3]/*[1]/caption" disable-output-escaping="yes"/>
										</xsl:otherwise>
									</xsl:choose>
								</legend>
									<xsl:if test="control[3]/*[1]/hint != ''">
                                        <xsl:value-of select="control[3]/*[1]/hint" disable-output-escaping="yes"/>
									</xsl:if>
                                    <xsl:apply-templates select="control[3]">
                                        <xsl:with-param name="disabled">
                                            <xsl:value-of select="/page/content/disabled_edit"/>
                                        </xsl:with-param>
                                    </xsl:apply-templates>
							</fieldset>
						</td>
						</tr>
					<tr>
						<td valign="top">
							<fieldset>
								<legend>
									<xsl:choose>
										<xsl:when test="control[4]/*[1]/error_field">
											<font class="red">
												<xsl:value-of select="control[4]/*[1]/caption" disable-output-escaping="yes"/>
											</font>
										</xsl:when>
										<xsl:otherwise>
											<xsl:value-of select="control[4]/*[1]/caption" disable-output-escaping="yes"/>
										</xsl:otherwise>
									</xsl:choose>
								</legend>
									<xsl:if test="control[4]/*[1]/hint != ''">
                                        <xsl:value-of select="control[4]/*[1]/hint" disable-output-escaping="yes"/>
									</xsl:if>
                                    <xsl:apply-templates select="control[4]">
                                        <xsl:with-param name="disabled">
                                            <xsl:value-of select="/page/content/disabled_edit"/>
                                        </xsl:with-param>
                                    </xsl:apply-templates>
							</fieldset>
						</td>
						<td valign="top">
							<fieldset>
								<legend>
									<xsl:choose>
										<xsl:when test="control[10]/*[1]/error_field">
											<font class="red">
												<xsl:value-of select="control[10]/*[1]/caption" disable-output-escaping="yes"/>
											</font>
										</xsl:when>
										<xsl:otherwise>
											<xsl:value-of select="control[10]/*[1]/caption" disable-output-escaping="yes"/>
										</xsl:otherwise>
									</xsl:choose>
								</legend>
									<xsl:if test="control[10]/*[1]/hint != ''">
                                        <xsl:value-of select="control[10]/*[1]/hint" disable-output-escaping="yes"/>
									</xsl:if>
                                    <xsl:apply-templates select="control[10]">
                                        <xsl:with-param name="disabled">
                                            <xsl:value-of select="/page/content/disabled_edit"/>
                                        </xsl:with-param>
                                    </xsl:apply-templates>
							</fieldset>
						</td>
					</tr>
				</table>
			</form>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
