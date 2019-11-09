<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no"  media-type="text/html"/>

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
  
    <xsl:include href="controls/period_selector_block.xsl"/>

  <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    

    <xsl:template match="content">
        <span class="mainheader">
        <xsl:call-template name="period_info" />
        </span>
        <hr />
        <xsl:call-template name="period_selector_block" />
        <xsl:for-each select="list">
            <xsl:if test="row">
            <script FOR="n[]" EVENT="onclick" LANGUAGE="JScript">
                clearAll("tbl_<xsl:value-of select="./handler/library"/>");
                this.style.background = "A9B2CA";
            </script>
            </xsl:if>
           <xsl:apply-templates select="."/>
       </xsl:for-each>
        <xsl:if test="_return">
            <a href="?{_return/hidden/value}"><xsl:value-of select="//_referers_caption_back" /></a>
        </xsl:if>
    </xsl:template>
</xsl:stylesheet>

  