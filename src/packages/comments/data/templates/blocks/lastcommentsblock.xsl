<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template name="lastcomments">
		<xsl:if test="/page/content/last_comments_block/comment">
			<b>Latest comments</b><br/>
			<xsl:for-each select="/page/content/last_comments_block/comment">
				<a href="{/page/@url}{article_url}"><b><xsl:value-of select="article_title"/></b></a><br/>
				
				<xsl:variable name="sign">
					<xsl:choose>
						<xsl:when test="contains(article_url, '?')">&amp;</xsl:when>
						<xsl:otherwise>?</xsl:otherwise>
					</xsl:choose>
				</xsl:variable>

				
				<a href="{/page/@url}{article_url}{$sign}{module}{article_id}comment={comment_id}#comment_{comment_id}"><xsl:value-of select="comment"/></a><br/>
				<xsl:variable name="author">
					<xsl:choose>
						<xsl:when test="author!=''"><xsl:value-of select="author"/></xsl:when>
						<xsl:when test="author_name!=''"><xsl:value-of select="author_name"/></xsl:when>
					</xsl:choose>
				</xsl:variable>
				
				Autor:<xsl:value-of select="$author"/><br/>
				
				<br/>								
			</xsl:for-each>
		</xsl:if>
	</xsl:template>	
</xsl:stylesheet>
