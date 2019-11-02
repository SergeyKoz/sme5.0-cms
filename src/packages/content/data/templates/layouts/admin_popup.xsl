<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="yes"  media-type="text/html"/>
    <xsl:variable name="request_uri"><xsl:value-of select="/page/@request_uri" /></xsl:variable>
    <xsl:variable name="page_root"><xsl:value-of select="/page/@root" /></xsl:variable>    
    <!--xsl:include href="../admin_leftmenu.xsl"/-->
    <!--xsl:include href="../admin_topmenu.xsl"/-->

    <!-- Section layout template -->
    <xsl:template match="page">
        <html>
            <head>
                <title><xsl:value-of select="content/localization/_PageTitle"/>::<xsl:value-of select="content/localization/_AdminTitle"/></title>
                <!--link rel="stylesheet" href="{/page/@framework_url}css/styles.css" type="text/css"/-->
                 <link rel="stylesheet" href="{/page/@framework_url}packages/libraries/css/styles.css" type="text/css"/>
                <script>
                   var ipath = "<xsl:value-of select="/page/@url"/>/img/";
                </script>
                <script type="text/javascript" src="{/page/@framework_url}scripts/menu.js"></script>
                <script type="text/javascript" src="{/page/@framework_url}scripts/admin.js"></script>
            </head>
            <body marginheight="0" marginwidth="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
                <!--Errors output -->
                <xsl:call-template name="errors" />
                <!-- Content output -->
                <xsl:apply-templates select="content"/>
                <!-- Footer output -->                  
            <xsl:call-template name="debug" />
            </body>
        </html>
    </xsl:template>             
</xsl:stylesheet>
  