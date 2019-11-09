<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    
    <xsl:template match="repeatcontrol"></xsl:template>
    
      <xsl:template match="repeat_container">
    
    	<input id="is_repeat" type="checkbox" name="repeat_event" value="1" onclick="ChangeRepeat(this.checked);">
    		<xsl:if test="../repeatcontrol/repeat_event=1">
    			<xsl:attribute name="checked"></xsl:attribute>
    		</xsl:if>
    	</input><label for="is_repeat"><xsl:value-of select="/page/content/localization/_repeat_event"/></label>
    	<br/><br/>
    	
    	<table cellpadding="10"><tr valign="top"><td>
    	
    	<fieldset>
    		<legend><xsl:value-of select="/page/content/localization/_repeat_every_legend"/></legend>
    		<div style="padding:10px;">
			<xsl:value-of select="/page/content/localization/_repeat_every_text"/>&amp;nbsp;<xsl:apply-templates select="repeat_every_count"/> <xsl:apply-templates select="repeat_every_term"/>
		</div>
	</fieldset>    	
    	
    	</td><td>
    	
    	<fieldset>
    		<legend><xsl:value-of select="/page/content/localization/_repeat_end_legend"/></legend>
    		<div style="padding:10px">
	    		<input id="repeat_end_0" type="radio" value="0" name="repeat_end" onclick="ChangeRepeatEnd(0);">
	    			<xsl:if test="../repeatcontrol/repeat_end=0">
	    				<xsl:attribute name="checked"></xsl:attribute>
	    			</xsl:if>
	    		</input>
	    		<label for="repeat_end_0"><xsl:value-of select="/page/content/localization/_repeat_end_0"/></label><br/>
	    		
	    		<input id="repeat_end_1" type="radio" value="1"  name="repeat_end" onclick="ChangeRepeatEnd(1);">
	    			<xsl:if test="../repeatcontrol/repeat_end=1">
	    				<xsl:attribute name="checked"></xsl:attribute>
	    			</xsl:if>
	    		</input>
	    		<label for="repeat_end_1"><xsl:value-of select="/page/content/localization/_repeat_end_1"/></label> <xsl:apply-templates select="repeat_end_iterations"/>&amp;nbsp;<xsl:value-of select="/page/content/localization/_repeat_end_1_1"/><br/>
	    		
	    		<input id="repeat_end_2" type="radio" value="2"  name="repeat_end" onclick="ChangeRepeatEnd(2);">
	    			<xsl:if test="../repeatcontrol/repeat_end=2">
	    				<xsl:attribute name="checked"></xsl:attribute>
	    			</xsl:if>
	    		</input>
	    		<label for="repeat_end_2"><xsl:value-of select="/page/content/localization/_repeat_end_2"/></label> <xsl:apply-templates select="repeat_end_day"/> <br/>
		</div>
	</fieldset>
    	
    	
    	</td></tr></table>
    	
    	<script type="text/Javascript">
    		function ChangeRepeat(checked){
    			if (checked){
    				document.getElementsByName('repeat_every_count')[0].disabled=false;
    				document.getElementsByName('repeat_every_term')[0].disabled=false;
    				document.getElementsByName('repeat_end')[0].disabled=false;
    				document.getElementsByName('repeat_end')[1].disabled=false;
    				document.getElementsByName('repeat_end')[2].disabled=false;
    				document.getElementsByName('repeat_end_iterations')[0].disabled=false;
    				document.getElementsByName('repeat_end_day_day')[0].disabled=false;
    				document.getElementsByName('repeat_end_day_month')[0].disabled=false;
    				document.getElementsByName('repeat_end_day_year')[0].disabled=false;
    				
    				for (i=0; i&lt;document.getElementsByName('repeat_end').length; i++){
    					if (document.getElementsByName('repeat_end')[i].checked)
    						ChangeRepeatEnd(i);
    				}
    				
    			}else{
    				document.getElementsByName('repeat_every_count')[0].disabled=true;
    				document.getElementsByName('repeat_every_term')[0].disabled=true;
    				document.getElementsByName('repeat_end')[0].disabled=true;
    				document.getElementsByName('repeat_end')[1].disabled=true;
    				document.getElementsByName('repeat_end')[2].disabled=true;
    				document.getElementsByName('repeat_end_iterations')[0].disabled=true;
    				document.getElementsByName('repeat_end_day_day')[0].disabled=true;
    				document.getElementsByName('repeat_end_day_month')[0].disabled=true;
    				document.getElementsByName('repeat_end_day_year')[0].disabled=true;
    			}    			
    		}
    		
    		ChangeRepeat(<xsl:choose>
							<xsl:when test="../repeatcontrol/repeat_event=1">true</xsl:when>
							<xsl:otherwise>false</xsl:otherwise>
						</xsl:choose>);
		function ChangeRepeatEnd(item){
			switch(item){
				case 0: 	document.getElementsByName('repeat_end_iterations')[0].disabled=true;
		    				document.getElementsByName('repeat_end_day_day')[0].disabled=true;
		    				document.getElementsByName('repeat_end_day_month')[0].disabled=true;
		    				document.getElementsByName('repeat_end_day_year')[0].disabled=true;
						break;
						
				case 1: 	document.getElementsByName('repeat_end_iterations')[0].disabled=false;
		    				document.getElementsByName('repeat_end_day_day')[0].disabled=true;
		    				document.getElementsByName('repeat_end_day_month')[0].disabled=true;
		    				document.getElementsByName('repeat_end_day_year')[0].disabled=true;
						break;
				case 2: 	document.getElementsByName('repeat_end_iterations')[0].disabled=true;
		    				document.getElementsByName('repeat_end_day_day')[0].disabled=false;
		    				document.getElementsByName('repeat_end_day_month')[0].disabled=false;
		    				document.getElementsByName('repeat_end_day_year')[0].disabled=false;
						break;
			}		
		}
		ChangeRepeatEnd(<xsl:value-of select="../repeatcontrol/repeat_end"/>);
    	</script>
    	
    </xsl:template>
</xsl:stylesheet>
