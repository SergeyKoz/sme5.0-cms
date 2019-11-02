<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="yes" media-type="text/html" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
	<xsl:variable name="request_uri">
		<xsl:value-of select="/page/@request_uri"/>
	</xsl:variable>
	<xsl:variable name="page_root">
		<xsl:value-of select="/page/@root"/>
	</xsl:variable>
	<!-- Section layout template -->
	<xsl:template match="page">
		<xsl:variable name="page-title">
			<xsl:value-of select="//_PageTitle"/>
		</xsl:variable>
		<html>
			<head>
				<title>
					<xsl:value-of select="/page/package/@title"/> - <xsl:value-of select="$page-title"/>
				</title>
				<link rel="stylesheet" href="{/page/@framework_url}packages/extranet/css/styles.css" type="text/css"/>
				<link rel="stylesheet" href="{/page/@framework_url}packages/extranet/css/smootheme/jqueryuiextranet.css" type="text/css"/>
				<script type="text/javascript" src="{/page/@framework_url}scripts/jquery.js"/>
				<script type="text/javascript" src="{/page/@framework_url}scripts/jqueryui.js"/>
				<script>
					$(document).ready(function(){
						$("button").button();
						$("input[type=submit]").button();
						$("input[type=button]").button();
					});
				</script>
				<xsl:for-each select="/page/content/scripts/script">
					<script type="{@type}" src="{.}"/>
				</xsl:for-each>
				<xsl:for-each select="/page/content/links/link">
					<link href="{.}" type="{@type}">
						<xsl:if test="@media!=''">
							<xsl:attribute name="media"><xsl:value-of select="@media"/></xsl:attribute>
						</xsl:if>
						<xsl:if test="@rel!=''">
							<xsl:attribute name="rel"><xsl:value-of select="@rel"/></xsl:attribute>
						</xsl:if>
					</link>
				</xsl:for-each>
			</head>
			<body marginheight="0" marginwidth="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
				<!-- Header output -->
				<script>
					var ipath = "<xsl:value-of select="/page/@url"/>/img/";
				</script>
				<!-- Body output -->
				<xsl:apply-templates select="content"/>
				<!-- Footer output -->
				<xsl:call-template name="debug"/>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>
