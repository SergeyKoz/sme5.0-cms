<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no"  media-type="text/html"/>
    <!-- verbal info about selected period -->
    <xsl:template name="period_info">
      <xsl:value-of select="//date_period/localization/period_title" />&#160;
      <xsl:choose>
        <xsl:when test="//date_period/periodSelector=0">
            <xsl:choose>
                <xsl:when test="//calendar/mode=1">
                    <!-- if calendar mode "day" -->
                    <xsl:value-of select="//date_period/localization/period_day" />
                    &#160;
                    (<xsl:value-of select="//date_period/start/day" />.<xsl:value-of select="//date_period/start/month" />.<xsl:value-of select="//date_period/start/year" />)
                </xsl:when>
                <xsl:when test="//calendar/mode=2">
                    <!-- if calendar mode "week" -->
                    <xsl:value-of select="//date_period/localization/period_week" />
                    <xsl:call-template name="period_description" />
                </xsl:when>
                <xsl:when test="//calendar/mode=3">
                    <!-- if calendar mode "month" -->
                    <xsl:value-of select="//date_period/localization/period_month" />
                    &#160;
                    (<xsl:value-of select="//calendar/date/monthCaption" />)
                </xsl:when>
                <xsl:when test="//calendar/mode=4">
                    <!-- if calendar mode "year" -->
                    <xsl:value-of select="//date_period/localization/period_year" />
                    &#160;
                    (<xsl:value-of select="//calendar/date/year" />)
                </xsl:when>
                <xsl:otherwise>
                    <!-- if calendar mode "custom period" -->
                    <xsl:value-of select="//date_period/localization/period_custom" />
                    <xsl:call-template name="period_description" />
                </xsl:otherwise>
            </xsl:choose>
        </xsl:when>
        <xsl:when test="//date_period/periodSelector=1">
            <xsl:value-of select="//date_period/localization/period_last7" />
            <xsl:call-template name="period_description" />
        </xsl:when>
        <xsl:when test="//date_period/periodSelector=2">
            <xsl:value-of select="//date_period/localization/period_last30" />
            <xsl:call-template name="period_description" />
        </xsl:when>
        <xsl:when test="//date_period/periodSelector=3">
            <xsl:value-of select="//date_period/localization/period_last90" />
            <xsl:call-template name="period_description" />
        </xsl:when>
        <xsl:when test="//date_period/periodSelector=4">
            <xsl:value-of select="//date_period/localization/period_last365" />
            <xsl:call-template name="period_description" />
        </xsl:when>
        <xsl:when test="//date_period/periodSelector=5">
            <xsl:value-of select="//date_period/localization/period_all" />
        </xsl:when>
      </xsl:choose>
    </xsl:template>
    <xsl:template name="period_description">
       (<xsl:value-of select="//date_period/localization/caption_from" /> 
        &#160;
       <xsl:value-of select="//date_period/start/day" />.<xsl:value-of select="//date_period/start/month" />.<xsl:value-of select="//date_period/start/year" /> 
        &#160;
       <xsl:value-of select="//date_period/localization/caption_to" />
        &#160;
       <xsl:value-of select="//date_period/end/day" />.<xsl:value-of select="//date_period/end/month" />.<xsl:value-of select="//date_period/end/year" />)
    </xsl:template>
    
</xsl:stylesheet>

  