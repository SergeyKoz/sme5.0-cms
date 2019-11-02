<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:include href="elements/title.xsl" />


    <xsl:template match="file2">
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
        <input type="text" name="{$name}" value="{$value}" >
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

      &amp;nbsp; <a href="javascript:void(0)" onclick="FilesDlg2('editform', '{$name}','{$directory}')"><img src="{/page/@framework_url}packages/libraries/img/ico_choose.gif" width="20" height="17" border="0" alt="{//_caption_file_select}"/></a>&amp;nbsp;
      <a href="javascript:void(0)" onclick="ClearField('editform', '{$name}')"><img src="{/page/@framework_url}packages/libraries/img/ico_clear.gif" width="20" height="17" border="0" alt="{//_caption_file_clear}"/></a>
      <a href="javascript:void(0)" onclick="FilePreview('{$name}','{/page/settings/filestorageurl}');"><img src="{/page/@framework_url}packages/libraries/img/ico_preview.gif" width="21" height="17" border="0" alt="{//_caption_file_preview}"/></a>

        <xsl:if test="title">
             <xsl:if test="title/align = 'right'">
                 <xsl:apply-templates select="title"/>
             </xsl:if>
        </xsl:if>

    </xsl:template>
</xsl:stylesheet>