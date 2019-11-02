<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no" media-type="text/html"/>
	<!-- Administrator section layout stylesheet -->
	<xsl:include href="layouts/layout.xsl"/>
	<xsl:include href="blocks/debug.xsl"/>
	<xsl:include href="blocks/errors.xsl"/>
	<xsl:template match="/">
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="content">
		<script type="text/javascript" src="{/page/@framework_url}scripts/menu.js"/>
		<script type="text/javascript">
            var moveWindow;
            function PageMovePopup(url)
            {
                if (moveWindow)
                {
                    moveWindow.close();
                }
                moveWindow = window.open(url, 'movePage',
                    'status=no, resizable=yes, scrollbars=yes, menubar=no, toolbar=no, width=400, height=400');
                
            }
            
            function doDelete(url)
            {
                if (confirm('<xsl:value-of select="//_confirm_delete_page"/>'))
                {
                    document.location = url;
                }
            }
            
            function doDeletePublications(url)
            {
                if (confirm('<xsl:value-of select="//_confirm_delete_publications"/>'))
                {
                    document.location = url;
                }
            }
            
            <xsl:if test="/page/@contextframe=1">
	            function cancelTreeEdit(){
	            	window.top.closeframe();
	            }
            </xsl:if>
		</script>
		<div class="pageheader">
			<span>
				<xsl:value-of select="/page/content/localization/_PageTitle"/>
			</span>
		</div>
		<div class=" clr"/>
		<!-- add new page -->
		<div style="margin-left:25px;">
			<button type="submit" value="{//_caption_add}" onClick="window.location.href='?package=content&amp;page=new&amp;restore={/page/content/restore}'; return false;" title="{//_title_add}">
				<img src="{/page/@framework_url}packages/libraries/img/ico_add_item.gif" alt="LogOff" align="absmiddle" border="0" width="16" height="16"/>&amp;nbsp;<xsl:value-of select="/page/content/localization/_caption_add_page"/>
			</button>
       
            		<xsl:if test="/page/@contextframe=1">
            		 	&amp;nbsp;
				<button type="submit" title="{/page/content/localization/_caption_cancel}" onClick="return (confirm('{/page/content/localization/_caption_confirm_cancel}') ? cancelTreeEdit() : false)" >
					<img src="{/page/@framework_url}packages/libraries/img/ico_cancel.gif" alt="" align="absmiddle" border="0" width="19" height="16"/> &amp;nbsp;<xsl:value-of select="/page/content/localization/_caption_cancel"/>
				</button>
			</xsl:if>
			<br/>
			<br/>
			<!-- structure tree -->
			<xsl:apply-templates select="structure_tree"/>
			<br/>
			<button type="submit" value="{/page/content/localization/_caption_add}" onClick="window.location.href='?package=content&amp;page=new&amp;restore={/page/content/restore}'; return false;" title="{//_title_add}">
				<img src="{/page/@framework_url}packages/libraries/img/ico_add_item.gif" alt="LogOff" align="absmiddle" border="0" width="16" height="16"/>&amp;nbsp;<xsl:value-of select="/page/content/localization/_caption_add_page"/>
			</button>
			<xsl:if test="/page/@contextframe=1">
				&amp;nbsp;
				<button type="submit" title="{//_caption_cancel}" onClick="return (confirm('{/page/content/localization/_caption_confirm_cancel}') ? cancelTreeEdit() : false)">
					<img src="{/page/@framework_url}packages/libraries/img/ico_cancel.gif" alt="" align="absmiddle" border="0" width="19" height="16"/> &amp;nbsp;<xsl:value-of select="/page/content/localization/_caption_cancel"/>
				</button>
			</xsl:if>
		</div>
		<!-- need some indentation to prevent context menu to go out of screen -->
		<br/>
		<br/>
	</xsl:template>
	<xsl:template match="structure_tree">
		<!-- recursive build structure tree -->
		<xsl:apply-templates select="item"/>
	</xsl:template>
	<xsl:template match="item">
		<xsl:variable name="is_context">
			<xsl:if test="/page/@contextframe=1">&amp;contextframe=1</xsl:if>
		</xsl:variable>
		<!-- line indentation (depends on nesting level) -->
		<!-- build context menu -->
		<img src="{/page/package/@url}img/blank.gif" height="1" width="{@level * 40}" class="fl"/>
		<div class="drop_menu">
			<img src="{/page/package/@url}img/menu.gif" border="0" title="{/page/content/localization/_contextmenu_caption}" onmouseout="setTimer();" onmouseover="ShowMenu('context_menu_{@id}',  0);" style="cursor:pointer"/>
			<xsl:call-template name="silvergray2">
				<xsl:with-param name="id">
					<xsl:value-of select="@id"/>
				</xsl:with-param>
				<xsl:with-param name="url">
					<xsl:value-of select="url"/>
				</xsl:with-param>
			</xsl:call-template>
		</div>&amp;nbsp;
			
        		
			<!-- /context menu -->
		<!-- Deactivate page -->
		<xsl:if test="@active = 1">
			<a href="{url}&amp;event=deact_page{$is_context}">
				<img src="{/page/package/@url}img/active.gif" border="0" title="{/page/content/localization/tooltip_deactivate}"/>
			</a>&amp;nbsp;
		</xsl:if>
		<!-- Activate page -->
		<xsl:if test="@active = 0">
			<a href="{url}&amp;event=act_page{$is_context}">
				<img src="{/page/package/@url}img/inactive.gif" border="0" title="{/page/content/localization/tooltip_activate}"/>
			</a>&amp;nbsp;
        		</xsl:if>
		<!-- language active-->
		<!--xsl:if test="count(/page/languages/language)>1"-->
		<xsl:variable name="_url" select="url"/>
		<xsl:for-each select="languages/language">
			<xsl:variable name="lng" select="."/>
			<xsl:if test="@active=1">
				<a href="{$_url}&amp;event=deact_{.}_lng{$is_context}">
					<img src="{/page/package/@url}img/active_{.}.gif" border="0" title="{/page/content/localization/_tooltip_deactivate_lang} ({/page/languages/language[prefix=$lng]/shortname})"/>
				</a>
			</xsl:if>
			<xsl:if test="@active=0">
				<a href="{$_url}&amp;event=act_{.}_lng{$is_context}">
					<img src="{/page/package/@url}img/inactive_{.}.gif" border="0" title="{/page/content/localization/_tooltip_activate_lang} ({/page/languages/language[prefix=$lng]/shortname})"/>
				</a>
			</xsl:if>
	        			&amp;nbsp;
	        		</xsl:for-each>
		<!--/xsl:if-->
		<!-- move up button -->
		<xsl:choose>
			<xsl:when test="@is_first = 0">
				<a href="{url}&amp;event=move_up{$is_context}">
					<img src="{/page/package/@url}img/move_up_enabled.gif" border="0" title="{/page/content/localization/_tooltip_move_up}"/>
				</a>&amp;nbsp;
            		</xsl:when>
			<xsl:otherwise>
				<img src="{/page/package/@url}img/move_up_disabled.gif" border="0" title="{/page/content/localization/_tooltip_move_up}"/>&amp;nbsp;
          		</xsl:otherwise>
		</xsl:choose>
		<!-- /move up button -->
		<!-- move down button -->
		<xsl:choose>
			<xsl:when test="@is_last = 0">
				<a href="{url}&amp;event=move_down{$is_context}">
					<img src="{/page/package/@url}img/move_down_enabled.gif" border="0" title="{/page/content/localization/_tooltip_move_down}"/>
				</a>&amp;nbsp;
            		</xsl:when>
			<xsl:otherwise>
				<img src="{/page/package/@url}img/move_down_disabled.gif" border="0" title="{/page/content/localization/_tooltip_move_down}"/>&amp;nbsp;
            		</xsl:otherwise>
		</xsl:choose>
		<!-- /move down button -->
		<xsl:value-of select="title"/>
		<!-- end of line -->
		<br/>
		<xsl:apply-templates select="item"/>
	</xsl:template>
	<xsl:template name="silvergray2">
		<xsl:param name="id"/>
		<xsl:variable name="is_context">
			<xsl:if test="/page/@contextframe=1">&amp;contextframe=1</xsl:if>
		</xsl:variable>
		<xsl:variable name="page_id" select="@id"/>
		<!--    -->
		<!--xsl:variable name="xoffset" select="-30+@level * 35"/-->
		<!--div id="context_menu_{$id}" style="display:none; position:absolute; z-index:1; margin-left : {$xoffset}px; margin-top : {$yoffset}px" onmouseout="setTimer();" onmouseover="ShowMenu('context_menu_{$id}',  0);"-->
		<div id="context_menu_{$id}" style="display:none; position:absolute; z-index:1; margin-left : -30px; margin-top : 15px" onmouseout="setTimer();" onmouseover="ShowMenu('context_menu_{$id}',  0);" class="dmenu">
			<table width="300" class="silvergray2">
				<tr>
					<td align="center" class="silvergray4">
						<strong style="line-height:28px;">
							<xsl:value-of select="/page/content/localization/_contextmenu_section_edit"/>
						</strong>
					</td>
				</tr>
				<xsl:for-each select="/page/languages/language">
					<tr>
						<td align="center">
							<a href="?page=editcontent&amp;package=content&amp;id={$id}&amp;lng={prefix}" target="edit_content">
								<xsl:value-of select="/page/content/localization/_contextmenu_edit"/> (<xsl:value-of select="shortname"/>)
							</a>
							<!-- /edit page -->
						</td>
					</tr>
				</xsl:for-each>
				<tr>
					<td align="center" class="silvergray4">
						<strong style="line-height:28px;">
							<xsl:value-of select="/page/content/localization/_contextmenu_section_actions"/>
						</strong>
					</td>
				</tr>
				<tr>
					<td align="center">
						<a href="javascript:void(0)" onClick="PageMovePopup('?page=move&amp;package=content&amp;id={@id}{$is_context}')">
							<xsl:value-of select="/page/content/localization/_contextmenu_move"/>
						</a>
					</td>
				</tr>
				<tr>
					<td align="center">
						<xsl:if test="@active = 1">
							<a href="{url}&amp;event=deact_page{$is_context}">
								<xsl:value-of select="/page/content/localization/_contextmenu_deactivate"/>
							</a>
						</xsl:if>
						<xsl:if test="@active = 0">
							<a href="{url}&amp;event=act_page{$is_context}">
								<xsl:value-of select="/page/content/localization/_contextmenu_activate"/>
							</a>
						</xsl:if>
					</td>
				</tr>
				<tr>
					<td align="center">
						<a href="{url}&amp;event=act_pages{$is_context}">
							<xsl:value-of select="/page/content/localization/_contextmenu_activate_branch"/>
						</a>
					</td>
				</tr>
				<tr>
					<td align="center">
						<a href="{url}&amp;event=deact_pages{$is_context}">
							<xsl:value-of select="/page/content/localization/_contextmenu_deactivate_branch"/>
						</a>
					</td>
				</tr>
				<tr>
					<td align="center">
						<a href="?package=content&amp;page=new&amp;parent_id={@id}&amp;event=additem&amp;restore={/page/content/restore}">
							<xsl:value-of select="/page/content/localization/_contextmenu_add"/>
						</a>
					</td>
				</tr>
				<tr>
					<td align="center">
						<a href="#" onClick="doDelete('{url}&amp;event=del_page{$is_context}')">
							<xsl:value-of select="/page/content/localization/_contextmenu_delete"/>
						</a>
					</td>
				</tr>
				<tr>
					<td align="center">
						<!-- edit page props -->
						<a href="?page=props&amp;package=content&amp;id={@id}&amp;restore={/page/content/restore}">
							<xsl:value-of select="/page/content/localization/_contextmenu_properties"/>
						</a>
					</td>
				</tr>
			</table>
		</div>
	</xsl:template>
</xsl:stylesheet>
