<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <!-- Administrator section layout stylesheet -->
  <xsl:include href="layouts/layout.xsl" />
  <xsl:include href="blocks/errors.xsl" />
  <xsl:include href="blocks/debug.xsl" />
  <!-- Variable for page title -->
  <xsl:variable name="page-title">File upload</xsl:variable>
  <!-- Applying root template -->
  <xsl:template match="/">
    <xsl:apply-templates />
  </xsl:template>
  <!-- Page content -->
  <xsl:template match="content">
    <xsl:apply-templates select="auto-close" />
    <table border="0" cellpadding="10" cellspacing="0"
    width="100%">
      <tr>
        <td align="center">
          <table border="0" cellpadding="1" cellspacing="0"
          width="170">
            <tr>
              <td bgcolor="#5A7EDC" width="100%">
                <table border="0" cellpadding="10" cellspacing="0"
                bgcolor="#ffffff" width="100%">
                  <form action="?" method="post"
                  enctype="multipart/form-data">
                    <input type="hidden" name="page"
                    value="uploaddlg" />
                    <input type="hidden" name="event"
                    value="UploadFile" />
                    <input type="hidden" name="directory"
                    value="{current-path}" />
                    <input type="hidden" name="form"
                    value="{target-form}" />
                    <input type="hidden" name="element"
                    value="{target-element}" />
                    <input type="hidden" name="tag_id"
                    value="{tag-id}" />
                    <tr>
                      <td>
                        <p class="heading1">Upload file:</p>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <input type="file" name="uploadedFile" />
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <button type="submit" value="Upload" OnClick="UploadDlg('{//content/current-path}','{//content/target-element}','{//content/target-form}', '{//content/tag-id}');">
                        <img src="{/page/@framework_url}packages/libraries/img/ico_upload.gif"
                             width="20" height="19" border="0"
                             alt="Upload"
                             align="absmiddle" />&amp;nbsp;Upload</button>
                      </td>
                      <td>
                        <button type="button" value="Cancel" OnClick="CancelUploadDlg('{//content/current-path}','{//content/target-element}','{//content/target-form}', '{//content/tag-id}');return false;">
                        <img src="{/page/@framework_url}packages/libraries/img/icn_delete.gif"
                             width="16" height="16" border="0"
                             alt="Cancel"
                             align="absmiddle" />&amp;nbsp;Cancel</button>
                      </td>
                    </tr>
                  </form>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </xsl:template>
  <xsl:template match="auto-close">
    <script language="JavaScript">
    CancelUploadDlg(
    '<xsl:value-of select="//content/current-path" />', 
    '<xsl:value-of select="//content/target-element" />', 
    '<xsl:value-of select="//content/target-form" />', 
    '<xsl:value-of select="//content/tag-id" />');
    </script>
  </xsl:template>
</xsl:stylesheet>
