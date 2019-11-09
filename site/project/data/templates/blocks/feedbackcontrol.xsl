<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template match="edit">
		<xsl:for-each select="langversion">
			
				<form class="form feedb" name="editform" action="" method="POST">
				
					<xsl:variable name="email" select="control[*/name='email']"/>
					<xsl:variable name="subject" select="control[*/name='subject']"/>
					<xsl:variable name="author" select="control[*/name='author']"/>
					<xsl:variable name="message" select="control[*/name='message']"/>
					
					<div>
						<label for="form-feedb-f1">
						<xsl:choose>
							<xsl:when test="$email/*/error_field">
								<span class="red"><xsl:value-of select="$email/*/caption"/>:*</span>
							</xsl:when>
							<xsl:otherwise>
								<xsl:value-of select="$email/*/caption"/>:*
							</xsl:otherwise>
						</xsl:choose>
						</label>
						<xsl:apply-templates select="$email">
							<xsl:with-param name="class">txt</xsl:with-param>
							<xsl:with-param name="id">form-feedb-f1</xsl:with-param>
						</xsl:apply-templates>
					</div>
					
					<div>
					<label for="form-feedb-f2">
					<xsl:choose>
						<xsl:when test="$subject/*/error_field">
							<span class="red"><xsl:value-of select="$subject/*/caption"/>:*</span>
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="$subject/*/caption"/>:*
						</xsl:otherwise>
					</xsl:choose>
					</label>
					
					<xsl:apply-templates select="$subject">
						<xsl:with-param name="class">txt</xsl:with-param>
						<xsl:with-param name="id">form-feedb-f2</xsl:with-param>
					</xsl:apply-templates>
					</div>
					
					<div>
					<label for="form-feedb-f3">
					<xsl:choose>
						<xsl:when test="$author/*/error_field">
							<span class="red"><xsl:value-of select="$author/*/caption"/>:*</span>
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="$author/*/caption"/>:*
						</xsl:otherwise>
					</xsl:choose>
					</label>
					<xsl:apply-templates select="$author">
						<xsl:with-param name="class">txt</xsl:with-param>
						<xsl:with-param name="id">form-feedb-f3</xsl:with-param>
					</xsl:apply-templates>
					</div>
					
					<div>
					<label for="form-feedb-f4">
					<xsl:choose>
						<xsl:when test="$message/*/error_field">
							<span class="red"><xsl:value-of select="$message/*/caption"/>:*</span>
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="$message/*/caption"/>:*
						</xsl:otherwise>
					</xsl:choose>
					</label>
					<xsl:apply-templates select="$message">
						<xsl:with-param name="class"/>
						<xsl:with-param name="id">form-feedb-f4</xsl:with-param>
					</xsl:apply-templates>
					</div>
					
					<!-- security -->
					
					<xsl:if test="/page/@user_id=''">
						<div class="code">
						<label for="form-feedb-f5">
						<xsl:choose>
							<xsl:when test="/page/content/securecode_error=1">
								<span class="red">
									<xsl:value-of select="/page/content/localization/_security_code"/>:*</span>
							</xsl:when>
							<xsl:otherwise>
								<xsl:value-of select="/page/content/localization/_security_code"/>:*
							</xsl:otherwise>
						</xsl:choose>
						</label>
						<img src="{/page/@url}scripts/securecode.php"/>
						<input id="form-feedb-f5" name="securecode" value=""/>
						</div>
					</xsl:if>
					
					<div class="required">
						*&amp;nbsp;-&amp;nbsp;<xsl:value-of select="/page/content/localization/_fields"/>
					</div>
					
					<div class="btn"><input class="btn" type="submit" value="{/page/content/localization/_caption_send_request}"/></div>
					
					<input type="hidden" name="event" value="DoAddItem"/>
				</form>
			
		</xsl:for-each>
	</xsl:template>
</xsl:stylesheet>
