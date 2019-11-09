<?xml version="1.0" encoding="utf-8" ?>
<!-- Main project layout -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="yes" indent="yes" media-type="text/html"/>
  <!-- Root template -->
  <xsl:template match="page">
  
  <html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  </head>
  <body> 
   <table><tr><td>
          <xsl:apply-templates select="content"/>
   </td></tr></table>
  </body>
  </html>
  
  </xsl:template>
</xsl:stylesheet>  