<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:include href="elements/title.xsl" />

    
    <xsl:template match="range">
    <tr>
     <td colspan="2">
      <xsl:value-of select="control" />
     </td>
    </tr>
    </xsl:template>
</xsl:stylesheet>