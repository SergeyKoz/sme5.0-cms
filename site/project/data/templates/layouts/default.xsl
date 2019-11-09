<?xml version="1.0" encoding="UTF-8"?>
<!-- Main project layout -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="UTF-8" omit-xml-declaration="yes" indent="no" media-type="text/html" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"/>
	<!--Project messages display template -->
	<xsl:include href="../blocks/project_messages.xsl"/>
	<!--XSL and XML dumps display template -->
	<xsl:include href="../blocks/project_dump.xsl"/>
	<!--User information block -->
	<xsl:include href="../blocks/project_user_info.xsl"/>
	
	<!-- Project menu block -->
	<xsl:include href="../blocks/project_top_menu.xsl"/>
	<xsl:include href="../blocks/project_menu.xsl"/>
	<xsl:include href="../blocks/project_bottom_menu.xsl"/>	
	<xsl:include href="../blocks/project_current_menu.xsl"/>
	
	<!--Copyright block -->
	<xsl:include href="../blocks/project_copyright.xsl"/>
	
	<!-- print block -->
	<xsl:include href="../blocks/print.xsl"/>
	
	<!-- Navigation line block -->
	<xsl:include href="../blocks/project_navigation_line.xsl"/>
	<xsl:include href="../controls/front_navigator.xsl"/>
	<xsl:include href="../controls/file_icon.xsl"/>
	<xsl:include href="../controls/banners.xsl"/>
	<xsl:include href="../blocks/project_search_block.xsl"/>
	<xsl:include href="../blocks/subscribe_block.xsl"/>
	
	<!-- Define global variable-->
	<xsl:variable name="request_uri">
		<xsl:value-of select="/page/@request_uri"/>
	</xsl:variable>
	<xsl:variable name="page_root">
		<xsl:value-of select="/page/@root"/>
	</xsl:variable>
	<xsl:variable name="page-title">
		<xsl:value-of select="//localization/SiteTitle"/>
	</xsl:variable>
	<!-- Root template -->
	<xsl:template match="page">		
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
				<!-- TITLE -->
				<xsl:choose>
					<xsl:when test="/page/content/cms_content/meta_title!=''">
						<title>
							<xsl:value-of select="/page/content/cms_content/meta_title"/>
						</title>
					</xsl:when>
					<xsl:when test="/page/titles/title">
						<title>
							<xsl:if test="/page/@id!=1">
								<xsl:for-each select="/page/titles/title">
									<xsl:value-of select="."/>
									<xsl:if test="position() &lt; count(../*)"> - </xsl:if>
								</xsl:for-each> - </xsl:if>
							<xsl:if test="$page-title != ''">
								<xsl:value-of select="$page-title"/>
							</xsl:if>
						</title>
					</xsl:when>
					<xsl:otherwise>
						<title>
							<xsl:value-of select="$page-title"/> - <xsl:value-of select="/page/package/@title"/>
						</title>
					</xsl:otherwise>
				</xsl:choose>
				<!-- META KEYWORDS -->
				<xsl:if test="/page/content/cms_content/meta_keywords!=''">
					<META name="keywords">
						<xsl:attribute name="content"><xsl:value-of select="/page/content/cms_content/meta_keywords"/></xsl:attribute>
					</META>
				</xsl:if>
				<!-- META DESCRIPTION -->
				<xsl:if test="/page/content/cms_content/meta_description!=''">
					<META name="description">
						<xsl:attribute name="content"><xsl:value-of select="/page/content/cms_content/meta_description"/></xsl:attribute>
					</META>
				</xsl:if>
				
				<link rel="stylesheet" type="text/css" href="{/page/@url}css/style.css"/>
				<script type="text/javascript">
	                    		var siteUrl='<xsl:value-of select="/page/@url"/>';
		                </script>
				<script type="text/javascript" src="{/page/@framework_url}scripts/jquery.js"/>
				
				<xsl:for-each select="/page/content/scripts/script">
					<script type="{@type}" src="{.}"/>
				</xsl:for-each>
				
				<xsl:for-each select="/page/content/links/link">
					<link href="{.}" type="{@type}">
						<xsl:if test="@media!=''">
							<xsl:attribute name="media"><xsl:value-of select="@media"/></xsl:attribute>
						</xsl:if>
						<xsl:if test="@rel!=''">
							<xsl:attribute name="rel"><xsl:value-of select="@rel"/></xsl:attribute>
						</xsl:if>
					</link>
				</xsl:for-each>
				
				<script type="text/javascript" src="{/page/@url}js/script.js"/>

			</head>
			<body>
				<xsl:call-template name="maincontextcontrol"/>
				<xsl:choose>
					<xsl:when test="not(/page/@print)">
						
						<div rel="SME:&amp;#123;'mode':'page', 'item_id':{/page/@id}&amp;#125;">
							<table border="1" width="100%">
								<tr>
									<td colspan="3">
										<!-- header -->
										<a href="{/page/@url}">
											<img src="{/page/@url}img/logo.gif" alt=""/>
										</a><br/>
	
										<xsl:call-template name="print"/>
									</td>
								</tr>
								<tr>
								
									<td width="20%" valign="top">
										<xsl:call-template name="project_page_menu"/><br/>
									
										<xsl:if test="/page/content/cms_banners/bannerplace[@place_id=3]/banner">
											<div rel="SME:&amp;#123;'mode':'banner_place', 'item_id':'3' &amp;#125;">
												<xsl:apply-templates select="content/cms_banners/bannerplace[@place_id=3]">
													<xsl:with-param name="place_id">3</xsl:with-param>
												</xsl:apply-templates>
											</div>
										</xsl:if>
									</td>
								
									<td width="60%" valign="top">
										<!-- center -->
										
										<xsl:if test="/page/@id != 1">
											<!-- navigation line -->
											<xsl:call-template name="project_current_menu"/>
											
											<xsl:call-template name="project_navigation_line"/>
											
											<h1>
												<xsl:value-of select="/page/content/cms_structure/title"/>
											</h1>
										</xsl:if>
																			
										<xsl:call-template name="project_messages"/>
										
										<!-- PAGE CONTENT -->
										<xsl:if test="not(/page/content/http/row/pid)">
											<div rel="SME:&amp;#123;'mode':'content', 'item_id':{/page/@id}&amp;#125;">
												<xsl:if test="/page/content/cms_content/content_text!=''">
													<div>
														<xsl:value-of select="/page/content/cms_content/content_text" disable-output-escaping="yes"/>
													</div>
												</xsl:if>
												
												<xsl:if test="/page/content/cms_content/tags/tag">
													<xsl:value-of select="/page/content/localization/_tag_caption"/>:
													<xsl:for-each select="/page/content/cms_content/tags/tag">
														<a href="{/page/@url}{/page/@lng_url_prefix}tags/?tag={@tag_decode}"><xsl:value-of select="."/></a><xsl:if test="position()!=last()">, </xsl:if>
													</xsl:for-each>
												</xsl:if>
												
												<xsl:if test="/page/content/cms_content/enable_comments=1 and /page/content/cms_comments">
													<xsl:call-template name="comments">
														<xsl:with-param name="article" select="/page/@id"/>
														<xsl:with-param name="module">content</xsl:with-param>
														<xsl:with-param name="url"><xsl:value-of select="/page/content/cms_structure/path"/>/</xsl:with-param>
													</xsl:call-template>
												</xsl:if>
											</div>
										</xsl:if>
										
										<xsl:apply-templates select="content"/>
										
									</td>
									<td width="20%" valign="top">
										<!-- right-->
										<xsl:call-template name="user_info"/>
										
										<xsl:if test="/page/content/calendar_block">
											<xsl:call-template name="calendar_month_block"/>
											<xsl:call-template name="calendar_last_block"/>
										</xsl:if>
										
										<xsl:call-template name="subscribe_block"/>
										
										<!--xsl:if test="/page/content/cms_publications/mapping[@system_name = 'news_block']/publication/field">
											<xsl:call-template name="news_block"/>
										</xsl:if-->
									</td>
								</tr>
								<tr>
									<td colspan="3">
										<xsl:call-template name="project_bottom_menu"/><br/>
										<!-- footer -->
										Powered by<br/>
										<a target="_blank" href="http://activemedia.ua">
											<img src="{/page/@url}img/logo_activemedia.gif" alt="Activemedia"/>
										</a><br/>
										
										<xsl:call-template name="project_copyright"/>
									</td>
										
								</tr>
								
							</table>
						</div>						
					</xsl:when>
					<xsl:otherwise>
						<table border="1">
							<tr><td>
								<!-- header -->
							
								<xsl:call-template name="print"/>
								<img src="{/page/@url}img/logo.jpg" border="0"/><br/>
								
							</td></tr>
							<tr><td>
								<!-- center -->
								<xsl:if test="/page/@id != 1">
									<xsl:call-template name="project_navigation_line"/>
								</xsl:if>
								<h1>
									<xsl:value-of select="/page/content/cms_structure/title"/>
								</h1>
								<xsl:call-template name="project_messages"/>
								
								<!-- PAGE CONTENT -->
								<xsl:if test="/page/content/cms_content/content_text!='' and not(/page/content/http/row/pid)">										
									<xsl:value-of select="/page/content/cms_content/content_text" disable-output-escaping="yes"/>
								</xsl:if>
								
								<xsl:apply-templates select="content"/>

								
							</td></tr>
							<tr><td>								
								<!-- footer -->
								Powered by<br/>
								<a target="_blank" href="http://activemedia.ua">
									<img src="{/page/@url}img/logo_activemedia.gif" alt="Activemedia"/>
								</a><br/>
								<xsl:call-template name="project_copyright"/>
							</td></tr>
						</table>
									
					</xsl:otherwise>
				</xsl:choose>
				<!-- Show dumps links -->
				<xsl:call-template name="dump"/>
				<!-- Show debug info -->
				<xsl:call-template name="debug"/>

			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>
