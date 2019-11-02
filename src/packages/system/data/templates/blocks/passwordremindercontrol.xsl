<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template name="passwordremindercontrol">
		<form action="" method="post" name="reminderForm">
			<input type="hidden" name="event" value="Process"/>
			<img src="{/page/settings/skinurl}img/1.gif" width="120" height="1" border="0"/>
			<br/>
			<xsl:choose>
				<xsl:when test="/page/content/errors/login=1">
					<span class="red"><xsl:value-of select="/page/content/localization/_rem_login"/> *</span>
				</xsl:when>
				<xsl:otherwise><xsl:value-of select="/page/content/localization/_rem_login"/> *</xsl:otherwise>
			</xsl:choose><br/>
			<input type="text" name="login" value="{login}" class=""/><br/>
			
			<xsl:choose>
				<xsl:when test="/page/content/errors/email=1">
					<span class="red"><xsl:value-of select="/page/content/localization/_rem_email"/> *</span>
				</xsl:when>
				<xsl:otherwise><xsl:value-of select="/page/content/localization/_rem_email"/> *</xsl:otherwise>
			</xsl:choose><br/>
			<input type="email" name="email" value="{email}" /><br/>
			<xsl:choose>
				<xsl:when test="/page/content/errors/code=1">
					<span class="red"><xsl:value-of select="/page/content/localization/_rem_code"/> *</span>
				</xsl:when>
				<xsl:otherwise><xsl:value-of select="/page/content/localization/_rem_code"/>*</xsl:otherwise>
			</xsl:choose><br/>
			<img src="{/page/@url}scripts/securecode.php"/>
			<input type="email" name="securecode" value="" /><br/>
			<input type="submit" value="{/page/content/localization/_rem_send}"/>
		</form>
	</xsl:template>
</xsl:stylesheet>
