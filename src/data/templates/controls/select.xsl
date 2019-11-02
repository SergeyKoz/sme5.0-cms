<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:include href="elements/title.xsl"/>
	<xsl:include href="elements/options.xsl"/>
	<xsl:template match="select">
		<xsl:param name="class"/>
		<xsl:param name="disabled"/>
		<xsl:param name="onchange"/>
		<xsl:param name="id"/>
		<xsl:if test="title">
			<xsl:if test="title/align != 'right'">
				<xsl:apply-templates select="title"/>
			</xsl:if>
		</xsl:if>
		<select>
			<xsl:choose>
				<xsl:when test="multiple='1'">
					<xsl:attribute name="name"><xsl:value-of select="name"/>[]</xsl:attribute>
					<xsl:attribute name="size">10</xsl:attribute>
				</xsl:when>
				<xsl:otherwise>
					<xsl:attribute name="name"><xsl:value-of select="name"/></xsl:attribute>
				</xsl:otherwise>
			</xsl:choose>
			<xsl:if test="$onchange != ''">
				<xsl:attribute name="onchange"><xsl:value-of select="$onchange"/></xsl:attribute>
			</xsl:if>
			<xsl:if test="$class != ''">
				<xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
			</xsl:if>
			<xsl:if test="(multiple = 'yes') or (multiple = 1)">
				<xsl:attribute name="multiple"> </xsl:attribute>
			</xsl:if>
			<xsl:if test="size != ''">
				<xsl:attribute name="size"><xsl:value-of select="size"/></xsl:attribute>
			</xsl:if>
			<xsl:if test="(disabled = 'yes') or (disabled = 1) or $disabled = 'yes'">
				<xsl:attribute name="disabled"> </xsl:attribute>
			</xsl:if>
			<xsl:if test="event">
				<xsl:for-each select="event">
					<xsl:attribute name="{name}"><xsl:value-of select="value"/></xsl:attribute>
				</xsl:for-each>
			</xsl:if>
			<xsl:if test="onchange != ''">
				<xsl:attribute name="onchange"><xsl:value-of select="onchange"/></xsl:attribute>
			</xsl:if>
			<xsl:if test="$id != ''">
				<xsl:attribute name="id"><xsl:value-of select="$id"/></xsl:attribute>
			</xsl:if>
			<xsl:apply-templates select="options"/>
		</select>
		<xsl:if test="title">
			<xsl:if test="title/align = 'right'">
				<xsl:apply-templates select="title"/>
			</xsl:if>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
