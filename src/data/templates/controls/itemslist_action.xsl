<?xml version="1.0" encoding="windows-1251"?>
<!-- edited with XMLSPY v5 rel. 4 U (http://www.xmlspy.com) by user (company) -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template name="list_action">
		<xsl:if test="(handler/disabled_view='no' and handler/disabled_edit='yes') or (handler/disabled_edit='no')">
			<td width="50">
				<img src="{/page/@framework_url}packages/libraries/img/ico_edit.gif" alt="{//_caption_edit}" border="0"/>
			</td>
		</xsl:if>
		<!--Move up or down arrow-->
		<xsl:if test="handler/disabled_move='no'">
			<td valign="middle" nowrap="yes" align="center">
				<xsl:choose>
					<xsl:when test="handler/order_by/field!=handler/move_field">
						<a href="{headers/header[1]/link/href}&amp;{handler/library}_order_by={handler/move_field}">
							<img src="{/page/@framework_url}packages/libraries/img/ico_arrows.gif" border="0" alt="{//_caption_priority}"/>
						</a>
					</xsl:when>
					<xsl:otherwise>
						<xsl:choose>
							<xsl:when test="handler/order_by/direction!='DESC'">
								<a href="{headers/header[1]/link/href}&amp;{handler/library}_order_by={handler/move_field}:DESC">
									<img src="{/page/@framework_url}packages/libraries/img/ico_arrows.gif" border="0" alt="{//_caption_priority}"/>
								</a>                        
                        &amp;nbsp;<img src="{/page/@framework_url}packages/libraries/img/downsimple.png" width="8" height="7"/>
							</xsl:when>
							<xsl:otherwise>
								<a href="{headers/header[1]/link/href}&amp;{handler/library}_order_by={handler/move_field}">
									<img src="{/page/@framework_url}packages/libraries/img/ico_arrows.gif" border="0" alt="{//_caption_priority}"/>
								</a>                        
                        &amp;nbsp;<img src="{/page/@framework_url}packages/libraries/img/upsimple.png" width="8" height="7"/>
							</xsl:otherwise>
						</xsl:choose>
					</xsl:otherwise>
				</xsl:choose>
                   &amp;nbsp;
                   </td>
		</xsl:if>
		<!--^ Move up or down arrow-->
		<!-- Copy link and checkbox -->
		<xsl:if test="handler/disabled_copy='no'">
			<td>
				<nobr>
					<input type="checkbox" name="copy_all" onclick="doSelectAll(document.listform_{handler/library}, 'copy_all', 'copy_item[]')">
						<xsl:if test="handler/disabled_copy ='yes'">
							<xsl:attribute name="disabled"> </xsl:attribute>
						</xsl:if>
					</input>
					<img src="{/page/@framework_url}packages/libraries/img/ico_copy.gif" alt="{//_caption_copy}"/>
				</nobr>
			</td>
		</xsl:if>
		<!--^ Copy link and checkbox -->
		<!-- Delete link and checkbox -->
		<xsl:if test="handler/disabled_delete='no'">
			<td>
				<nobr>
					<input type="checkbox" name="delete_all" onclick="doSelectAll(document.listform_{handler/library}, 'delete_all', 'delete_item[]')">
						<xsl:if test="handler/disabled_delete ='yes'">
							<xsl:attribute name="disabled"> </xsl:attribute>
						</xsl:if>
					</input>
					<img src="{/page/@framework_url}packages/libraries/img/icn_delete.gif" alt="{//_caption_delete}" border="0"/>
				</nobr>
			</td>
		</xsl:if>
		<!--^ Delete link and checkbox -->
	</xsl:template>
	<xsl:template name="item_action">
		<xsl:variable name="package">
			<xsl:if test="../handler/package!=''">package=<xsl:value-of select="../handler/package"/>&amp;</xsl:if>
		</xsl:variable>
		<xsl:if test="(../handler/disabled_view='no' and ../handler/disabled_edit='yes') or (../handler/disabled_edit='no')">
			<td style="text-align:center">
				<a href="?{$package}page={../handler/page}&amp;event=EditItem&amp;item_id={./@id}&amp;start={../navigator/start}&amp;order_by={../navigator/bar/element[1]/order_by}&amp;library={../handler/library}&amp;restore={../handler/restore}&amp;{../handler/library}_parent_id={../handler/parent_id}&amp;custom_var={../handler/custom_var}&amp;custom_val={../handler/custom_val}&amp;host_library_ID={../handler/host_library_ID}" class="under">
					<xsl:choose>
						<xsl:when test="../handler/disabled_edit = 'no'">
							<img src="{/page/@framework_url}packages/libraries/img/ico_edit.gif" width="16" height="16" border="0" alt="{//_caption_edit}"/>
						</xsl:when>
						<xsl:otherwise>
							<img src="{/page/@framework_url}packages/libraries/img/ico_view.gif" width="16" height="16" border="0" alt="{//_caption_view}"/>
						</xsl:otherwise>
					</xsl:choose>
				</a>
			</td>
		</xsl:if>
		<!-- Move link -->
		<xsl:if test="../handler/disabled_move='no'">
			<td style="text-align:center">
				<xsl:choose>
					<xsl:when test="../handler/order_by/field=../handler/move_field">
						<a href="{../headers/header[1]/link/href}&amp;page={../handler/page}&amp;move_library={../handler/library}&amp;{../handler/library}_order_by={../handler/order_by/field}:{../handler/order_by/direction}&amp;event=MoveUp&amp;item_id={./@id}&amp;move_id={./@prev_id}&amp;restore={../handler/restore}" class="under">
							<img src="{/page/@framework_url}packages/libraries/img/ico_up.gif" border="0" alt="{//_caption_move_up}"/>
						</a> &amp;nbsp;
                         <a href="{../headers/header[1]/link/href}&amp;page={../handler/page}&amp;move_library={../handler/library}&amp;{../handler/library}_order_by={../handler/order_by/field}:{../handler/order_by/direction}&amp;event=MoveDown&amp;item_id={./@id}&amp;move_id={./@next_id}&amp;restore={../handler/restore}" class="under">
							<img src="{/page/@framework_url}packages/libraries/img/ico_down.gif" border="0" alt="{//_caption_move_down}"/>
						</a>
					</xsl:when>
					<xsl:otherwise>
						<img src="{/page/@framework_url}packages/libraries/img/ico_arrows_disabled.gif" border="0"/>
					</xsl:otherwise>
				</xsl:choose>
			</td>
		</xsl:if>
		<!--^ Move link -->
		<!-- Copy link -->
		<xsl:if test="../handler/disabled_copy='no'">
			<td style="text-align:center">
				<input type="checkbox" name="copy_item[]" value="{./@id}">
					<xsl:if test="../handler/disable_copy ='yes'">
						<xsl:attribute name="disabled"> </xsl:attribute>
					</xsl:if>
				</input>
				<a href="?{$package}page={../handler/page}&amp;event=CopyItem&amp;item_id={./@id}&amp;start={../navigator/start}&amp;order_by={../navigator/bar/element[1]/order_by}&amp;library={../handler/library}&amp;restore={../handler/restore}&amp;{../handler/library}_parent_id={../handler/parent_id}&amp;custom_var={../handler/custom_var}&amp;custom_val={../handler/custom_val}&amp;host_library_ID={../handler/host_library_ID}" class="under">
					<img src="{/page/@framework_url}packages/libraries/img/ico_copy.gif" width="16" height="16" border="0" alt="{//_caption_copy}"/>
				</a>
			</td>
		</xsl:if>
		<!--^ Copy link -->
		<xsl:if test="../handler/disabled_delete='no'">
			<td style="text-align:center">
				<nobr>
					<!--input type="hidden" name="items[]" value="{./@id}"/-->
					<input type="checkbox" name="delete_item[]" value="{./@id}">
						<xsl:if test="../handler/disabled_delete ='yes'">
							<xsl:attribute name="disabled"> </xsl:attribute>
						</xsl:if>
					</input>
					<xsl:choose>
						<xsl:when test="../handler/disabled_delete !='yes'">
							<a href="?{$package}page={../handler/page}&amp;event=DeleteItem&amp;item_id={./@id}&amp;start={../navigator/start}&amp;order_by={../navigator/bar/element[1]/order_by}&amp;library={../handler/library}&amp;restore={../handler/restore}&amp;{../handler/library}_parent_id={../handler/parent_id}&amp;custom_var={../handler/custom_var}&amp;custom_val={../handler/custom_val}&amp;host_library_ID={../handler/host_library_ID}" OnClick="return confirm('{//_caption_confirm_delete}')" class="under">
								<img src="{/page/@framework_url}packages/libraries/img/icn_delete.gif" width="16" height="16" border="0" alt="{//_caption_delete}"/>
							</a>
						</xsl:when>
						<xsl:otherwise>
							<img src="{/page/@framework_url}packages/libraries/img/icn_delete.gif" width="16" height="16" border="0" alt="{//_caption_delete}"/>
						</xsl:otherwise>
					</xsl:choose>
				</nobr>
			</td>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
