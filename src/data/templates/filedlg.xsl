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
  
    <table border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<iframe src="?page=filedlg&amp;event=FilesList&amp;f=" width="400" height="400"></iframe>
			</td>
		</tr>
	</table>
  </xsl:template>
</xsl:stylesheet>
