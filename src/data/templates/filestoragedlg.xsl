<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="yes"  media-type="text/html"/>

    <!-- Administrator section layout stylesheet -->
    <xsl:include href="layouts/layout.xsl"/>
    <xsl:include href="blocks/errors.xsl"/>
    <xsl:include href="blocks/debug.xsl"/>

    <!-- Variable for page title -->
    <xsl:variable name="page-title">File Storage</xsl:variable>


    <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    <xsl:template match="content">

    

    <script language="JavaScript">

    function FilesDlg_OK() {

                var selectedIndex = document.hiddenForm.fileList.selectedIndex;
                if (selectedIndex != -1) {
                    window.opener.cb_SaveFilePath('<xsl:value-of select="target-form"/>', 
                    '<xsl:value-of select="target-element"/>', 
                    

              <xsl:choose>
                 <xsl:when test="tag-id = 1">
                    '<xsl:value-of select="/page/settings/filestorageurl"/>'+
                 
                    <xsl:choose>
                      <xsl:when test="private-directory = 'yes'">
                        '/<xsl:value-of select="current-path"/>/' 
                      </xsl:when>
                      <xsl:otherwise>
                        '/' 
                      </xsl:otherwise>
                    </xsl:choose>
                 
                 
                 </xsl:when>
                 <xsl:otherwise>
                    
                    <xsl:choose>
                      <xsl:when test="private-directory = 'yes'">
                        '/<xsl:value-of select="current-path"/>/' 
                      </xsl:when>
                      <xsl:otherwise>
                        '/' 
                      </xsl:otherwise>
                    </xsl:choose>

                 </xsl:otherwise>
              </xsl:choose>


                    + document.hiddenForm.fileList.options[selectedIndex].value,


                    '<xsl:value-of select="tag-id"/>'
                    );
                    window.close();
                }
    }                                           
    </script>
        <table border="0" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <td align="center">                 
            <table border="0" cellpadding="1" cellspacing="0" width="170">
            <tr>
                <td bgcolor="#5A7EDC" width="100%">
                <table border="0" cellpadding="10" cellspacing="0" bgcolor="#ffffff" width="100%">
                <form action="?" name="hiddenForm" method="post">
                    <input type="hidden" name="page" value="filestoragedlg"/>
                    <input type="hidden" name="form" value="{target-form}"/>
                    <input type="hidden" name="event" value=""/>
                    <input type="hidden" name="element" value="{target-element}"/>
                    <input type="hidden" name="directory" value="{current-path}"/>
                    <tr><td><xsl:apply-templates select="path"/></td></tr>
                    <xsl:if test="folders/folder">
                    <tr><td><p class="heading2"><xsl:apply-templates select="folders"/></p></td></tr>
                    </xsl:if>
                    <tr>
                      <td>
                   <xsl:if test="/page/content/create-dir-disabled=0">
                      <input type="text" name="folder"/><input type="button" value="Create" onClick="FilesDlg_Create();"/>
                   </xsl:if>
                      </td>
                    </tr>

                    <form name="fileListForm">

                    <tr><td><xsl:apply-templates select="files"/></td></tr>
                    <tr>
                      <td>
                         <xsl:call-template name="buttons"/>
                      </td>
                    </tr>
                    </form>

                </form>
                </table>
                </td>
            </tr>
            </table>
            </td>
        </tr>
        </table>
    </xsl:template>

    <xsl:template match="path">
        <xsl:apply-templates />
    </xsl:template>

    <xsl:template match="path/folder">
        <a href="" OnClick="changeFolder('{.}'); return false;"><xsl:value-of select="@description"/></a>&amp;nbsp;/&amp;nbsp;
    </xsl:template>

    <xsl:template match="path/folder[last()]">
        <b><xsl:value-of select="@description"/></b>
    </xsl:template>

    <xsl:template match="folders">
        <b>Sub folders:</b><br/><img src="images/pix.gif" width="1" height="3"/><br/>
        <select name="newDirectory">
            <xsl:apply-templates />
        </select>&amp;nbsp;
        
        
        <button style="height:25px;" type="button" value="Upload" OnClick="FilesDlg_Go();"><img src="{/page/@framework_url}packages/libraries/img//ico_goto.gif" width="16" height="16" border="0" alt="Go" align="absmiddle"/> &amp;nbsp;Go</button>
        
    </xsl:template>

    <xsl:template match="folders/folder">
        <option value="{@path}"><xsl:value-of select="@description"/></option>
    </xsl:template>

    <xsl:template match="files">
        <form name="fileListForm">
            <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td><p class="heading2">Files</p></td>
                </tr>
                <xsl:if test="file">
                <tr>
                    <td colspan="2" align="center">
                        <select name="fileList" size="10">
                            <xsl:apply-templates select="file"/>
                        </select><br/>
                        <button type="button" value="Delete" OnClick="deleteFile();"><img src="{/page/@framework_url}packages/libraries/img//ico_delete.gif" width="20" height="19" border="0" alt="Upload" align="absmiddle"/> &amp;nbsp;Delete</button>
                    </td>
                </tr>
                </xsl:if>
                <tr><td><br/></td></tr>
                <tr>                                                                                                                                                                                        
                    <td><xsl:if test="file">
                    <xsl:choose>
                    <xsl:when test="/page/content/private-directory = 'yes'">
                       <button type="button" value="Preview" OnClick="FilesDlg_View('{/page/settings/filestorageurl}{/page/content/current-path}/');">
                       <img src="{/page/@framework_url}packages/libraries/img//ico_preview.gif" width="21" height="17" border="0" alt="{//_caption_file_preview}" align="absmiddle"/> &amp;nbsp;Preview</button>
                    </xsl:when>
                    <xsl:otherwise>
                       <button type="button" value="Preview" OnClick="FilesDlg_View('{/page/settings/filestorageurl}');">
                       <img src="{/page/@framework_url}packages/libraries/img//ico_preview.gif" width="21" height="17" border="0" alt="{//_caption_file_preview}" align="absmiddle"/> &amp;nbsp;Preview</button>
                    </xsl:otherwise>
                    </xsl:choose>
                    </xsl:if>
                    </td>

                    <td>
                         <button type="button" value="Upload" OnClick="UploadDlg('{//content/current-path}','{//content/target-element}','{//content/target-form}', '{//content/tag-id}');"><img src="{/page/@framework_url}packages/libraries/img//ico_upload.gif" width="20" height="19" border="0" alt="Upload" align="absmiddle"/> &amp;nbsp;Upload</button>
                 </td>
                 </tr>

                 <tr><td></td></tr>
                 
                 <tr>
                 <td>
                    <xsl:if test="file">
                    <button type="button" value="OK" OnClick="FilesDlg_OK();"><img src="{/page/@framework_url}packages/libraries/img//ico_apply.gif" width="16" height="16" border="0" alt="Choose" align="absmiddle"/> &amp;nbsp;Choose</button>
                    </xsl:if>
                 </td>
                 
                 <td>
                    <xsl:if test="file">
                    <button type="button" value="Cancel" OnClick="FilesDlg_Cancel();"><img src="{/page/@framework_url}packages/libraries/img//icn_delete.gif" width="16" height="16" border="0" alt="Cancel" align="absmiddle"/> &amp;nbsp;Cancel</button>
                    </xsl:if>
                 </td>
                </tr>
            </table>
        </form>
    </xsl:template>
    
    <xsl:template name="buttons">
    </xsl:template>

    <xsl:template match="file">
        <option value="{.}"><xsl:value-of select="@description"/></option>

    </xsl:template>
</xsl:stylesheet>