<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="UTF-8" omit-xml-declaration="yes" media-type="text/html"/>
	<!-- INCLUDING NAVIGATOR TEMPLATE-->
	<xsl:template name="news_block">
	
		

		<b><xsl:value-of select="/page/content/localization/_news_block_caption"/></b>
		<ul>
		<xsl:for-each select="/page/content/cms_publications/mapping[@system_name = 'news_block']/publication">
			<li>
				<xsl:call-template name="news_block_fields"/>
			</li>
		</xsl:for-each>
		</ul>
		<div>
			<a href="{/page/@url}{/page/@lng_url_prefix}{/page/content/cms_publications/mapping[@system_name = 'news_block']/@target_entry_point_url}">
				<xsl:value-of select="/page/content/localization/_all_news_caption"/>
			</a>
		</div>
	</xsl:template>
	
	<xsl:template name="news_block_fields">
		<xsl:variable name="field1" select="./field[@is_link=1 and @is_caption=1]"/>
		<xsl:variable name="value1" select="$field1/value"/>
			
		<xsl:variable name="field3" select="./field[@system_name='textarea']"/>
		<xsl:variable name="value3" select="$field3/value"/>			

		<xsl:variable name="field5" select="./field[@system_name='date']"/>
		<xsl:variable name="value5" select="$field5/value"/>
		
		<span class="date"><xsl:value-of select="$value5"/></span>
		
		<a>
			<xsl:if test="($field1/@is_link=1) and (./@publication_type != 0)">
				<xsl:attribute name="href">
					<xsl:value-of select="/page/@url"/><xsl:value-of select="/page/@lng_url_prefix"/>
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
					</xsl:choose>?pid=<xsl:value-of select="./@publication_id"/>
				</xsl:attribute>
			</xsl:if>
			<xsl:value-of select="$value1"/>
		</a><br/>
		
		<xsl:if test="$value3!=''">
			<xsl:value-of select="$value3" disable-output-escaping="yes"/>
		</xsl:if>
	
		
	</xsl:template>
	
</xsl:stylesheet>
