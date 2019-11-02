<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:template name="page_banners">
        <input type="hidden" name="pageBannersIds" value=""/>
        <script type="text/javascript">
            function onPageBannerListClick(list)
            {
                for(var i=0; i &lt; list.length; i++)
                {
                    if (list.options[i].value == '')
                    {
                        list.options[i].selected=false;
                    }
                }
                //alert(list.options[list.selectedIndex].value);
            }
            function doCollectBannerIDs()
            {
                list=document.all.pageBannersList;
                var ids = '';
                for(var i=0; i &lt; list.length; i++)
                {
                    if ((list.options[i].value != '') &amp;&amp; (list.options[i].selected))
                    {
                        if (ids != '')
                        {
                            ids += ',';
                        }
                        ids += list.options[i].value;
                    }
                }
                document.all.pageBannersIds.value = ids;
            }
        </script>
        <select size="16" multiple="1" name="pageBannersList" onchange="onPageBannerListClick(this);">
            <xsl:for-each select="//page_banners/group">
                <option value=""><xsl:value-of select="caption" /></option>

                <xsl:for-each select="item">
                    <option value="{value}">
                        <xsl:if test="selected=1">
                            <xsl:attribute name="selected"></xsl:attribute>
                        </xsl:if>
                        &amp;nbsp;&amp;nbsp;&amp;nbsp;&amp;nbsp;<xsl:value-of select="caption" />
                    </option>
                </xsl:for-each>
                
            </xsl:for-each>
            
        </select>
    </xsl:template>
</xsl:stylesheet>