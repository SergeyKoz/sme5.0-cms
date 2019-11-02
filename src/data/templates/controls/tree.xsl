<?xml version="1.0" encoding="windows-1251"?>
<!-- edited with XMLSPY v5 rel. 4 U (http://www.xmlspy.com) by user (company) -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
    <xsl:include href="elements/sub_node_list.xsl" />
    <xsl:template match="categories">
    <xsl:param name="url"/>
    <xsl:param name="var_name"/>

    <xsl:if test="sub_node_list/node">
        <link href="{/page/@url}css/tree_style.css" rel="stylesheet" type="text/css"/>
        
        <script language="JavaScript">
            image_path = '<xsl:value-of select="/page/@url"/>';
            var_name = '<xsl:value-of select="$var_name"/>';
            if(var_name=='')var_name='sub';
        </script>

        <script language="JavaScript" src="{/page/@framework_url}scripts/tree/argumenturl.js"></script>
        <script language="JavaScript" src="{/page/@framework_url}scripts/tree/tree.js"></script>
        <script language="JavaScript" src="{/page/@framework_url}scripts/tree/tree_format.js"></script>

        <script language="JavaScript">
        var type_doc1 = {
         "format":{
             "eimages":[
                 image_path+"img/i_document.gif",
                 image_path+"img/i_document.gif",
                 image_path+"img/i_document.gif",
                 image_path+"img/minus.gif",
                 image_path+"img/minusbottom.gif",
                 image_path+"img/plus.gif",
                 image_path+"img/plusbottom.gif",
                 image_path+"img/line.gif",
                 image_path+"img/join.gif",
                 image_path+"img/joinbottom.gif"
             ]
          }
        };

        var TREE1_NODES = [<xsl:apply-templates select="sub_node_list"><xsl:with-param name="url"><xsl:value-of select="$url"/></xsl:with-param><xsl:with-param name="var_name"><xsl:value-of select="$var_name"/></xsl:with-param></xsl:apply-templates>];
        var tree = new COOLjsTree("tree", TREE1_NODES, TREE1_FORMAT);
        if(src) tree.restoreState(src);
              
        </script>


    </xsl:if>


    </xsl:template>
</xsl:stylesheet>
