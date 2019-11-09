<?xml version="1.0" encoding="windows-1251" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="UTF-8" omit-xml-declaration="yes" media-type="text/html"/>

<xsl:template name="_default_field">
<!-- WETHER SHOW OR NOT THIS FIELD CONTENT
DO  SHOW IF:
            publication::@show_empty_fields is 0 and field is NOT empty
            publication::@show_empty_fields is 1
-->

    <xsl:if test="((../@show_empty_fields = 0) and (./value != '')) or ((../@show_empty_fields = 1))">
     
      <!-- PRINTING FIELD HEADER DELIMITERS -->
      <xsl:if test="delimiters/header != ''">
         <xsl:value-of select="delimiters/header" disable-output-escaping="yes"/>
      </xsl:if>
      <!-- /PRINTING FIELD HEADER DELIMITERS -->

        <!-- PRINTING CAPTION TITLE-->
          <xsl:choose>
          <!-- IF PUBLICATION TYPE IS NOT "SINGLE PUBLICATION"-->
            <xsl:when test="../@publication_type != 0">
            <!-- IF SHOW FIELD CAPTION IN LIST MODE IS SET TO 1-->
                <xsl:if test="./@show_list_field_caption=1">
                <!-- PRINTING FIELD CAPTION-->
                    <i><xsl:value-of select="./caption"/></i><br/>
                </xsl:if>
            </xsl:when>
            <!-- IF PUBLICATION TYPE IS "SINGLE PUBLICATION-->
            <xsl:otherwise>
            <!-- IF SHOW FIELD CAPTION IS SET TO 1 -->
                <xsl:if test="./@show_publication_field_caption=1">
                <!-- PRINTING FIELD CAPTION-->
                    <i><xsl:value-of select="./caption"/></i><br/>
                </xsl:if>
            </xsl:otherwise>
          </xsl:choose>

        <!-- /PRINTING CAPTION TITLE-->
       
        <!-- PREPARING VALUE VARIABLE-->
          <xsl:variable name="value">
             <xsl:choose>
                 <!-- IF IN LIST (PUBLICATION TYPE != "SINGLE PUBLICATION")-->
                 <xsl:when test="../@publication_type != 0">
                      <xsl:choose>
                         <!-- IF NEED TO BE CUT-->
                         <xsl:when test="./@cut_to_length > 0">
                            <!-- CUTTING VALUE -->
                            <xsl:value-of select="substring(value, 1, ./@cut_to_length)"/>
                            <!-- /CUTTING VALUE -->
                                <!-- IF VALUE __ACTUALLY__ CUTTED-->
                                <xsl:if test="string-length(value) > ./@cut_to_length">
                                <!-- PRINTING DOTS-->
                                ...
                                <!-- /PRINTING DOTS-->
                                </xsl:if>
                                <!-- /IF VALUE CUTTED-->
                         </xsl:when>
                         <!-- /IF NEED TO BE CUT-->

                         <!-- NO NEED TO BE CUT-->
                         <xsl:otherwise>
                            <xsl:value-of select="./value"/>
                         </xsl:otherwise>
                         <!-- /NO NEED TO BE CUT-->
                      </xsl:choose>
                 </xsl:when>
                 <!-- /IF IN LIST-->

                 <!-- IF IN PUBLICATION-->
                 <xsl:otherwise>
                    <xsl:value-of select="./value"/>
                 </xsl:otherwise>
                 <!-- /IF IN PUBLICATION-->

             </xsl:choose>
          </xsl:variable>
        <!-- /PREPARING VALUE VARIABLE-->

    
        <!-- PRINTING OPENING <A> TAG IF THIS IS A LINK-->
        <xsl:if test="(./@is_link=1) and (../@publication_type != 0)">
            <xsl:text disable-output-escaping="yes">&lt;</xsl:text>a href="<xsl:value-of select="/page/@url"/><xsl:choose><xsl:when test="../@target_entry_point_url"><xsl:value-of select="../@target_entry_point_url"/></xsl:when><xsl:otherwise><xsl:choose><xsl:when test="../../@target_entry_point_url"><xsl:value-of select="../../@target_entry_point_url"/></xsl:when><xsl:otherwise><xsl:value-of select="/page/@request_url"/></xsl:otherwise></xsl:choose></xsl:otherwise></xsl:choose>?pid=<xsl:value-of select="../@publication_id"/>"<xsl:text disable-output-escaping="yes">>&lt;b&gt;</xsl:text>
        </xsl:if>
        <!-- /PRINTING OPENING <A> TAG IF THIS IS A LINK-->
      
        <!-- PRINTING CAPTION VALUE-->
        <xsl:choose>
         <!-- SINGLE LINE TEXT -->
         <xsl:when test="./@system_name = 'text'">
            <xsl:value-of select="$value"/>
         </xsl:when>

         <!-- PLAIN TEXT BLOCK-->
         <xsl:when test="./@system_name = 'textarea'">
            <xsl:value-of select="$value" disable-output-escaping="yes"/>
         </xsl:when>
    
         <!-- HTML BLOCK-->
         <xsl:when test="./@system_name = 'spaweditor'">
            <xsl:value-of select="$value" disable-output-escaping="yes"/>
         </xsl:when>
         
         <!-- PICTURE -->
         <xsl:when test="./@system_name = 'picture'">
            <xsl:if test="./value != ''">
                <img src="{/page/settings/filestorageurl}{./value}" border="0"/>
            </xsl:if>
         </xsl:when>

         <!-- EMAIL -->
         <xsl:when test="./@system_name = 'email'">
            <a href="mailto:{./value}">
                <xsl:value-of select="$value"/>
            </a>
         </xsl:when>

         <!-- URL -->
         <xsl:when test="./@system_name = 'url'">
            <a href="{./value}" target="_blank">
                <xsl:value-of select="$value"/>
            </a>
         </xsl:when>

         <!-- DATE -->
         <xsl:when test="./@system_name = 'date'">
            <xsl:value-of select="./value"/>
         </xsl:when>
    
         <!-- FILE TO DOWNLOAD -->
         <xsl:when test="./@system_name = 'file'">
            <a href="{/page/settings/filestorageurl}{./value}" target="_blank"><xsl:value-of select="./value"/></a>
         </xsl:when>
    
        </xsl:choose>
        <!-- /PRINTING CAPTION VALUE-->
    
        <!-- PRINTING CLOSING </A> TAG IF THIS IS A LINK-->
        <xsl:if test="(./@is_link=1) and (../@publication_type != 0)">
            <xsl:text disable-output-escaping="yes">&lt;/b&gt;&lt;/a&gt;</xsl:text>
        </xsl:if>
        <!-- /PRINTING CLOSING </A> TAG IF THIS IS A LINK-->
    
      <!-- PRINTING FIELD FOOTER DELIMITERS -->
      <xsl:if test="delimiters/footer != ''">
         <xsl:value-of select="delimiters/footer" disable-output-escaping="yes"/>
      </xsl:if>
      <!-- /PRINTING FIELD FOOTER DELIMITERS -->


        <br/>
    </xsl:if>
      <BR/>
      --
      <BR/>
</xsl:template> 

</xsl:stylesheet>               
