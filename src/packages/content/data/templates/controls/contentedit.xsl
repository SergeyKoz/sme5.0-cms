<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template match="edit">
		<xsl:if test="langversion/control">
			<form action="?" method="post" name="editform" onSubmit="setTabNumber()">
				<input type="hidden" name="tab_id" value="{//edit/tab_id}"/>
				<input type="hidden" name="PHPSESSID" value="{/page/@session_id}"/>
				<xsl:for-each select="hiddens">
					<xsl:apply-templates select="hidden"/>
				</xsl:for-each>
				<div class="silvergray">
					<div class="pageHeader" style="width:725px;">
                        <span class="mainHeader contentedit">
                            <xsl:if test="treepath/treepath/link">
                                <xsl:apply-templates select="treepath/treepath"/>
                            </xsl:if>
                            <xsl:if test="treepath/treepath/link and custom_caption/link">&amp;nbsp;>>&amp;nbsp;</xsl:if>
                            <xsl:if test="custom_caption/link">
                                <xsl:apply-templates select="custom_caption/link"/>
                            </xsl:if>
                            <xsl:if test="treepath/treepath/link or custom_caption/link">
                                <br/>
                            </xsl:if>
                            <span><xsl:value-of select="//_PageTitle"/></span>
                        </span>
                        <div class="clr"></div>
                        <div style="text-align:right; float:right;">
                        <xsl:if test="/page/content/disabled_button !='yes'">
                            <button type="submit" title="{//_caption_save}" onclick="return confirm('{//_caption_confirm_save}');">
                                <img src="{/page/@framework_url}packages/libraries/img/icn_savefile.gif" alt="LogOff" align="absmiddle" border="0" width="16" height="16"/> &amp;nbsp;<xsl:value-of select="//_caption_save"/>
                            </button>
                        </xsl:if>
                        <button type="submit" title="{//_caption_close}">
                            <xsl:attribute name="onclick">
                                <xsl:choose>
                                    <xsl:when test="/page/@contextframe=1">return (confirm('<xsl:value-of select="//_caption_confirm_close"/>') ? GoBack() : false)</xsl:when>
                                    <xsl:otherwise>return (confirm('<xsl:value-of select="//_caption_confirm_close"/>') ? window.close() : false)</xsl:otherwise>
                                </xsl:choose>
                            </xsl:attribute>

                            <img src="{/page/@framework_url}packages/libraries/img/ico_cancel.gif" alt="LogOff" align="absmiddle" border="0" width="19" height="16"/> &amp;nbsp;<xsl:value-of select="//_caption_close"/>
                        </button>
                        </div>
					</div>
				</div>
				<br/>
				<table cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="99%" style="padding-left:10px; padding-right:10px;" valign="top">
							<div class="tab-pane" id="tabPane1">
								<script type="text/javascript">
tp1 = new WebFXTabPane( document.getElementById( "tabPane1" ) );
</script>
								<xsl:for-each select="langversion">
									<xsl:if test="count(./control) &gt; 0">
										<div class="tab-page" id="tabPage{position()}">
											<h2 class="tab">
												<xsl:value-of select="longname" disable-output-escaping="yes"/>
											</h2>
											<script type="text/javascript">tp1.addTabPage( document.getElementById( "tabPage<xsl:value-of select="position()"/>" ) );</script>
											<xsl:for-each select="control">
													<legend>
														<xsl:if test="name(./*[1])!='checkbox'">
															<xsl:choose>
																<xsl:when test="./*[1]/error_field">
																	<font class="red">
																		<xsl:value-of select="./*[1]/caption" disable-output-escaping="yes"/>
																	</font>
																</xsl:when>
																<xsl:otherwise>
																	<xsl:value-of select="./*[1]/caption" disable-output-escaping="yes"/>
																</xsl:otherwise>
															</xsl:choose>
															<xsl:for-each select="./*">
																<xsl:call-template name="indicator"/>
															</xsl:for-each>
														</xsl:if>
													</legend>
                                                    <xsl:if test="./*[1]/hint != ''">
                                                        <xsl:value-of select="./*[1]/hint" disable-output-escaping="yes"/>
                                                    </xsl:if>
                                                    <xsl:apply-templates select=".">
                                                        <xsl:with-param name="disabled">
                                                            <xsl:value-of select="/page/content/disabled_edit"/>
                                                        </xsl:with-param>
                                                    </xsl:apply-templates>
                                                    <xsl:if test="name(./*[1])='checkbox'">
                                                        <xsl:choose>
                                                            <xsl:when test="./*[1]/error_field">
                                                                <font class="red">
                                                                    <xsl:value-of select="./*[1]/caption"/>
                                                                </font>
                                                            </xsl:when>
                                                            <xsl:otherwise>
                                                                <xsl:value-of select="./*[1]/caption"/>
                                                            </xsl:otherwise>
                                                        </xsl:choose>
                                                        <xsl:for-each select="./*">
                                                            <xsl:call-template name="indicator"/>
                                                        </xsl:for-each>
                                                    </xsl:if>
											</xsl:for-each>
										</div>
									</xsl:if>
								</xsl:for-each>
								<!--  Add information tab in end of tabs-->
								<xsl:if test="principal">
									<div class="tab-page" id="tabPage{count(langversion)+1}">
										<h2 class="tab">
											<xsl:value-of select="//localization/_InfoSectionLongName"/>
										</h2>
										<script type="text/javascript">tp1.addTabPage( document.getElementById( "tabPage<xsl:value-of select="count(langversion)+1"/>" ) );</script>
										<fieldset style="width:100%; padding:10px;">
											<table align="left" border="0" cellpadding="2" cellspacing="0" width="100%">
												<tr>
													<td nowrap="nowrap" valign="top" width="30%">
														<xsl:value-of select="//localization/_lastmodified"/>: </td>
													<td nowrap="yes" aling="left">
														<b>
															<xsl:value-of select="principal/_lastmodified"/>
														</b>
													</td>
												</tr>
												<tr>
													<td nowrap="yes">
														<xsl:value-of select="//localization/_createrid"/>:</td>
													<td aling="left">
														<b>
															<xsl:value-of select="principal/_creatername"/>
														</b>
													</td>
												</tr>
												<tr>
													<td nowrap="yes">
														<xsl:value-of select="//localization/_ownerid"/>:</td>
													<td aling="left">
														<b>
															<xsl:value-of select="principal/_ownername"/>
														</b>
													</td>
												</tr>
											</table>
										</fieldset>
									</div>
								</xsl:if>
								<!--^ Add information tab in end of tabs-->
							</div>
							<script type="text/javascript">
setupAllTabs();
tp1.setSelectedIndex( 1 );
tp1.setSelectedIndex( 0 );
<xsl:if test="//edit/tab_id!=''">
tp1.setSelectedIndex(<xsl:value-of select="//edit/tab_id"/>);
</xsl:if>
							</script>
						</td>
					</tr>
				</table>
				<div class="silverGray">
					<div class="pageHeader">
						<table cellpadding="0" cellspacing="0" border="0" width="97%">
							<tr>
								<td align="center" width="100%" valign="bottom">
									<!-- Save and Back buttons -->
										<table cellpadding="0" cellspacing="0" border="0" align="center">
											<tr>
												<xsl:if test="/page/content/disabled_button !='yes'">
													<td>&amp;nbsp;</td>
													<td>
														<button type="submit" title="{//_caption_save}" onClick="return confirm('{//_caption_confirm_save}');">
															<img src="{/page/@framework_url}packages/libraries/img/icn_savefile.gif" alt="LogOff" align="absmiddle" border="0" width="16" height="16"/> &amp;nbsp;<xsl:value-of select="//_caption_save"/>
														</button>
													</td>
												</xsl:if>
												<td>
													<button type="submit" title="{//_caption_close}" onClick="return (confirm('{//_caption_confirm_close}') ? window.close() : false)">
														<xsl:attribute name="onclick">
															<xsl:choose>
																<xsl:when test="/page/@contextframe=1">return (confirm('<xsl:value-of select="//_caption_confirm_close"/>') ? GoBack() : false)</xsl:when>
																<xsl:otherwise>return (confirm('<xsl:value-of select="//_caption_confirm_close"/>') ? window.close() : false)</xsl:otherwise>
															</xsl:choose>
														</xsl:attribute>

														<img src="{/page/@framework_url}packages/libraries/img/ico_cancel.gif" alt="LogOff" align="absmiddle" border="0" width="19" height="16"/> &amp;nbsp;<xsl:value-of select="//_caption_cancel"/>
													</button>
												</td>
												
											</tr>
										</table>
									<!--^ Save and Back buttons -->
								</td>
								<td width="5%">
        </td>
							</tr>
						</table>
					</div>
				</div>
			</form>
			<script type="text/javascript">
//<![CDATA[

setupAllTabs();

//]]></script>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
