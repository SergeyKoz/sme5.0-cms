<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no"  media-type="text/html"/>
    
    <!-- Administrator section layout stylesheet -->
    <xsl:include href="layouts/layout.xsl"/>
    <xsl:include href="blocks/debug.xsl"/>
    <xsl:include href="blocks/errors.xsl"/>
    
    <!-- Include controls -->
    <xsl:include href="controls/period_selector_block.xsl"/>

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
    </style>
    <table width="100%">
    <tr>
      <td style="padding-left: 6px;">
        <span class="mainheader">
            <!-- title -->
            <xsl:value-of select="//diagram_header/title" />
            <xsl:choose>
                <!-- period -->
                <xsl:when test="//diagram_header/period_start != ''">
                    (<xsl:value-of select="//diagram_header/period_start" />
                    -
                    <xsl:value-of select="//diagram_header/period_end" />)
                </xsl:when>
                <xsl:otherwise>
                <!-- period - whole -->
                    (<xsl:value-of select="//_diagram_period_whole" />)
                </xsl:otherwise>
            </xsl:choose>
            
        </span>
            <!-- stat data -->
            <table class="diagram_table" cellspacing="1">
            <tr>
            <!-- draw captions of columns -->
            <xsl:for-each select="//diagram_header/caption">
                <td width="80" align="center">
                    <b><xsl:value-of select="." /></b>
                </td>
            </xsl:for-each>
            </tr>
            <!-- stat data -->
            <xsl:for-each select="//diagram/data/item">
                <tr>
                <xsl:choose>
                    <xsl:when test="position() mod 2 = 1">
                        <xsl:attribute name="bgcolor">#FFFFFF</xsl:attribute>
                    </xsl:when>
                    <xsl:otherwise>
                        <xsl:attribute name="bgcolor">#F0F0F0</xsl:attribute>
                    </xsl:otherwise>
                </xsl:choose>
                    <td align="center">
                        <xsl:value-of select="caption" />
                    </td>
                    <xsl:for-each select="value">
                    <td align="center">
                        <xsl:value-of select="abs" />
                    </td>
                    </xsl:for-each>
                </tr>
            </xsl:for-each>
            </table>
      </td>
    </tr>
    </table>
    </xsl:template>
    
</xsl:stylesheet>

  