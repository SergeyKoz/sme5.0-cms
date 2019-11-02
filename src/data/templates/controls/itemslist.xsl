<?xml version="1.0" encoding="windows-1251"?>
<!-- edited with XMLSPY v5 rel. 4 U (http://www.xmlspy.com) by user (company) -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template match="list">
		<!-- Show filter form -->
		<xsl:apply-templates select="filterform"/>
		<!-- /Show filter form -->
		<xsl:choose>
			<xsl:when test="((handler/last_level !='yes') or not (handler/last_level)) and (handler/disable_lastlevel_list='no')">
				<xsl:if test=". !=''">
					<form name="listform_{handler/library}" method="POST" action="?{handler/append_hrefs}">
						<input type="hidden" name="PHPSESSID" value="{/page/@session_id}"/>
						<!-- page header -->
						<div class="pageheader">
							<span class="blue_tit">
								<xsl:value-of select="_PageTitle"/>
							</span>
							<xsl:if test="treepath/treepath/link">
								<div class="clr"/>
								<xsl:apply-templates select="treepath/treepath"/>
							</xsl:if>
							<!--xsl:if test="treepath/treepath/link and custom_caption/link">
								<span>&amp;nbsp;>>&amp;nbsp;</span>
							</xsl:if-->
							<xsl:if test="custom_caption/link">
								<div class="clr"/>
								<span>
									<xsl:apply-templates select="custom_caption/link"/>
								</span>
							</xsl:if>
						</div>
						<div class="clr"/>
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<xsl:if test="levelup_link">
								<tr>
									<td>
										<table class="linkup">
											<tr>
												<td>
													<img src="{/page/@framework_url}packages/libraries/img/ico_levelup.gif" width="14" height="13"/>
													<xsl:apply-templates select="levelup_link">
														<xsl:with-param name="class">linkup</xsl:with-param>
													</xsl:apply-templates>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</xsl:if>
							<tr>
								<td valign="top">
									<xsl:choose>
										<xsl:when test="row">
											<xsl:for-each select="hiddens">
												<xsl:apply-templates select="."/>
											</xsl:for-each>
											<xsl:if test="navigator/bar/element">
												<xsl:apply-templates select="navigator">
													<xsl:with-param name="class">under</xsl:with-param>
												</xsl:apply-templates>
											</xsl:if>
											<table border="0" id="tbl_{handler/library}" class="sort-table" cellspacing="0">
												<thead>
													<tr id="tbl_{handler/library}_header" style="position:static;">
														<xsl:if test="handler/node_move='yes'">
															<td>
																<input type="checkbox" name="check_all_{handler/library}" onclick="doSelectAll(document.listform_{handler/library}, 'check_all_{handler/library}', 'item[]')"/>
															</td>
														</xsl:if>
														<xsl:for-each select="headers/header">
															<td>
																<!--xsl:if test="position()=1">
																	<xsl:attribute name="class">check-column</xsl:attribute>
																</xsl:if-->
																<xsl:if test="./@type='checkbox'">
																	<xsl:text disable-output-escaping="yes"><![CDATA[
                                                                       <table cellspacing="0" cellpadding="0" border="0" style="padding:0px;border:none;">
                                                                       <tr><td style="padding:0px;border:none;" valign="center">
                                                                       ]]></xsl:text>
																	<input type="checkbox" name="_{./@name}" onclick="doSelectAll(document.listform_{../../handler/library}, '_{./@name}', '{./@name}[]')"/>
																	<xsl:text disable-output-escaping="yes"><![CDATA[
                                                                       </td><td style="padding:0px;border:none;" class="nowrap">
                                                                       ]]></xsl:text>
																</xsl:if>
																<xsl:choose>
																	<xsl:when test="./@selected=1">
																		<!--xsl:attribute name="class">nowrap</xsl:attribute-->
																		<xsl:choose>
																			<xsl:when test="./@direction=0">
																				<xsl:apply-templates select=".">
																					<xsl:with-param name="class">under</xsl:with-param>
																				</xsl:apply-templates>
																				<img src="{/page/@framework_url}packages/libraries/img/downsimple.png" width="8" height="7" alt=""/>
																			</xsl:when>
																			<xsl:otherwise>
																				<xsl:apply-templates select=".">
																					<xsl:with-param name="class">under</xsl:with-param>
																				</xsl:apply-templates>
																				<img src="{/page/@framework_url}packages/libraries/img/upsimple.png" width="8" height="7" alt=""/>
																			</xsl:otherwise>
																		</xsl:choose>
																	</xsl:when>
																	<xsl:otherwise>
																		<xsl:apply-templates select=".">
																			<xsl:with-param name="class"/>
																		</xsl:apply-templates>
																	</xsl:otherwise>
																</xsl:choose>
																<xsl:if test="./@type='checkbox'">
																	<xsl:text disable-output-escaping="yes"><![CDATA[
                           </td></tr></table>
                           ]]></xsl:text>
																</xsl:if>
																<!--/nobr-->
															</td>
														</xsl:for-each>
														<xsl:call-template name="list_action_custom"/>
														<xsl:call-template name="list_action"/>
													</tr>
												</thead>
												<xsl:for-each select="row">
													<tr id="n[]">
														<xsl:if test="../handler/node_move='yes'">
															<td nowrap="yes" class="sfd">
																<input type="checkbox" name="item[]" value="{./@id}"/>
															</td>
														</xsl:if>
														<input type="hidden" name="items[]" value="{./@id}"/>
														<xsl:for-each select="control">
															<td>
																<!--xsl:if test="position()=1">
																	<xsl:attribute name="class">check-column</xsl:attribute>
																</xsl:if-->
																<xsl:if test="./@align != ''">
																	<xsl:attribute name="align"><xsl:value-of select="./@align"/></xsl:attribute>
																</xsl:if>
																<xsl:apply-templates select=".">
																	<xsl:with-param name="class">under</xsl:with-param>
																</xsl:apply-templates>
															</td>
														</xsl:for-each>
														<xsl:call-template name="item_action_custom"/>
														<xsl:call-template name="item_action"/>
													</tr>
												</xsl:for-each>
											</table>
											<!--script>
											  AddScroll("tbl_<xsl:value-of select="handler/library"/>", "tbl_<xsl:value-of select="handler/library"/>_header");
											</script-->
											<xsl:if test="navigator/bar/element">
												<xsl:apply-templates select="navigator">
													<xsl:with-param name="class">under</xsl:with-param>
												</xsl:apply-templates>
											</xsl:if>
										</xsl:when>
										<xsl:otherwise>
											<xsl:for-each select="hiddens">
												<xsl:apply-templates select="."/>
											</xsl:for-each>
											<xsl:value-of select="//_caption_empty_list"/>
										</xsl:otherwise>
									</xsl:choose>
									<div class="silvergray">
										<div class="fl">
											<xsl:if test="handler/disabled_add ='no'">
												<button class="" type="submit" value="{//_caption_add}" onClick="window.location.href='?page={handler/page}&amp;event=AddItem&amp;library={handler/library}&amp;{handler/library}_start={navigator/start}&amp;{handler/library}_order_by={navigator/bar/element[1]/order_by}&amp;restore={handler/restore}&amp;{handler/library}_parent_id={handler/parent_id}&amp;custom_var={handler/custom_var}&amp;custom_val={handler/custom_val}&amp;host_library_ID={handler/host_library_ID}'; return false;" title="{//_title_add}">
													<img src="{/page/@framework_url}packages/libraries/img/ico_add_item.gif" alt="LogOff" align="absmiddle" border="0" width="16" height="16"/>&amp;nbsp;
                                                <xsl:value-of select="//_caption_add"/>
												</button>
											</xsl:if>
										</div>
										<xsl:if test="count(destinationtreeselect/select/options/option) &gt; 1">
											<div class="fl">
												<xsl:apply-templates select="destinationtreeselect">
													<xsl:with-param name="class">select_dest</xsl:with-param>
												</xsl:apply-templates>
											</div>
											<div class="fl">
												<button class="" type="submit" value="{//_caption_jump}" onClick="document.listform_{handler/library}.event.value='Jump';" title="{//_title_jump}">
													<img src="{/page/@framework_url}packages/libraries/img/ico_goto.gif" alt="{//_title_jump}" align="absmiddle" border="0" width="16" height="16"/>
												</button>
												<xsl:if test="handler/node_move='yes' and row">
													<button class="" type="submit" value="{//_caption_move}" onClick="if(confirm('{//_caption_confirm_move}'))document.listform_{handler/library}.event.value='Move';else return false;" title="{//_title_move}">
														<img src="{/page/@framework_url}packages/libraries/img/ico_move.gif" alt="{//_caption_move}" align="absmiddle" border="0" width="16" height="16"/>
													</button>
												</xsl:if>
											</div>
										</xsl:if>
										<xsl:if test="row">
											<div class="fr">
												<xsl:if test="handler/mega_delete = 'yes' and handler/disabled_delete='no'">
													<button class="" type="submit" value="{//_caption_delete_all}" onClick="if(confirm('{//_caption_confirm_delete_all}'))document.listform_{handler/library}.event.value='MegaDelete';else return false;" title="{//_title_delete_all}">
														<img src="{/page/@framework_url}packages/libraries/img/ico_delete.gif" alt="LogOff" align="absmiddle" border="0" width="16" height="16"/> &amp;nbsp;<xsl:value-of select="//_caption_delete_all"/>
													</button>
												</xsl:if>
												<xsl:if test="handler/disabled_apply='no'">
													<button class="" type="submit" value="{//_caption_apply}" onClick="return confirm('{//_caption_confirm_apply}');" title="{//_title_apply}">
														<img src="{/page/@framework_url}packages/libraries/img/ico_apply.gif" alt="" align="absmiddle" border="0" width="16" height="16"/> &amp;nbsp;<xsl:value-of select="//_caption_apply"/>
													</button>
												</xsl:if>
											</div>
										</xsl:if>
										<xsl:if test="hiddens/hidden[name='contextframe']/value=1">
											<div class="fr">
												<button class="" type="submit" value="{//_caption_cancel}" onClick="if(confirm('{//_caption_confirm_cancel}'))document.listform_{handler/library}.event.value='GoBack';else return false;" title="{//_caption_cancel}">
													<img src="{/page/@framework_url}packages/libraries/img/ico_cancel.gif" alt="" align="absmiddle" border="0" width="16" height="16"/> &amp;nbsp;<xsl:value-of select="//_caption_cancel"/>
												</button>
											</div>
										</xsl:if>
									</div>
								</td>
							</tr>
						</table>
					</form>
				</xsl:if>
			</xsl:when>
			<xsl:otherwise>
				<xsl:if test="levelup_link">
					<table class="linkup">
						<tr>
							<td style="padding:10px;">
								<img src="{/page/@framework_url}packages/libraries/img/ico_levelup.gif" width="14" height="13"/>
								<xsl:apply-templates select="levelup_link">
									<xsl:with-param name="class">linkup</xsl:with-param>
								</xsl:apply-templates>
							</td>
						</tr>
					</table>
				</xsl:if>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
</xsl:stylesheet>
