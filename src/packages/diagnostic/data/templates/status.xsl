<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="no"  media-type="text/html"/>

    <!-- Administrator section layout stylesheet -->
    <xsl:include href="layouts/layout.xsl"/>
    <xsl:include href="blocks/debug.xsl"/>
    <xsl:include href="blocks/errors.xsl"/>
  
  <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    

    <xsl:template match="content">


      <table border="0" id="tests_table" class="sort-table" cellpadding="0" cellspacing="0" width="100%">
      <thead>
      <tr>
        <td valign="top"><b>Sites</b></td>
        <xsl:for-each select="tests/test">
           <td valign="top">
              <b><xsl:value-of select="caption"/></b><br/>
              <xsl:if test="description != ''">
                  <small><xsl:value-of select="description"/></small>
              </xsl:if>
           </td>
        </xsl:for-each>

      </tr>
      </thead>
      <xsl:for-each select="site">
         <tr id="n[]">
            <td valign="center">
              <a href="{data/url}" target="_blank"><b><xsl:value-of select="data/caption"/></b></a><br/>
              <small><xsl:value-of select="data/url"/></small><br/>
              <xsl:if test="result">
                <xsl:choose>
                   <xsl:when test="result/value = -3">
                     <font class="red">Password Incorrect</font>
                   </xsl:when>
                   <xsl:when test="result/value = -10">
                     <font class="red">Site is down or unreachable</font>
                   </xsl:when>
                   <xsl:when test="result/value = -20">
                     <font class="red">No gateway found</font><br/>
                     <small>( <xsl:value-of select="data/tester"/> )</small>
                   </xsl:when>


                   <xsl:otherwise>
                     <font color="green">OK</font>
                   </xsl:otherwise>

                </xsl:choose>
              </xsl:if>
            </td>
            <xsl:for-each select="tests/response">
              <td valign="top">
                 <xsl:choose>
                    <xsl:when test="./@type='STATUS'">
                       <xsl:choose>
                          <xsl:when test=". = 1">
                          <xsl:attribute name="align">center</xsl:attribute>
                          <b><font color="green">OK</font></b>
                          </xsl:when>
                          <xsl:otherwise>
                          <xsl:attribute name="align">center</xsl:attribute>
                          <b><font class="red">ERR</font></b>
                          </xsl:otherwise>
                       </xsl:choose>
                    </xsl:when>
                    <xsl:when test="./@type='STRING'">
                       <font color="NAVY"><xsl:value-of select="."/></font>
                    </xsl:when>
                    <xsl:when test="./@type='ERROR'">
                       <xsl:choose>
                          <xsl:when test=". = -2">
                          <xsl:attribute name="align">center</xsl:attribute>
                          <b><font color="D08000">TFNF</font></b>
                          </xsl:when>
                          <xsl:otherwise>
                          </xsl:otherwise>
                       </xsl:choose>

                    </xsl:when>


                 </xsl:choose>
              </td>
            </xsl:for-each>
         </tr>
      </xsl:for-each>
      </table>
     <script LANGUAGE="JScript"> clearAll("tests_table");  </script>
            <script FOR="n[]" EVENT="onclick" LANGUAGE="JScript">
                clearAll("tests_table");
                this.style.background = "A9B2CA";
            </script>
      <br/>
      <table border="0" id="tests_table" class="sort-table-active" cellpadding="0" cellspacing="0" width="100%">
       <tr>
         <td><b><font color="green">OK</font></b></td>
         <td>test passed successfully</td>
       </tr>
       <tr>
         <td><b><font class="red">ERR</font></b></td>
         <td>test failed</td>
       </tr>
       <tr>
         <td><b><font color="D08000">TFNF</font></b></td>
         <td>test file not found</td>
       </tr>

      </table>
    </xsl:template>
</xsl:stylesheet>

  