<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template match="edit">
		<xsl:if test="langversion/control">
			<form class="form" action="?" method="post" name="editform">
				<input type="hidden" name="tab_id" value="{//edit/tab_id}"/>
				<input type="hidden" name="PHPSESSID" value="{/page/@session_id}"/>
				<xsl:for-each select="hiddens">
					<xsl:apply-templates select="hidden"/>
				</xsl:for-each>
				<xsl:for-each select="langversion">
					<xsl:variable name="login" select="control[*/name='user_login']"/>
					<xsl:variable name="password" select="control[*/name='user_password']"/>
					<xsl:variable name="email" select="control[*/name='email']"/>
					<xsl:variable name="name" select="control[*/name='name']"/>
					<xsl:variable name="phone" select="control[*/name='phone']"/>
					<xsl:variable name="additional" select="control[*/name='additional']"/>
					<label class="label">
						<strong>
							<xsl:choose>
								<xsl:when test="$login/*/error_field">
									<span class="red">
										<xsl:value-of select="$login/*/caption"/>:<span class="star">*</span>
									</span>
								</xsl:when>
								<xsl:otherwise>
									<xsl:value-of select="$login/*/caption"/>:<span class="star">*</span>
								</xsl:otherwise>
							</xsl:choose>
						</strong>
						<xsl:choose>
							<xsl:when test="$login/statictext">
								<em>
									<xsl:apply-templates select="$login"/>
								</em>
							</xsl:when>
							<xsl:otherwise>
								<xsl:apply-templates select="$login">
									<xsl:with-param name="class">txt</xsl:with-param>
									<xsl:with-param name="id"/>
								</xsl:apply-templates>
							</xsl:otherwise>
						</xsl:choose>
					</label>
					<label class="label">
						<strong>
							<xsl:choose>
								<xsl:when test="$password/*/error_field">
									<span class="red">
										<xsl:value-of select="$password/*/caption"/>:<span class="star">*</span>
									</span>
								</xsl:when>
								<xsl:otherwise>
									<xsl:value-of select="$password/*/caption"/>:<span class="star">*</span>
								</xsl:otherwise>
							</xsl:choose>
						</strong>
						<xsl:apply-templates select="$password">
							<xsl:with-param name="class">txt</xsl:with-param>
							<xsl:with-param name="id"/>
						</xsl:apply-templates>
						<br/>
					</label>
					<label class="label">
						<strong>
							<xsl:choose>
								<xsl:when test="$email/*/error_field">
									<span class="red">
										<xsl:value-of select="$email/*/caption"/>:<span class="star">*</span>
									</span>
								</xsl:when>
								<xsl:otherwise>
									<xsl:value-of select="$email/*/caption"/>:<span class="star">*</span>
								</xsl:otherwise>
							</xsl:choose>
						</strong>
						<xsl:apply-templates select="$email">
							<xsl:with-param name="class">txt</xsl:with-param>
							<xsl:with-param name="id"/>
						</xsl:apply-templates>
						<br/>
					</label>
					<label class="label">
						<strong>
							<xsl:choose>
								<xsl:when test="$name/*/error_field">
									<span class="red">
										<xsl:value-of select="$name/*/caption"/>:<span class="star">*</span>
									</span>
								</xsl:when>
								<xsl:otherwise>
									<xsl:value-of select="$name/*/caption"/>:<span class="star">*</span>
								</xsl:otherwise>
							</xsl:choose>
						</strong>
						<xsl:apply-templates select="$name">
							<xsl:with-param name="class">txt</xsl:with-param>
							<xsl:with-param name="id"/>
						</xsl:apply-templates>
						<br/>
					</label>
					
					<label class="label">
						<strong>
							<xsl:value-of select="$phone/*/caption"/>:
						</strong>
						<xsl:apply-templates select="$phone">
							<xsl:with-param name="class">txt</xsl:with-param>
							<xsl:with-param name="id"/>
						</xsl:apply-templates>
						<br/>
					</label>					
					<label class="label">
						<strong>
							<xsl:value-of select="$additional/*/caption"/>:
					</strong>
						<xsl:apply-templates select="$additional">
							<xsl:with-param name="class">textarea</xsl:with-param>
							<xsl:with-param name="id"/>
						</xsl:apply-templates>
						<br/>
					</label>
					<xsl:if test="/page/@user_id=''">
						<label class="label code">
							<strong>
								<xsl:choose>
									<xsl:when test="/page/content/securecode_error=1">
										<font color="red">
											<xsl:value-of select="/page/content/localization/_security_code"/>
											<span class="star">*</span>
										</font>
									</xsl:when>
									<xsl:otherwise>
										<xsl:value-of select="/page/content/localization/_security_code"/>
										<span class="star">*</span>
									</xsl:otherwise>
								</xsl:choose>:
						</strong>
							<img src="{/page/@url}scripts/securecode.php"/>
							<input name="securecode" value=""/>
						</label>
					</xsl:if>
					<div class="label required">
						<span class="star">*</span>&amp;nbsp;-&amp;nbsp;<xsl:value-of select="/page/content/localization/_fields"/>
					</div>
					<br/>
					<xsl:variable name="submit_button_text">
						<xsl:choose>
							<xsl:when test="/page/@user_id=''">
								<xsl:value-of select="/page/content/localization/_button_add"/>
							</xsl:when>
							<xsl:otherwise>
								<xsl:value-of select="/page/content/localization/_button_change"/>
							</xsl:otherwise>
						</xsl:choose>
					</xsl:variable>
					<div class="btn">
						<input class="btn" type="submit" value="{$submit_button_text}"/>
					</div>
				</xsl:for-each>
				<xsl:choose>
					<xsl:when test="/page/@user_id=''">
						<input type="hidden" name="event" value="DoAddItem"/>
					</xsl:when>
					<xsl:otherwise>
						<input type="hidden" name="event" value="DoEditItem"/>
					</xsl:otherwise>
				</xsl:choose>
			</form>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
