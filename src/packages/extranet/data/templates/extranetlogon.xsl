<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="no" media-type="text/html"/>
	<!-- Administrator section layout stylesheet -->
	<xsl:include href="layouts/layout.xsl"/>
	<xsl:include href="blocks/logon_errors.xsl"/>
	<xsl:include href="blocks/debug.xsl"/>
	<xsl:template match="/">
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="content">
    	<div class="logonform"> 
			<form action="" method="post" name="logonForm">
                <input type="hidden" name="event" value="Process"/>
                <input type="hidden" name="page" value="extranetlogon"/>
                <input type="hidden" name="camefrom" value="{camefrom}"/>
                <input type="hidden" name="query" value="{query}"/>
                <table cellpadding="3" cellspacing="0" border="0">
                    <tr>
                        <td align="center" colspan="2">
                            <img src="{//page/package/@url}img/logo_logon.gif"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <xsl:call-template name="errors"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="greycolor">Login: <br/>
                            <input type="text" name="login" value="{formLogin}" class="ticket" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="greycolor">Password:<br/>
                            <input type="password" name="password" class="ticket"/>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="text-align:center;">
                            <button onClick="document.logonForm.submit();" type="submit">
                                <img src="{/page/@framework_url}/packages/extranet/img/logoff.gif" alt="LogOff" align="absmiddle" border="0" width="16" height="16"/> &amp;nbsp;Logon</button>
                        </td>
                    </tr>
                </table>
                <br/>
                <center>
                    <font class="copy">&amp;copy; Activemedia, LLC. 2003-2012.</font>
                </center>
			</form>
        </div>
	</xsl:template>
</xsl:stylesheet>
