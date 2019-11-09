<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template match="datetime">
		<xsl:param name="class"/>
		<xsl:param name="disabled"/>
		<xsl:param name="date_flag"/>
		<xsl:param name="entry"/>
		<xsl:if test="days">
			<select name="day{$date_flag}" id="day{$date_flag}">
				<xsl:if test="$class != ''">
					<xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
				</xsl:if>
				<xsl:if test="(disabled = 'yes') or (disabled = 1) or $disabled ='yes'">
					<xsl:attribute name="disabled"> </xsl:attribute>
				</xsl:if>
				
				<option value="0">
					<xsl:value-of select="$entry/day_default"/>
				</option>
				
				<xsl:for-each select="days/day">
					<option value="{.}">
						<xsl:if test="./@selected">
							<xsl:attribute name="selected"> </xsl:attribute>
						</xsl:if>
						<xsl:value-of select="."/>
					</option>
				</xsl:for-each>
			</select>
		</xsl:if>
		<xsl:if test="months">
			<select name="mon{$date_flag}" id="month{$date_flag}">
				<xsl:if test="$class != ''">
					<xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
				</xsl:if>
				<xsl:if test="(disabled = 'yes') or (disabled = 1) or $disabled ='yes'">
					<xsl:attribute name="disabled"> </xsl:attribute>
				</xsl:if>
				<xsl:if test="$date_flag=1">
					<option value="0">
						<xsl:value-of select="$entry/mon_default"/>
					</option>
				</xsl:if>
				<xsl:for-each select="months/month">
					<option value="{.}">
						<xsl:if test="./@selected">
							<xsl:attribute name="selected"> </xsl:attribute>
						</xsl:if>
						<xsl:variable name="m_pos" select="."/>
						<xsl:value-of select="$entry/months/month[@mid=$m_pos]"/>
					</option>
				</xsl:for-each>
			</select>
		</xsl:if>
		<xsl:if test="years">
			<select name="year{$date_flag}" id="year{$date_flag}">
				<xsl:if test="$class != ''">
					<xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
				</xsl:if>
				<xsl:if test="(disabled = 'yes') or (disabled = 1) or $disabled ='yes'">
					<xsl:attribute name="disabled"> </xsl:attribute>
				</xsl:if>
				<xsl:if test="$date_flag=1">
					<option value="0">
						<xsl:value-of select="$entry/year_default"/>
					</option>
				</xsl:if>
				<xsl:for-each select="years/year">
					<option value="{.}">
						<xsl:if test="./@selected">
							<xsl:attribute name="selected"> </xsl:attribute>
						</xsl:if>
						<xsl:value-of select="."/>
					</option>
				</xsl:for-each>
			</select>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
