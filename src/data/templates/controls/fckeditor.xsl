<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
<xsl:template match="fckeditor">
  <xsl:param name="class"/>
  <xsl:param name="disabled"/>
  <xsl:for-each select="//localization/_alias_hint">
    <xsl:value-of select="."  disable-output-escaping="yes"/>
  </xsl:for-each>    
     <xsl:value-of select="editor_content" disable-output-escaping="yes"/>
</xsl:template> 
   
</xsl:stylesheet>