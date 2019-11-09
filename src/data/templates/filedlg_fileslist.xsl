<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="no" media-type="text/html" />
  <!-- Administrator section layout stylesheet -->

    <xsl:include href="layouts/layout.xsl"/>
    <xsl:include href="blocks/errors.xsl"/>
    <xsl:include href="blocks/debug.xsl"/>
  <!-- Variable for page title -->
  <xsl:template match="/">
    <xsl:apply-templates />
  </xsl:template>
  
  <xsl:template match="content">
    <xsl:apply-templates select="file_dialog"/>
  </xsl:template>
  
  <xsl:template match="file_dialog">
	<xsl:for-each select="path/item">
		<xsl:if test=". != ''">
			/<xsl:value-of select="." />
		</xsl:if>
	</xsl:for-each>/
	<br/>
	<br/>
	

	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<!-- folders -->
		<xsl:for-each select="folders/item">
		<tr>
			<td width="">
				<a href="?page=filedlg&amp;event=FilesList&amp;f={id}"><b><xsl:value-of select="name"/></b></a>&amp;nbsp;
			</td>
			<td width="50">
				&amp;nbsp;
			</td>
			<td width="120" nowrap="1">
				<nobr><xsl:value-of select="date"/></nobr>
			</td>
		</tr>
		</xsl:for-each>
		<!-- files -->
		<xsl:for-each select="files/item">
		<tr>
			<td>
				<xsl:value-of select="name"/>&amp;nbsp;
			</td>
			<td width="50" align="right">
				<nobr><xsl:value-of select="size"/>&amp;nbsp;</nobr>
			</td>
			<td width="120" nowrap="1">
				<nobr><xsl:value-of select="date"/></nobr>
			</td>
		</tr>
		</xsl:for-each>
	</table>
  </xsl:template>
</xsl:stylesheet>
