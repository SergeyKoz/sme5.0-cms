<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
 <xsl:template match="feedback_form">
  <form action="?" method="POST" name="feedback_form"> 
   <input type="hidden" name="event" value="SendFeedback"/>
   <table>

<script language="JavaScript">

var subj = new Array();

<xsl:for-each select="departments/department">
   subj[<xsl:value-of select="./@id"/>] = new Array(
   <xsl:for-each select="subject">
   "('<xsl:value-of select="caption"/>', '<xsl:value-of select="./@id"/>', '<xsl:value-of select="./@selected"/>')"<xsl:if test="position() &lt; count(../subject)">,</xsl:if> 
   </xsl:for-each>
   );
   
</xsl:for-each>


function populateSubject(inForm,selected) {
    //return;
    var selectedArray = subj[selected];
    while (selectedArray.length &lt; inForm.subject_id.options.length) {
        inForm.subject_id.options[(inForm.subject_id.options.length - 1)] = null;
    }
    var _sel = false;
    for (var i=0; i &lt; selectedArray.length; i++) {
        eval("inForm.subject_id.options[i]=" + "new Option" + selectedArray[i]);
        eval("option = new Array"+selectedArray[i]);
        //alert(option[2]);
        if(option[2] == 0){
            inForm.subject_id.options[i].selected = false;
       } else {
            inForm.subject_id.options[i].selected = true;
            _sel = true;
       }
    }
    if (!_sel)
    {
        inForm.subject_id.selectedIndex = 0;
    }
}
</script>
         <tr><td>
         <xsl:value-of select="//_caption_select_departments"/><br/>
         <select name="department_id" onChange="populateSubject(this.form, this.options[this.selectedIndex].value)">

       <xsl:for-each select="departments/department">
          <option value="{./@id}">
          <xsl:if test="./@selected = 1"><xsl:attribute name="selected"></xsl:attribute></xsl:if>
          <xsl:value-of select="caption"/></option>
       </xsl:for-each>
        </select>       
        </td></tr>
        <tr><td>
         <xsl:value-of select="//_caption_select_subjects"/><br/>
        <select name="subject_id">
        </select>
        <script language="JavaScript">populateSubject(document.feedback_form, <xsl:value-of select="departments/department[@selected=1]/@id"/>);</script>
        </td></tr>

       
        <xsl:for-each select="field">
          <tr><td>
          
          <font color="black">
          <xsl:if test="./@error = 1">
          <xsl:attribute name="color">red</xsl:attribute>
          </xsl:if>
          <xsl:value-of select="caption"/>
          </font>
          
          <br/>
          
          <xsl:choose>
             <xsl:when test="./@type='text'">
                 <input type="text" name="{./@name}" value="{value}"/>
             </xsl:when>
             <xsl:when test="./@type='email'">
                 <input type="text" name="{./@name}" value="{value}"/>
             </xsl:when>
             <xsl:when test="./@type='textarea'">
                 <textarea name="{./@name}"><xsl:value-of select="value"/></textarea>
             </xsl:when>

          </xsl:choose>

          
          </td></tr>
       </xsl:for-each>
   </table>
   <input type="submit" value="{//_caption_button_submit_feedback}"/>
  </form>
 
 </xsl:template>
</xsl:stylesheet>
