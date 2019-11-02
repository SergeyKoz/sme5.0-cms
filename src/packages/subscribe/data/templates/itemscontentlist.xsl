<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no" media-type="text/html"/>
	<!-- Administrator section layout stylesheet -->
	<xsl:include href="layouts/layout.xsl"/>
	<xsl:include href="blocks/debug.xsl"/>
	<xsl:include href="blocks/errors.xsl"/>
	<!-- Include controls -->
	<xsl:include href="controls/indicator.xsl"/>
	<xsl:include href="controls/text.xsl"/>
	<xsl:include href="controls/hidden.xsl"/>
	<xsl:include href="controls/checkbox.xsl"/>
	<xsl:include href="controls/select.xsl"/>
	<xsl:include href="controls/password.xsl"/>
	<xsl:include href="controls/radio.xsl"/>
	<xsl:include href="controls/textarea.xsl"/>
	<xsl:include href="controls/htmleditor.xsl"/>
	<xsl:include href="controls/link.xsl"/>
	<xsl:include href="controls/treepath.xsl"/>
	<xsl:include href="controls/datetime.xsl"/>
	<xsl:include href="controls/navigator.xsl"/>
	<xsl:include href="controls/radiogroup.xsl"/>
	<xsl:include href="controls/checkboxgroup.xsl"/>
	<xsl:include href="controls/filelink.xsl"/>
	<!-- Items list controls (renderer and action) -->
	<xsl:include href="controls/itemslist_action.xsl"/>
	<xsl:include href="controls/itemslist_action_custom.xsl"/>
	<xsl:include href="controls/itemslist.xsl"/>
	<!-- Filter form template -->
	<xsl:include href="controls/filterform.xsl"/>
	<!-- Text range  template -->
	<xsl:include href="controls/range.xsl"/>
	<xsl:template match="/">
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="content">
		<script>
				var processLineObject=document.getElementById('processLine');
				
				function sendSubscribe(id, title){
				
					var istestCollection=document.getElementsByName('is_test[]');
					var istest=false;
					for (i=0; i&lt;istestCollection.length; i++)
						if (istestCollection[i].value==id)
							if (istestCollection[i].checked) istest=true;
					
						
					var msg='<xsl:value-of select="/page/content/localization/_sub_init_text1"/> '+(istest==1 ? '<xsl:value-of select="/page/content/localization/_sub_init_text2"/> ' :'')+'<xsl:value-of select="/page/content/localization/_sub_init_text3"/> \''+title+'\''+'?';
					
					
					if (confirm(msg)){
						var url='<xsl:value-of select="/page/@url"/>scripts/subscribemailingstart.php';
						var data={event : 'Mailing', id: id};
						if (istest) data.test=1;
						$.get(url, data, endInitMailing);
					}
					return false;
				}
				
				function endInitMailing(){
					alert('<xsl:value-of select="/page/content/localization/_sub_init_text4"/>.');
					return;	
				}						
				
				function processView(){
					setTimeout('processView()',1000);
					var uni=+new Date();
					var url='<xsl:value-of select="/page/@url"/>CACHE/subscribeprocess.txt';
					$.get(url, {uni:uni}, writeProcess);
				}
				
				
				function writeProcess(indicator){						
					if (indicator=='100'){
						processLine3Object.style.display='none';
					} else {
						processLine3Object.style.display='block';
						processLine2Object.innerHTML='<xsl:value-of select="/page/content/localization/_caption_send_line"/> 	'+indicator+'%';
						var width1 = new String(indicator+'%');
						processLine1Object.style.width=width1;
					}
				}
				
			</script>
		<div>
			<fieldset id="processLine3" style="display:none;">
				<legend id="processLine2"/>
                <div align="center" id="processLine1" style="background-color:#863434; width:50%;">
                    <br/><br/>
                </div>
			</fieldset>
		</div>
		<xsl:for-each select="list">
			<xsl:if test="row">
				<script FOR="n[]" EVENT="onclick" LANGUAGE="JScript">
					clearAll("tbl_<xsl:value-of select="./handler/library"/>");
					this.style.background = "A9B2CA";
				</script>
			</xsl:if>
			<xsl:apply-templates select="."/>
		</xsl:for-each>
		<script type="text/javascript">
			var processLine1Object=document.getElementById('processLine1');
			var processLine2Object=document.getElementById('processLine2');
			var processLine3Object=document.getElementById('processLine3');
			processLine3Object.style.display='none';
			processView();
		</script>
	</xsl:template>
</xsl:stylesheet>
