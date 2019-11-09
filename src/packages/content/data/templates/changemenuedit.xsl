<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="no" indent="yes" media-type="text/html"/>
	<xsl:include href="layouts/layout.xsl"/>
	<xsl:include href="blocks/debug.xsl"/>
	<xsl:include href="blocks/errors.xsl"/>
	<!-- Include controls -->
	<xsl:include href="controls/indicator.xsl"/>
	<!--xsl:include href="controls/text.xsl"/-->
	<xsl:include href="controls/hidden.xsl"/>
	<xsl:include href="controls/checkbox.xsl"/>
	<xsl:include href="controls/select.xsl"/>
	<xsl:include href="controls/dbeditblock.xsl"/>
	<xsl:include href="controls/password.xsl"/>
	<xsl:include href="controls/radio.xsl"/>
	<xsl:include href="controls/textarea.xsl"/>
	<xsl:include href="controls/htmleditor.xsl"/>
	<xsl:include href="controls/link.xsl"/>
	<xsl:include href="controls/treepath.xsl"/>
	<xsl:include href="controls/datetime.xsl"/>
	<xsl:include href="controls/navigator.xsl"/>
	<xsl:include href="controls/itemslist.xsl"/>
	<xsl:include href="controls/itemsedit.xsl"/>
	<xsl:include href="controls/radiogroup.xsl"/>
	<xsl:include href="controls/checkboxgroup.xsl"/>
	<xsl:include href="controls/statictext.xsl"/>
	<xsl:include href="controls/file.xsl"/>
	<xsl:include href="controls/file2.xsl"/>
	<xsl:include href="controls/extrahtmleditor.xsl"/>
	<xsl:include href="controls/machtmleditor.xsl"/>
	<xsl:include href="controls/secure.xsl"/>
	<xsl:include href="controls/autocomplete.xsl"/>
	<xsl:template match="/">
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="content">
		<xsl:if test="edit">
			<xsl:apply-templates select="edit"/>
		</xsl:if>
	</xsl:template>
	
	<xsl:template match="text">
		<xsl:if test="/page/content/pagestree/page">
			<style type="">
				.list_style {
					list-style-type:none;
				}
			</style>
			<ul class="list_style">
				<xsl:for-each select="/page/content/pagestree/page">
					<xsl:apply-templates select="." mode="pagestree"/>
				</xsl:for-each>
			</ul>
		</xsl:if>
	</xsl:template>
	
	<xsl:template match="page" mode="pagestree">
		<li>
			<input type="checkbox" name="page_id[]" value="{id}">
				<xsl:if test="selected=1">
					<xsl:attribute name="checked"></xsl:attribute>
				</xsl:if>
			</input>
			<xsl:value-of select="title"/>
			<xsl:if test="page">
				<ul class="list_style">
					<xsl:for-each select="page">
						<xsl:apply-templates select="." mode="pagestree"/>
					</xsl:for-each>
				</ul>
			</xsl:if>
		</li>
	</xsl:template>
</xsl:stylesheet>
