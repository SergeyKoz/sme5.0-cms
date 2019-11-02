<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no" media-type="text/html"/>
	<!-- Variable for page title -->
	<xsl:template match="page">
		<xsl:apply-templates select="content"/>
	</xsl:template>
	<xsl:template match="content">
		<html>
			<head>
				<title>
					<xsl:value-of select="/page/package/@title"/>::<xsl:value-of select="/page/content/localization/_PageTitle"/>
				</title>
			</head>
		</html>
		<frameset rows="100,*" cols="131,*" frameborder="NO" border="0" framespacing="0">
			<frame name="logo" src="frame.php?package=extranet&amp;page=logo" border="0" frameborder="NO" SCROLLING="NO" noresize="noresize"/>
			<frame name="topmenu" src="frame.php?package=extranet&amp;page=topmenu" frameborder="NO" border="0" noresize="noresize" scrolling="NO"/>
			<frame name="leftmenu" src="frame.php?package=extranet&amp;page=leftmenu" frameborder="NO" noresize="noresize" scrolling="NO"/>
			<xsl:variable name="contenturl">
				<xsl:choose>
					<xsl:when test="/page/content/content_url"><xsl:value-of select="/page/content/content_url"/></xsl:when>
					<xsl:otherwise>package=extranet&amp;page=default</xsl:otherwise>
				</xsl:choose>
			</xsl:variable>
			<frame name="content" src="frame.php?{$contenturl}" frameborder="NO"/>
		</frameset>
	</xsl:template>
</xsl:stylesheet>
