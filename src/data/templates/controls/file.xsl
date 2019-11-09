<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:include href="elements/title.xsl" />


    <xsl:template match="file">
        <xsl:param name="class"/>
        <xsl:variable name="name"><xsl:value-of select="name"/></xsl:variable>
        <xsl:variable name="directory"><xsl:value-of select="directory"/></xsl:variable>
        <xsl:variable name="maxlength"><xsl:value-of select="maxlength"/></xsl:variable>
        <xsl:variable name="value"><xsl:value-of select="value"/></xsl:variable>
        <xsl:if test="title">
             <xsl:if test="title/align != 'right'">
                 <xsl:apply-templates select="title"/>
             </xsl:if>
        </xsl:if>
        <input type="text" name="{$name}" value="{$value}" id="file_{$name}">
           <xsl:if test="$class != ''">
             <xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
           </xsl:if>
           <xsl:if test="maxlength != ''">
             <xsl:attribute name="maxlength">
                <xsl:value-of select="maxlength"/>
             </xsl:attribute>
           </xsl:if>
           <xsl:if test="size != ''">
             <xsl:attribute name="size">
                <xsl:value-of select="size"/>
             </xsl:attribute>
           </xsl:if>

        </input>

     <!-- &amp;nbsp; <a href="javascript:FilesDlg('editform', '{$name}','{$directory}')"><img src="{/page/@framework_url}packages/libraries/img/ico_choose.gif" width="20" height="17" border="0" alt="{//_caption_file_select}"/></a>&amp;nbsp;-->
	<xsl:if test="tiny_url!=''">
      		<script type="text/javascript" src="{tiny_url}plugins/filemanager/js/mcfilemanager.js"></script>
	     	<script type="">
			function mcFileManagerOpen(field){
	     			mcFileManager.browse({fields : 'file_'+field, relative_urls : true, document_base_url : '<xsl:value-of select="/page/settings/filestorageurl"/>'});
	     		}
     		</script>
      	</xsl:if>
     &amp;nbsp; <a href="javascript:mcFileManagerOpen('{$name}');">
     
     	<img src="{/page/@framework_url}packages/libraries/img/ico_choose.gif" width="20" height="17" border="0" alt="{//_caption_file_select}"/></a>&amp;nbsp;
     <a href="javascript:ClearField('editform', '{$name}')"><img src="{/page/@framework_url}packages/libraries/img/ico_clear.gif" width="20" height="17" border="0" alt="{//_caption_file_clear}"/></a>
      <a href="javascript:FilePreview('{$name}','{/page/settings/filestorageurl}');"><img src="{/page/@framework_url}packages/libraries/img/ico_preview.gif" width="21" height="17" border="0" alt="{//_caption_file_preview}"/></a>
      <xsl:call-template name="indicator"/>

        <xsl:if test="title">
             <xsl:if test="title/align = 'right'">
                 <xsl:apply-templates select="title"/>
             </xsl:if>
        </xsl:if>

    </xsl:template>
</xsl:stylesheet>