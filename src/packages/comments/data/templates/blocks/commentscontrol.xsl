<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">

	<xsl:template name="comments">
		<xsl:param name="article"/>
		<xsl:param name="module"/>

		<xsl:for-each select="/page/content/cms_comments">
			
			<xsl:if test="editor_url">
				<script type="text/javascript">
					if (!(typeof tinyMCE=='object')){
						var newScript = document.createElement("script");
						newScript.src='<xsl:value-of select="editor_url"/>tiny_mce.js';
						document.body.appendChild(newScript);
					}
				</script>
			</xsl:if>
			<xsl:variable name="p"><xsl:value-of select="$module"/><xsl:value-of select="$article"/></xsl:variable>
			<xsl:variable name="parent" select="form_data/parent"/>

			<xsl:if test="commments_list[@p=$p]/item">
				<ul>					
					<xsl:for-each select="commments_list[@p=$p]/item">
						<xsl:variable name="margin" select="level*20"/>
						<li style="margin-left:{$margin}px;">
							Автор:
							<xsl:choose>
								<xsl:when test="user_login!=''">
									<xsl:value-of select="user_login"/>
								</xsl:when>
								<xsl:otherwise><xsl:value-of select="author_name"/></xsl:otherwise>
							</xsl:choose>
							
							<xsl:if test="parent_user_login!='' or parent_author_name!=''">
								відповів користовачу
								<xsl:choose>
									<xsl:when test="parent_user_login!=''">
										<xsl:value-of select="parent_user_login"/>
									</xsl:when>
									<xsl:otherwise><xsl:value-of select="parent_author_name"/></xsl:otherwise>
								</xsl:choose>
							</xsl:if>
							
							<br/>
								
								
							Опубліковано:<xsl:value-of select="posted"/><br/>
							<xsl:if test="/page/content/cms_comments/comments_voting=1">
								<xsl:choose>
									<xsl:when test="rating=0">0</xsl:when>
									<xsl:when test="rating>0"><b><span class="green"><xsl:value-of select="rating"/></span></b></xsl:when>
									<xsl:when test="rating&lt;0"><b><span class="red"><xsl:value-of select="rating"/></span></b></xsl:when>
								</xsl:choose>
								<!-- voting-->
								<br/>
							</xsl:if>
		
							<xsl:value-of select="comment" disable-output-escaping="yes"/><br/>
		
							<xsl:if test="not(/page/@user_id='' and /page/content/cms_comments/comments_only_register=1)">							
								<div id="{$p}main_comment_form_container_{comment_id}">
									<xsl:choose>
											<xsl:when test="$parent=comment_id">
												<xsl:for-each select="/page/content/cms_comments">
													<xsl:call-template name="comment_form">
														<xsl:with-param name="article" select="$article"/>
														<xsl:with-param name="module" select="$module"/>
													</xsl:call-template>
												</xsl:for-each>
											</xsl:when>
										
										<xsl:otherwise>
											<a href="" onclick="return {$p}answer({comment_id});">Відповісти</a>
										</xsl:otherwise>
									</xsl:choose>
								</div><br/>							
							</xsl:if>
						</li>
					</xsl:for-each>
				</ul>
				<xsl:apply-templates select="commments_list[@p=$p]/navigator"/>
			</xsl:if>

			<xsl:if test="not(/page/@user_id='' and comments_only_register=1)">
				
				<div  id="{$p}main_comment_form_container_0">
					<xsl:choose>
						<xsl:when test="form_data/parent>0">
							<a href="" onclick="return {$p}answer(0)">Додати коментар</a>
						</xsl:when>
						<xsl:otherwise>
							<xsl:call-template name="comment_form">
								<xsl:with-param name="article" select="$article"/>
								<xsl:with-param name="module" select="$module"/>
							</xsl:call-template>
						</xsl:otherwise>
					</xsl:choose>
					
				</div>
			</xsl:if>

			<script type="">
			
				<xsl:if test="editor_url">
					<xsl:variable name="tiny_lang">
						<xsl:choose>
							<xsl:when test="/page/@language='ua'">uk</xsl:when>
							<xsl:otherwise><xsl:value-of select="/page/@language"/></xsl:otherwise>
						</xsl:choose>
					</xsl:variable>
					function <xsl:value-of select="$p"/>tinyInit(){
						tinyMCE.init({
							language : "<xsl:value-of select="$tiny_lang"/>",
							mode : "specific_textareas",
							editor_selector:'<xsl:value-of select="$p"/>CommentClass',
							theme : "simple",
							valid_elements : "p,b,i,u,strike,ul,ol,li"
						});
					}
					<xsl:value-of select="$p"/>tinyInit();					
				</xsl:if>
			
				var <xsl:value-of select="$p"/>currentFormContainer=<xsl:value-of select="form_data/parent"/>;
				function <xsl:value-of select="$p"/>answer(comment_id){	
					var currentContaiter=<xsl:value-of select="$p"/>currentFormContainer;
					
					if(comment_id!=currentContaiter){
				
						var newFormContainerObject=document.getElementById('<xsl:value-of select="$p"/>main_comment_form_container_'+comment_id);
						var currentFormContainerObject=document.getElementById('<xsl:value-of select="$p"/>main_comment_form_container_'+currentContaiter);
	
						<xsl:if test="editor_url">
						var tiny=tinyMCE.get(document.<xsl:value-of select="$p"/>CommentForm.comment.id);
						tiny.remove(); tiny.destroy();						
						</xsl:if>
						
						newFormContainerObject.innerHTML=currentFormContainerObject.innerHTML;
	
						answerCaption=(currentContaiter==0 ? 'Додати коментар' : 'Відповісти');
						currentFormContainerObject.innerHTML='&lt;a href="" onclick="return <xsl:value-of select="$p"/>answer('+currentContaiter+');">'+answerCaption+'&lt;/a>';
						
						<xsl:if test="editor_url"><xsl:value-of select="$p"/>tinyInit();</xsl:if>
						
						document.getElementById('<xsl:value-of select="$p"/>parent').value=comment_id;
	
						<xsl:value-of select="$p"/>currentFormContainer=comment_id;
					}
					var cancelButtonObject=document.getElementById('<xsl:value-of select="$p"/>comment_cancel_button');					
					cancelButtonObject.style.display=(comment_id==0 ? 'none' : 'block');


					return false;
				}
				<xsl:if test="form_data/parent>0">
					<xsl:value-of select="$p"/>answer(<xsl:value-of select="form_data/parent"/>);
				</xsl:if>
			</script>

		</xsl:for-each>


	</xsl:template>
	
	<xsl:template name="comment_form">
		<xsl:param name="article"/>
		<xsl:param name="module"/>
		<xsl:variable name="p"><xsl:value-of select="$module"/><xsl:value-of select="$article"/></xsl:variable>
		<form action="{action_uri}" method="post" name="{$p}CommentForm">
			<xsl:choose>
				<xsl:when test="/page/@user_id=''">

					<xsl:choose>
						<xsl:when test="err_data/name and $article=form_data/article">
							<span class="red">Имя *:</span>
						</xsl:when>
						<xsl:otherwise>Имя *:</xsl:otherwise>
					</xsl:choose>
					<xsl:variable name="name_value">
						<xsl:if test="$article=form_data/article"><xsl:value-of select="form_data/name"/></xsl:if>
					</xsl:variable>
					 <input type="text" name="name" value="{$name_value}"/><br/>
					<xsl:choose>
						<xsl:when test="err_data/email and $article=form_data/article">
							<span class="red">Email *:</span>
						</xsl:when>
						<xsl:otherwise>Email *:</xsl:otherwise>
					</xsl:choose>
					<xsl:variable name="email_value">
						<xsl:if test="$article=form_data/article"><xsl:value-of select="form_data/email"/></xsl:if>
					</xsl:variable>
					<input type="text" name="email" value="{$email_value}"/><br/>
				</xsl:when>
				<xsl:otherwise>
					Автор:<b><xsl:value-of select="/page/@user_name"/></b><br/>
				</xsl:otherwise>
			</xsl:choose>

			<xsl:choose>
				<xsl:when test="err_data/comment and $article=form_data/article">
					<span class="red">Коментар <xsl:value-of select="comments_length"/> символів *</span>
				</xsl:when>
				<xsl:otherwise>Коментар <xsl:value-of select="comments_length"/> символів *</xsl:otherwise>
			</xsl:choose>
			
			<xsl:variable name="comment_value">
				<xsl:if test="$article=form_data/article"><xsl:value-of select="form_data/comment"/></xsl:if>
			</xsl:variable>
			
			<textarea class="{$p}CommentClass" name="comment"><xsl:value-of select="$comment_value"/></textarea>
			<xsl:if test="/page/@user_id=''">
				<xsl:choose>
					<xsl:when test="err_data/securecode and $article=form_data/article">
						<span class="red">Захисний код *</span>
					</xsl:when>
					<xsl:otherwise>Захисний код *</xsl:otherwise>
				</xsl:choose><br/>
				<input name="securecode" value="" /><br/>
				<img src="{/page/@url}scripts/securecode.php" /><br/>
			</xsl:if>
			<input type="hidden" name="article" value="{$article}"/>
			<input type="hidden" name="module" value="{$module}"/>
			<input type="hidden" name="parent" value="{form_data/parent}" id="{$p}parent"/>
			<input type="hidden" name="event" value="AddComment"/>
			<input type="submit" value="Відправити"/>
			<input type="submit" style="display:none;" value="Відмінити" onclick="return {$p}answer(0);" id="{$p}comment_cancel_button"/>
		</form>
	</xsl:template>
</xsl:stylesheet>
