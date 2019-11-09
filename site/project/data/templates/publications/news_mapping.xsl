<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="UTF-8" omit-xml-declaration="yes" media-type="text/html"/>
	<!-- INCLUDING NAVIGATOR TEMPLATE-->
	<xsl:template name="news_mapping">
		<xsl:for-each select="/page/content/cms_publications/mapping[@system_name = 'news_list' or @system_name = 'news']">
				<xsl:if test="./@publication_type=0">
					<xsl:for-each select="publication">
						<xsl:call-template name="news_fields"/>
					</xsl:for-each>
				</xsl:if>
				<xsl:if test="./@publication_type=2">
					<div rel="SME:&amp;#123;'mode':'mapping', 'item_id':{item_id}&amp;#125;">
						<xsl:for-each select="publication">
							<xsl:call-template name="news_list_fields"/>
						</xsl:for-each>
													
						<xsl:apply-templates select="navigator"/>
					</div>
				</xsl:if>
		</xsl:for-each>
	</xsl:template>
	
	<xsl:template name="news_list_fields">
		<xsl:variable name="field1" select="./field[@is_link=1 and @is_caption=1 and @param_name='title']"/>
		<xsl:variable name="value1" select="$field1/value"/>
		
		<xsl:variable name="field2" select="./field[@system_name='picture']"/>
		<xsl:variable name="value2" select="$field2/value"/>
		
		<xsl:variable name="field3" select="./field[@system_name='textarea']"/>
		<xsl:variable name="value3" select="$field3/value"/>
		
		<xsl:variable name="field5" select="./field[@system_name='date']"/>
		<xsl:variable name="value5" select="$field5/value"/>
		
		
		<xsl:if test="$value5!=''">
			<span class=""><xsl:value-of select="$value5" disable-output-escaping="yes"/></span>
		</xsl:if>
		
		<xsl:variable name="url"><xsl:value-of select="/page/@url"/>
			<xsl:value-of select="/page/@lng_url_prefix"/>
			<xsl:choose>
				<xsl:when test="./@target_entry_point_url">
					<xsl:value-of select="./@target_entry_point_url"/>
				</xsl:when>
				<xsl:otherwise>
					<xsl:choose>
						<xsl:when test="../@target_entry_point_url">
							<xsl:value-of select="../@target_entry_point_url"/>
						</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="/page/@request_url"/>
						</xsl:otherwise>
					</xsl:choose>
				</xsl:otherwise>
			</xsl:choose>
		</xsl:variable>
		
		<b>
			<a>
				<xsl:if test="($field1/@is_link=1) and (./@publication_type != 0)">
					<xsl:attribute name="href">
						<xsl:value-of select="$url"/>?pid=<xsl:value-of select="./@publication_id"/>
					</xsl:attribute>
				</xsl:if>
				<xsl:value-of select="$value1"/>
			</a>
		</b><br/>

		<xsl:if test="$value2!=''">
			<img class="img" src="{/page/settings/filestorageurl}{$value2}" alt="{$value1}"/><br/>
		</xsl:if>
		
		<xsl:if test="$value3!=''">
			<div class=""><xsl:value-of select="$value3" disable-output-escaping="yes"/><br/></div>
		</xsl:if>
		
		<xsl:if test="./tags/tag!=''">
			<div class="tags">
			<b><xsl:value-of select="/page/content/localization/_tag_caption"/></b>:
			<xsl:for-each select="./tags/tag">
				<a href="{/page/@url}{/page/@lng_url_prefix}tags/?tag={@encode}"><xsl:value-of select="."/></a><xsl:if test="position()!=last()">, </xsl:if>
			</xsl:for-each>
			</div>
			<br/>
		</xsl:if>
		
	</xsl:template>
	
	<xsl:template name="news_fields">
		<div>
		 	<xsl:if test="./@is_category=0">
		 		<xsl:attribute name="rel">SME:{'mode':'publication', 'item_id':<xsl:value-of select="@publication_id"/>};</xsl:attribute>
		 	</xsl:if>
			<xsl:if test="field">
				<xsl:variable name="field1" select="./field[@system_name='text']"/>
				<xsl:variable name="value1" select="$field1/value"/>
				
				<xsl:variable name="field2" select="./field[@system_name='date']"/>
				<xsl:variable name="value2" select="$field2/value"/>
				
				<xsl:variable name="field3" select="./field[@system_name='spaweditor']"/>
				<xsl:variable name="value3" select="$field3/value"/>
				
				<xsl:variable name="field5" select="./field[@system_name='url']"/>
				<xsl:variable name="value5" select="$field5/value"/>
				<xsl:variable name="caption5" select="$field5/caption"/>
				
				<xsl:variable name="field6" select="./field[@system_name='text' and @param_name='source']"/>
				<xsl:variable name="value6" select="$field6/value"/>		
				<xsl:variable name="caption6" select="$field6/caption"/>
			
				<xsl:value-of select="$value2"/><b><xsl:value-of select="$value1"/></b><br/>
				
				<div class=""><xsl:value-of select="$value3" disable-output-escaping="yes"/></div><br/>
				
				<xsl:choose>
					<xsl:when test="$value5!='' and $value6!=''">
						<div class="tags">
							<b><xsl:value-of select="/page/content/localization/_source"/>:</b>&amp;nbsp;
							<a href="{$value5}" target="_blank"><xsl:value-of select="$value6"/></a>
						</div>
					</xsl:when>			
					<xsl:when test="$value6!=''">
						<div class="tags">
						<b>
						<xsl:value-of select="/page/content/localization/_source"/>:</b>&amp;nbsp;
						<xsl:value-of select="$value6"/>
						</div>
					</xsl:when>
					<xsl:when test="$value5!=''">
					<div class="">
						<b>
							<xsl:value-of select="/page/content/localization/_source"/>:</b>&amp;nbsp;
							<a href="{$value5}" target="_blank"><xsl:value-of select="$value5"/></a>
						</div>
					</xsl:when>			
				</xsl:choose>		
				
				<xsl:if test="./tags/tag!=''">
					<div class="">
						<b><xsl:value-of select="/page/content/localization/_tag_caption"/></b>:
						<xsl:for-each select="./tags/tag">
							<a href="{/page/@url}{/page/@lng_url_prefix}tags/?tag={@encode}"><xsl:value-of select="."/></a><xsl:if test="position()!=last()">, </xsl:if>
						</xsl:for-each>
					</div>
				</xsl:if>
				
				<xsl:variable name="url">
					<xsl:value-of select="/page/@lng_url_prefix"/>
					<xsl:choose>
						<xsl:when test="./@target_entry_point_url">
							<xsl:value-of select="./@target_entry_point_url"/>?pid=<xsl:value-of select="./@publication_id"/>
						</xsl:when>
						<xsl:otherwise>
							<xsl:choose>
								<xsl:when test="../../mapping[@system_name = 'news_list']/@target_entry_point_url">
									<xsl:value-of select="../../mapping[@system_name = 'news_list']/@target_entry_point_url"/>?pid=<xsl:value-of select="./@publication_id"/>
								</xsl:when>
								<xsl:otherwise>
									<xsl:value-of select="/page/@request_url"/>
								</xsl:otherwise>
							</xsl:choose>
						</xsl:otherwise>
					</xsl:choose>
				</xsl:variable>
				
				<xsl:if test="@publication_disable_comments=0 and @mapping_enable_comments=1 and /page/content/cms_comments">	
					<xsl:call-template name="comments">
						<xsl:with-param name="article" select="@publication_id"/>
						<xsl:with-param name="module">publications</xsl:with-param>
						<xsl:with-param name="url" select="$url"/>
					</xsl:call-template>
				</xsl:if>
				
				
			</xsl:if>
		</div>

		
	</xsl:template>

	
</xsl:stylesheet>
