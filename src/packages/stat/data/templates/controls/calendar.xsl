<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
<!-- template for calendar control -->
    <xsl:template match="calendar">
    <style>
        .calendar_dow_hdr {
            color:#504090;
            font-weight: bold;
            border-bottom: 1px solid #e7e7d7;
            border-top: 1px solid #e7e7d7;
        }

        .calendar_dow_current {
            background-color: #e7e7d7;
            border-bottom: 1px solid #909090;
            border-top: 1px solid #909090;
            border-left: 1px solid #909090;
            border-right: 1px solid #909090;
        }

        .calendar_today_cell {
            border-top: 1px solid #e7e7d7;
        }
        .calendar_dow_outside_month {
            color:#909090;
        }
        .calendar_dow {
            text-decoration: none;
        }
        
        .calendar_navi {
            text-decoration: none;
        }
    </style>
        <table border="0" width="200" cellspacing="0">
            <tr>
				<td colspan="8" align="center">
                    <!-- link to prior month -->
                    <a href="{navigation/prior_month}" class="calendar_navi" >&lt;</a>
                    &#160;
                    <!-- localized caption of month -->
                    <a href="{date/monthCaption/@href}" class="calendar_navi" ><xsl:value-of select="date/monthCaption" /></a>
                    <!-- link to next month -->
                    &#160;
                    <a href="{navigation/next_month}" class="calendar_navi" >&gt;</a>
                    &#160;&#160;
                    <!-- link to prior year -->
                    <a href="{navigation/prior_year}" class="calendar_navi" >&lt;</a>
                    &#160;
                    <!-- year -->
                    <a href="{date/year/@href}" class="calendar_navi" ><xsl:value-of select="date/year" /></a>
                    &#160;
                    <!-- link to next month -->
                    <a href="{navigation/next_year}" class="calendar_navi" >&gt;</a>
				</td>
			</tr>
            <tr>
				<!-- draw localized weekdays captions -->
				<xsl:for-each select="localization/weekdays/day">
                    <td align="center" class="calendar_dow_hdr">
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
                                <xsl:attribute name="class">calendar_dow_current</xsl:attribute>
                            </xsl:if>
                            <xsl:choose>
                                <!-- @selected=1 if current day is selected -->
                                <xsl:when test="@selected=1">
                                    <b><a href="{@href}" class="calendar_dow"><xsl:value-of select="." /></a></b>
                                </xsl:when>
                                <xsl:otherwise>
                                    <xsl:choose>
                                        <!-- @outside=1 if current day not in current (selected) month -->
                                        <xsl:when test="@outside=1">
                                            <span class="calendar_dow_outside_month"><xsl:value-of select="." /></span>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <!-- day of current (selected) month -->
                                            <a href="{@href}" class="calendar_dow"><xsl:value-of select="." /></a>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </xsl:otherwise>
                            </xsl:choose>
                        </td>
                    </xsl:for-each>
                    </tr>
                </xsl:for-each>
            <tr>
				<td colspan="8" class="calendar_today_cell">
					<!-- link to select today -->
					<a href="{navigation/today}"><xsl:value-of select="localization/today" /></a>
				</td>
			</tr>
        </table>
    </xsl:template>

</xsl:stylesheet>
