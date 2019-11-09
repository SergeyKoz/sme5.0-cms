<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="no" media-type="text/html"/>
	<!-- Administrator section layout stylesheet -->
	<xsl:include href="layouts/admin_popup.xsl"/>
	<xsl:include href="blocks/debug.xsl"/>
	<xsl:include href="blocks/errors.xsl"/>
	<xsl:template match="/">
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="content">
		<xsl:variable name="is_context">
			<xsl:if test="/page/@contextframe=1">&amp;contextframe=1</xsl:if>
		</xsl:variable>
		<script>
            function doMove(to_id, name)
            {
                if (confirm("<xsl:value-of select="//_confirm_move_page"/> '" + name + "' ?"))
                {
                    window.opener.document.location = "?package=content&amp;library=&amp;page=structure&amp;event=page_move<xsl:value-of select="$is_context"/>&amp;id="
                        + "<xsl:value-of select="tree_info/page_id"/>" + "&amp;to=" + to_id;
                    window.close();
                }
            }
        </script>
        
		<div class="silverGray2">
            <!--img src="{/page/@framework_url}packages/libraries/img/ico_pencil.gif" align="absmiddle" width="32" height="32"/-->
            <span class="mainHeader move">
                <xsl:value-of select="//_title_page_move2"/>: <font color="black">
                    <xsl:value-of select="tree_info/page_title"/>
                </font>
                <br/>
                <font color="black">
                    <xsl:value-of select="//_title_page_move"/>
                </font>
            </span>
		</div>
        <div class="clr"></div>
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td valign="middle" align="left" class="menuitem" style="padding-left:10px;">
					<xsl:apply-templates select="structure_tree"/>
				</td>
			</tr>
		</table>
	</xsl:template>
	<xsl:template match="structure_tree">
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td valign="middle" align="left" class="menuitem" style="padding-left:10px;">
					<!-- root node -->
					<a href="javascript:void(0)" class="menuitem" onClick="doMove(0, '{//_tree_root}')">
						<xsl:value-of select="//_tree_root"/>
					</a>
					<br/>
					<!-- build tree -->
					<xsl:apply-templates select="item"/>
				</td>
			</tr>
		</table>
	</xsl:template>
	<xsl:template match="item">
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td valign="middle" align="left" class="menuitem" style="padding-left:10px;">
					<img src="{/page/package/@url}img/blank.gif" height="1" width="{@level * 40}"/>
					<xsl:choose>
						<!-- add link to pages where we can move -->
						<xsl:when test="@can_move_here=1">
							<a href="javascript:void(0)" class="menuitem" onClick="doMove({@id}, '{title_encoded}')">
								<xsl:value-of select="title"/>
							</a>
						</xsl:when>
						<xsl:otherwise>
							<!-- disabled to move into -->
							<xsl:value-of select="title"/>
						</xsl:otherwise>
					</xsl:choose>
					<br/>
					<xsl:apply-templates select="item"/>
				</td>
			</tr>
		</table>
	</xsl:template>
</xsl:stylesheet>
