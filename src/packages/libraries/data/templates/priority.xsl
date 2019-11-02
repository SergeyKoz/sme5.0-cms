<?xml version="1.0" encoding="windows-1251"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" version="1.0" encoding="windows-1251" omit-xml-declaration="no"  media-type="text/html"/>

    <!-- Administrator section layout stylesheet -->
  <xsl:include href="layouts/layout.xsl"/>
  <xsl:include href="blocks/errors.xsl"/>
    <xsl:include href="blocks/debug.xsl"/>


    <xsl:template match="/"><xsl:apply-templates/></xsl:template>
    

    <xsl:template match="content">
                <!-- FRAME 1  begin -->

<xsl:choose>
<xsl:when test="/page/@user_groupid='1'">
<table cellpadding="10" cellspacing="10" border="0" width="100%"><tr><td class="arial12">
<fieldset style="padding:10px;">

	<xsl:choose>
	<xsl:when test="/page/@language = 'en'">
	<p>While working with the administrative system of the site Interbucks.com you can use Administrator Manual (please see link in the upper right corner of the screen). We recommend you keep this Manual open or print it out for your convenience while using the system.</p>
	
	<p>Administrative part of Interbucks.com includes the following:
	<ul style="margin-top:0px;">
		<li>Main menu.<br/>
				Located on the left side of the page and consists of the following parts (points):</li>
					<ul>
						<li>Orders</li>
						<li>Last Changes</li>
						<li>Libraries</li>
						<li>Products</li>
						<li>Support and FAQ</li>
					</ul>
	</ul>
	
	<ul style="margin-top:0px;">
		<li>Additional menu.<br/>
				Located on the top of the page and has three items:</li>
					<ul>
						<li>Users</li>
						<li>Subscribers</li>
						<li>Settings</li>
					</ul>
	</ul>
	</p>
	
	<p>Click on the button with the name of the section (item) of the menu gives access to its subsections.</p>
	</xsl:when>
	
	<xsl:otherwise>
	<p>��� ������ � �������� ���������� ������ Interbucks.com �� ������ ������������ ������������ ��������������, ������ �� ������� ����������� � ������� ������ ����. ����������� ������� �������� ��� ����������� ������ ����������� ��� �������� ����������� ��������.</p>
	
	<p>���������������� ����� ����� Interbucks.com ��������:
	<ul style="margin-top:0px;">
		<li>�������� ����.<br/>
				��������� � ����� ����� �������� � ������� �� ��������� �������� (�������):</li>
					<ul>
						<li>������</li>
						<li>��������� ���������</li>
						<li>����������</li>
						<li>������</li>
						<li>��� � ����</li>
					</ul>
	</ul>
	
	<ul style="margin-top:0px;">
		<li>�������������� ����.<br/>
				����������� � ������� ����� �������� � ������������ ����� ��������:</li>
					<ul>
						<li>������������</li>
						<li>����������</li>
						<li>���������</li>
					</ul>
	</ul>
	</p>
	
	<p>��� ������� �� ������ � ��������� ���� ��� ����� ������� (������) ��������� ���� ����������� ������ � ��� �����������.</p>
	</xsl:otherwise>
	</xsl:choose>

</fieldset>
</td></tr></table>
</xsl:when>

<xsl:otherwise>
<table cellpadding="10" cellspacing="10" border="0" width="100%"><tr><td class="arial12">
<fieldset style="padding:10px;background-color:buttonface;">

<xsl:choose>
<xsl:when test="/page/@language = 'en'">
	<p>While working with the administrative system of the site Interbucks.com you can use Vendor�s Manual (please see link in the upper right corner of the screen). We recommend you keep this Manual open or print it out for your convenience while using the system.</p>
	<p>Administrative part of Interbucks.com includes the following parts (please see navigation on the left side of the page):
	<ul style="margin-top:0px;">	
		<li>Orders</li>
		<li>Products</li>
	</ul>
	</p>
	<p>Click on the button with the name of the section (item) of the menu gives access to its subsections.</p>
</xsl:when>

<xsl:otherwise>
<p>��� ������ � �������� ���������� �������� � �������� Interbucks.com �� ������ ������������ ������������ �������������� ����������, ������ �� ������� ����������� � ������� ������ ����. ����������� ������� �������� ��� ����������� ������ ����������� ��� �������� ����������� ��������.</p>

<p>���� ���������������� ����� ����� Interbucks.com ��������� � ����� ����� �������� � ������� �� ��������� �������� (�������):
<ul style="margin-top:0px;">
	<li>������</li>
	<li>������</li>
</ul>
</p>
<p>��� ������� �� ������ � ��������� ���� ��� ����� ������� (������) ���� ����������� ������ � ��� �����������. </p>

</xsl:otherwise>
</xsl:choose>

</fieldset>
</td></tr></table>
</xsl:otherwise>
</xsl:choose>

                <!-- FRAME 1  end -->
        
    </xsl:template>
    
</xsl:stylesheet>
