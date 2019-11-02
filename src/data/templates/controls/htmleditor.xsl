<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:template match="htmleditor">
       <xsl:variable name="name"><xsl:value-of select="name"/></xsl:variable>
       <xsl:variable name="image_path"><xsl:value-of select="/page/@framework_url"/>img/htmleditor/</xsl:variable>
       <xsl:variable name="css_path"><xsl:value-of select="/page/@url"/>css/</xsl:variable>
                <script language="JavaScript" src="{/page/@framework_url}scripts/toolbar.js"></script>
                <link rel="stylesheet" type="text/css" href="{/page/@url}css/toolbar.css"/>
<xsl:for-each select="//localization/_alias_hint">
 <xsl:value-of select="." />
</xsl:for-each>

<table border="0" cellspacing="0" cellpadding="0" width="100%">

    <tr>
        <td id="SPAW_{$name}_toolbar_top_design" class="SPAW_classic_toolbar" colspan="3">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td align="left" valign="top" class="SPAW_classic_toolbar_top">
                    <img id="SPAW_{$name}_tb_cut" alt="Cut" src="{$image_path}tb_cut.gif" onClick="SPAW_cut_click('{$name}',this)" class="SPAW_classic_tb_out" onMouseOver="SPAW_classic_bt_over(this)" onMouseOut="SPAW_classic_bt_out(this)" onMouseDown="SPAW_classic_bt_down(this)" onMouseUp="SPAW_classic_bt_up(this)"   unselectable="on"/>
                    <img id="SPAW_{$name}_tb_copy" alt="Copy" src="{$image_path}tb_copy.gif" onClick="SPAW_copy_click('{$name}',this)" class="SPAW_classic_tb_out" onMouseOver="SPAW_classic_bt_over(this)" onMouseOut="SPAW_classic_bt_out(this)" onMouseDown="SPAW_classic_bt_down(this)" onMouseUp="SPAW_classic_bt_up(this)"   unselectable="on"/>
                    <img id="SPAW_{$name}_tb_paste" alt="Paste" src="{$image_path}tb_paste.gif" onClick="SPAW_paste_click('{$name}',this)" class="SPAW_classic_tb_out" onMouseOver="SPAW_classic_bt_over(this)" onMouseOut="SPAW_classic_bt_out(this)" onMouseDown="SPAW_classic_bt_down(this)" onMouseUp="SPAW_classic_bt_up(this)"   unselectable="on"/>
                    <img id="SPAW_{$name}_tb_vertical_separator" alt="" src="{$image_path}tb_vertical_separator.gif"  unselectable="on"/><img id="SPAW_{$name}_tb_undo" alt="Undo" src="{$image_path}tb_undo.gif" onClick="SPAW_undo_click('{$name}',this)" class="SPAW_classic_tb_out" onMouseOver="SPAW_classic_bt_over(this)" onMouseOut="SPAW_classic_bt_out(this)" onMouseDown="SPAW_classic_bt_down(this)" onMouseUp="SPAW_classic_bt_up(this)"   unselectable="on"/>
                    <img id="SPAW_{$name}_tb_redo" alt="Redo" src="{$image_path}tb_redo.gif" onClick="SPAW_redo_click('{$name}',this)" class="SPAW_classic_tb_out" onMouseOver="SPAW_classic_bt_over(this)" onMouseOut="SPAW_classic_bt_out(this)" onMouseDown="SPAW_classic_bt_down(this)" onMouseUp="SPAW_classic_bt_up(this)"   unselectable="on"/>
                    <img id="SPAW_{$name}_tb_vertical_separator" alt="" src="{$image_path}tb_vertical_separator.gif"  unselectable="on"/><select size="1" id="SPAW_{$name}_tb_style" name="SPAW_{$name}_tb_style" align="absmiddle" class="SPAW_classic_tb_input" onchange="SPAW_style_change('{$name}',this)" ><option>Style</option><option value="style2">Style2</option></select>
                    <img id="SPAW_{$name}_tb_vertical_separator" alt="" src="{$image_path}tb_vertical_separator.gif"  unselectable="on"/><img id="SPAW_{$name}_tb_bold" alt="Bold" src="{$image_path}tb_bold.gif" onClick="SPAW_bold_click('{$name}',this)" class="SPAW_classic_tb_out" onMouseOver="SPAW_classic_bt_over(this)" onMouseOut="SPAW_classic_bt_out(this)" onMouseDown="SPAW_classic_bt_down(this)" onMouseUp="SPAW_classic_bt_up(this)"   unselectable="on"/>
                    <img id="SPAW_{$name}_tb_italic" alt="Italic" src="{$image_path}tb_italic.gif" onClick="SPAW_italic_click('{$name}',this)" class="SPAW_classic_tb_out" onMouseOver="SPAW_classic_bt_over(this)" onMouseOut="SPAW_classic_bt_out(this)" onMouseDown="SPAW_classic_bt_down(this)" onMouseUp="SPAW_classic_bt_up(this)"   unselectable="on"/>
                    <img id="SPAW_{$name}_tb_underline" alt="Underline" src="{$image_path}tb_underline.gif" onClick="SPAW_underline_click('{$name}',this)" class="SPAW_classic_tb_out" onMouseOver="SPAW_classic_bt_over(this)" onMouseOut="SPAW_classic_bt_out(this)" onMouseDown="SPAW_classic_bt_down(this)" onMouseUp="SPAW_classic_bt_up(this)"   unselectable="on"/>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    <select size="1" id="SPAW_spaw3_tb_font" name="SPAW_spaw3_tb_font" align="absmiddle" class="SPAW_classic_tb_input" onchange="SPAW_font_change('{$name}',this)" ><option>Font</option><option value="Arial,Helvetica,Verdana, Sans Serif">Arial</option><option value="Courier, Courier New">Courier</option><option value="Tahoma, Verdana, Arial, Helvetica, Sans Serif">Tahoma</option><option value="Times New Roman, Times, Serif">Times</option><option value="Verdana, Tahoma, Arial, Helvetica, Sans Serif">Verdana</option></select><select size="1" id="SPAW_spaw3_tb_fontsize" name="SPAW_spaw3_tb_fontsize" align="absmiddle" class="SPAW_classic_tb_input" onchange="SPAW_fontsize_change('{$name}',this)" ><option>Size</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option></select>
                    <img id="SPAW_{$name}_tb_vertical_separator" alt="" src="{$image_path}tb_vertical_separator.gif"  unselectable="on"/><img id="SPAW_{$name}_tb_ordered_list" alt="Ordered list" src="{$image_path}tb_ordered_list.gif" onClick="SPAW_ordered_list_click('{$name}',this)" class="SPAW_classic_tb_out" onMouseOver="SPAW_classic_bt_over(this)" onMouseOut="SPAW_classic_bt_out(this)" onMouseDown="SPAW_classic_bt_down(this)" onMouseUp="SPAW_classic_bt_up(this)"   unselectable="on"/>
                    <img id="SPAW_{$name}_tb_bulleted_list" alt="Bulleted list" src="{$image_path}tb_bulleted_list.gif" onClick="SPAW_bulleted_list_click('{$name}',this)" class="SPAW_classic_tb_out" onMouseOver="SPAW_classic_bt_over(this)" onMouseOut="SPAW_classic_bt_out(this)" onMouseDown="SPAW_classic_bt_down(this)" onMouseUp="SPAW_classic_bt_up(this)"   unselectable="on"/>
                    <img id="SPAW_{$name}_tb_vertical_separator" alt="" src="{$image_path}tb_vertical_separator.gif"  unselectable="on"/>
                    <img id="SPAW_{$name}_tb_indent" alt="Indent" src="{$image_path}tb_indent.gif" onClick="SPAW_indent_click('{$name}',this)" class="SPAW_classic_tb_out" onMouseOver="SPAW_classic_bt_over(this)" onMouseOut="SPAW_classic_bt_out(this)" onMouseDown="SPAW_classic_bt_down(this)" onMouseUp="SPAW_classic_bt_up(this)"   unselectable="on"/>
                    <img id="SPAW_{$name}_tb_unindent" alt="Unindent" src="{$image_path}tb_unindent.gif" onClick="SPAW_unindent_click('{$name}',this)" class="SPAW_classic_tb_out" onMouseOver="SPAW_classic_bt_over(this)" onMouseOut="SPAW_classic_bt_out(this)" onMouseDown="SPAW_classic_bt_down(this)" onMouseUp="SPAW_classic_bt_up(this)"   unselectable="on"/>
                    <img id="SPAW_{$name}_tb_vertical_separator" alt="" src="{$image_path}tb_vertical_separator.gif"  unselectable="on"/>
                    <img id="SPAW_{$name}_tb_left" alt="Left" src="{$image_path}tb_left.gif" onClick="SPAW_left_click('{$name}',this)" class="SPAW_classic_tb_out" onMouseOver="SPAW_classic_bt_over(this)" onMouseOut="SPAW_classic_bt_out(this)" onMouseDown="SPAW_classic_bt_down(this)" onMouseUp="SPAW_classic_bt_up(this)"   unselectable="on"/>
                    <img id="SPAW_{$name}_tb_center" alt="Center" src="{$image_path}tb_center.gif" onClick="SPAW_center_click('{$name}',this)" class="SPAW_classic_tb_out" onMouseOver="SPAW_classic_bt_over(this)" onMouseOut="SPAW_classic_bt_out(this)" onMouseDown="SPAW_classic_bt_down(this)" onMouseUp="SPAW_classic_bt_up(this)"   unselectable="on"/>
                    <img id="SPAW_{$name}_tb_right" alt="Right" src="{$image_path}tb_right.gif" onClick="SPAW_right_click('{$name}',this)" class="SPAW_classic_tb_out" onMouseOver="SPAW_classic_bt_over(this)" onMouseOut="SPAW_classic_bt_out(this)" onMouseDown="SPAW_classic_bt_down(this)" onMouseUp="SPAW_classic_bt_up(this)"   unselectable="on"/>
                    </td>
                 </tr>
             </table>
         </td>
         <td id="SPAW_{$name}_toolbar_top_html" class="SPAW_classic_toolbar" colspan="3" style="display : none;">
         </td>
     </tr>
     <tr>
         <td id="SPAW_{$name}_toolbar_left_design" valign="top" class="SPAW_classic_toolbar" >
         </td>
         <td id="SPAW_{$name}_toolbar_left_html" valign="top" class="SPAW_classic_toolbar" style="display : none;">
         </td>
         <td align="left" valign="top" width="100%">
            <textarea id="{$name}" name="{$name}" style="width:100%; height:247px; display:none;" class="SPAW_classic_editarea">
            <xsl:value-of select="content"/>
            </textarea>
            <input type="hidden" id="SPAW_{$name}_editor_mode" name="SPAW_{$name}_editor_mode" value="design"/>
            <input type="hidden" id="SPAW_{$name}_lang" value="en"/>
            <input type="hidden" id="SPAW_{$name}_theme" value="classic"/>
            <input type="hidden" id="SPAW_{$name}_borders" value="on"/>
            <iframe id="{$name}_rEdit" style="width:100%; height:200px; direction:ltr;" onLoad="SPAW_editorInit('{$name}','{$css_path}/wysiwyg.css','ltr');" class="SPAW_classic_editarea" frameborder="no"></iframe><br/>
         </td>
         <td id="SPAW_{$name}_toolbar_right_design" valign="top" class="SPAW_classic_toolbar">
         </td>
         <td id="SPAW_{$name}_toolbar_right_html" valign="top" class="SPAW_classic_toolbar" style="display : none;">
         </td>
     </tr>
     <tr>
         <td class="SPAW_classic_toolbar">
         </td>
         <td id="SPAW_{$name}_toolbar_bottom_design" class="SPAW_classic_toolbar" width="100%">
             <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td align="right" valign="top" class="SPAW_classic_toolbar_bottom">
                        <img id="SPAW_{$name}_tb_design_tab_on" alt="" src="{$image_path}tb_design_tab_on.gif"  unselectable="on"/>
                        <img id="SPAW_{$name}_tb_html_tab" alt="Switch to HTML (code) mode" src="{$image_path}tb_html_tab.gif" onClick="SPAW_html_tab_click('{$name}',this)" class="SPAW_classic_tb_out" onMouseOver="SPAW_classic_bt_over(this)" onMouseOut="SPAW_classic_bt_out(this)" onMouseDown="SPAW_classic_bt_down(this)" onMouseUp="SPAW_classic_bt_up(this)"   unselectable="on"/>
                    </td>
                </tr>
             </table>
         </td>
         <td id="SPAW_{$name}_toolbar_bottom_html" class="SPAW_classic_toolbar" width="100%" style="display : none;">
             <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                   <td align="right" valign="top" class="SPAW_classic_toolbar_bottom">
                      <img id="SPAW_{$name}_tb_design_tab" alt="Switch to WYSIWYG (design) mode" src="{$image_path}tb_design_tab.gif" onClick="SPAW_design_tab_click('{$name}',this)" class="SPAW_classic_tb_out" onMouseOver="SPAW_classic_bt_over(this)" onMouseOut="SPAW_classic_bt_out(this)" onMouseDown="SPAW_classic_bt_down(this)" onMouseUp="SPAW_classic_bt_up(this)"   unselectable="on"/>
                      <img id="SPAW_{$name}_tb_html_tab_on" alt="" src="{$image_path}tb_html_tab_on.gif"  unselectable="on"/>
                   </td>
                </tr>
             </table>
          </td>
          <td class="SPAW_classic_toolbar">
          </td>
      </tr>
   </table>
<script language="javascript">
    setTimeout('document.all.<xsl:value-of select="$name"/>.value = document.all.<xsl:value-of select="$name"/>.value.replace(/&quot;/g,\'"\');',0);
</script>

    </xsl:template>
</xsl:stylesheet>