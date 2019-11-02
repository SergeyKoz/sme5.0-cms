<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no"  media-type="text/html"/>

    <!-- Administrator section layout stylesheet -->
  <xsl:include href="layouts/layout.xsl"/>
  <xsl:include href="blocks/errors.xsl"/>
  <xsl:include href="blocks/debug.xsl"/>


    <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    

<xsl:template match="content">
<xsl:choose>
	<xsl:when test="mode='install'">	
		<br/><br/><br/>
		
    <table width="90%" align="center" class="sort-table">
    <tr>
    <td style="padding:10px;">
    <p style="font-size:14px;">
     <xsl:value-of select="//localization/reinstall_caption_1" disable-output-escaping="yes"/>
     <br/>
     <xsl:value-of select="//localization/reinstall_caption_2" disable-output-escaping="yes"/>
    
    </p>
        
				<table cellspacing="0" cellpadding="0" border="0">
				<tr><td>
                <input type="button" value="{//localization/reinstall_button_caption}" onclick="if (confirm('{//localization/are_you_sure}')) location.href='?package=filesystem&amp;page=filemanager&amp;event=ReInstall'"/></td></tr>
				</table>
				
    </td>
    </tr>
    </table>
   </xsl:when>
   <xsl:when test="mode='administrate'">
   <br/><br/><br/>
		
    <table width="90%" align="center" class="sort-table">
    <tr>
    <td style="padding:10px;">
    <p style="font-size:14px;">
    
     <xsl:value-of select="//localization/administrate_caption_1" disable-output-escaping="yes"/>
     
    
    </p>    
    <script language="JavaScript">
     function OpenWindow()	{	
      window.open('<xsl:value-of select="script_url" />/admin/','filemanage','location=0,menubar=0,resizable=yes,status=0,menubar=no,width=800,height=500,scrollbars=yes');         
     } 
    </script>
    
				<table cellspacing="0" cellpadding="0" border="0">
				<tr><td><input type="button" value="{//localization/administrate_button_caption}" onclick="OpenWindow()"/></td></tr>
				</table>
				 
    </td>
    </tr>
    </table>    
   </xsl:when>
   
   <xsl:otherwise>
   </xsl:otherwise>
   
 </xsl:choose>  
</xsl:template>
    
</xsl:stylesheet>
