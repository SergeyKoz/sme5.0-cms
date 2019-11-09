<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
<!-- template for calendar control -->
    <xsl:template match="calendar">
        <table border="1">
            <tr>
				<td colspan="8" align="center">
				<!-- link to prior month -->
				<a href="{navigation/prior_month}">&lt;</a>
                &#160;
				<!-- localized caption of month -->
				<a href="{date/monthCaption/@href}"><xsl:value-of select="date/monthCaption" /></a>
				<!-- link to next month -->
                &#160;
				<a href="{navigation/next_month}">&gt;</a>
				&#160;&#160;
				<!-- link to prior year -->
				<a href="{navigation/prior_year}">&lt;</a>
                &#160;
				<!-- year -->
				<a href="{date/year/@href}"><xsl:value-of select="date/year" /></a>
                &#160;
				<!-- link to next month -->
				<a href="{navigation/next_year}">&gt;</a>
				</td>
			</tr>
            <tr>
				<!-- draw localized weekdays captions -->
				<xsl:for-each select="localization/weekdays/day">
                    <td align="center" width="20">
                        <xsl:value-of select="." />
                    </td>
                </xsl:for-each>
            </tr>
			<!-- draw calendar -->
				<xsl:for-each select="week">
                    <tr>
                    <xsl:for-each select="day">
                        <td align="center">
                            <!-- @today=1 if current day is today -->
                            <xsl:if test="@today=1">
                                <xsl:attribute name="bgColor">#F7F7EF</xsl:attribute>
                            </xsl:if>
                            <xsl:choose>
                                <!-- @selected=1 if current day is selected -->
                                <xsl:when test="@selected=1">
                                    [<a href="{@href}"><xsl:value-of select="." /></a>]
                                </xsl:when>
                                <xsl:otherwise>
                                    <xsl:choose>
                                        <!-- @outside=1 if current day not in current (selected) month -->
                                        <xsl:when test="@outside=1">
                                            <xsl:value-of select="." />
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <!-- day of current (selected) month -->
                                            <a href="{@href}"><xsl:value-of select="." /></a>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </xsl:otherwise>
                            </xsl:choose>
                        </td>
                    </xsl:for-each>
                    </tr>
                </xsl:for-each>
            <tr>
				<td colspan="8">
					<!-- link to select today -->
					<a href="{navigation/today}"><xsl:value-of select="localization/today" /></a>
				</td>
			</tr>
        </table>
    </xsl:template>

</xsl:stylesheet>
