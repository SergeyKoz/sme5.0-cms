<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no"  media-type="text/html"/>

    <!-- Administrator section layout stylesheet -->
    <xsl:include href="layouts/layout.xsl"/>
    <xsl:include href="blocks/debug.xsl"/>
    <xsl:include href="blocks/errors.xsl"/>
    
    <xsl:include href="controls/diagram.xsl"/>
    <!-- Include controls -->
    <xsl:include href="controls/date_period.xsl"/>
    <xsl:include href="controls/calendar.xsl"/>
    <xsl:include href="controls/period_info.xsl"/>

    <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    <xsl:template match="content">
    <style>
      .diagram_table {
        border-top: 1px solid #ffffff;
        border-bottom: 1px solid #ffffff;
        border-left: 1px solid #ffffff;
        border-right: 1px solid #ffffff;
      }
      
      .diagram_table_bar_cell {
        background-color: #e4e0d8;
        border-bottom: 1px solid #ffffff;
      }
      .diagram_table_legend_cell {
        background-color: #e4e0d8;
        border-top: 1px solid #ffffff;
      }
      .diagram_title {
            font-size: 11pt;
            font-family: arial, tahoma, verdana, sans-serif;
            color: #102f68;
            font-weight: bold;
      }
    </style>
    <table width="100%">
    <tr>
      <td style="padding-left: 6px;" cellspacing="0">
        <span class="mainheader">
        	<xsl:call-template name="period_info" />
        </span>

        <table border="0" width="100%" cellspacing="0">
            <tr>
            <td>
                <table border="0">
                    <!-- stat first visit date -->
                    <tr>
                        <td width="250"><xsl:value-of select="//_stat_first_visit_caption" /></td>
                        <td><b><xsl:value-of select="stat/first_visit" /></b></td>
                    </tr>
                    <!-- stat first visit date -->
                    <tr>
                        <td><xsl:value-of select="//_stat_last_visit_caption" /></td>
                        <td><b><xsl:value-of select="stat/last_visit" /></b></td>
                    </tr>
                    <!-- stat available days -->
                    <tr>
                        <td><xsl:value-of select="//_stat_avail_days_caption1" /></td>
                        <td><b><xsl:value-of select="stat/stat_days" /></b>&amp;nbsp;
                            <xsl:value-of select="//_stat_avail_days_caption2" />
                        </td>
                    </tr>
                    <!-- hits -->
                    <tr>
                        <td><xsl:value-of select="//_stat_hits_caption" /></td>
                        <td><b><xsl:value-of select="stat/hits" /></b></td>
                    </tr>
                    <!-- hosts -->
                    <tr>
                        <td><xsl:value-of select="//_stat_hosts_caption" /></td>
                        <td><b><xsl:value-of select="stat/hosts" /></b></td>
                    </tr>
                    <!-- transfers -->
                    <tr>
                        <td><xsl:value-of select="//_stat_transfers_caption" /></td>
                        <td><b><xsl:value-of select="stat/transfers" /></b></td>
                    </tr>
                    <!-- max visits and date of it -->
                    <tr>
                        <td><xsl:value-of select="//_stat_max_visits_caption" /></td>
                        <td><b><xsl:value-of select="stat/max_hits/count" /></b>&amp;nbsp;
                            (<xsl:value-of select="stat/max_hits/date" />)
                        </td>
                    </tr>
                    
            </table>
            <hr />
                <table border="0">
                    <!-- hits in period -->
                    <tr>
                        <td width="250"><xsl:value-of select="//_stat_period_hits_caption" /></td>
                        <td><b><xsl:value-of select="stat/period_hits" /></b></td>
                    </tr>
                <!-- hosts in period -->
                    <tr>
                        <td><xsl:value-of select="//_stat_period_hosts_caption" /></td>
                        <td><b><xsl:value-of select="stat/period_hosts" /></b></td>
                    </tr>
                    <!-- transfers in period -->
                    <tr>
                        <td><xsl:value-of select="//_stat_period_transfers_caption" /></td>
                        <td><b><xsl:value-of select="stat/period_transfers" /></b></td>
                    </tr>
                </table>
            </td>
            <td valign="top">
                <table border="0" width="100%" cellspacing="0">
                    <tr>
                        <td valign="top" align="right">
                            <!-- date period control -->
                            <xsl:apply-templates select="date_period"/>
                        </td>
                    </tr>
                    <tr>
                        <td width="10%" align="right">
                            <!-- calendar control -->
                            <xsl:apply-templates select="calendar"/>
                        </td>
                    </tr>
                </table>


            </td>
            </tr>
        </table>

        <br />
        <hr />

        <!-- Hourly diagram -->
        <br />
        <br />
        <span class="diagram_title">
            <xsl:value-of select="//_diagram_hourly_title" />
        </span>
        &amp;nbsp;
        &amp;nbsp;
        [<a href="?package=stat&amp;library=stat&amp;page=stat&amp;action=dia_data_hourly" target="_blank"><xsl:value-of select="//_stat_view_detailed_data" /></a>]
        
        <xsl:call-template name="draw_diagram">
            <xsl:with-param name="diagram_name">diagram_hourly</xsl:with-param>
            <xsl:with-param name="diagram_cell_width">25</xsl:with-param>
            <xsl:with-param name="diagram_bars_width">6</xsl:with-param>
        </xsl:call-template>
        <br />
        <hr />
        <!-- Weekly diagram -->
        <span class="diagram_title">
            <xsl:value-of select="//_diagram_weekly_title" />
        </span>
        &amp;nbsp;
        &amp;nbsp;
        [<a href="?package=stat&amp;library=stat&amp;page=stat&amp;action=dia_data_weekly" target="_blank"><xsl:value-of select="//_stat_view_detailed_data" /></a>]
        <xsl:call-template name="draw_diagram">
            <xsl:with-param name="diagram_name">diagram_weekly</xsl:with-param>
            <xsl:with-param name="diagram_cell_width">94</xsl:with-param>
            <xsl:with-param name="diagram_bars_width">18</xsl:with-param>
        </xsl:call-template>
        <br />
        <hr />
        <!-- Monthly diagram -->
        <span class="diagram_title">
            <xsl:value-of select="//_diagram_monthly_title" />
        </span>
        &amp;nbsp;
        &amp;nbsp;
        [<a href="?package=stat&amp;library=stat&amp;page=stat&amp;action=dia_data_monthly" target="_blank"><xsl:value-of select="//_stat_view_detailed_data" /></a>]
        <xsl:call-template name="draw_diagram">
            <xsl:with-param name="diagram_name">diagram_monthly</xsl:with-param>
            <xsl:with-param name="diagram_cell_width">53</xsl:with-param>
            <xsl:with-param name="diagram_bars_width">12</xsl:with-param>
        </xsl:call-template>
        <br />
        <hr />
        <!-- Daily diagram -->
        <span class="diagram_title">
            <xsl:value-of select="//_diagram_daily_title" />
        </span>
        &amp;nbsp;
        &amp;nbsp;
        [<a href="?package=stat&amp;library=stat&amp;page=stat&amp;action=dia_data_daily" target="_blank"><xsl:value-of select="//_stat_view_detailed_data" /></a>]
        <xsl:call-template name="draw_diagram">
            <xsl:with-param name="diagram_name">diagram_daily</xsl:with-param>
            <xsl:with-param name="diagram_cell_width">18</xsl:with-param>
            <xsl:with-param name="diagram_bars_width">6</xsl:with-param>
        </xsl:call-template>
        <br />
        <hr />
        <!-- Yearly diagram -->
        <span class="diagram_title">
            <xsl:value-of select="//_diagram_yearly_title" />
        </span>
        &amp;nbsp;
        &amp;nbsp;
        [<a href="?package=stat&amp;library=stat&amp;page=stat&amp;action=dia_data_yearly" target="_blank"><xsl:value-of select="//_stat_view_detailed_data" /></a>]
        <xsl:call-template name="draw_diagram">
            <xsl:with-param name="diagram_name">diagram_yearly</xsl:with-param>
            <xsl:with-param name="diagram_cell_width">90</xsl:with-param>
            <xsl:with-param name="diagram_bars_width">18</xsl:with-param>
        </xsl:call-template>
        <br />
      </td>
    </tr>
    </table>
    </xsl:template>
    
</xsl:stylesheet>

  