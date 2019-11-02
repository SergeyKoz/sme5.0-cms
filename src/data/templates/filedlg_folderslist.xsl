<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no" media-type="text/html" />
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
	<table border="0" cellpadding="0" cellspacing="0">
		<!-- folders -->
		<xsl:for-each select="folders/item">
		<tr>
			<td width="">
				<b><xsl:value-of select="name"/>&amp;nbsp;</b>
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
