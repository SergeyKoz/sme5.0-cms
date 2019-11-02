<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template name="maincontextcontrol">
		<xsl:param name="bodyclass"/>
		<xsl:choose>
			<xsl:when test="/page/content/cms_context/context_mode = 'edit'">
				<xsl:attribute name="class"><xsl:value-of select="$bodyclass"/> edit</xsl:attribute>
			</xsl:when>
			<xsl:when test="$bodyclass!=''">
				<xsl:attribute name="class"><xsl:value-of select="$bodyclass"/></xsl:attribute>
			</xsl:when>
		</xsl:choose>
		<xsl:if test="/page/@user_id>0 and (/page/content/cms_context/contextmenu/menu/item or /page/content/cms_context/menu/section or  /page/content/cms_context/context_mode='view')">
			<script type="text/javascript">
				jQuery(document).ready(function(){
					<xsl:if test="/page/content/cms_context/contextmenu/menu">
					initSMEControls();
					</xsl:if>
					jQuery('.sme-item-control-panel').draggable();
					jQuery('.sme-item-control-panel').bind('mouseover',function(){jQuery(this).parent().addClass('dashed');}).bind('mouseout', function(){jQuery(this).parent().removeClass('dashed');});

				});
			</script>
			<div id="dialog" title="" align="center">
				<iframe src="" id="dialogframe" style="width:98%; height:98%; border:0;"/>
			</div>
			<script type="text/javascript">
				var downImage=['downarrowclass', '<xsl:value-of select="/page/content/cms_context/context_url"/>img/menudown.gif', 23];
				var rightImage=['rightarrowclass', '<xsl:value-of select="/page/content/cms_context/context_url"/>img/menuright.gif'];

				ddsmoothmenu.arrowimages={down:downImage, right:rightImage};
			</script>
			<script type="text/javascript">

				ddsmoothmenu.init({
					mainmenuid: "maincontextmenu", //menu DIV id
					orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
					classname: 'sme-control-panel_', //class added to menu's outer DIV
					//customtheme: ["#1c5a80", "#18374a"],
					contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
				})

				$( "#dialog" ).dialog({autoOpen: false, modal: true, resizable:false, width: 900, height:600, dialogClass:'sme_dialog_panel'});

				function openmainmenuframe(url){
					url='<xsl:value-of select="/page/@url"/>extranet/frame.php'+url+'&amp;contextframe=1';
					$( "#dialogframe" )[0].src=url;
					$( "#dialog" ).dialog( "open" );
					return false;
				}

				//open mode frame
				function openframe(url, cfmr, params){
					if (cfmr!='') if (!confirm(cfmr)) return false;
					var pars='?';
					for(key in params)
						pars=pars+'&amp;'+key+'='+params[key];

					$( "#dialogframe" )[0].src='<xsl:value-of select="/page/@url"/>'+url+pars+'&amp;contextframe=1';
					$( "#dialog" ).dialog( "open" );
					return false;
				}

				function closeframe(){
					$( "#dialog" ).dialog( "close" );
				}

				function refreshpage(messages){
					$( "#dialog" ).dialog( "close" );
					page(messages);
				}

				//open mode ajax
				function openajax(url, cfmr, parameters){
					if (cfmr!='') if (!confirm(cfmr)) return false;
					url='<xsl:value-of select="/page/@url"/>'+url;
					$.get(url, parameters, openajaxend);
					return false;
				}

				function openajaxend(requst){
					if (requst!=''){
						var messages=eval(requst);
						page(messages);
					}
				}

				function page(messages){
					var msgs='';
					if (typeof messages=='object')
						for (i=0; i&lt;messages.length; i++)
							msgs=msgs+'&amp;MESSAGE[]='+messages[i];

					var pageurl='<xsl:value-of select="/page/@url"/>
				<xsl:value-of select="/page/@request_uri"/>';
					pageurl=pageurl.replace(/&amp;MESSAGE\[\]=.*?$/gi, '');
					window.location.href=pageurl+msgs;
				}

				<xsl:if test="/page/content/cms_context/contextmenu/menu">
					var contextmenu=[<xsl:for-each select="/page/content/cms_context/contextmenu/menu[item]">
					{'mode':'<xsl:value-of select="@mode"/>', 'item_id':'<xsl:value-of select="@item_id"/>', menu:[<xsl:for-each select="item">{'url':'<xsl:value-of select="url"/>', 'mode':'<xsl:value-of select="mode"/>', 'type':'<xsl:value-of select="type"/>', 'caption':'<xsl:value-of select="caption"/>', <xsl:if test="confirm!=''">'confirm':'<xsl:value-of select="confirm"/>',</xsl:if>
							<xsl:if test="icon_class!=''">'icon_class':'<xsl:value-of select="icon_class"/>',</xsl:if>
							<xsl:if test="icon_url!=''">'icon_url':'<xsl:value-of select="icon_url"/>',</xsl:if> 'params':{<xsl:if test="params/param">
								<xsl:for-each select="params/param">'<xsl:value-of select="@key"/>':'<xsl:value-of select="."/>'<xsl:if test="position()!=last()">, </xsl:if>
								</xsl:for-each>
							</xsl:if>}}<xsl:if test="position()!=last()">, </xsl:if>
						</xsl:for-each>]} <xsl:if test="position()!=last()">, </xsl:if>
					</xsl:for-each>];


       				function initSMEControls(){
       					var contextUrl='<xsl:value-of select="/page/content/cms_context/context_url"/>';
       					var menu, menuObject, menuItemsObject, menuItemObject, menuLinkObject, script="", params;
						$("*[rel^='SME']").each(function(i){
							var rel=this.getAttribute('rel');
							rel=eval('['+rel.substr(4,rel.length-4)+']')[0];

							for (i=0; i&lt;contextmenu.length; i++){
								if (contextmenu[i].mode==rel.mode &amp;&amp; contextmenu[i].item_id==rel.item_id){
									menu=contextmenu[i].menu;

									menuItemsObject=$('&lt;ul/>').attr('style', 'display:none');


									for (c=0; c&lt;menu.length; c++){
										menuItemObject=$('&lt;li/>');
										if (menu[c].icon_class!='')
											menuItemObject.addClass(menu[c].icon_class);
	
										menuLinkObject=$('&lt;a/>').text(menu[c].caption);
										params=new Object;
										for(var param in menu[c].params) params[param]=menu[c].params[param];
										for(var param in rel.params) params[param]=rel.params[param];
	
										if (menu[c].type=='separator') menuLinkObject.append('&lt;hr/>');
										
										if (menu[c].type=='item'){
											menuLinkObject.attr('href', '');
											if (menu[c].mode=='frame'){
												(function (menu, params) {menuLinkObject.click(function(){
													return openframe(menu.url, (typeof menu.confirm=='string' ? menu.confirm : ''), params);
												});})(menu[c], params);
											}
	
											if (menu[c].mode=='ajax'){
												(function (menu, params) {menuLinkObject.click(function(){
													return openajax(menu.url, (typeof menu.confirm=='string' ? menu.confirm : ''), params);
												});})(menu[c], params);
											}
										}
										menuItemsObject.append(menuItemObject.append(menuLinkObject));
									}

									menuObject=$('&lt;div/>').attr('id', 'contextmenu'+rel.mode+rel.item_id).addClass('sme-item-control-panel').append($('&lt;ul/>').append($('&lt;li/>').append($('&lt;a/>').addClass('icon').append($('&lt;img/>').attr({'src':contextUrl+'img/menu.png', 'alt':''}))).append(menuItemsObject)));

									$(this).addClass('sme-area-data sme-area-'+rel.mode).prepend(menuObject);
	
									ddsmoothmenu.init({
										mainmenuid: "contextmenu"+rel.mode+rel.item_id,
										orientation: 'h',
										classname: 'sme-item-control-panel',
										contentsource: "markup"
									})
								}
							}
						});
					}
					
					
					
					
				</xsl:if>
				
				function ClearCache(){
					url='<xsl:value-of select="/page/@url"/>extranet/frame.php';						
					var parameters={'package':'system', 'page':'cleancache'};
					$.get(url, parameters, CacheCleaned);
					return false;
				}
				
				function CacheCleaned(){
					alert('<xsl:value-of select="/page/content/localization/context_cache_cleaned"/>');
				}
				
			</script>
			<div id="maincontextmenu" class="sme-control-panel_">
				<span class="icon">&amp;nbsp;</span>
				<ul style="padding:6px 0px 0">
					<xsl:if test="/page/content/cms_context/contextmenu or /page/content/cms_context/context_mode='view'">
						<li>
							<xsl:choose>
								<xsl:when test="/page/content/cms_context/context_mode='view'">
									<xsl:attribute name="class">act</xsl:attribute>
									<b>
										<a href="{/page/@url}{/page/@request_uri}&amp;mode=view">
											<span>
												<xsl:value-of select="/page/content/localization/context_view_mode"/>
											</span>
										</a>
									</b>
								</xsl:when>
								<xsl:otherwise>
									<a href="{/page/@url}{/page/@request_uri}&amp;mode=view">
										<span>
											<xsl:value-of select="/page/content/localization/context_view_mode"/>
										</span>
									</a>
								</xsl:otherwise>
							</xsl:choose>
						</li>
						<li class="top_item_menu">
							<xsl:choose>
								<xsl:when test="/page/content/cms_context/context_mode='edit'">
									<xsl:attribute name="class">act</xsl:attribute>
									<b>
										<a href="{/page/@url}{/page/@request_uri}&amp;mode=edit">
											<span>
												<xsl:value-of select="/page/content/localization/context_edit_mode"/>
											</span>
										</a>
									</b>
								</xsl:when>
								<xsl:otherwise>
									<a href="{/page/@url}{/page/@request_uri}&amp;mode=edit">
										<span>
											<xsl:value-of select="/page/content/localization/context_edit_mode"/>
										</span>
									</a>
								</xsl:otherwise>
							</xsl:choose>
						</li>
					</xsl:if>
					<xsl:if test="/page/content/cms_context/menu/section">
						<li style="z-index: 98;">
							<a class="" href="{/page/@url}extranet/" target="_blank">
								<span>
									<xsl:value-of select="/page/content/localization/context_control_panel"/>
								</span>
							</a>
							<ul style="display: none;">
								<xsl:for-each select="/page/content/cms_context/menu/section">
									<li>
										<a href="javascript:void 0" onclick="return false;">
											<span>
												<xsl:value-of select="title"/>
											</span>
										</a>
										<ul>
											<xsl:for-each select="link">
												<li>
													<a href="" onclick="return openmainmenuframe('{url}');">
														<span>
															<xsl:value-of select="title" disable-output-escaping="yes"/>
														</span>
													</a>
												</li>
											</xsl:for-each>
										</ul>
									</li>
								</xsl:for-each>
							</ul>
						</li>
					</xsl:if>
					<xsl:if test="count(/page/content/cms_context/languages/language)>1">
						<li style="z-index: 98;">
							<a class="" href="javascript:void 0" onclick="return false;">
								<span>
									<xsl:value-of select="/page/content/cms_context/languages/language[prefix=/page/@language]/shortname"/>
								</span>
							</a>
							<ul style="display: none;" class="langul" >
								<xsl:for-each select="/page/content/cms_context/languages/language[prefix!=/page/@language]">
									<li>
										<a href="{/page/@url}{prefix}/">
											<span>
												<xsl:value-of select="shortname"/>
											</span>
										</a>										
									</li>
								</xsl:for-each>
							</ul>
						</li>
					</xsl:if>
					<!-- Right buttons -->
					<li class="rb">
						<a href="javascript:;" title="{/page/content/localization/context_clean_cache}" onclick="return ClearCache();" class="clcache">&amp;nbsp;</a>
					</li>
					<li class="rb">
						<a class="" href="{/page/@url}extranet/frame.php?package=system&amp;page=userlogoff">
							<span>
								<xsl:value-of select="/page/content/localization/context_exit"/>
							</span>
						</a>
					</li>
					<li class="rb" style="margin:0 10px;">
						<xsl:value-of select="/page/content/localization/context_user"/>:
						<xsl:value-of select="/page/@user_name"/>
					</li>
				</ul>
				<div style="clear:both"/>
			</div>
		</xsl:if>
	</xsl:template>
	<xsl:template name="contextcontrol">
		<xsl:param name="mode"/>
		<xsl:param name="item_id"/>
		<xsl:param name="params"/>
		<xsl:param name="class"/>
		<xsl:if test="/page/content/cms_context/contextmenu/menu[@mode=$mode and @item_id=$item_id]/item">
			<xsl:variable name="containerclass">
				sme-area-data sme-area-<xsl:value-of select="$mode"/>
				<xsl:if test="$class!=''">
					<xsl:text> </xsl:text>
					<xsl:value-of select="$class"/>
				</xsl:if>
			</xsl:variable>
			<xsl:attribute name="class"><xsl:value-of select="$containerclass"/></xsl:attribute>
			<div id="contextmenu{$mode}{$item_id}" class="sme-item-control-panel">
				<ul>
					<li>
						<a class="icon">
							<img src="{/page/content/cms_context/context_url}img/menu.png" alt=""/>
						</a>
						<ul style="display:none">
							<xsl:for-each select="/page/content/cms_context/contextmenu/menu[@mode=$mode and @item_id=$item_id]/item">
								<li>
									<xsl:if test="icon_class!=''">
										<xsl:attribute name="class"><xsl:value-of select="icon_class"/></xsl:attribute>
									</xsl:if>
									<xsl:choose>
										<xsl:when test="type='item'">
											<xsl:variable name="par">
												<xsl:if test="params/param">, {<xsl:for-each select="params/param">
														<xsl:value-of select="@key"/>:'<xsl:value-of select="."/>'<xsl:if test="position()!=last()"> ,</xsl:if>
													</xsl:for-each>
													<xsl:if test="$params!=''">, <xsl:value-of select="$params"/>
													</xsl:if>}</xsl:if>
											</xsl:variable>
											<a href="" onclick="return open{mode}('{url}', '{confirm}'{$par});">
												<xsl:if test="icon_url">
													<img src="{icon_url}" alt="{caption}"/>
												</xsl:if>
												<xsl:value-of select="caption"/>
											</a>
										</xsl:when>
										<xsl:when test="type='separator'">
											<a>
												<hr/>
											</a>
										</xsl:when>
									</xsl:choose>
								</li>
							</xsl:for-each>
						</ul>
					</li>
				</ul>
			</div>
			<script type="text/javascript">
				ddsmoothmenu.init({
					mainmenuid: "contextmenu<xsl:value-of select="$mode"/>
				<xsl:value-of select="$item_id"/>", //menu DIV id
					orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
					classname: 'sme-item-control-panel', //class added to menu's outer DIV
					//customtheme: ["#1c5a80", "#18374a"],
					contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
				})
			</script>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
