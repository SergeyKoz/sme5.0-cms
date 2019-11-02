<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="html" version="1.0" encoding="windows-1251"
  omit-xml-declaration="no" media-type="text/html" />
  <!-- Administrator section layout stylesheet -->
  <xsl:include href="layout.xsl" />
  <xsl:include href="blocks/debug.xsl" />
  <!--xsl:include href="controls.xsl"/-->
  <!-- Variable for page title -->
  <xsl:variable name="page-title">File Storage</xsl:variable>
  <xsl:template match="/">
    <xsl:apply-templates />
  </xsl:template>
  <xsl:template match="content">
    <xsl:for-each select="error-messages/message">
      <p class="error" style="margin:5px;">
        <xsl:value-of select="." />
      </p>
    </xsl:for-each>
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>
          <p>
          <span class="heading1">Current path
          :</span>&amp;nbsp;/&amp;nbsp;
          <xsl:apply-templates select="path" />&amp;nbsp;/</p>
        </td>
      </tr>
      <tr>
        <td>
          <img src="images/pix.gif" width="1" height="15" />
        </td>
      </tr>
      <tr>
        <td>
          <xsl:apply-templates select="folders" />
        </td>
      </tr>
      <tr>
        <td>
          <br />
        </td>
      </tr>
      <tr>
        <td>
          <xsl:apply-templates select="files" />
        </td>
      </tr>
    </table>
  </xsl:template>
  <xsl:template match="path">
    <xsl:apply-templates />
  </xsl:template>
  <xsl:template match="path/folder">
  <a href="files.php?directory={.}">
    <xsl:value-of select="@description" />
  </a>&amp;nbsp;/&amp;nbsp;</xsl:template>
  <xsl:template match="path/folder[last()]">
    <b>
      <xsl:value-of select="@description" />
    </b>
  </xsl:template>
  <xsl:template match="folders">
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>
          <p class="heading1">Folders</p>
        </td>
      </tr>
      <tr>
        <td>
          <img src="images/pix.gif" width="1" height="7" />
        </td>
      </tr>
      <xsl:if test="folder">
        <tr>
          <td bgcolor="#000000">
            <table border="0" cellspacing="1" cellpadding="4">
              <tr bgcolor="#a2a9af">
                <td>
                  <p class="navigation">Folder Name</p>
                </td>
                <td>
                  <p class="navigation">Options</p>
                </td>
              </tr>
              <xsl:apply-templates />
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <br />
          </td>
        </tr>
      </xsl:if>
    </table>
    <table border="0" cellpadding="0" cellspacing="0">
      <form action="?" method="post">
        <input type="hidden" name="page" value="filestorage" />
        <input type="hidden" name="event" value="CreateFolder" />
        <input type="hidden" name="directory"
        value="{//current-path}" />
        <tr>
          <td colspan="2">
            <p class="heading2">Create new folder:</p>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <img src="images/pix.gif" width="1" height="3" />
          </td>
        </tr>
        <tr>
          <td align="right" width="50%">
          <input type="text" name="new_folder"
          value="" />&amp;nbsp;&amp;nbsp;</td>
          <td>
            <input type="submit" value="Create" />
          </td>
        </tr>
      </form>
    </table>
  </xsl:template>
  <xsl:template match="folders/folder">
    <tr>
      <xsl:attribute name="bgcolor">
        <xsl:choose>
          <xsl:when test="position() mod 2 = 0">#F7F7F7</xsl:when>
          <xsl:otherwise>#FFFFFF</xsl:otherwise>
        </xsl:choose>
      </xsl:attribute>
      <td>
        <a class="tableElements" href="files.php?directory={.}">
          <xsl:value-of select="@description" />
        </a>
      </td>
      <td>
        <a class="tableElements"
        href="javascript: if (confirm('Are you sure?')) location='files.php?event=DeleteFolder&amp;directory={@quoted}';">
        Delete</a>
      </td>
    </tr>
  </xsl:template>
  <xsl:template match="files">
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>
          <p class="heading1">Files</p>
        </td>
      </tr>
      <tr>
        <td>
          <img src="images/pix.gif" width="1" height="7" />
        </td>
      </tr>
      <xsl:if test="file">
        <tr>
          <td bgcolor="#000000">
            <table border="0" cellspacing="1" cellpadding="4">
              <form action="?" name="fileListForm" method="post">
                <input type="hidden" name="page"
                value="filestorage" />
                <input type="hidden" name="event" value="" />
                <input type="hidden" name="directory"
                value="{//current-path}" />
                <tr bgcolor="#a2a9af">
                  <td>
                    <img src="images/pix.gif" width="1"
                    height="1" />
                  </td>
                  <td>
                    <p class="navigation">File Name</p>
                  </td>
                  <td>
                    <p class="navigation">Options</p>
                  </td>
                </tr>
                <xsl:apply-templates />
                <tr bgcolor="#ffffff">
                  <td>
                    <input type="checkbox" name="check_all"
                    OnClick="doSelectAll(document.forms['fileListForm']);" />
                  </td>
                  <td>
                    <p>Delete selected files</p>
                  </td>
                  <td align="center">
                    <a class="tableElements"
                    href="javascript:checkSelected(document.forms['fileListForm'], 'DeleteFiles', 'There are no selected files');">
                    Delete</a>
                  </td>
                </tr>
              </form>
            </table>
          </td>
        </tr>
        <tr>
          <td>
            <br />
          </td>
        </tr>
      </xsl:if>
    </table>
    <table border="0" cellpadding="0" cellspacing="0">
      <form action="?" method="post" enctype="multipart/form-data">
        <input type="hidden" name="page" value="filestorage" />
        <input type="hidden" name="event" value="UploadFile" />
        <input type="hidden" name="directory"
        value="{//current-path}" />
        <tr>
          <td colspan="2">
            <p class="heading2">Upload file:</p>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <img src="images/pix.gif" width="1" height="3" />
          </td>
        </tr>
        <tr>
          <td width="210">
            <input type="file" name="uploadedFile" />
          </td>
          <td>
            <input type="submit" value="Upload" />
          </td>
        </tr>
      </form>
    </table>
  </xsl:template>
  <xsl:template match="files/file">
    <tr>
      <xsl:attribute name="bgcolor">
        <xsl:choose>
          <xsl:when test="position() mod 2 = 0">#F7F7F7</xsl:when>
          <xsl:otherwise>#FFFFFF</xsl:otherwise>
        </xsl:choose>
      </xsl:attribute>
      <td>
        <input type="checkbox" name="file_{@md5filename}" value="1"
        OnClick="syncSelected(document.forms['fileListForm'], document.forms['fileListForm'].elements['file_{@md5filename}']);" />
      </td>
      <td>
        <a class="tableElements" href="{/page/@app-path}{.}"
        target="_new">
          <xsl:value-of select="@description" />
        </a>
      </td>
      <td align="center">
        <a class="tableElements"
        href="javascript:doDeleteSingleFile(document.forms['fileListForm'], document.forms['fileListForm'].elements['file_{@md5filename}']);">
        Delete</a>
      </td>
    </tr>
  </xsl:template>
</xsl:stylesheet>
