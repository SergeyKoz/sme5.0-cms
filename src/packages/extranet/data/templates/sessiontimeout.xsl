<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no"  media-type="text/html"/>

    <!-- Administrator section layout stylesheet -->
    <xsl:include href="layouts/layout.xsl"/>
    <xsl:include href="blocks/debug.xsl"/>

    <xsl:template match="/"><xsl:apply-templates/></xsl:template>


    <xsl:template match="content">
    <script language="JavaScript">
    	function Redirect(url)	{
      	if (parent!=null)	{
        	parent.location.href=url;
        }	else	{
        	location.href=url;
        }
      }
    </script>
		<xsl:value-of select="localization/timeoutText" disable-output-escaping="yes" />
    </xsl:template>
</xsl:stylesheet>

  