<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="UTF-8" omit-xml-declaration="no" media-type="text/html"/>
	<xsl:template name="calendar_block">
		<xsl:for-each select="/page/content/calendar_block">
			
			<div rel="SME:&amp;#123;'mode':'eventsblock', 'item_id':''&amp;#125;">
				<h2>
					<xsl:value-of select="/page/content/localization/calendar_block"/>
				</h2>
				<xsl:call-template name="calendar_month"/>
				
				<xsl:call-template name="calendar_lastevents"/>

				<a href="{/page/@url}{/page/@lng_url_prefix}{entry}" class="fr">
					<xsl:value-of select="/page/content/localization/calendar_block_all"/>
				</a>
			</div>
		</xsl:for-each>
	</xsl:template>
	<xsl:template name="calendar_month">
		<div id="monthcalendar"/>
		<script type="text/javascript">
			<xsl:variable name="callang">
				<xsl:choose>
					<xsl:when test="/page/@language='ua'">uk</xsl:when>
					<xsl:otherwise>
						<xsl:value-of select="/page/@language"/>
					</xsl:otherwise>
				</xsl:choose>
			</xsl:variable>
                            
                        var monthEvents={'<xsl:value-of select="month"/>':[<xsl:for-each select="days/day">
				<xsl:value-of select="."/>
				<xsl:if test="position()!=last()">, </xsl:if>
			</xsl:for-each>]}
                        var selectedMonth='<xsl:value-of select="month"/>';
                        var selectedItemStyle='';	
            
                        $(function(){
                            $.datepicker.setDefaults( $.datepicker.regional['<xsl:value-of select="$callang"/>']);
                            
                            $('#monthcalendar').datepicker({
                                showOtherMonths: true,
                                selectOtherMonths: false,
                                beforeShowDay: function(date) {
                                    var day = date.getDate();
                                    var month = two(date.getMonth()+1)+'.'+date.getFullYear();
                                    
                                    if (typeof(monthEvents[selectedMonth]) == 'object' &amp;&amp; selectedMonth==month){
                                        if (in_array(day, monthEvents[selectedMonth])){
                                        //if (typeof(monthEvents[selectedMonth][day])=='object'){
                                            return [true, selectedItemStyle];
                                        }
                                    }
                                    return [false, ""];
                                },
                                onChangeMonthYear: function(year, month, inst){
                                    selectedMonth=two(month)+'.'+year;
                                    if (typeof(monthEvents[selectedMonth]) != 'object'){
                                        var url='<xsl:value-of select="/page/@url"/>scripts/getmonth.php';
                                        var data={'m':month, 'y':year<xsl:if test="/page/content/parameters_menu/categories/item">, <xsl:for-each select="/page/content/parameters_menu/categories/item">'c<xsl:value-of select="@c"/>':<xsl:value-of select="."/>
					<xsl:if test="position()!=last()">, </xsl:if>
				</xsl:for-each>
			</xsl:if>};
                                        $.get(url, data, function(data){
                                            var data=eval(data);
                                            if (typeof(data[0]) == 'object'){
                                            		var days=data[0].days;
                                            		monthEvents[data[0].month]=[];    
                                            		for(i=0; i&lt;days.length; i++){
                                            		
                                            			for (item in days[i]){
                                            				item=parseInt(item);
                                            				monthEvents[data[0].month].push(item);
                                            			}
                                            		}
                                                //monthEvents[data[0].month]=data[0].days;
                                                $('#monthcalendar').datepicker('refresh');
                                                setCalendarMonthYearLink(year, month);
                                            }
                                        });
                                    }
                                },
                                onSelect: function(dateText, inst){
                                    var year = dateText.substr(6, 4);
                                    var month = dateText.substr(3, 2);
                                    var day = dateText.substr(0, 2);
                                    if (typeof(monthEvents[month+'.'+year]) == 'object'){
                                        if (in_array(parseInt(day,10), monthEvents[month+'.'+year])) {
                                            var url='<xsl:value-of select="/page/@url"/>
			<xsl:value-of select="/page/@lng_url_prefix"/>
			<xsl:value-of select="entry"/>'+year+'-'+month+'-'+day+'/';
                                            location.href = url;
                                        }
                                    }
                                }
                            });
        
                            setCalendarMonthYearLink();
                        });
                            
                        function setCalendarMonthYearLink(year, month){ 
                            var date = new Array();
                            
                            if (year>0 &amp;&amp; month>0){
                                date[0]='1';
                                date[1]=two(month);
                                date[2]=year;
                            }else{
                                date=$('#monthcalendar').val();
                                date=date.split("/");
                            }					
                            if (date.length==3){
                                var url='<xsl:value-of select="/page/@url"/>
			<xsl:value-of select="/page/@lng_url_prefix"/>
			<xsl:value-of select="entry"/>'+date[2]+'-'+date[1]+'/';	
                                var a=$('.ui-datepicker-title').html();
                                $('.ui-datepicker-title').empty();
                                a='&lt;a href="'+url+'">'+a+'&lt;/a>'; 
                                $('.ui-datepicker-title').html(a);
                            }
                        }
                            
                        function in_array(val, ar){
                            if (typeof(ar) != 'object' || !ar || !ar.length){
                                return false;
                            }
                        
                            for (key in ar){
                                if (val == ar[key]){
                                    return true;
                                }
                            }
                            return false;
                        }
                            
                        function two(str){
                            if (typeof(str) != 'string'){
                                str = str.toString();
                            }
                            return str.length &lt;2 ? '0' + str : str;
                        }
                    </script>
	</xsl:template>
	
	<xsl:template name="calendar_lastevents">
	
		<xsl:if test="events/event">

			<ul>
				<xsl:for-each select="events/event">
					<li>
						<xsl:value-of select="date_start"/>
						<xsl:if test="date_end!=date_start"> - <xsl:value-of select="date_end"/>
						</xsl:if>
						<b>
							<a href="{/page/@url}{/page/@lng_url_prefix}{../../entry}{category_system}/">
								<xsl:value-of select="category_title"/>:
						</a>
						</b>
						<a href="{/page/@url}{/page/@lng_url_prefix}{../../entry}{category_system}/{system}/">
							<xsl:value-of select="title" disable-output-escaping="yes"/>
						</a>
						<br/>
						
						<xsl:if test="small_image!=''">
							<img class="fl" src="{/page/settings/cacheurl}thumbs/50x50/{small_image}" alt="{title}" title="{title}" border="0"/>
						</xsl:if>
						<xsl:if test="short_description!=''">
							<div>
								<xsl:value-of select="short_description" disable-output-escaping="yes"/>
							</div>
						</xsl:if>						
						<br/>
					</li>
				</xsl:for-each>
			</ul>
		</xsl:if>
	</xsl:template>
	

</xsl:stylesheet>
