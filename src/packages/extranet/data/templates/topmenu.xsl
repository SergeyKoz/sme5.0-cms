<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no" media-type="text/html"/>
	<!-- Administrator section layout stylesheet -->
	<xsl:include href="layouts/layout.xsl"/>
	<xsl:include href="blocks/errors.xsl"/>
	<xsl:include href="blocks/debug.xsl"/>
	<xsl:template match="/">
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="content">
		<script src="{/page/@framework_url}packages/extranet/scripts/coolbuttons.js"></script>
		<table width="100%" class="silvergray" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
                    <xsl:for-each select="menu/section/link">
                        <!-- users button -->
                            <button title="{title}" class="coolButton" onClick="parent.content.location.href='{url}'">
                                <img src="{image}" alt="" align="absmiddle" border="0" width="16" height="16"/> &amp;nbsp;<xsl:value-of select="title"/>
                            </button>
                    </xsl:for-each>
				</td>
				<td>
					<!-- logoff button -->
                    <button onClick="parent.content.location.href='?package=extranet&amp;page=topmenu&amp;event=LogOff'" title="LogOff" style="margin-right:15px; float:right">
                        <img src="{/page/@framework_url}packages/extranet/img/logoff.gif" alt="LogOff" align="absmiddle" border="0" width="16" height="16"/> &amp;nbsp;<xsl:value-of select="localization/logOffText"/>
                    </button>
					<!-- /logoff button -->
				</td>
			</tr>
		</table>
		<!-- status links -->
		<div class="clr"></div>
		
        <div class="userinfo">
        	<div><img src="{/page/@framework_url}packages/extranet/img/icn_person.gif" alt="" align="absmiddle" border="0" width="16" height="16"/>
            &amp;nbsp;User:&amp;nbsp;<b><xsl:value-of select="/page/@user_name"/></b>&amp;nbsp;<a href="{/page/@url}docs/Admin_help.doc" target="_blank">
								<img src="{/page/@framework_url}packages/extranet/img/admin_help_ico.gif" width="16" height="16" border="0" align="absmiddle"/>
							</a>
        	</div>
        </div>
		<div class="clr"></div>
        <div class="userinfo">
        	<div><img src="{/page/@framework_url}packages/extranet/img/ico_language.gif" alt="" align="absmiddle" border="0" width="16" height="16"/>
            	&amp;nbsp;Language:&amp;nbsp;
                <xsl:for-each select="/page/languages/language">
                    <xsl:choose>
                        <xsl:when test="prefix!=(/page/@language)">
                            <a class="yellow" href="?package=extranet&amp;page=framelist&amp;language={prefix}" target="_parent">
                                <xsl:value-of select="shortname"/>
                            </a>
                        </xsl:when>
                        <xsl:otherwise>
                            <b>
                                <xsl:value-of select="shortname"/>
                            </b>
                        </xsl:otherwise>
                    </xsl:choose>
                    <!-- separator -->
                    <xsl:if test="position()!=count(../language)">
                            |
                    </xsl:if>
                    <!-- ^ separator -->
                </xsl:for-each>
        	</div>
        </div>
		<div class="clr"></div>
        <br/><br/><br/><br/>
        <div class="clr"></div>
		<script>
			parent.topmenu.document.body.className  = "topframe";
			parent.topmenu.document.body.scroll = 'no'
		</script>
	</xsl:template>
</xsl:stylesheet>
