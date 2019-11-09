<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="UTF-8" omit-xml-declaration="yes" media-type="text/html"/>
	<xsl:template name="print">
		<xsl:choose>
			<xsl:when test="not(/page/@print)">
				<a class="print" href="javascript:PrintWindow('{/page/@url}{/page/@request_uri}&amp;print=1');">
					<!--img src="{/page/@url}img/print.gif" border="0" align="absmiddle"/-->
					<xsl:value-of select="//_print"/>
				</a>
			</xsl:when>
			<xsl:otherwise>
				<div class="usenav">
					<a class="print" href="javascript:window.print();">
						<!--img src="{/page/@url}img/print.gif" border="0" align="absmiddle"/-->
						<xsl:value-of select="//_caption_text_print"/>
					</a>
					
					<a class="close" href="javascript:window.close();">
						<xsl:value-of select="//_caption_text_close"/>
					</a>
				</div>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:template>
</xsl:stylesheet>
