<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no"  media-type="text/html"/>
    <xsl:template match="date_period">
    <style>
        .date_period_edit {
            height: 20;
            font-size: 9pt;
        }
    
    </style>
      <form action="{submit_url}" method="POST" name="dateForm_period">
        <input type="hidden" name="event" value="DatePeriodSelect"/>
        <xsl:value-of select="localization/period_selector_title" />
        &#160;
        <select name="dateForm_periodSelector" onChange="OnPeriodSelectChanged()" class="date_period_edit" >
            <option value="0"><xsl:value-of select="//period_selector_custom" /></option>
            <option value="1"><xsl:value-of select="//period_selector_week" /></option>
            <option value="2"><xsl:value-of select="//period_selector_month" /></option>
            <option value="3"><xsl:value-of select="//period_selector_quarter" /></option>
            <option value="4"><xsl:value-of select="//period_selector_year" /></option>
            <option value="5"><xsl:value-of select="//period_selector_all" /></option>
        </select>
        <br />
        <xsl:value-of select="//localization/caption_from" />
        &#160;
        <input type="text" name="dateForm_dayEdit1" maxlength="2" size="2" value="{start/day}" class="date_period_edit"/>
        <input type="text" name="dateForm_monthEdit1" maxlength="2" size="2" value="{start/month}" class="date_period_edit" />
        <input type="text" name="dateForm_yearEdit1" maxlength="4" size="4" value="{start/year}" class="date_period_edit" />
        &#160;
        <xsl:value-of select="//localization/caption_to" />
        &#160;
        <input type="text" name="dateForm_dayEdit2" maxlength="2" size="2" value="{end/day}"  class="date_period_edit"/>
        <input type="text" name="dateForm_monthEdit2" maxlength="2" size="2" value="{end/month}"  class="date_period_edit"/>
        <input type="text" name="dateForm_yearEdit2" maxlength="4" size="4" value="{end/year}"  class="date_period_edit"/>
        &#160;
        <input type="submit" name="dateForm_Submit" value="{//localization/form_submit_caption}" class="date_period_edit" />
        <script language="JavaScript">
            document.all.dateForm_periodSelector.selectedIndex = <xsl:value-of select="periodSelector" />;
            dateForm_CheckEnable();
            function dateForm_CheckEnable()
            {
                var stateEnable = false;
                if (document.all.dateForm_periodSelector.selectedIndex == 0)
                {
                    stateEnable = false;
                } else {
                    stateEnable = true;
                }
                document.all.dateForm_dayEdit1.disabled = stateEnable;
                document.all.dateForm_monthEdit1.disabled = stateEnable;
                document.all.dateForm_yearEdit1.disabled = stateEnable;
                document.all.dateForm_dayEdit2.disabled = stateEnable;
                document.all.dateForm_monthEdit2.disabled = stateEnable;
                document.all.dateForm_yearEdit2.disabled = stateEnable;
            }
            function OnPeriodSelectChanged()
            {
                dateForm_CheckEnable();
            }
        </script>
      </form>
    </xsl:template>
   
</xsl:stylesheet>

  