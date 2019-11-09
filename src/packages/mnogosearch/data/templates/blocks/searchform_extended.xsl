<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template match="search">
		<xsl:if test="control">
			<form action="?" method="get" name="editform">
				<input type="hidden" name="event" value="Search"/>
				<br/>
				<table cellpadding="0" cellspacing="0" border="0" width="100%">
					<tr>
						<td width="99%" style="padding-left:10px; padding-right:10px;" valign="top">
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
							<fieldset>
								<legend>
									<xsl:choose>
										<xsl:when test="control[5]/*[1]/error_field">
											<font class="red">
												<xsl:value-of select="control[5]/*[1]/caption" disable-output-escaping="yes"/>
											</font>
										</xsl:when>
										<xsl:otherwise>
											<xsl:value-of select="control[5]/*[1]/caption" disable-output-escaping="yes"/>
										</xsl:otherwise>
									</xsl:choose>
								</legend>
                                
                                <xsl:if test="control[5]/*[1]/hint != ''">
                                    <xsl:value-of select="control[5]/*[1]/hint" disable-output-escaping="yes"/>
                                </xsl:if>
                                
                                <xsl:apply-templates select="control[5]">
                                    <xsl:with-param name="disabled">
                                        <xsl:value-of select="/page/content/disabled_edit"/>
                                    </xsl:with-param>
                                </xsl:apply-templates>
							</fieldset>
							<fieldset>
								<legend>
									<xsl:choose>
										<xsl:when test="control[6]/*[1]/error_field">
											<font class="red">
												<xsl:value-of select="control[6]/*[1]/caption" disable-output-escaping="yes"/>
											</font>
										</xsl:when>
										<xsl:otherwise>
											<xsl:value-of select="control[6]/*[1]/caption" disable-output-escaping="yes"/>
										</xsl:otherwise>
									</xsl:choose>
								</legend>
                                
                                <xsl:if test="control[6]/*[1]/hint != ''">
                                    <xsl:value-of select="control[6]/*[1]/hint" disable-output-escaping="yes"/>
                                </xsl:if>
                                
                                <xsl:apply-templates select="control[6]">
                                    <xsl:with-param name="disabled">
                                        <xsl:value-of select="/page/content/disabled_edit"/>
                                    </xsl:with-param>
                                </xsl:apply-templates>
							</fieldset>
							<fieldset>
								<legend>
									<xsl:choose>
										<xsl:when test="control[7]/*[1]/error_field">
											<font class="red">
												<xsl:value-of select="control[7]/*[1]/caption" disable-output-escaping="yes"/>
											</font>
										</xsl:when>
										<xsl:otherwise>
											<xsl:value-of select="control[7]/*[1]/caption" disable-output-escaping="yes"/>
										</xsl:otherwise>
									</xsl:choose>
								</legend>
                                
                                <xsl:if test="control[7]/*[1]/hint != ''">
                                    <xsl:value-of select="control[7]/*[1]/hint" disable-output-escaping="yes"/>
                                </xsl:if>
                                
                                <xsl:if test="control[7]/checkboxgroup/checkbox">
                                    <xsl:for-each select="control[7]/checkboxgroup/checkbox">
                                        <input type="checkbox" name="{name}" value="{value}">
                                            <xsl:if test="checked = 'yes'">
                                                <xsl:attribute name="checked"> </xsl:attribute>
                                            </xsl:if>
                                        </input>
                                        <xsl:value-of select="caption"/>
                                        <br/>
                                    </xsl:for-each>
                                    <br/>
                                </xsl:if>
							</fieldset>
                            <fieldset>
                                <legend>
                                    <xsl:choose>
                                        <xsl:when test="control[8]/*[1]/error_field">
                                            <font class="red">
                                                <xsl:value-of select="control[8]/*[1]/caption" disable-output-escaping="yes"/>
                                            </font>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <xsl:value-of select="control[8]/*[1]/caption" disable-output-escaping="yes"/>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </legend>
                                    <xsl:if test="control[8]/*[1]/hint != ''">
                                                            <xsl:value-of select="control[8]/*[1]/hint" disable-output-escaping="yes"/>
                                    </xsl:if>
                                    <xsl:apply-templates select="control[8]">
                                        <xsl:with-param name="disabled">
                                            <xsl:value-of select="/page/content/disabled_edit"/>
                                        </xsl:with-param>
                                    </xsl:apply-templates>
                            </fieldset>
                            <fieldset>
                                <legend>
                                    <xsl:choose>
                                        <xsl:when test="control[9]/*[1]/error_field">
                                            <font class="red">
                                                <xsl:value-of select="control[9]/*[1]/caption" disable-output-escaping="yes"/>
                                            </font>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <xsl:value-of select="control[9]/*[1]/caption" disable-output-escaping="yes"/>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </legend>
                                    <xsl:if test="control[1]/*[1]/hint != ''">
                                        <xsl:value-of select="control[9]/*[1]/hint" disable-output-escaping="yes"/>
                                    </xsl:if>
                                    <xsl:apply-templates select="control[9]">
                                        <xsl:with-param name="disabled">
                                            <xsl:value-of select="/page/content/disabled_edit"/>
                                        </xsl:with-param>
                                    </xsl:apply-templates>
                            </fieldset>
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
                            <fieldset>
                                <xsl:if test="control[11]/*[1]/hint != ''">
                                    <xsl:value-of select="control[11]/*[1]/hint" disable-output-escaping="yes"/>
                                </xsl:if>
                                <xsl:apply-templates select="control[11]">
                                    <xsl:with-param name="disabled">
                                        <xsl:value-of select="/page/content/disabled_edit"/>
                                    </xsl:with-param>
                                </xsl:apply-templates>
                                <xsl:if test="name(control[11]/*[1])='checkbox'">
                                    <xsl:choose>
                                        <xsl:when test="control[12]/*[1]/error_field">
                                            <font class="red">
                                                <xsl:value-of select="control[11]/*[1]/caption"/>
                                            </font>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <xsl:value-of select="control[11]/*[1]/caption"/>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </xsl:if>
                            </fieldset>
                            <fieldset>
                                    <xsl:if test="control[12]/*[1]/hint != ''">
                                        <xsl:value-of select="control[12]/*[1]/hint" disable-output-escaping="yes"/>
                                    </xsl:if>
                                    <xsl:apply-templates select="control[12]">
                                        <xsl:with-param name="disabled">
                                            <xsl:value-of select="/page/content/disabled_edit"/>
                                        </xsl:with-param>
                                    </xsl:apply-templates>
                                    <xsl:if test="name(control[12]/*[1])='checkbox'">
                                        <xsl:choose>
                                            <xsl:when test="control[12]/*[1]/error_field">
                                                <font class="red">
                                                    <xsl:value-of select="control[12]/*[1]/caption"/>
                                                </font>
                                            </xsl:when>
                                            <xsl:otherwise>
                                                <xsl:value-of select="control[12]/*[1]/caption"/>
                                            </xsl:otherwise>
                                        </xsl:choose>
                                    </xsl:if>
                            </fieldset>
						</td>
					</tr>
				</table>
			</form>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
