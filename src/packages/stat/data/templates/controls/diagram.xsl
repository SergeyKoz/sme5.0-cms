<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no"  media-type="text/html"/>

    <xsl:template name="draw_diagram">
            <xsl:param name="diagram_name"/>
            <xsl:param name="diagram_cell_width"/>
            <xsl:param name="diagram_bars_width"/>

        <!-- set to desired values -->
        <xsl:variable name="diagram_cell_spacing" select="2" />
        <xsl:variable name="diagram_bars_height" select="150" />
        <xsl:choose>
            <xsl:when test="//diagram/data[@id=$diagram_name]/abs_max_value=0 or //diagram/data[@id=$diagram_name]/values_count=0">
                <table width="100%" class="diagram_table" cellspacing="10">
                <tr heigth="80"><td valign="middle">
                    <b><xsl:value-of select="//_diagram_nodata" /></b>
                </td></tr>
                </table>
            </xsl:when>
            <xsl:otherwise>
                <table class="diagram_table" cellspacing="{$diagram_cell_spacing}">
                <tr>
                    <!-- draw values -->
                    <xsl:for-each select="//diagram/data[@id=$diagram_name]/item">
                        <td valign="bottom" width="{$diagram_cell_width}" align="center" class="diagram_table_bar_cell">
                            <!-- draw multiple value bars -->
                            <xsl:for-each select="value">
                                <xsl:choose>
                                    <!-- if value is "0" - draw blank (transparent image) -->
                                    <xsl:when test="norm * $diagram_bars_height = 0">
                                        <img src="{//package/@url}/img/blank.gif" width="{$diagram_bars_width}" height="{$diagram_bars_height}"/>
                                    </xsl:when>
                                    <xsl:otherwise>
                                        <!-- draw diagram bar, position() - number of bar in set -->
                                        <xsl:choose>
                                            <xsl:when test="position() = 1">
                                                <img src="{//package/@url}/img/graph_bar1.gif" width="{$diagram_bars_width}" height="{norm * $diagram_bars_height}" title="{abs}" />
                                            </xsl:when>
                                            <xsl:when test="position() = 2">
                                                <img src="{//package/@url}/img/graph_bar2.gif" width="{$diagram_bars_width}" height="{norm * $diagram_bars_height}" title="{abs}" />
                                            </xsl:when>
                                            <xsl:when test="position() = 3">
                                                <img src="{//package/@url}/img/graph_bar3.gif" width="{$diagram_bars_width}" height="{norm * $diagram_bars_height}" title="{abs}" />
                                            </xsl:when>
                                        </xsl:choose>
                                    </xsl:otherwise>
                                </xsl:choose>
                            </xsl:for-each>
                        </td>
                    </xsl:for-each>
                </tr>
                <tr>
                    <!-- draw caption of values -->
                    <xsl:for-each select="//diagram/data[@id=$diagram_name]/item">
                        <td align="center">
                            <xsl:value-of select="caption" />
                        </td>
                    </xsl:for-each>
                </tr>
                <tr>
                    <td class="diagram_table_legend_cell" colspan="{//diagram/data[@id=$diagram_name]/values_count}" style="padding-left:6">
                        <img src="{//package/@url}/img/graph_bar1.gif" width="8" height="8" />
                        - <xsl:value-of select="//diagram/data[@id=$diagram_name]/localization/hosts" />
                        &amp;nbsp;
                        <img src="{//package/@url}/img/graph_bar2.gif" width="8" height="8" />
                        - <xsl:value-of select="//diagram/data[@id=$diagram_name]/localization/hits" />
                        &amp;nbsp;
                        <img src="{//package/@url}/img/graph_bar3.gif" width="8" height="8" />
                        - <xsl:value-of select="//diagram/data[@id=$diagram_name]/localization/refs" />
                        &amp;nbsp;
                    </td>
                </tr>
                </table>
                
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>


</xsl:stylesheet>

  