<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="UTF-8" omit-xml-declaration="no" media-type="text/html"/>
	<xsl:template name="events_filter">
		<xsl:for-each select="/page/content/events_filter">
			<form action="?" method="get" name="CalendarFilterForm" onsubmit="OnEventsSearch();" class="sort">
				<xsl:value-of select="form_date1/datetime/caption"/>
				<br/>
				<xsl:apply-templates select="form_date1/datetime">
					<xsl:with-param name="entry" select="."/>
				</xsl:apply-templates>
				<input type="hidden" id="popupcalendar1"/>
				<br/>
				<xsl:value-of select="form_date2/datetime/caption"/>
				<br/>
				<xsl:apply-templates select="form_date2/datetime">
					<xsl:with-param name="date_flag">1</xsl:with-param>
					<xsl:with-param name="entry" select="."/>
				</xsl:apply-templates>
				<input type="hidden" id="popupcalendar2"/>
				<br/>
				<xsl:value-of select="keywords/text/caption"/>
				<br/>
				<xsl:apply-templates select="keywords/text">
					<xsl:with-param name="size">20</xsl:with-param>
				</xsl:apply-templates>
				<br/>
				<xsl:value-of select="category/select/caption"/>
				<br/>
				<xsl:apply-templates select="category/select">
					<xsl:with-param name="id">calendar_category_select</xsl:with-param>
				</xsl:apply-templates>
				<br/>
				<input type="hidden" name="event" value="search"/>
				<input type="submit" value="{/page/content/localization/_caption_search}"/>
			</form>
			<script type="text/javascript">
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

					$('#popupcalendar1').datepicker({	
						showOn: 'button',
						buttonImage: '<xsl:value-of select="/page/package/@url"/>img/calendar.gif',
						buttonImageOnly: true,
						showOtherMonths: true,
						selectOtherMonths: false,
						beforeShow: function(input, inst) {
							var d=$('#day').val();
							var m=$('#month').val();
							var y=$('#year').val();
							if (d>0 &amp;&amp; m>0 &amp;&amp; y>0){
								input.value=d+'.'+m+'.'+y;
							}
						},
						onSelect: function(dateText, inst) {
							var m=inst.selectedMonth+1;
							m=(m&lt;10 ? '0' : '')+m;
							
							var d=inst.selectedDay;
							d=(d&lt;10 ? '0' : '')+d;

							$('#day').val(d).change();
							$('#month').val(m).change();
							$('#year').val(inst.selectedYear).change();
						}
					});

					$('#popupcalendar2').datepicker({
						showOn: 'button',
						buttonImage: '<xsl:value-of select="/page/package/@url"/>img/calendar.gif',
						buttonImageOnly: true,
						showOtherMonths: true,
						selectOtherMonths: false,
						beforeShow: function(input, inst) {
							var d=$('#day1').val();
							var m=$('#month1').val();
							var y=$('#year1').val();
							if (d>0 &amp;&amp; m>0 &amp;&amp; y>0){
								input.value=d+'.'+m+'.'+y;
							}
						},
						onSelect: function(dateText, inst) {
							var m=inst.selectedMonth+1;
							m=(m&lt;10 ? '0' : '')+m;
							
							var d=inst.selectedDay;
							d=(d&lt;10 ? '0' : '')+d;

							$('#day1').val(d).change();
							$('#month1').val(m).change();
							$('#year1').val(inst.selectedYear).change();
						}
					});
				})
				
				var categories=[<xsl:for-each select="categories/category">{'id':'<xsl:value-of select="category_id"/>', 'system':'<xsl:value-of select="system"/>'}<xsl:if test="position()!=last()">, </xsl:if>
				</xsl:for-each>];
				
				$(document).ready(function(){
					$('#calendar_category_select').change(setFormAction);
					
					$('#day').change(setFormAction);
					$('#month').change(setFormAction);
					$('#year').change(setFormAction);
					
					$('#day1').change(setFormAction);
					$('#month1').change(setFormAction);
					$('#year1').change(setFormAction);
				});
				
				function setFormAction(){
					var page='<xsl:value-of select="/page/@url"/>
				<xsl:value-of select="/page/@lng_url_prefix"/>
				<xsl:value-of select="/page/content/calendar_entry"/>';
					
					var datePrefix='';
					
					//set dates
					
					var d1='', d2='';
					
					var y=$('#year').val();
					var m=$('#month').val();
					var d=$('#day').val();
					
					if (d>0){
						d1=y+'-'+m+'-'+d;
					}else{
						d1=y+'-'+m;
					}
					
					y=$('#year1').val();
					m=$('#month1').val();
					d=$('#day1').val();
					
					if (y>0 || m>0 || d>0){
						d2=y+'-'+m+'-'+d;
					}
					
					datePrefix=d1+(d2!='' ? '/'+d2 : '/-')+'/';
					
					//set category
					var categoryPrefix='';
					var cat=$('#calendar_category_select').val();						
					if(cat>0){
						for (i=0; i&lt;categories.length; i++){
							if (categories[i].id==cat){									
								categoryPrefix+=categories[i].system+'/';
							}
						}
					}
					document.CalendarFilterForm.action=page+datePrefix+categoryPrefix;					
				}

				function OnEventsSearch(){
					var fields=['calendar_category_select', 'popupcalendar1', 'popupcalendar2', 'year', 'month', 'day', 'year1', 'month1', 'day1'];
					
					for (i=0; i&lt;fields.length; i++){
						$('#'+fields[i]).removeAttr('name');
					}
				}
			</script>
		</xsl:for-each>
	</xsl:template>
	<xsl:template name="events_list">
		<xsl:if test="/page/content/events_list/events/item">
			<xsl:apply-templates select="/page/content/events_list/events/navigator"/>
			<ul rel="SME:&amp;#123;'mode':'eventslist', 'item_id':''&amp;#125;">
				<xsl:for-each select="/page/content/events_list/events/item">
					<li>
						<xsl:value-of select="date_start"/>
						<xsl:if test="date_end!=date_start"> - <xsl:value-of select="date_end"/>
						</xsl:if>
						<b>
							<a href="{/page/@url}{/page/@lng_url_prefix}{/page/content/calendar_entry}{category_system}/">
								<xsl:value-of select="category_title"/>:
						</a>
						</b>
						<a href="{/page/@url}{/page/@lng_url_prefix}{/page/content/calendar_entry}{category_system}/{system}/">
							<xsl:value-of select="title" disable-output-escaping="yes"/>
						</a>
						<br/>
						<xsl:if test="small_image!=''">
							<img class="fl" src="{/page/settings/cacheurl}thumbs/80x80/{small_image}" alt="{title}" title="{title}" border="0"/>
						</xsl:if>
						<xsl:if test="short_description!=''">
							<div>
								<xsl:value-of select="short_description" disable-output-escaping="yes"/>
							</div>
						</xsl:if>
						<xsl:variable name="id" select="event_id"/>
						<xsl:if test="/page/content/events_list/tags/tag[@event_id=$id]">
							<xsl:value-of select="/page/content/localization/_tag_caption"/>:
								<xsl:for-each select="/page/content/events_list/tags/tag[@event_id=$id]">
								<a href="{/page/@url}{/page/@lng_url_prefix}tags/?tag={@tag_decode}">
									<xsl:value-of select="."/>
								</a>
								<xsl:if test="position()!=last()">, </xsl:if>
							</xsl:for-each>
							<br/>
						</xsl:if>
						<br/>
					</li>
				</xsl:for-each>
			</ul>
		</xsl:if>
	</xsl:template>
	<xsl:template name="event_detail">
		<xsl:if test="/page/content/event_detail/event">
			<xsl:for-each select="/page/content/event_detail/event">
				<div rel="SME:&amp;#123;'mode':'event', 'item_id':'{/page/content/event_detail/event/event_id}'&amp;#125;">
					<h2>
						<xsl:value-of select="title"/>
					</h2>
					<xsl:value-of select="date_start"/>
					<xsl:if test="date_end!=date_start"> - <xsl:value-of select="date_end"/>
					</xsl:if>
					<br/>
					<xsl:value-of select="/page/content/localization/_category"/>:
	                             	<a href="{/page/@url}{/page/@lng_url_prefix}{/page/content/calendar_entry}{category_system}/">
						<xsl:value-of select="category_title"/>
					</a>
					<br/>
					
					<xsl:if test="small_image!=''">
						<img class="fl" src="{/page/settings/cacheurl}thumbs/150x150/{small_image}" alt="{title}" title="{title}" border="0"/>
					</xsl:if>
					
					<xsl:value-of select="full_description" disable-output-escaping="yes"/>
					<xsl:if test="contacts!=''">
						<b><xsl:value-of select="/page/content/localization/_calendar_contact_info"/>:</b>
						<xsl:value-of select="contacts" disable-output-escaping="yes"/>
						<br/>
					</xsl:if>
					<xsl:if test="email!=''">
						<b><xsl:value-of select="/page/content/localization/_calendar_contact_info_email"/>:</b>
						<a href="mailto:{email}" target="_blank">
							<xsl:value-of select="email"/>
						</a>
						<br/>
					</xsl:if>
					<xsl:if test="url!=''">						
						<b><xsl:value-of select="/page/content/localization/_calendar_contact_info_url"/>:</b>
						<a href="{url}" target="_blank">
							<xsl:value-of select="url"/>
						</a>
						<br/>
					</xsl:if>
					<xsl:if test="../tags/tag">
						<b>
							<xsl:value-of select="/page/content/localization/_tag_caption"/>:</b>
						<xsl:for-each select="../tags/tag">
							<a href="{/page/@url}{/page/@lng_url_prefix}tags/?tag={@tag_decode}">
								<xsl:value-of select="."/>
							</a>
							<xsl:if test="position()!=last()">, </xsl:if>
						</xsl:for-each>
					</xsl:if>
					<xsl:if test="enable_comments=1 and /page/content/cms_comments">
						<xsl:call-template name="comments">
							<xsl:with-param name="article" select="event_id"/>
							<xsl:with-param name="module">calendar</xsl:with-param>
							<xsl:with-param name="url">
								<xsl:value-of select="/page/@lng_url_prefix"/>
								<xsl:value-of select="/page/content/calendar_entry"/>
								<xsl:value-of select="category_system"/>/<xsl:value-of select="system"/>/</xsl:with-param>
						</xsl:call-template>
					</xsl:if>
				</div>
			</xsl:for-each>
		</xsl:if>
	</xsl:template>
	<xsl:template name="events_default">
		<xsl:variable name="entry" select="/page/content/calendar_entry"/>
		<xsl:for-each select="/page/content/events_default/monthcalendar">
			<div rel="SME:&amp;#123;'mode':'eventsdefault', 'item_id':''&amp;#125;">
			
			
				<style type="text/css">
					.calendar_weekend {color:red;}
					.calendar_current {font-weight: bold;}
					.calendar_outside {color:grey;}
				</style>
			
				<table cellspacing="0" cellpadding="0" width="100%">
					<thead>
						<tr>
							<th colspan="2">
								<a href="{/page/@url}{/page/@lng_url_prefix}{$entry}{prev_month/year}-{prev_month/month}/">
									<xsl:value-of select="prev_month/month_caption"/>&amp;nbsp;<xsl:value-of select="prev_month/year"/>
								</a>
							</th>
							<th colspan="3">
								<strong>
									<xsl:value-of select="current_month/month_caption"/>&amp;nbsp;<xsl:value-of select="current_month/year"/>
								</strong>
							</th>
							<th colspan="2">
								<a href="{/page/@url}{/page/@lng_url_prefix}{$entry}{next_month/year}-{next_month/month}/">
									<xsl:value-of select="next_month/month_caption"/>&amp;nbsp;<xsl:value-of select="next_month/year"/>
								</a>
							</th>
						</tr>
						<tr>
							<!-- draw localized weekdays captions -->
							<xsl:for-each select="localization/weekdays/day">
								<th>
									<xsl:value-of select="."/>
								</th>
							</xsl:for-each>
						</tr>
					</thead>
					<tbody>
						<xsl:for-each select="week">
							<tr valign="top">
								<xsl:for-each select="day">
									<td width="15%">
										<xsl:choose>
											<xsl:when test="@today=1">
												<xsl:attribute name="class">calendar_current</xsl:attribute>
											</xsl:when>
											<xsl:when test="@weekend=1 and not(@outside=1)">
												<xsl:attribute name="class">calendar_weekend</xsl:attribute>
											</xsl:when>
											<xsl:when test="@outside=1">
												<xsl:attribute name="class">calendar_outside</xsl:attribute>
											</xsl:when>
										</xsl:choose>
										<div>
											<xsl:value-of select="."/>
											<div class="calendar_events">
												<xsl:if test="not(@outside)">
													<xsl:call-template name="calendar_cell">
														<xsl:with-param name="day" select="."/>
													</xsl:call-template>
												</xsl:if>
											</div>
										</div>
									</td>
								</xsl:for-each>
							</tr>
						</xsl:for-each>
					</tbody>
				</table>
				<xsl:for-each select="/page/content/events_filter/categories">
					<xsl:if test="category">
						<div class="clr" style="height:15px;"/>
						<h2>
							<xsl:value-of select="/page/content/localization/categories_caption"/>
						</h2>
						<ul>
							<xsl:for-each select="category">
								<li class="fl margin20">
									<a href="{/page/@url}{/page/@lng_url_prefix}{/page/content/calendar_entry}{system}/">
										<xsl:value-of select="caption"/>
									</a>
								</li>
							</xsl:for-each>
						</ul>
					</xsl:if>
				</xsl:for-each>
			</div>
		</xsl:for-each>
	</xsl:template>
	<xsl:template name="calendar_cell">
		<xsl:param name="day"/>
		<xsl:for-each select="/page/content/events_default/monthevents/event[day=$day]">
			<a href="{/page/@url}{/page/@lng_url_prefix}{/page/content/calendar_entry}{category_system}/{system}/" title="{short_description}">
				<xsl:value-of select="title"/>
			</a>
			<xsl:if test="position()!=last()">
				<br/>
				<br/>
			</xsl:if>
		</xsl:for-each>
	</xsl:template>
</xsl:stylesheet>
