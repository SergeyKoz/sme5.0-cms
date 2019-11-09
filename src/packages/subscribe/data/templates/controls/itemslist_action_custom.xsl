<?xml version="1.0" encoding="utf-8"?>
<!-- edited with XMLSPY v5 rel. 4 U (http://www.xmlspy.com) by user (company) -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
	<xsl:template name="list_action_custom">
		<xsl:if test="handler/library = 'contentlist'">
			<td>
				<xsl:value-of select="//localization/_subscribe_item_title"/>
			</td>
		</xsl:if>
		<!--xsl:if test="handler/library = 'teamlist'">  
        <td><xsl:value-of select="//localization/_subscribe_not_send" /></td>          
    </xsl:if>  
    
    <xsl:if test="handler/library = 'archivelist'">  
        <td><xsl:value-of select="//localization/_subscribe_title" /></td>      

    </xsl:if-->
		<xsl:if test="handler/library = 'user_list'">
			<td>
				<xsl:value-of select="//localization/_subscribe_item_title"/>
			</td>
		</xsl:if>
		<xsl:if test="handler/library = 'subscribelist'">
			<td>
				<xsl:value-of select="//localization/_subscribe_item_title"/>
			</td>
		</xsl:if>
	</xsl:template>
	<xsl:template name="item_action_custom">
		<xsl:if test="../handler/library = 'contentlist'">
			<!--, -->
			<xsl:variable name="_test">
				<xsl:choose>
					<xsl:when test="./control[@position=5]/checkbox/checked='yes'">1</xsl:when>
					<xsl:otherwise>0</xsl:otherwise>
				</xsl:choose>
			</xsl:variable>
			<td>
				<!--a href="" onclick="return sendSubscribe({./@id}, '{./control[@position=2]/link/caption}', {$_test});"-->
				<a href="" onclick="return sendSubscribe({./@id}, '{./control[@position=2]/link/caption}');">
					<xsl:value-of select="//localization/_caption_subscribe"/>
				</a>
			</td>
		</xsl:if>
		<!--xsl:if test="../handler/library = 'teamlist'">
     <td><a href="?package=subscribe&amp;page=mailinglist&amp;library=user_list&amp;team_id={./@id}"><xsl:value-of select="//localization/_subscribe_item_title" /></a></td>   
   </xsl:if> 
   
   <xsl:if test="../handler/library = 'archivelist'">
     <td><a href="?package=subscribe&amp;page=mailinglist&amp;library=user_list&amp;id={./@id}"><xsl:value-of select="//localization/_subscribe_item_title" /></a></td>   

   </xsl:if-->
		<xsl:if test="../handler/library = 'user_list'">
			<td>
				<input type="checkbox" name="{//http/row/team_id/name}{//http/row/id/name}[{//http/row/team_id/value}{//http/row/id/value}][{./@id}]" checked="checked"/>
			</td>
		</xsl:if>
		<xsl:if test="../handler/library = 'subscribelist'">
			<td>
				<input type="checkbox" name="sub_id[{./@id}]" checked="checked"/>
			</td>
		</xsl:if>
	</xsl:template>
</xsl:stylesheet>
