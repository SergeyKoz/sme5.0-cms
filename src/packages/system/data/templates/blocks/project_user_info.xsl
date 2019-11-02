<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template name="user_info">
		<xsl:choose>
			<xsl:when test="/page/@user_id !=''">
				<b>
					<xsl:value-of select="//localization/_user_login_caption"/>
				</b>:
				<xsl:choose>
					<xsl:when test="/page/content/authindicator[name!='']">
						<xsl:value-of select="/page/content/authindicator/name"/>
					</xsl:when>
					<xsl:otherwise>
						<xsl:value-of select="//page/@user_name"/>
					</xsl:otherwise>
				</xsl:choose><br/>				
				<a href="{/page/@url}{/page/@lng_url_prefix}profile/">
					<xsl:value-of select="/page/content/localization/_user_profile_caption"/>
				</a>
				<br/>
				<a href="{/page/@url}{/page/@lng_url_prefix}logoff/">
					<xsl:value-of select="/page/content/localization/_user_logoff_caption"/>
				</a>
			</xsl:when>
			<xsl:otherwise>
				<form method="post" action="{/page/@url}logon/?camefrom={/page/@request_uri}" name="quick_logon_form">
					<input type="hidden" name="event" value="Process"/>
					<xsl:value-of select="/page/content/localization/text_login"/>
					<br/>
					<input tabindex="1" class="" type="text" name="login" value=""/><br/>
					<xsl:value-of select="/page/content/localization/text_password"/>
					<br/>
					<input tabindex="2" class="" type="password" name="password" value=""/>
					<br/>
					<input tabindex="3" type="submit" value="{/page/content/localization/text_logon}"/>
					<br/>
					<a href="{/page/@url}registration/">
						<xsl:value-of select="/page/content/localization/_user_registration_caption"/>
					</a>
					<br/>
					<a href="{/page/@url}reminder/">
						<xsl:value-of select="/page/content/localization/_user_reminder_caption"/>
					</a>
				</form>
			</xsl:otherwise>
		</xsl:choose>
		<br/>
	</xsl:template>
</xsl:stylesheet>
