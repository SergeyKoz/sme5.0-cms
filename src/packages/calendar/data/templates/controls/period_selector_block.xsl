<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="yes"  media-type="text/html"/>

    <!-- Include controls -->
    <xsl:include href="date_period.xsl"/>
    <xsl:include href="calendar.xsl"/>
    <xsl:include href="period_info.xsl"/>

    <xsl:template name="period_selector_block">
       <table border="0" width="100%">
            <tr>
                <td valign="top">
                    <table width="100%" height="100" border="0">
                        <tr>
                            <td valign="top">
                                <!-- date period control -->
                                <xsl:apply-templates select="date_period"/>
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="10%" valign="top">
                    <!-- calendar control -->
                    <xsl:apply-templates select="calendar"/>
                </td>
            </tr>
        </table>
    </xsl:template>
    
</xsl:stylesheet>
