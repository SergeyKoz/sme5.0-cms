<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="yes"  media-type="text/html"/>
    <xsl:variable name="request_uri"><xsl:value-of select="/page/@request_uri" /></xsl:variable>
    <xsl:variable name="page_root"><xsl:value-of select="/page/@root" /></xsl:variable>

    <!-- Section layout template -->
    <xsl:template match="page">
    <xsl:variable name="page-title"><xsl:value-of select="//_PageTitle" /></xsl:variable>
        <html>
            <script>
                var ipath = "<xsl:value-of select="/page/@url"/>/img/";
            </script>

            <script language="JavaScript" src="{/page/@framework_url}/packages/libraries/scripts/library.js"></script>

            <head>
                <title><xsl:value-of select="/page/package/@title"/> - <xsl:value-of select="$page-title"/></title>
                <link rel="stylesheet" href="{/page/@framework_url}packages/extranet/css/styles.css" type="text/css"/>
            </head>
            <body marginheight="0" marginwidth="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
                <!-- Body output -->
                <xsl:apply-templates select="content"/>
                <!-- Footer output -->
                <xsl:call-template name="debug" />        
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>