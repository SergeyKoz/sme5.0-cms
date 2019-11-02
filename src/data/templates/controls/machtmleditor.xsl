<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:template match="machtmleditor">
        <xsl:param name="class"/>    
        <xsl:param name="disabled"/>    
        <xsl:variable name="name"><xsl:value-of select="name"/></xsl:variable>
        <xsl:variable name="directory"><xsl:value-of select="directory"/></xsl:variable>
<!-- -->

<br/>
<script language="javascript" src="{/page/@framework_url}packages/libraries/scripts/maceditor.js"></script>
<script language="javascript">
imageTag_<xsl:value-of select="name"/>= false;
etcode_<xsl:value-of select="name"/>= new Array();
</script>
<span>
<input type="button" class="butt" accesskey="b" name="edittools0_{name}" value=" B " style="font-weight:bold; width: 30px" onClick="etstyle(0,'{name}')" onMouseOver="helpline('b','{name}')" />
<input type="button" class="butt" accesskey="i" name="edittools2_{name}" value=" i " style="font-style:italic; width: 30px" onClick="etstyle(2,'{name}')" onMouseOver="helpline('i','{name}')" />
<input type="button" class="butt" accesskey="u" name="edittools4_{name}" value=" u " style="text-decoration: underline; width: 30px" onClick="etstyle(4,'{name}')" onMouseOver="helpline('u','{name}')" />
<input type="button" class="butt" accesskey="e" name="edittools8_{name}" value="Email" style="width: 40px" onClick="simpletags(8,'{name}')" onMouseOver="helpline('c','{name}')" />
<input type="button" class="butt" accesskey="l" name="edittools10_{name}" value="List" onClick="etstyle(10,'{name}')" onMouseOver="helpline('l','{name}')" />
<input type="button" class="butt" accesskey="o" name="edittools12_{name}" value="List="  onClick="etstyle(12,'{name}')" onMouseOver="helpline('o','{name}')" />
<input type="button" class="butt" accesskey="g" name="edittools26_{name}" value="&#149;Line"  onClick="etstyle(26,'{name}')" onMouseOver="helpline('g','{name}')" />
<input type="button" class="butt" accesskey="z" name="edittools22_{name}" value="Paragraph"  onClick="etstyle(22,'{name}')" onMouseOver="helpline('z','{name}')" />
<!--input type="button" class="butt" accesskey="p" name="edittools14_{name}" value="Img"  onClick="simpletags(14,'{name}')" onMouseOver="helpline('p','{name}')" /-->
<input type="button" class="butt" accesskey="w" name="edittools16_{name}" value="URL" style="text-decoration: underline; width: 40px" onClick="simpletags(16,'{name}')" onMouseOver="helpline('w','{name}')" />
&amp;nbsp;
<a href="javascript:FilesDlg('editform', '{$name}','{$directory}', 1)"><img src="{/page/@framework_url}packages/libraries/img/ico_choose.gif" width="20" height="17" border="0" alt="{//_caption_picture_select}"/></a>

<!--input type="button" class="butt" accesskey="p" name="edittools14_{name}" value="File Library"  onClick="filetags(26,'{name}')" onMouseOver="helpline('f','{name}')" /-->
<br/>
<input type="text" class="" name="helpbox_{name}" size="100" maxlength="100"  value="Help line" disabled="yes"/><br/>
<select class="FormSelect" name="edittools18_{name}" onChange="etfontstyle('&lt;font style=\'color:' + this.form.edittools18_{name}.options[this.form.edittools18_{name}.selectedIndex].value + '\'&gt;', '&lt;/font&gt;','{name}')" onMouseOver="helpline('s','{name}')">
<option style="color:black;" value="#444444" class="genmed">Цвет</option>
<option style="color:darkred;" value="darkred" class="genmed">Dark Red</option>
<option style="color:red; " value="red" class="genmed">Red</option>
<option style="color:orange; " value="orange" class="genmed">Orange</option>
<option style="color:brown; " value="brown" class="genmed">Brown</option>
<option style="color:yellow;" value="yellow" class="genmed">Yellow</option>
<option style="color:green;" value="green" class="genmed">Green</option>
<option style="color:olive; " value="olive" class="genmed">Olive</option>
<option style="color:cyan;" value="cyan" class="genmed">Cyan</option>
<option style="color:blue;" value="blue" class="genmed">Blue</option>
<option style="color:darkblue; " value="darkblue" class="genmed">Dark Blue</option>
<option style="color:indigo; " value="indigo" class="genmed">Indigo</option>
<option style="color:violet; " value="violet" class="genmed">Violet</option>
<option style="color:white; " value="white" class="genmed">White</option>
<option style="color:black; " value="black" class="genmed">Black</option>
</select> &amp;nbsp;
<select class="FormSelect" name="edittools20_{name}" onChange="etfontstyle('&lt;font style=\'font-size:' + this.form.edittools20_{name}.options[this.form.edittools20_{name}.selectedIndex].value + '\'&gt;', '&lt;/font&gt;','{name}')" onMouseOver="helpline('f','{name}')">
<option value="" class="genmed">Размер</option>
<option value="7px" class="genmed">Мелкий</option>
<option value="10px" class="genmed">Маленький</option>
<option value="12px" class="genmed">Нормалный</option>
<option value="18px" class="genmed">Средний</option>
<option  value="24px" class="genmed">Большой</option>
</select>
<select class="FormSelect" name="edittools24_{name}" onChange="etfontstyle('&lt;font face=\'' + this.form.edittools24_{name}.options[this.form.edittools24_{name}.selectedIndex].value + '\'&gt;', '&lt;/font&gt;','{name}')" onMouseOver="helpline('q','{name}')">
<option value="0"> шрифт </option>
<option value="arial">Arial</option>
<option value="verdana">Verdana</option>
<option value="times new roman">Times</option>
<option value="courier new">Courier</option>
<option value="century gothic">Century</option>
</select>
<a href="javascript:etstyle(-1,'{name}')" class="genmed" onMouseOver="helpline('a','{name}')">Закрыть тэги</a>
</span>
<br/>

        <textarea  name="{name}"   rows="{rows}"  cols="{cols}" disable-output-escaping="yes">
           <xsl:if test="$class != ''">                                                 
             <xsl:attribute name="class"><xsl:value-of select="$class"/></xsl:attribute>
           </xsl:if>                                                                    

           <xsl:if test="(readonly = 'yes') or (readonly = 1) or $disabled = 'yes'">
                <xsl:attribute name="readonly"> </xsl:attribute>
           </xsl:if>
           <xsl:if test="(disabled = 'yes') or (disabled = 1)">
                <xsl:attribute name="disabled"> </xsl:attribute>
           </xsl:if>

           <xsl:value-of select="content" disable-output-escaping="yes"/>
        </textarea>


<br/>
<input type="button" class="butt"  value="Preview"  onClick="preview_html('{name}', Array('{/page/@url}css/style.css','{/page/@url}css/style.css'))" />
      
    </xsl:template>
</xsl:stylesheet>