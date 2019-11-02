function SPAW_classic_bt_over(ctrl)
{
  ctrl.className = "SPAW_classic_tb_over";
}
function SPAW_classic_bt_out(ctrl)
{
  var imgfile = SPAW_base_image_name(ctrl)+".gif";
  ctrl.src = imgfile;
  ctrl.disabled = false;
  if (ctrl.getAttribute("spaw_state") == true)
  {
    ctrl.className = "SPAW_classic_tb_down";
  }
  else
  {
    ctrl.className = "SPAW_classic_tb_out";
  }
}
function SPAW_classic_bt_down(ctrl)
{
  ctrl.className = "SPAW_classic_tb_down";
}
function SPAW_classic_bt_up(ctrl)
{
  ctrl.className = "SPAW_classic_tb_out";
}
function SPAW_classic_bt_off(ctrl)
{
  var imgfile = SPAW_base_image_name(ctrl)+"_off.gif";
  ctrl.src = imgfile;
  ctrl.disabled = true;
}

<!--
var spaw_active_toolbar = true;
  var spaw_editors = new Array();
 
  function SPAW_editor_registered(editor)
  {
    var found = false;
    for(i=0;i<spaw_editors.lenght;i++)
    {
      if (spaw_editors[i] == editor)
      {
        found = true;        
        break;
      } 
    }    
    return(found);
  }
 
  function SPAW_UpdateFields()
  {
    for (i=0; i<spaw_editors.length; i++)
    {
      SPAW_updateField(spaw_editors[i], null);
    }
  }
 
// adds event handler for the form to update hidden fields
  function SPAW_addOnSubmitHandler(editor)
  {
    thefield = SPAW_getFieldByEditor(editor, null);
    var sTemp = "";
    oForm = document.forms['editform'];        
    if(oForm.onsubmit != null) {
      // sTemp = oForm.onsubmit.value;      
      //iStart = sTemp.indexOf("{") + 2;
      //sTemp = sTemp.substr(iStart,sTemp.length-iStart-2);
    }
    
    if (sTemp.indexOf("SPAW_UpdateFields();") == -1)
    {
      oForm.onsubmit = new Function("SPAW_UpdateFields();" + sTemp);
    }   
  }


  function SPAW_editorInit(editor, css_stylesheet, direction)
  {
    if (!SPAW_editor_registered(editor))
    {
      if (document.readyState != 'complete')
      {
        setTimeout(function(){SPAW_editorInit(editor, css_stylesheet, direction);},1000);
        return;
      }
 
      this[editor+'_rEdit'].document.designMode = 'On';
 

      spaw_editors[spaw_editors.length] = editor;
 
      SPAW_addOnSubmitHandler(editor);
 
 
      if (this[editor+'_rEdit'].document.readyState == 'complete')
      {
        this[editor+'_rEdit'].document.createStyleSheet(css_stylesheet);
        this[editor+'_rEdit'].document.body.dir = direction;
        this[editor+'_rEdit'].document.body.innerHTML = document.all[editor].value;
    SPAW_toggle_borders(editor,this[editor+'_rEdit'].document.body,null);
 
        this[editor+'_rEdit'].document.onkeyup = function() { SPAW_onkeyup(editor); }
        this[editor+'_rEdit'].document.onmouseup = function() { SPAW_update_toolbar(editor, true); }
 
        spaw_context_html = "";
        SPAW_update_toolbar(editor, true);
      }
    }
  }
 
 


  function SPAW_bold_click(editor, sender)
  {
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('bold', false, null);
    SPAW_update_toolbar(editor, true);
  }

  function SPAW_italic_click(editor, sender)
  {
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('italic', false, null);
    SPAW_update_toolbar(editor, true);
  }

  function SPAW_underline_click(editor, sender)
  {
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('underline', false, null);
    SPAW_update_toolbar(editor, true);
  }
 
  function SPAW_left_click(editor, sender)
  {
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('justifyleft', false, null);
    SPAW_update_toolbar(editor, true);
  }

  function SPAW_center_click(editor, sender)
  {
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('justifycenter', false, null);
    SPAW_update_toolbar(editor, true);
  }

  function SPAW_right_click(editor, sender)
  {
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('justifyright', false, null);
    SPAW_update_toolbar(editor, true);
  }

  function SPAW_ordered_list_click(editor, sender)
  {
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('insertorderedlist', false, null);
    SPAW_update_toolbar(editor, true);
  }

  function SPAW_bulleted_list_click(editor, sender)
  {
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('insertunorderedlist', false, null);
    SPAW_update_toolbar(editor, true);
  }
 


  function SPAW_copy_click(editor, sender)
  {
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('copy', false, null);
    SPAW_update_toolbar(editor, true);
  }

  function SPAW_paste_click(editor, sender)
  {
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('paste', false, null);
    SPAW_update_toolbar(editor, true);
  }
 
  function SPAW_cut_click(editor, sender)
  {
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('cut', false, null);
    SPAW_update_toolbar(editor, true);
  }

  function SPAW_delete_click(editor, sender)
  {
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('delete', false, null);
    SPAW_update_toolbar(editor, true);
  }

  function SPAW_indent_click(editor, sender)
  {
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('indent', false, null);
    SPAW_update_toolbar(editor, true);
  }

  function SPAW_unindent_click(editor, sender)
  {
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('outdent', false, null);
    SPAW_update_toolbar(editor, true);
  }

  function SPAW_undo_click(editor, sender)
  {
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('undo','',null);
    SPAW_update_toolbar(editor, true);
  }

  function SPAW_redo_click(editor, sender)
  {
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('redo', false, null);
    SPAW_update_toolbar(editor, true);
  }
 
 
  function SPAW_getParentTag(editor)
  {
    var trange = this[editor+'_rEdit'].document.selection.createRange();
    if (window.frames[editor+'_rEdit'].document.selection.type != "Control")
    {
      return (trange.parentElement());
    }
    else
    {
      return (trange(0));
    }
  }

  function SPAW_ltrim(txt)
  {
    var spacers = " \t\r\n";
    while (spacers.indexOf(txt.charAt(0)) != -1)
    {
      txt = txt.substr(1);
    }
    return(txt);
  }
  function SPAW_rtrim(txt)
  {
    var spacers = " \t\r\n";
    while (spacers.indexOf(txt.charAt(txt.length-1)) != -1)
    {
      txt = txt.substr(0,txt.length-1);
    }
    return(txt);
  }
  function SPAW_trim(txt)
  {
    return(SPAW_ltrim(SPAW_rtrim(txt)));
  }


  function SPAW_isFoolTag(editor, el)
  {
    var trange = this[editor+'_rEdit'].document.selection.createRange();
    var ttext;
    if (trange != null) ttext = SPAW_trim(trange.htmlText);
    if (ttext != SPAW_trim(el.innerHtml))
      return false;
    else
      return true;
  }
 
  function SPAW_style_change(editor, sender)
  {
    classname = sender.options[sender.selectedIndex].value;
 
    window.frames[editor+'_rEdit'].focus();

    var el = SPAW_getParentTag(editor);
    if (el != null && el.tagName.toLowerCase() != 'body')
    {
      if (classname != 'default')
        el.className = classname;
      else
        el.removeAttribute('className');
    }
    else if (el.tagName.toLowerCase() == 'body')
    {
      if (classname != 'default')
        this[editor+'_rEdit'].document.body.innerHTML = '<p class="'+classname+'">'+this[editor+'_rEdit'].document.body.innerHTML+'</p>';
      else
        this[editor+'_rEdit'].document.body.innerHTML = '<p>'+this[editor+'_rEdit'].document.body.innerHTML+'</p>';
    }
    sender.selectedIndex = 0;

    SPAW_update_toolbar(editor, true);
  }

  function SPAW_font_change(editor, sender)
  {
    fontname = sender.options[sender.selectedIndex].value;
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('fontname', false, fontname);
    sender.selectedIndex = 0;
    SPAW_update_toolbar(editor, true);
  }

  function SPAW_fontsize_change(editor, sender)
  {
    fontsize = sender.options[sender.selectedIndex].value;
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('fontsize', false, fontsize);
    sender.selectedIndex = 0;
    SPAW_update_toolbar(editor, true);
  }

  function SPAW_paragraph_change(editor, sender)
  {
    format = sender.options[sender.selectedIndex].value;
    window.frames[editor+'_rEdit'].focus();
    this[editor+'_rEdit'].document.execCommand('formatBlock', false, format);
    sender.selectedIndex = 0;
    SPAW_update_toolbar(editor, true);
  }


  function SPAW_design_tab_click(editor, sender)
  {
    iText = document.all[editor].value;
    this[editor+'_rEdit'].document.body.innerHTML = iText;

    document.all['SPAW_'+editor+'_editor_mode'].value = 'design';

    document.all['SPAW_'+editor+'_toolbar_top_html'].style.display = 'none';
    document.all['SPAW_'+editor+'_toolbar_left_html'].style.display = 'none';
    document.all['SPAW_'+editor+'_toolbar_right_html'].style.display = 'none';
    document.all['SPAW_'+editor+'_toolbar_bottom_html'].style.display = 'none';

    document.all['SPAW_'+editor+'_toolbar_top_design'].style.display = 'inline';
    document.all['SPAW_'+editor+'_toolbar_left_design'].style.display = 'inline';
    document.all['SPAW_'+editor+'_toolbar_right_design'].style.display = 'inline';
    document.all['SPAW_'+editor+'_toolbar_bottom_design'].style.display = 'inline';

    document.all[editor].style.display = "none";
    document.all[editor+"_rEdit"].style.display = "inline";
    document.all[editor+"_rEdit"].document.body.focus();

    SPAW_toggle_borders(editor,this[editor+'_rEdit'].document.body, null);

    this[editor+'_rEdit'].focus();
    SPAW_update_toolbar(editor, true);
  }

  function SPAW_html_tab_click(editor, sender)
  {
    iHTML = this[editor+'_rEdit'].document.body.innerHTML;
    document.all[editor].value = iHTML;

    document.all['SPAW_'+editor+'_editor_mode'].value = 'html';

    document.all['SPAW_'+editor+'_toolbar_top_design'].style.display = 'none';
    document.all['SPAW_'+editor+'_toolbar_left_design'].style.display = 'none';
    document.all['SPAW_'+editor+'_toolbar_right_design'].style.display = 'none';
    document.all['SPAW_'+editor+'_toolbar_bottom_design'].style.display = 'none';

    document.all['SPAW_'+editor+'_toolbar_top_html'].style.display = 'inline';
    document.all['SPAW_'+editor+'_toolbar_left_html'].style.display = 'inline';
    document.all['SPAW_'+editor+'_toolbar_right_html'].style.display = 'inline';
    document.all['SPAW_'+editor+'_toolbar_bottom_html'].style.display = 'inline';

    document.all[editor+"_rEdit"].style.display = "none";
    document.all[editor].style.display = "inline";
    document.all[editor].focus();

    this[editor+'_rEdit'].focus();
    SPAW_update_toolbar(editor, true);
  }

  function SPAW_getFieldByEditor(editor, field)
  {
    var thefield;
    if (field == null || field == "")
    {
      var flds = document.getElementsByName(editor);
      thefield = flds[0].id;
    }
    else
    {
      thefield=field;
    }
    return thefield;
  }

  function SPAW_getHtmlValue(editor, thefield)
  {
    var htmlvalue;

    if(document.all['SPAW_'+editor+'_editor_mode'].value == 'design')
    {
      htmlvalue = this[editor+'_rEdit'].document.body.innerHTML;
    }
    else
    {
      htmlvalue = document.all[thefield].value;
    }
    return htmlvalue;
  }

  function SPAW_updateField(editor, field)
  {
    var thefield = SPAW_getFieldByEditor(editor, field);

    var htmlvalue = SPAW_getHtmlValue(editor, thefield);

    if (document.all[thefield].value != htmlvalue)
    {
      document.all[thefield].value = htmlvalue;
    }
  }

  function SPAW_confirm(editor,block,message) {
    return showModalDialog('spaw/dialogs/confirm.php?lang=' + document.all['SPAW_'+editor+'_lang'].value + '&theme=' + document.all['SPAW_'+editor+'_theme'].value + '&block=' + block + '&message=' + message, null, 'dialogHeight:100px; dialogWidth:300px; resizable:no; status:no');
  }


  function SPAW_toggle_borders(editor, root, toggle)
  {
    var toggle_mode = toggle;
    if (toggle == null)
    {
      var tgl_borders = document.getElementById("SPAW_"+editor+"_borders");
      if (tgl_borders != null)
      {
        toggle_mode = tgl_borders.value;
      }
      else
      {
        toggle_mode = "on"
      }
    }

  }

  function SPAW_toggle_borders_click(editor, sender)
  {
    var toggle_mode;

    var tgl_borders = document.getElementById("SPAW_"+editor+"_borders");
    if (tgl_borders != null)
    {
      toggle_mode = tgl_borders;

      if (toggle_mode.value == "on")
      {
        toggle_mode.value = "off";
      }
      else
      {
        toggle_mode.value = "on";
      }

      SPAW_toggle_borders(editor,this[editor+'_rEdit'].document.body, toggle_mode.value);
    }
    SPAW_update_toolbar(editor, true);
  }

  function SPAW_base_image_name(ctrl)
  {
    var imgname = ctrl.src.substring(0,ctrl.src.lastIndexOf("/"))+"/tb_"+ctrl.id.substr(ctrl.id.lastIndexOf("_tb_")+4, ctrl.id.length);
    return imgname;
  }

  function SPAW_onkeyup(editor)
  {
    var eobj = window.frames[editor+'_rEdit'];
    if (eobj.event.ctrlKey || (eobj.event.keyCode >= 33 && eobj.event.keyCode<=40))
    {
      SPAW_update_toolbar(editor, false);
    }
  }

  var spaw_context_html = "";

  function SPAW_update_toolbar(editor, force)
  {
    //window.frames[editor+'_rEdit'].focus();
    var pt = SPAW_getParentTag(editor);
    if (pt)
    {
      if (pt.outerHTML == spaw_context_html && !force)
      {
        return;
      }
      else
      {
        spaw_context_html = pt.outerHTML;
      }
    }

    table_row_items     = [
                            "table_row_insert",
                            "table_row_delete"
                          ];
    table_cell_items    = [
                            "table_cell_prop",
                            "table_column_insert",
                            "table_column_delete",
                            "table_cell_merge_right",
                            "table_cell_merge_down",
                            "table_cell_split_horizontal",
                            "table_cell_split_vertical"
                          ];
    table_obj_items     = [
                            "table_prop"
                          ];
    img_obj_items       = [
                            "image_prop"
                          ];

    standard_cmd_items  = [ // command,             control id
                            ["cut",                 "cut"],
                            ["copy",                "copy"],
                            ["paste",               "paste"],
                            ["undo",                "undo"],
                            ["redo",                "redo"],
                            ["bold",                "bold"],
                            ["italic",              "italic"],
                            ["underline",           "underline"],
                            ["justifyleft",         "left"],
                            ["justifycenter",       "center"],
                            ["justifyright",        "right"],
                            ["indent",              "indent"],
                            ["outdent",             "unindent"]
                          ];

    togglable_items     = [ // command,             control id
                            ["bold",                "bold"],
                            ["italic",              "italic"],
                            ["underline",           "underline"],
                            ["justifyleft",         "left"],
                            ["justifycenter",       "center"],
                            ["justifyright",        "right"],
                            ["insertorderedlist",   "ordered_list"],
                            ["insertunorderedlist", "bulleted_list"],
                            ["createlink",          "hyperlink"],
                            ["inserthorizontalrule","hr"]
                          ];
    standard_dropdowns  = [ // command,             control id
                            ["fontname",            "font"],
                            ["fontsize",            "fontsize"],
                            ["formatblock",         "paragraph"]
                          ];

    if (!spaw_active_toolbar) return;

    //window.frames[editor+'_rEdit'].focus();

    var eobj = window.frames[editor+'_rEdit'];
    var edoc = eobj.document;

    for (i=0; i<togglable_items.length; i++)
    {
      SPAW_toggle_tbi_state(editor, standard_cmd_items[i][1], edoc.queryCommandState(standard_cmd_items[i][0]));
    }
    for (i=0; i<standard_cmd_items.length; i++)
    {
      SPAW_toggle_tbi(editor, standard_cmd_items[i][1], edoc.queryCommandEnabled(standard_cmd_items[i][0]));
    }

    if (document.all["SPAW_"+editor+"_borders"].value == "on")
    {
      SPAW_toggle_tbi_state(editor, "toggle_borders", true);
    }
    else
    {
      SPAW_toggle_tbi_state(editor, "toggle_borders", false);
    }

    for (i=0; i<standard_dropdowns.length; i++)
    {
      SPAW_toggle_tbi_dropdown(editor, standard_dropdowns[i][1], edoc.queryCommandValue(standard_dropdowns[i][0]));
    }
    var pt = SPAW_getParentTag(editor);
    SPAW_toggle_tbi_dropdown(editor, "style", pt.className);
  }

  function SPAW_toggle_tb_items(editor, items, enable)
  {
    for (i=0; i<items.length; i++)
    {
      SPAW_toggle_tbi(editor, items[i], enable);
    }
  }

  function SPAW_toggle_tbi(editor, item, enable)
  {
    if (document.all["SPAW_"+editor+"_tb_"+item])
    {
      var ctrl = document.all["SPAW_"+editor+"_tb_"+item];
      if (enable)
      {
        if (ctrl)
        {
          eval("SPAW_"+document.all["SPAW_"+editor+"_theme"].value+"_bt_out(ctrl);");
        }
      }
      else
      {
        if (ctrl)
        {
          eval("SPAW_"+document.all["SPAW_"+editor+"_theme"].value+"_bt_off(ctrl);");
        }
      }
    }
  }

  function SPAW_toggle_tbi_state(editor, item, state)
  {
    if (document.all["SPAW_"+editor+"_tb_"+item])
    {
      var ctrl = document.all["SPAW_"+editor+"_tb_"+item];
      ctrl.setAttribute("spaw_state",state)
      eval("SPAW_"+document.all["SPAW_"+editor+"_theme"].value+"_bt_out(ctrl);");
    }
  }

  function SPAW_toggle_tbi_dropdown(editor, item, value)
  {
    if (document.all["SPAW_"+editor+"_tb_"+item])
    {
      var ctrl = document.all["SPAW_"+editor+"_tb_"+item];
      ctrl.options[0].selected = true;
      for (ii=0; ii<ctrl.options.length; ii++)
      {
        if (ctrl.options[ii].value == value)
        {
          ctrl.options[ii].selected = true;
        }
        else
        {
          ctrl.options[ii].selected = false;
        }
      }
    }
  }


//-->