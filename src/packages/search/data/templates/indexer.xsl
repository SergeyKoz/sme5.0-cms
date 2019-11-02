<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no" media-type="text/html"/>
	<!-- User section layout stylesheet -->
	<!-- Administrator section layout stylesheet -->
	<xsl:include href="layouts/layout.xsl"/>
	<xsl:include href="blocks/errors.xsl"/>
	<xsl:include href="blocks/debug.xsl"/>
	<xsl:template match="/">
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="content">
    	<div class="content">
            <p style="font-size:14px;">
                <xsl:value-of select="/page/content/localization/_indexation_description" disable-output-escaping="yes"/>
            </p>
            <iframe id="indexerframe" style="display: none;"/>
            <br/>
            <table cellspacing="0" cellpadding="0" border="0" id="indexingbutton">
                <tr>
                    <td style="border:0px;">
                        <input type="button" value="{/page/content/localization/_indexation_start}" style="color:red; font-weight:bold;" onclick="indexerStart();"/>
                    </td>
                    
                    <xsl:if test="/page/@contextframe=1">
                        <td style="border:0px;">
                            <input type="button" value="{/page/content/localization/_caption_cancel}" style="color:red; font-weight:bold;" onclick="return (confirm('{//_caption_confirm_cancel}') ? window.top.closeframe() : false)"/>
                        </td>
                    </xsl:if>
                    
                </tr>
            </table>
            
            
            
            <table cellspacing="0" cellpadding="0" border="0" id="indexingprocess" style="display:none;">
                <tr>
                    <td>
                        <p>
                        <b><xsl:value-of select="/page/content/localization/_indexation_process_1"/>:</b>&amp;nbsp;<span style="color:red;font-weight:bold;" id="processcounter"/>&amp;nbsp;<b><xsl:value-of select="/page/content/localization/_indexation_process_2"/>.</b></p>
                    </td>
                </tr>
            </table>
            <script>
                function indexerStart(){
                    document.getElementById('indexerframe').src='<xsl:value-of select="/page/content/url"/>';
                    document.getElementById('indexingbutton').style.display='none';
                    document.getElementById('processcounter').innerHTML='0';
                    document.getElementById('processcounter').display='block';
                }
                
                function indexProcess(){                		
                    document.getElementById('indexingbutton').style.display='none';
                    var c=document.getElementById('processcounter');
                    document.getElementById('indexingprocess').style.display='block';
                    var v=c.innerHTML;
                    v++;
                    c.innerHTML=v;
                }
                
                function indexDone(){                		
                    document.getElementById('indexingbutton').style.display='block';
                    document.getElementById('indexingprocess').style.display='none';
                    alert("<xsl:value-of select="/page/content/localization/_indexation_done"/>");
                }             		
            </script>
        </div>
	</xsl:template>
</xsl:stylesheet>
