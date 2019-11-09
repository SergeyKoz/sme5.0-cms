<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="no"  media-type="text/html"/>

    <!-- Administrator section layout stylesheet -->
    <xsl:include href="layouts/layout.xsl"/>
    <xsl:include href="blocks/errors.xsl"/>
    <xsl:include href="blocks/debug.xsl"/>
    <xsl:template match="/"><xsl:apply-templates/></xsl:template>


    <xsl:template match="content">
    
    	<xsl:if test="menu/section/link">
		<script type="">
				$(document).ready(function(){
					$('.frameleftmenu dt:first').addClass('selected');
						$('.frameleftmenu dd:not(:first)').hide();
						$(".frameleftmenu dt input").click(function(){
						$(this).parent().next("dd").slideToggle("fast").siblings("dd:visible").slideUp("fast");
						$(this).parent().toggleClass("selected");
						$(this).parent().siblings("dt").removeClass("selected");
					});
				});
							
			</script>
		
			<dl class="frameleftmenu">
				<xsl:for-each select="menu/section[link]">
					<dt>
						<input type="button" value="{title}" class="menubutton"/>
					</dt>
					<dd>
					<ul>
						<xsl:for-each select="link">
							
								<li>
									<a class="img" href="" onclick="parent.{target}.location='{url}'; return false;">
										<img src="{/page/settibngs/filestorageurl}{image}" alt="" />
										<br/>
										
									</a>
									<a href="" onclick="parent.{target}.location='{url}'; return false;">
										<xsl:value-of select="title" disable-output-escaping="yes"/>
									</a>
								</li>
							
						</xsl:for-each>
						</ul>
					</dd>
				</xsl:for-each>
			</dl>
		</xsl:if>

 <script>
	parent.leftmenu.document.body.className  = "navigationframelinks";
	parent.leftmenu.document.body.scroll = 'no'
</script>   
<div id="adminmenushadow"></div>
    </xsl:template>

</xsl:stylesheet>