<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    	<xsl:template name="calendar_month_block">
    	
    		<xsl:for-each select="/page/content/calendar_block">

	    		<link rel="stylesheet" type="text/css" href="{packageurl}css/jquery-ui-1.7.3.custom-min.css"/>			
			<script type="text/javascript" src="{packageurl}js/jquery-ui-i18n.min.js"></script>
			
			
			<div class="crns">
				<div class="crn tr">&amp;nbsp;</div>
				<div class="crn tl">&amp;nbsp;</div>
				<div class="cont">
					<div id="monthcalendar"/>
				</div>
				<div class="crn bl">&amp;nbsp;</div>
				<div class="crn br">&amp;nbsp;</div>
			</div>
			
			<script type="text/javascript">
				<xsl:variable name="callang">
					<xsl:choose>
						<xsl:when test="/page/@language='ua'">uk</xsl:when>
						<xsl:otherwise><xsl:value-of select="/page/@language"/></xsl:otherwise>
					</xsl:choose>				
				</xsl:variable>
				
				var monthEvents={'<xsl:value-of select="month"/>':[<xsl:for-each select="days/day"><xsl:value-of select="."/><xsl:if test="position()!=last()">, </xsl:if></xsl:for-each>]}
				var selectedMonth=null;
				var selectedItemStyle='';				
				$(function(){
					$.datepicker.setDefaults($.extend($.datepicker.regional["<xsl:value-of select="$callang"/>"]));					
					$('#monthcalendar').datepicker({	showOtherMonths: true,
												selectOtherMonths: false,
												beforeShowDay: function(date) {													
													var day = date.getDate();
													var month = two(date.getMonth()+1)+'.'+date.getFullYear();
													if (typeof(monthEvents[selectedMonth]) == 'object' &amp;&amp; selectedMonth==month)
														if (in_array(day, monthEvents[selectedMonth]))
															return [true, selectedItemStyle];
													return [false, ""];
												},
												onChangeMonthYear: function(year, month, inst){
													selectedMonth=two(month)+'.'+year;
													if (typeof(monthEvents[selectedMonth]) != 'object'){
														var url='<xsl:value-of select="/page/@url"/><xsl:value-of select="/page/@lng_url_prefix"/><xsl:value-of select="entry"/>';
														var data={'m':month, 'y':year, 'event':'GetMonthDays'};
														$.get(url, data, function(data){
															var data=eval(data);
															if (typeof(data[0]) == 'object'){
																monthEvents[data[0].month]=data[0].days;
																$('#monthcalendar').datepicker('refresh');
															}
														});
									
													}
												},
												onSelect: function(dateText, inst){
													var year = dateText.substr(6, 4);
													var month = dateText.substr(3, 2);
													var day = dateText.substr(0, 2);
													if (typeof(monthEvents[month+'.'+year]) == 'object')
														if (in_array(parseInt(day,10), monthEvents[month+'.'+year])) {
															var url='<xsl:value-of select="/page/@url"/><xsl:value-of select="/page/@lng_url_prefix"/><xsl:value-of select="entry"/>?c_day='+day+'&amp;c_mon='+month+'&amp;c_year='+year;
															location.href = url;
														}
	
												}
											});
				})
				
				function in_array(val, ar){
					if (typeof(ar) != 'object' || !ar || !ar.length) 
						return false;
					
					for (key in ar)
						if (val == ar[key])
							return true;					
					return false;
				}
				
				function two(str){
					if (typeof(str) != 'string')
						str = str.toString();					
					return str.length &lt;2 ? '0' + str : str;
				}
				
				
			</script>
		</xsl:for-each>
	</xsl:template>

	<xsl:template name="calendar_last_block">
	
	
		<div rel="SME:&amp;#123;'mode':'eventsblock', 'item_id':''&amp;#125;">
			<xsl:if test="/page/content/calendar_block/events/event">
				<ul class="pub short">
					<xsl:for-each select="/page/content/calendar_block/events/event">
						<li class="item">
							<span class="date"><xsl:value-of select="date_start"/></span>
							<h2 class="h4"><a href="{/page/@url}{/page/@lng_url_prefix}{/page/content/calendar_block/entry}?e={event_id}"><xsl:value-of select="title"/></a></h2>
							<xsl:if test="short_description!=''">
								<div class="text"><xsl:value-of select="short_description" disable-output-escaping="yes"/></div>
							</xsl:if>
						</li>
					</xsl:for-each>
				</ul>
				
				<a href="{/page/@url}{/page/@lng_url_prefix}{/page/content/calendar_block/entry}">
					<xsl:value-of select="//localization/_to_events"/>
				</a>
			</xsl:if>
		</div>

	</xsl:template>

</xsl:stylesheet>