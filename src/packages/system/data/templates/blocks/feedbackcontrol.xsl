<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template match="edit">
		<xsl:for-each select="langversion">
			
				<form class="form feedb" name="editform" action="" method="POST">
				
					<xsl:variable name="email" select="control[*/name='email']"/>
					<xsl:variable name="subject" select="control[*/name='subject']"/>
					<xsl:variable name="author" select="control[*/name='author']"/>
					<xsl:variable name="message" select="control[*/name='message']"/>
				
					<xsl:choose>
						<xsl:when test="$email/*/error_field">
							<font class="red">
								<xsl:value-of select="$email/*/caption"/>*
							</font>
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="$email/*/caption"/> *
						</xsl:otherwise>
					</xsl:choose><br/>
					<xsl:apply-templates select="$email">
						<xsl:with-param name="class"></xsl:with-param>
					</xsl:apply-templates><br/>
					
					<xsl:choose>
						<xsl:when test="$subject/*/error_field">
							<font class="red">
								<xsl:value-of select="$subject/*/caption"/> *
							</font>
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="$subject/*/caption"/> *
						</xsl:otherwise>
					</xsl:choose><br/>
					<xsl:apply-templates select="$subject">
						<xsl:with-param name="class"></xsl:with-param>
					</xsl:apply-templates><br/>
					
					<xsl:choose>
						<xsl:when test="$author/*/error_field">
							<font class="red">
								<xsl:value-of select="$author/*/caption"/> *
							</font>
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="$author/*/caption"/> *
						</xsl:otherwise>
					</xsl:choose><br/>
					<xsl:apply-templates select="$author">
						<xsl:with-param name="class"></xsl:with-param>
					</xsl:apply-templates><br/>
					
					<xsl:choose>
						<xsl:when test="$message/*/error_field">
							<font class="red">
								<xsl:value-of select="$message/*/caption"/> *
							</font>
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="$message/*/caption"/> *
						</xsl:otherwise>
					</xsl:choose><br/>
					<xsl:apply-templates select="$message">
						<xsl:with-param name="class"/>
					</xsl:apply-templates><br/>
					
					<!-- security -->
					<xsl:if test="/page/@user_id=''">
						<xsl:choose>
							<xsl:when test="/page/content/securecode_error=1">
								<font class="red">
									<xsl:value-of select="/page/content/localization/_security_code"/> *</font>
							</xsl:when>
							<xsl:otherwise>
								<xsl:value-of select="/page/content/localization/_security_code"/> *
							</xsl:otherwise>
						</xsl:choose><br/>
						<img src="{/page/@url}securecode/"/>
						<input class="txt" name="securecode" value=""/><br/>
					</xsl:if>
					
					
					*&amp;nbsp;<xsl:value-of select="/page/content/localization/_fields"/>
					
					<br/>
					<input type="submit" value="{/page/content/localization/_caption_send_request}"/>
					
					<input type="hidden" name="event" value="DoAddItem"/>
				</form>
			
		</xsl:for-each>
	</xsl:template>
</xsl:stylesheet>
