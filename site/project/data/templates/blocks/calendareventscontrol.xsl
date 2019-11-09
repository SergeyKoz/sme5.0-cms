<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="no" media-type="text/html"/>
	<xsl:template name="events_filter">
		<xsl:for-each select="/page/content/events_filter">			
			<form action="?" method="get">
			
				<xsl:value-of select="form_date1/datetime/caption"/>
				<br/>
				
				<xsl:apply-templates select="form_date1/datetime">
					<xsl:with-param name="entry" select="."/>
				</xsl:apply-templates><input type="hidden" id="popupcalendar1"/>
				
				<xsl:value-of select="form_date2/datetime/caption"/>
				<br/>
				<xsl:apply-templates select="form_date2/datetime">
					<xsl:with-param name="date_flag">2</xsl:with-param>
					<xsl:with-param name="entry" select="."/>
				</xsl:apply-templates><input type="hidden" id="popupcalendar2"/>
				<br/>				
				<xsl:value-of select="keywords/text/caption"/>
				<br/>
				<xsl:apply-templates select="keywords/text">
					<xsl:with-param name="class">txt</xsl:with-param>
				</xsl:apply-templates>
				<br/>
				<xsl:value-of select="c/select/caption"/>
				<br/>
				<xsl:apply-templates select="c/select">
					<xsl:with-param name="class"/>
				</xsl:apply-templates>
				<br/>
				<input type="hidden" name="event" value="search"/>
				<input type="submit" value="{/page/content/localization/_caption_search}"/>
			</form>
			
			<link rel="stylesheet" type="text/css" href="{/page/package/@url}css/jquery-ui-1.7.3.custom-min.css"/>
			<script type="text/javascript" src="{/page/package/@url}js/jquery-ui-1.7.3.custom.min.js"></script>
			<script type="text/javascript" src="{/page/package/@url}js/jquery-ui-i18n.min.js"></script><script type="text/javascript">
				<xsl:variable name="callang">
					<xsl:choose>
						<xsl:when test="/page/@language='ua'">uk</xsl:when>
						<xsl:otherwise>
							<xsl:value-of select="/page/@language"/>
						</xsl:otherwise>
					</xsl:choose>
				</xsl:variable>								
				$(function(){
					$.datepicker.setDefaults($.extend($.datepicker.regional["<xsl:value-of select="$callang"/>"]));
					
					$('#popupcalendar1').datepicker({	showOn: 'button',
												buttonImage: '<xsl:value-of select="/page/package/@url"/>img/popupcalendar/dlcalendar.gif',
												buttonImageOnly: true,
												showOtherMonths: true,
												selectOtherMonths: false,
												beforeShow: function(input, inst) { 
													var d=$('#c_day').val();
													var m=$('#c_mon').val();
													var y=$('#c_year').val();
													if (d>0 &amp;&amp; m>0 &amp;&amp; y>0)
														input.value=d+'.'+m+'.'+y;
												},
												onSelect: function(dateText, inst) {																								var m=inst.selectedMonth+1;
													m=(m&lt;10 ? '0' : '')+m;
													
													$('#c_day').val(inst.selectedDay);
													$('#c_mon').val(m);
													$('#c_year').val(inst.selectedYear);
													
												}});
												
					$('#popupcalendar2').datepicker({	showOn: 'button',
												buttonImage: '<xsl:value-of select="/page/package/@url"/>img/popupcalendar/dlcalendar.gif',
												buttonImageOnly: true,
												showOtherMonths: true,
												selectOtherMonths: false,
												beforeShow: function(input, inst) { 
													var d=$('#c_day2').val();
													var m=$('#c_mon2').val();
													var y=$('#c_year2').val();
													if (d>0 &amp;&amp; m>0 &amp;&amp; y>0)
														input.value=d+'.'+m+'.'+y;
												},
												onSelect: function(dateText, inst) {
													var m=inst.selectedMonth+1;
													m=(m&lt;10 ? '0' : '')+m;
 
													$('#c_day2').val(inst.selectedDay);
													$('#c_mon2').val(m);
													$('#c_year2').val(inst.selectedYear);
												}});
				})
			</script>
			
		</xsl:for-each>
	</xsl:template>
	<xsl:template name="events_list">
		<xsl:if test="/page/content/events_list">
			<div rel="SME:&amp;#123;'mode':'eventslist', 'item_id':''&amp;#125;">
				<xsl:if test="/page/content/events_list/events/item">
					<xsl:apply-templates select="/page/content/events_list/events/navigator"/>
					<ul>
						<xsl:for-each select="/page/content/events_list/events/item">
							<li>
								<xsl:if test="small_image!=''">
									<a href="{/page/@url}{/page/@lng_url_prefix}{/page/content/calendar_entry}?e={event_id}">
										<img class="" src="{/page/settings/filestorageurl}{small_image}" alt="{title}" title="{title}" border="0"/>
									</a>
								</xsl:if>
								<xsl:value-of select="date_start"/>
								<xsl:if test="date_end!=date_start">-<xsl:value-of select="date_end"/>
								</xsl:if>
								<a href="{/page/@url}{/page/@lng_url_prefix}{/page/content/calendar_entry}?e={event_id}">
									<xsl:value-of select="title" disable-output-escaping="yes"/>
								</a>
								<br/>
								<xsl:if test="short_description!=''">
									<xsl:value-of select="short_description" disable-output-escaping="yes"/>
									<br/>
								</xsl:if>
								<xsl:variable name="id" select="event_id"/>
								<xsl:if test="/page/content/events_list/tags/tag[@event_id=$id]">
									<xsl:value-of select="/page/content/localization/_tag_caption"/>:
									<xsl:for-each select="/page/content/events_list/tags/tag[@event_id=$id]">
										<a href="{/page/@url}{/page/@lng_url_prefix}tags/?tag={@tag_decode}"><xsl:value-of select="."/></a>
										<xsl:if test="position()!=last()">, </xsl:if>								
									</xsl:for-each>
									<br/>
								</xsl:if>
								<br/>
							</li>
						</xsl:for-each>
					</ul>
				</xsl:if>
			</div>
		</xsl:if>
	</xsl:template>
	<xsl:template name="event_detail">
	
			
	
	
		<xsl:if test="/page/content/event_detail/event">
			<div rel="SME:&amp;#123;'mode':'event', 'item_id':'{/page/content/event_detail/event/event_id}'&amp;#125;">
				<ul>
					<xsl:for-each select="/page/content/event_detail/event">
						<li>
							<xsl:value-of select="date_start"/>
							<xsl:if test="date_end!=date_start">-<xsl:value-of select="date_end"/>
							</xsl:if>&amp;nbsp;
							<b><xsl:value-of select="title"/></b>
							
							&amp;nbsp;<a href="{/page/@url}{/page/@lng_url_prefix}{/page/content/calendar_entry}?c={category_id}">
								<xsl:value-of select="category_title"/>
							</a>
							<xsl:if test="small_image!=''">
								<img src="{/page/settings/filestorageurl}{small_image}" alt="{title}" title="{title}" border="0"/>
								<br/>
							</xsl:if>
							<xsl:value-of select="full_description" disable-output-escaping="yes"/>
							<xsl:if test="email!='' or url!='' or contacts!=''">
								<b><xsl:value-of select="/page/content/localization/_calendar_contact_info"/></b>
								<br/>
								<xsl:if test="contacts!=''">
									<xsl:value-of select="contacts" disable-output-escaping="yes"/><br/>
								</xsl:if>
								<xsl:if test="email!=''">
									<b><xsl:value-of select="/page/content/localization/_calendar_contact_info_email"/></b>:
									<a href="mailto:{email}" target="_blank">
										<xsl:value-of select="email"/>
									</a><br/>
								</xsl:if>
								<xsl:if test="url!=''"><b><xsl:value-of select="/page/content/localization/_calendar_contact_info_url"/></b>:
									<a href="{url}" target="_blank">
										<xsl:value-of select="url"/>
									</a><br/>
								</xsl:if>
							</xsl:if>
							
							<xsl:if test="../tags/tag">
								<xsl:value-of select="/page/content/localization/_tag_caption"/>:
								<xsl:for-each select="../tags/tag">
									<a href="{/page/@url}{/page/@lng_url_prefix}tags/?tag={@tag_decode}"><xsl:value-of select="."/></a>
									<xsl:if test="position()!=last()">, </xsl:if>								
								</xsl:for-each>
							</xsl:if>
							
							<xsl:if test="enable_comments=1 and /page/content/cms_comments">
								<xsl:call-template name="comments">
									<xsl:with-param name="article" select="event_id"/>
									<xsl:with-param name="module">calendar</xsl:with-param>
									<xsl:with-param name="url"><xsl:value-of select="/page/@lng_url_prefix"/><xsl:value-of select="/page/content/calendar_entry"/>?e=<xsl:value-of select="event_id"/></xsl:with-param>
								</xsl:call-template>
							</xsl:if>
							
						</li>
					</xsl:for-each>
				</ul>
			</div>
		</xsl:if>
			
	</xsl:template>
	<xsl:template name="events_default">
		<xsl:if test="/page/content/events_default">
			<div rel="SME:&amp;#123;'mode':'eventsdefault', 'item_id':''&amp;#125;">
				<xsl:if test="/page/content/events_default/categories/category">
					<xsl:for-each select="/page/content/events_default/categories/category">
						<xsl:variable name="curr_category" select="category_id"/>
						<xsl:if test="/page/content/events_default/events/event[category_id=$curr_category]">
							<a style="text-decoration:underline;color:#000" href="{/page/@url}{/page/@lng_url_prefix}{/page/content/calendar_entry}?c={category_id}">
								<b>
									<xsl:value-of select="caption"/>
								</b>
							</a>
							<ul>
								<xsl:for-each select="/page/content/events_default/events/event[category_id=$curr_category]">
									<li>
										<xsl:if test="small_image!=''">
											<a href="{/page/@url}{/page/@lng_url_prefix}{/page/content/calendar_entry}?e={event_id}">
												<img class="" src="{/page/settings/filestorageurl}{small_image}" alt="{title}" title="{title}" border="0"/>
												<br/>
											</a>
										</xsl:if>
										<xsl:value-of select="date_start"/>
										<xsl:if test="date_end!=date_start">-<xsl:value-of select="date_end"/>
										</xsl:if>
										<a href="{/page/@url}{/page/@lng_url_prefix}{/page/content/calendar_entry}?e={event_id}">
											<xsl:value-of select="title"/>
										</a>
										<br/>
										<xsl:if test="short_description!=''">
											<xsl:value-of select="short_description" disable-output-escaping="yes"/>
											<br/>
										</xsl:if>
										<br/>
									</li>
								</xsl:for-each>
							</ul>
						</xsl:if>
					</xsl:for-each>
				</xsl:if>
			</div>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
