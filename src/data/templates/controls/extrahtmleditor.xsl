<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template match="extrahtmleditor">
		<xsl:param name="class"/>
		<xsl:param name="disabled"/>
		
		<!-- TinyMCE -->
<script type="text/javascript">
	<xsl:variable name="tiny_lang"><xsl:choose>
		<xsl:when test="/page/@language='ua'">uk</xsl:when>
		<xsl:otherwise><xsl:value-of select="/page/@language"/></xsl:otherwise>
	</xsl:choose>	
	</xsl:variable>
	
	tinyMCE.init({
		// General options
		language : "<xsl:value-of select="$tiny_lang"/>",
		
		mode : "specific_textareas",
		<xsl:if test="$disabled='yes'">
			readonly : 1,
		</xsl:if>

		editor_selector : "editor_<xsl:value-of select="name"/>",
		theme : "<xsl:value-of select="theme"/>",
		
		<xsl:choose>
			<xsl:when test="skin='o2k7'">
				skin : "o2k7",
			</xsl:when>
			<xsl:when test="skin='silver'">
				skin : "o2k7",
				skin_variant : "silver",
			</xsl:when>
			<xsl:when test="skin='black'">
				skin : "o2k7",
				skin_variant : "black",
			</xsl:when>			
		</xsl:choose>
		
		<xsl:if test="theme='advanced'">		
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,filemanager,imagemanager",

		// Theme options    emotions,
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
//styleselect,
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		//content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		//template_external_list_url : "lists/template_list.js",
		//external_link_list_url : "lists/link_list.js",
		//external_image_list_url : "lists/image_list.js",
		//media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		/*template_replace_values : {
			username : "Some User",
			staffid : "991234"
		},*/
		
		
		</xsl:if>
		// Enable translation mode
		convert_urls : true,		
		
		relative_urls : false	
		
		
	});
	

</script>
<!--

mcFileManager.init({
	relative_urls : false,
	remember_last_path : false
});

mcImageManager.init({
	relative_urls : false,
	remember_last_path : false
});
relative_urls : true,
document_base_url : "http://localhost/zencart/"

За ссылки в самом редакторе отвечают 3 параметра, у меня выставлено так:
relative_urls : false,
remove_script_host : true,
document_base_url : "http://site.com/",

Вопрос по теме:
Как залепить свои теги? - желательно сделать кнопкой в панели.
Конкретно интересует вставка бб кодов, таких как хайд, спойлер и подобного.
Рассмотрю любые варианты. 
rows="15" cols="80" style="width: 80%"
-->
<!-- /TinyMCE -->
		<textarea name="{name}" id="editor_{name}" class="editor_{name}">
			<xsl:if test="cols>0">
				<xsl:attribute name="cols"><xsl:value-of select="cols"/></xsl:attribute>
			</xsl:if>
			<xsl:if test="rows>0">
				<xsl:attribute name="rows"><xsl:value-of select="rows"/></xsl:attribute>
			</xsl:if>
			<xsl:value-of select="content"/>
		</textarea>
	</xsl:template>	
</xsl:stylesheet>
