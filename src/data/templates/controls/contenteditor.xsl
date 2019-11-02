<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
<xsl:template match="extrahtmleditor">
  <xsl:param name="class"/>
  <xsl:param name="disabled"/>
  <xsl:for-each select="//localization/_alias_hint">
    <xsl:value-of select="."  disable-output-escaping="yes"/>
  </xsl:for-each>
  <xsl:value-of select="editor_browser" />
  <xsl:value-of select="editor_compatibility" />
  <xsl:value-of select="editor_version" />
  <xsl:choose>
   <!-- If editor support this browser -->
   <xsl:when test="editor_compatibility=1"> 
     <xsl:choose>
     <!-- If used  editor of version 2  -->
      <xsl:when test="editor_version=2">
        <xsl:choose>
         <xsl:when test="editor_browser='Gecko'"> <!-- If user browser Gecko compatibility -->           
           <script language="JavaScript"  src="{editor_url}?spaw_name={name}" />
         </xsl:when>
         <xsl:otherwise>      
           <script language="JavaScript"  src="{editor_url}script.js.php?spaw_name={name}"/>                      
           <!-- <xsl:call-template name="editor_ie_2" /> -->
         </xsl:otherwise>
        </xsl:choose>        
      </xsl:when> 
      <!-- If used  editor of version 1  -->
     <xsl:otherwise>
        <!--<xsl:call-template name="editor_ie_1" />-->
     </xsl:otherwise>     
     </xsl:choose>     
     <xsl:value-of select="editor_content" disable-output-escaping="yes"/>
   </xsl:when>   
   
   <!-- If editor support this browser -->
   <xsl:otherwise>
    Your browser does not support spaw editor.<BR/>
    <textarea cols="100" rows="10">
     <xsl:value-of select="content" disable-output-escaping="yes"/>
    </textarea>
   </xsl:otherwise>
  </xsl:choose>
  
  <xsl:if test="spaw_jsdisabled=0">    
  </xsl:if>                
</xsl:template>
    

</xsl:stylesheet>