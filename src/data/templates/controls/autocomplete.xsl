<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template match="autocomplete">
		<xsl:param name="class"/>
		<xsl:param name="size"/>
		<xsl:param name="style"/>
		<xsl:param name="id"/>
		<xsl:param name="disabled"/>
		
		<xsl:variable name="_id">
			<xsl:choose>
				<xsl:when test="$id!=''"><xsl:value-of select="$id"/></xsl:when>
				<xsl:otherwise><xsl:value-of select="name"/>_id</xsl:otherwise>
			</xsl:choose>
		</xsl:variable>
				
		<xsl:if test="$disabled!='yes'">
			<script type="">
				function <xsl:value-of select="name"/>_liFormat (row, i, num) {
					var result = row[0];
					return result;
				}
				
				function <xsl:value-of select="name"/>_selectItem(li) {
				}
			</script>
		</xsl:if>

		<xsl:variable name="fieldlibrary" select="../../../hiddens/hidden[name='library']/value"/>
		<xsl:variable name="fieldpackage" select="../../../hiddens/hidden[name='package']/value"/>
		<xsl:variable name="fieldname" select="name"/>
		<xsl:variable name="wordsfield" select="words_field"/>
		<xsl:variable name="extraParamsString">{package:"libraries", page:"autocomplete", ac_package:"<xsl:value-of select="$fieldpackage"/>", ac_library:"<xsl:value-of select="$fieldlibrary"/>", ac_page:"<xsl:value-of select="/page/@name"/>"<xsl:if test="field_table!=''">, ac_field_table:"<xsl:value-of select="field_table"/>" </xsl:if>, ac_field_name:"<xsl:value-of select="name"/>" <xsl:if test="words_field!=''">, ac_words_field:"<xsl:value-of select="words_field"/>" </xsl:if>
			<xsl:if test="words_delimeter!=''">, ac_words_delimeter:"<xsl:value-of select="words_delimeter"/>"</xsl:if>
			<xsl:if test="autocomplete_method!=''">, ac_autocomplete_method:"<xsl:value-of select="autocomplete_method"/>"</xsl:if><xsl:if test="parameters/parameter">, </xsl:if><xsl:for-each select="parameters/parameter"><xsl:value-of select="@name"/>:"<xsl:value-of select="."/>"<xsl:if test="position()!=last()">, </xsl:if></xsl:for-each>}</xsl:variable>
				
		<input type="text" name="{$fieldname}" value="{value}" disable-output-escaping="yes" size="100" id="{$_id}">
			<xsl:if test="$class != ''">
				<xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
			</xsl:if>
			<xsl:if test="$style != ''">
				<xsl:attribute name="style"><xsl:value-of select="$style"/></xsl:attribute>
			</xsl:if>
			<xsl:if test="$disabled = 'yes'">
				<xsl:attribute name="disabled"> </xsl:attribute>
			</xsl:if>
			<xsl:if test="size != ''">
				<xsl:attribute name="size"><xsl:value-of select="size"/></xsl:attribute>
			</xsl:if>
			<xsl:if test="$size != ''">
				<xsl:attribute name="size"><xsl:value-of select="$size"/></xsl:attribute>
			</xsl:if>
		</input>
		
		
		<xsl:if test="$disabled != 'yes'">
			<script type="">						
				var <xsl:value-of select="$fieldname"/>_extraParams=<xsl:value-of select="$extraParamsString"/>;							
				$(document).ready(function(){
				  $("#<xsl:value-of select="$_id"/>").autocomplete("<xsl:value-of select="/page/@url"/>extranet/frame.php", {
				    delay:10,
				    minChars:1,
				    matchSubset:false,
				    autoFill:true,
				    matchContains:false,
				    cacheLength:10,
				    selectFirst:true,
				    formatItem:<xsl:value-of select="name"/>_liFormat,
				    <xsl:if test="multiple=1">multiple: true,</xsl:if>
				    maxItemsToShow:10,
				    onItemSelect:<xsl:value-of select="name"/>_selectItem,
				    extraParams : <xsl:value-of select="$fieldname"/>_extraParams
				  });
				});
			</script>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
