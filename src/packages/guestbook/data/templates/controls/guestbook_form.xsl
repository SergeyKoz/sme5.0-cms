<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
 <xsl:template match="guestbook_form">
   <form action="?" method="POST" name="guestbook_form"> 
   <input type="hidden" name="event" value="GuestbookAddMessage"/>
   <table border="1" width="100%">
   		<!-- FORM TITLE BLOCK-->
        <tr height="50">
         	<td align="top">
         		<xsl:value-of select="//_guestbook_form_title" />
         	</td>
        </tr>
   		<!-- END OF FORM TITLE BLOCK-->
   		<!-- INPUT FIELDS BLOCK -->
        <xsl:for-each select="field">
          <tr><td>
          <font color="black">
          <xsl:if test="./@error = 1">
          <xsl:attribute name="color">red</xsl:attribute>
          </xsl:if>
          <!-- Control caption -->
          <xsl:value-of select="caption"/>
          </font>
          
          <br/>
          
          <xsl:choose>
             <xsl:when test="./@type='text'">
                 <input type="text" name="{./@name}" value="{value}">
	                 <xsl:if test="value=''">
	                 	<xsl:attribute name="value"><xsl:value-of select="default_value" /></xsl:attribute>
	                 </xsl:if>
                 </input>
             </xsl:when>
             <xsl:when test="./@type='email'">
                 <input type="text" name="{./@name}" value="{value}">
	                 <xsl:if test="value=''">
	                 	<xsl:attribute name="value"><xsl:value-of select="default_value" /></xsl:attribute>
	                 </xsl:if>
                 </input>
             </xsl:when>
             <xsl:when test="./@type='textarea'">
                 <textarea name="{./@name}" style="width:350;height:100"><xsl:value-of select="value"/>
	                 <xsl:if test="value=''">
	                 	<xsl:value-of select="default_value" />
	                 </xsl:if>
                 </textarea>
             </xsl:when>
          </xsl:choose>
          </td></tr>
       </xsl:for-each>
   		<!-- END OF INPUT FIELDS BLOCK -->
   </table>
   <br />
   <input type="submit" value="{//_guestbook_submit_button_caption}"/>
  </form>
  	<xsl:choose>
		<xsl:when test="messages/count=0">
		 	<xsl:value-of select="//_guestbook_no_messages" />
		</xsl:when>
		<xsl:otherwise>
			<!-- MESSAGES NAVIGATOR (TOP) BLOCK -->
			<xsl:apply-templates select="navigator" />
			<!-- END OF MESSAGES NAVIGATOR (TOP) BLOCK -->
			<!-- MESSAGES LIST BLOCK -->
			<xsl:apply-templates select="messages/msg" />
			<!-- END OF MESSAGES LIST BLOCK -->
			<!-- MESSAGES NAVIGATOR (BOTTOM) BLOCK -->
			<xsl:apply-templates select="navigator" />
			<!-- END OF MESSAGES NAVIGATOR (BOTTOM) BLOCK -->
		</xsl:otherwise>
  	</xsl:choose>
 </xsl:template>

 <xsl:template match="messages/msg">
	<table border="1" width="100%">
		<tr>
			<td>
				<!-- Message owner's signature -->
	 			<xsl:value-of select="signature" />
	 			<xsl:if test="email != ''">
	 				(<a href="mailto:{email}"><xsl:value-of select="email" /></a>)
	 			</xsl:if>
			</td>
			<td width="1%">
				<!-- Date when message had been posted -->
	 			<nobr><xsl:value-of select="posted_date" /></nobr>
			</td>
		</tr>
		<tr height="50" valign="top">
			<td colspan="2">
				<!-- Text of message -->
	 			<xsl:value-of select="text" />
			</td>
		</tr>
		<xsl:if test="comment != ''">
			<tr>
				<td colspan="2">
					<!-- Moderator's comment to message -->
		 			<xsl:value-of select="comment" />
				</td>
			</tr>
		</xsl:if>
		<tr height="5">
			<td colspan="2"></td>
		</tr>
 	</table>
 </xsl:template>

</xsl:stylesheet>


