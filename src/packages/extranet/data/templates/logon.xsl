<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no"  media-type="text/html"/>

    <!-- Administrator section layout stylesheet -->
    <xsl:include href="layouts/layout.xsl"/>
    <xsl:include href="blocks/errors.xsl"/>
    <xsl:include href="blocks/debug.xsl"/>
    
    <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    

    <xsl:template match="content">
        <form action="" method="post">
            <input type="hidden" name="event" value="Process"/>
            <input type="hidden" name="page" value="extranetlogon"/>
            <input type="hidden" name="camefrom" value="{camefrom}"/>
            <input type="hidden" name="query" value="{query}"/>
            <table>
                <tr>
                    <td>Login</td>
                    <td><input type="text" name="login" value="{formLogin}"/></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password"/></td>
                </tr>
                <tr><td colspan="2"><input type="submit" value="Logon"/></td></tr>
            </table>
        </form>
    </xsl:template>
</xsl:stylesheet>

  
