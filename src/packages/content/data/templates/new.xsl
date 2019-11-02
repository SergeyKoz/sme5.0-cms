<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no"  media-type="text/html"/>

    <!-- Administrator section layout stylesheet -->
    <xsl:include href="layouts/layout.xsl"/>
    <xsl:include href="blocks/debug.xsl"/>
    <xsl:include href="blocks/errors.xsl"/>
    <xsl:include href="controls/select.xsl"/>
    <xsl:include href="controls/indicator.xsl"/>
    <xsl:include href="controls/bannerselectbox.xsl"/>

    <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    <xsl:template match="content">
        <xsl:apply-templates select="page_props" />
    </xsl:template>
    
    <xsl:template match="page_props">
      <script>
        function doSubmit()
        {
            if (confirm('<xsl:value-of select="//_confirm_add_new_page" />'))
            {
            <xsl:if test="/page/content/page_banners != ''" >
                doCollectBannerIDs();
            </xsl:if>
                document.all.pageProps_form.submit();
            }
        }
        
        function doCancel()
        {
            if (confirm('<xsl:value-of select="//_confirm_new_page_cancel" />'))
            {
                document.location = "?package=content&amp;page=structure";
            }
        }
        
      </script>
      <form action="{submit_url}" method="POST" name="pageProps_form">
        <input type="hidden" name="event" value="SubmitPageProps"/>
         <!-- title -->
			<div class="silverGray2">
				
					<table cellpadding="0" cellspacing="0" border="0" width="100%" style="padding-bottom:10px;padding-top:10px;">
						<tr>
							<td valign="middle" align="right" height="32" style="padding-left:10px;">
								<img src="{/page/@framework_url}packages/libraries/img/ico_pencil.gif" align="absmiddle" width="32" height="32"/>
							</td>
							<td width="70%" valign="middle">
								<font class="mainHeader">
									 <xsl:value-of select="//_title_add_new_page" />
								</font>
							</td>
							<td align="right" width="25%" valign="middle">
								
								<!-- Save and Back buttons -->
								
									<table cellpadding="0" cellspacing="0" border="0" align="center" width="95%">
										<tr>
											<td>
												<button type="button" value="{//_caption_cancel}" onClick="doCancel()">
													<img src="{/page/@framework_url}packages/libraries/img/ico_cancel.gif" alt="Cancel" align="absmiddle" border="0" width="16" height="16"/>
													&amp;nbsp;<xsl:value-of select="//_caption_cancel"/>
												</button>
											</td>
											<td>&amp;nbsp;</td>
											<td>
													<button type="submit" title="{//_caption_save}" onClick="doSubmit()">
														<img src="{/page/@framework_url}packages/libraries/img/icn_savefile.gif" alt="save" align="absmiddle" border="0" width="16" height="16"/>
														&amp;nbsp;<xsl:value-of select="//_caption_save"/>
													</button>
												</td>
										</tr>
									</table>
								<!--^ Save and Back buttons -->
							</td>
							<td width="4%">
							</td>
						</tr>
					</table>
				
			</div>
<BR/>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<tr>
					<td valign="top">
                    	<table cellpadding="0" cellspacing="0" border="0" width="100%">
									<tr>
										<td nowrap="" class="pl_30" width="40%">
											 <xsl:value-of select="//_title_add_new_page_to" />
										</td>
										<td width="99%">	
                                            <xsl:apply-templates select="/page/content/tree_combobox/select" />
										</td>
									</tr>
                                
                                     <tr>
										<td nowrap="" class="pl_30" width="40%">
                                           <xsl:value-of select="//_title_page_system_name" />
										</td>
										<td width="99%">	
                                            <input type="text" name="name" value="{name}"  size="60"/>
										</td>
									</tr>
                                    <tr>
										<td nowrap="" class="pl_30" width="40%">
										&amp;nbsp;
										</td>
										<td width="99%">	
                                            <input type="checkbox" name="active" value="1" checked="1" />
                                            <xsl:value-of select="//_title_page_activity" />
                                            <br/><br/>
										</td>
									</tr>
			 						<tr>
										<td class="pl_30" width="40%"><xsl:value-of select="//_title_page_title" /></td>
										<td width="99%">
                                             <input type="text" name="title" value="{title}" size="60"></input>
										</td>
									</tr>

                                    <tr>
										<td nowrap="" class="pl_30" width="40%">
										&amp;nbsp;
										</td>
										<td width="99%">
                                            <input type="checkbox" name="show_in_top_menu" value="1" checked="1" />
                                            <xsl:value-of select="//_title_show_in_top_menu" />
                                            <br />
                                            <input type="checkbox" name="show_in_bottom_menu" value="1" checked="1" />
                                            <xsl:value-of select="//_title_show_in_bottom_menu" />
                                            <br />
										</td>
									</tr>
                                     <xsl:if test="/page/content/page_banners != ''" >
                                     <tr>
										<td nowrap="" class="pl_30" width="40%">
											         <xsl:value-of select="//_title_page_banners" />
										</td>
										<td width="99%">	
                                          <xsl:call-template name="page_banners" />
										</td>
									</tr>
                                    </xsl:if>
                        </table>            
                    </td>
                </tr>
</table>
<BR/>                
 <!-- title -->
			<div class="silverGray2">
					<table cellpadding="0" cellspacing="0" border="0" width="100%" style="padding-bottom:10px;padding-top:10px;">
						<tr>
							<td valign="middle" align="right" height="32" style="padding-left:10px;">
								<img src="{/page/@framework_url}packages/libraries/img/ico_pencil.gif" align="absmiddle" width="32" height="32"/>
							</td>
							<td width="70%" valign="middle">
								<font class="mainHeader">
									 <xsl:value-of select="//_title_add_new_page" />
								</font>
							</td>
							<td align="right" width="25%" valign="middle">
								
								<!-- Save and Back buttons -->
								
									<table cellpadding="0" cellspacing="0" border="0" align="center" width="95%">
										<tr>
											<td>
												<button type="button" value="{//_caption_cancel}" onClick="doCancel()">
													<img src="{/page/@framework_url}packages/libraries/img/ico_cancel.gif" alt="Cancel" align="absmiddle" border="0" width="16" height="16"/>
													&amp;nbsp;<xsl:value-of select="//_caption_cancel"/>
												</button>
											</td>
											<td>&amp;nbsp;</td>
											<td>
													<button type="submit" title="{//_caption_save}" onClick="doSubmit()">
														<img src="{/page/@framework_url}packages/libraries/img/icn_savefile.gif" alt="save" align="absmiddle" border="0" width="16" height="16"/>
														&amp;nbsp;<xsl:value-of select="//_caption_save"/>
													</button>
												</td>
										</tr>
									</table>
								<!--^ Save and Back buttons -->
							</td>
							<td width="4%">
							</td>
						</tr>
					</table>
				
			</div>
      </form>
    </xsl:template>
</xsl:stylesheet>

  