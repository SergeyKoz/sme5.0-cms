 <xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
 <xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="yes"  media-type="text/html"/>

 <xsl:template name="debug">
            <xsl:if test="content/debug">
               <hr/>
               <a name="_debug_menu"  onclick="$('#dbg_info').toggle();">Debug Info</a>
               <div id="dbg_info" style="display:none;">
                 <h3>Debug menu</h3>
                 
                <table border="1" width="95%" cellspacing="2" cellpadding="2" align="center">
                    <tr>
                      <td valign="top"><b>&amp;nbsp;Name</b></td>
                      <td valign="top"><b>&amp;nbsp;Link</b></td>
                    </tr>
                     <tr>
                      <td valign="top">&amp;nbsp;Main information</td>
                      <td valign="top">&amp;nbsp;<a href="#_debug_main" >Click here</a></td>
                    </tr>
                    <tr>
                      <td valign="top">&amp;nbsp;Imported libraries</td>
                      <td valign="top">&amp;nbsp;<a href="#_debug_libraries" >Click here</a></td>
                    </tr>
                    <tr>
                      <td valign="top">&amp;nbsp;Configs and localization information</td>
                      <td valign="top">&amp;nbsp;<a href="#_debug_config" >Click here</a></td>
                    </tr>
                    
                    <tr>
                      <td valign="top">&amp;nbsp;SQL information</td>
                      <td valign="top">&amp;nbsp;<a href="#_debug_config" >Click here</a></td>
                    </tr>
                    <tr>
                      <td valign="top">&amp;nbsp;Templates information</td>
                      <td valign="top">&amp;nbsp;<a href="#_debug_templates" >Click here</a></td>
                    </tr>
                     <tr>
                      <td valign="top">&amp;nbsp;Classes information</td>
                      <td valign="top">&amp;nbsp;<a href="#_debug_classes" >Click here</a></td>
                    </tr>
                    <tr>
                      <td valign="top">&amp;nbsp;HTTP request vars information</td>
                      <td valign="top">&amp;nbsp;<a href="#_debug_http" >Click here</a></td>
                    </tr>
                     <tr>
                      <td valign="top">&amp;nbsp;Localization information</td>
                      <td valign="top">&amp;nbsp;<a href="#_debug_localization" >Click here</a></td>
                    </tr>
                     <tr>
                      <td valign="top">&amp;nbsp;Messages (errors and warning) information</td>
                      <td valign="top">&amp;nbsp;<a href="#_debug_messages" >Click here</a></td>
                    </tr>
                 </table>

                    <xsl:if test="content/debug/page_info">
                 <table>
                 </table>
                 <hr/>
                  <a name="_debug_main" />
                  <a href="#_debug_menu" ><b>To Menu ^ </b></a>
                  <h3>Main information:</h3>
                  <table border="1" width="95%" cellspacing="2" cellpadding="2" align="center">
                    <tr>
                        <td valign="top"><b>&amp;nbsp;Page</b></td>
                      <td valign="top">&amp;nbsp;<xsl:value-of select="content/debug/page_info/class"/></td>
                    </tr>
                    <tr>
                      <td valign="top"><b>&amp;nbsp;Version</b></td>
                      <td valign="top">&amp;nbsp;<xsl:value-of select="content/debug/page_info/version"/></td>
                    </tr>
                    <tr>
                      <td valign="top"><b>&amp;nbsp;Template </b></td>
                      <td valign="top">&amp;nbsp;<xsl:value-of select="content/debug/page_info/template_name"/></td>
                    </tr>
                    <tr>
                      <td valign="top"><b>&amp;nbsp;Template path</b></td>
                      <td valign="top">&amp;nbsp;<xsl:value-of select="content/debug/page_info/template_path"/></td>
                    </tr>
                     <tr>
                      <td valign="top"><b>&amp;nbsp;Package</b></td>
                      <td valign="top">&amp;nbsp;<xsl:value-of select="content/debug/page_info/package"/></td>
                    </tr>
                     <tr>
                      <td valign="top"><b>&amp;nbsp;Library</b></td>
                      <td valign="top">&amp;nbsp;<xsl:value-of select="content/debug/page_info/lib" disable-output-escaping="yes"/></td>
                    </tr>
                  </table>
                </xsl:if>
                  <xsl:if test="content/debug/libraries">                   
                    <hr/>
                   <a name="_debug_libraries" />
                   <a href="#_debug_menu" ><b>To Menu ^ </b></a>
                    <h3>Imported libraries:</h3>                                        
                    <table width="95%" cellpadding="2"   border="1"  align="center">
                    <tr>
                      <td>
                        <b>Name</b>
                      </td>
                      <td><b>Description</b></td>                      
                    </tr>                   
                    
                      <xsl:for-each select="/page/content/debug/libraries/item">
                        <tr>
                         <td align="center">
                            <b><xsl:value-of select="name" disable-output-escaping="yes" /></b>
                         </td>
                           <td nowrap="yes">
                        <xsl:value-of select="description" disable-output-escaping="yes"/>
                         </td>                  
                        </tr>
                    </xsl:for-each>                    
                    </table>       
                  </xsl:if>
                   <xsl:if test="content/debug/config">
                  <hr/>
                 <a href="#_debug_menu" ><b>To Menu ^ </b></a>
                  <a name="_debug_config" />
                  <h3>Configuration files debug info:</h3>

                  <table width="95%" cellpadding="2"   border="1"  align="center">
                    <tr>
                      <td>
                        <b>Name</b>
                      </td>
                      <td><b>Description</b></td>
                                          <td><b>Status</b></td>
                    </tr>
                    <xsl:for-each select="/page/content/debug/config/item">
                        <tr>
                         <td>
                            <xsl:value-of select="name" disable-output-escaping="yes" />
                         </td>
                           <td nowrap="yes">
                        <xsl:value-of select="description" disable-output-escaping="yes"/>
                         </td>
                         <td nowrap="yes">
                                            <xsl:value-of select="error" disable-output-escaping="yes" />

                         </td>
                        </tr>
                    </xsl:for-each>
                  </table>
                  </xsl:if>
                 <xsl:if test="content/debug/sql">
                  <hr/>
                  <a href="#_debug_menu" ><b>To Menu ^ </b></a>
                  <a name="_debug_sql" />
                  <h3>SQL debug info:</h3>
                  <table  width="95%"  align="center">
                  <xsl:for-each select="/page/content/debug/sql/item">
                    <tr>
                    <td valign="top"><b>#</b></td>
                    <td valign="top"><font class="red"><b><xsl:value-of select="position()" /></b></font></td>
                    </tr>
                    <tr>
                    <td valign="top"><b>Query:</b></td>
                    <td valign="top" style="font-size:10px;"><pre><xsl:value-of select="description" /></pre></td>
                    </tr>
                    <xsl:if test="records != ''">
                     <tr>
                     <td valign="top"><b>Records:</b></td>
                     <td valign="top"><b><xsl:value-of select="records" /></b>


                     <xsl:if test="time &gt;= 0.01">
                     (<font color="FF0000"><b><u><xsl:value-of select="time" /></u></b> c.</font>)

                     </xsl:if>
                     <xsl:if test="(time &lt; 0.01) and (time &gt;= 0.001)">
                     (<font color="D09000"><b><xsl:value-of select="time" /></b> c.</font>)

                     </xsl:if>
                     <xsl:if test="time &lt; 0.001">
                     (<font color="009000"><b><xsl:value-of select="time" /></b> c.</font>)

                     </xsl:if>


                     </td>
                     </tr>
                    </xsl:if>
                    <tr>
                     <xsl:if test="result ='Error'">
                          <xsl:attribute name="bgcolor">EEEEEE</xsl:attribute>
                          <xsl:attribute name="border">1</xsl:attribute>
                      </xsl:if>

                    <td valign="top"><b>Result:</b></td>

                    <td valign="top">
                        <b>
                        <xsl:choose>
                            <xsl:when test="result ='Error'">
                                <font class="red"><xsl:value-of select="result" /></font>
                            </xsl:when>
                            <xsl:otherwise>
                                <font color="navy"><xsl:value-of select="result" /></font>
                            </xsl:otherwise>

                        </xsl:choose>
                        </b>
                    </td>
                    </tr>
                    <xsl:if test="error != ''">
                    <tr>
                    <td valign="top"><b>Description:</b></td>
                    <td valign="top"><b><xsl:value-of select="error" /></b></td>
                    </tr>
                    </xsl:if>
                    <tr><td colspan="3"><br/></td></tr>
                  </xsl:for-each>
                   <tr>
                    <td valign="top"><b>Total:</b></td>
                    <td valign="top"><b><xsl:value-of select="/page/content/debug/sql/total" /></b></td>
                    </tr>
                 </table>
                </xsl:if>




                  <xsl:if test="content/debug/templates">
                  <hr/>
                  <a href="#_debug_menu" ><b>To Menu ^ </b></a>
                  <a name="_debug_templates" />
                  <h3>Templates debug info:</h3>

                  <table width="95%" cellpadding="2"  border="1"  align="center">
                    <tr>
                      <td>
                        <b>Name</b>
                      </td>
                      <td><b>Path</b></td>
                      <td><b>Status</b></td>

                    </tr>
                    <xsl:for-each select="/page/content/debug/templates/item">
                        <tr>
                         <td valign="top">
                            <xsl:value-of select="name" disable-output-escaping="yes" />
                         </td>                                                  
                         <td>
                            <font size="-2"><xsl:value-of select="description" disable-output-escaping="yes" /></font>
                         </td>                          
                            <td nowrap="yes">
                            <xsl:value-of select="error" disable-output-escaping="yes" />
                         </td>
                        </tr>
                    </xsl:for-each>
                  </table>
                  </xsl:if>
                  <BR/>
                  <a href="#_debug_menu" ><b>To Menu ^ </b></a>
                  <xsl:if test="content/debug/classes">
                  <hr/>
                  <a name="_debug_classes" />
                  <h3>Classes debug info:</h3>

                  <table width="95%" cellpadding="2" border="1"  align="center">
                    <tr>
                      <td>
                        <b>Name</b>
                      </td>
                      <td><b>Path</b></td>
                      <td>
                      <b>Time</b>
                      </td>
                    </tr>
                    <xsl:for-each select="/page/content/debug/classes/item">
                        <tr>
                         <td valign="top">
                            <xsl:value-of select="name" />
                         </td>
                         <td>
                            <font size="-2"><xsl:value-of select="description" /></font>
                         </td>
                         <td>
                            <font size="-2"><nobr>
                     <xsl:if test="time &gt;= 0.01">
                     <font color="FF0000"><b><u><xsl:value-of select="time" /></u></b> c.</font>

                     </xsl:if>
                     <xsl:if test="(time &lt; 0.01) and (time &gt;= 0.001)">
                     <font color="D09000"><b><xsl:value-of select="time" /></b> c.</font>

                     </xsl:if>
                     <xsl:if test="time &lt; 0.001">
                     <font color="009000"><b><xsl:value-of select="time" /></b> c.</font>

                     </xsl:if>
                            </nobr>
                            </font>
                         </td>

                        </tr>
                    </xsl:for-each>
                  <tr>
                         <td valign="top">
                           <b> Total:</b>
                         </td>
                         <td colspan="2" align="right">
                           <b><xsl:value-of select="content/debug/classes/total" /> c.</b>
                         </td>
                  </tr>
                  </table>

                  </xsl:if>
                  <BR/>
                  <xsl:if test="/page/content/http/row">
                                        <hr/>
                  <a href="#_debug_menu" ><b>To Menu ^ </b></a>
                                        <a name="_debug_http" />
                    <h3>HTTP request vars:</h3>
                    <xsl:for-each select="/page/content/http/row">
                        <h4><xsl:value-of select="@name" /></h4><BR/>
                                            <table width="95%" cellpadding="2"  border="1" align="center">
                        <tr>
                        <td><b>Name</b></td>
                          <td><b>value</b></td>
                      </tr>
                      <xsl:for-each select="./*">
                      <tr>
                        <td valign="middle"><b><font size="-1"><xsl:value-of select="name"  disable-output-escaping="yes"/></font></b></td>
                        <td>

                                                    <font size="-1">
                          <xsl:choose>
                             <xsl:when test="count(value)=1">
                            <xsl:value-of select="value" disable-output-escaping="yes" />
                           </xsl:when>
                           <xsl:otherwise>
                            <xsl:for-each select="value">
                                               <xsl:value-of select="@name" disable-output-escaping="yes"/> =&amp;gt; <xsl:value-of select="." disable-output-escaping="yes" /><BR/>
                            </xsl:for-each>
                           </xsl:otherwise>
                          </xsl:choose>
                          </font>
                        </td>
                      </tr>
                      </xsl:for-each>
                        </table>
                    </xsl:for-each>
                                      <HR/>
                  </xsl:if>
                  
                    <xsl:if test="content/debug/_debug_localization">
               <a href="#_debug_menu" ><b>To Menu ^ </b></a>
               <a name="_debug_localization" />
                <hr/>
                  <h3>Localization variables:</h3>
                 <table width="95%" cellpadding="2" border="1" align="center">
                    <tr>
                      <td>
                        <b>Name</b>
                      </td>
                      <td>
                       <b>Section</b>
                      </td>
                      <td>
                       <b>Package</b>
                      </td>
                      <td>
                      <b>Value</b>
                      </td>
                    </tr>
                 <xsl:for-each select="content/debug/_debug_localization/*">
                   <tr>
                     <td>&amp;nbsp;<xsl:value-of select="name(.)" /></td>
                    <td>&amp;nbsp;<font color="green"><xsl:value-of select="./@section" /></font></td>
                    <td>&amp;nbsp;<font class="red"><xsl:value-of select="./@package" /></font></td>
                     <td>&amp;nbsp;<xsl:value-of select="." /></td>
                   </tr>
                 </xsl:for-each>
                 </table>
               </xsl:if>
              <xsl:if test="content/debug/_debug_messages">
               <a href="#_debug_menu" ><b>To Menu ^ </b></a>
               <a name="_debug_messages" />
                <hr/>
                  <h3>Messages (errors and warnings) variables:</h3>
                 <table width="95%" cellpadding="2" border="1" align="center">
                    <tr>
                      <td>
                        <b>Name</b>
                      </td>
                      <td>
                       <b>Section</b>
                      </td>
                      <td>
                       <b>Package</b>
                      </td>
                      <td>
                      <b>Value</b>
                      </td>
                    </tr>
                 <xsl:for-each select="content/debug/_debug_messages/*">
                   <tr>
                     <td>&amp;nbsp;<xsl:value-of select="name(.)" /></td>
                    <td>&amp;nbsp;<font color="green"><xsl:value-of select="./@section" /></font></td>
                    <td>&amp;nbsp;<font class="red"><xsl:value-of select="./@package" /></font></td>
                     <td>&amp;nbsp;<xsl:value-of select="." /></td>
                   </tr>
                 </xsl:for-each>
                 </table>
                 <a href="#_debug_menu" ><b>To Menu ^ </b></a>  <BR/>
               </xsl:if>
               </div>
              </xsl:if>
 </xsl:template>
</xsl:stylesheet>