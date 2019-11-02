<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:template match="content_data">
      <xsl:value-of select="content_text" disable-output-escaping="yes"/>
    </xsl:template>
</xsl:stylesheet>