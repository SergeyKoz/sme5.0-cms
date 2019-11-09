<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="UTF-8" omit-xml-declaration="yes" media-type="text/html"/>
	<xsl:variable name="request_uri">
		<xsl:value-of select="/page/@request_uri"/>
	</xsl:variable>
	<xsl:variable name="page_root">
		<xsl:value-of select="/page/@root"/>
	</xsl:variable>
	<!-- Section layout template -->
	<xsl:template match="page">
		<html>
			<head>
				<title>
					<xsl:value-of select="package/@title"/>::<xsl:value-of select="content/localization/_PageTitle"/>
				</title>
				<link rel="stylesheet" href="{/page/@framework_url}packages/libraries/css/styles.css" type="text/css"/>
				<script type="text/javascript" src="{/page/@framework_url}scripts/jquery.js"></script>
				<script type="text/javascript" src="{/page/@framework_url}packages/libraries/scripts/tabpane.js"></script>
				<link rel="stylesheet" href="{/page/@framework_url}packages/extranet/css/smootheme/jqueryuiextranet.css" type="text/css"/>
				<script type="text/javascript" src="{/page/@framework_url}scripts/jqueryui.js"></script>
				<script>
					$(document).ready(function(){
						$("button").button();
						$("input[type=submit]").button();
						$("input[type=button]").button();
					});
				</script>
				<xsl:for-each select="/page/content/scripts/script">
					<script type="{@type}" src="{.}"></script>
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
			<body class="mainwindowform" marginheight="0" marginwidth="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
                <!-- Header output -->
                <script>var ipath = "<xsl:value-of select="/page/@url"/>/img/";</script>
                <script language="JavaScript" src="{/page/@framework_url}/packages/libraries/scripts/library.js"></script>
                <!-- Content -->
                <!--Errors output -->
                <xsl:call-template name="errors"/>
                <!-- Content output -->
                <div class="content">
                	<xsl:apply-templates select="content"/>
                </div>
				<xsl:call-template name="debug"/>
			</body>
		</html>
		<script language="JavaScript">
			InitScroll();
		</script>
	</xsl:template>
</xsl:stylesheet>
