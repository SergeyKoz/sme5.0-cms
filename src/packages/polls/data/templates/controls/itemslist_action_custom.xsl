<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template name="list_action_custom">
		<xsl:choose>
			<xsl:when test="handler/library='polls'">
				<td>
					<xsl:value-of select="//localization/_title_reset"/>
				</td>
			</xsl:when>
			<xsl:when test="handler/library='polls_variants'">
				<td>
					<xsl:value-of select="//localization/_title_reset"/>
				</td>
				<xsl:if test="/page/content/list/row/control/checkbox[name='variants[]']/checked='yes'">
					<td>
						<xsl:value-of select="//localization/_title_variants"/>
					</td>
				</xsl:if>
			</xsl:when>
			<xsl:otherwise>
     </xsl:otherwise>
		</xsl:choose>
	</xsl:template>
	<xsl:template name="item_action_custom">
		<xsl:choose>
			<xsl:when test="../handler/library='polls'">
				<td>
					<a href="?page={../handler/page}&amp;event=ResetItem&amp;item_id={./@id}&amp;start={../navigator/start}&amp;order_by={../navigator/bar/element[1]/order_by}&amp;library={../handler/library}&amp;restore={../handler/restore}&amp;{../handler/library}_parent_id={../handler/parent_id}&amp;custom_var={../handler/custom_var}&amp;custom_val={../handler/custom_val}&amp;host_library_ID={../handler/host_library_ID}" class="under" onclick="return confirm('{/page/content/localization/_reset_confirm}');">
						<xsl:value-of select="//localization/_caption_reset"/>
					</a>
				</td>
			</xsl:when>
			<xsl:when test="../handler/library='polls_variants'">
				<td>
					<a href="?page={../handler/page}&amp;event=ResetItem&amp;item_id={./@id}&amp;start={../navigator/start}&amp;order_by={../navigator/bar/element[1]/order_by}&amp;library={../handler/library}&amp;restore={../handler/restore}&amp;{../handler/library}_parent_id={../handler/parent_id}&amp;custom_var={../handler/custom_var}&amp;custom_val={../handler/custom_val}&amp;host_library_ID={../handler/host_library_ID}" class="under" onclick="return confirm('{/page/content/localization/_reset_confirm}');">
						<xsl:value-of select="//localization/_caption_reset"/>
					</a>
				</td>
				<xsl:if test="/page/content/list/row/control/checkbox[name='variants[]']/checked='yes'">
					<td>
						<xsl:if test="control/checkbox[name='variants[]']/checked='yes'">
							<a href="?page=itemslist&amp;item_id={./@id}&amp;start={../navigator/start}&amp;order_by={../navigator/bar/element[1]/order_by}&amp;library=polls_var&amp;parent_id={../handler/parent_id}" target="_blank" class="under">
								<xsl:value-of select="//localization/_caption_variants"/>
							</a>
						</xsl:if>
					</td>
				</xsl:if>
			</xsl:when>
			<xsl:otherwise>
     </xsl:otherwise>
		</xsl:choose>
	</xsl:template>
</xsl:stylesheet>
