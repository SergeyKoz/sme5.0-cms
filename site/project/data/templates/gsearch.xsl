<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="utf-8" omit-xml-declaration="no" media-type="text/html"/>
	<!-- Project layout stylesheet -->
	<xsl:include href="layouts/default.xsl"/>
	<!--Banners display template -->
	<xsl:include href="controls/banners.xsl"/>
	<!--Content display template -->
	<xsl:include href="controls/content.xsl"/>
	<!--Debug display include -->
	<xsl:include href="blocks/debug.xsl"/>
	<xsl:template match="/">
		<xsl:apply-templates/>
	</xsl:template>
	<xsl:template match="content">
	
		<script src="http://www.google.com/jsapi?key={/page/content/search_api_key}" type="text/javascript"/>
		<style type="text/css">
	
		      div.search-control {
		        width : 80%;
		      }
		
		      div.search-control .gsc-control {
		        width : 100%;
		      }
		
		
		      /* restrict global search form width */
		      #searchForm .gsc-control {
		        width : 500px;
		      }
		
		      /* disable twiddle's and size selectors */
		      #leftSearchControl .gsc-twiddle,
		      #rightSearchControl .gsc-twiddle {
		        background-image : none;
		      }
		
		      div.search-control .gsc-resultsHeader .gsc-title {
		        padding-left : 20px;
		        font-weight : bold;
		        font-size : 14px;
		      }
		
		      /*
		      div.search-control .gsc-resultsHeader div.gsc-results-selector {
		        display : none;
		      }
		      */
		      div.search-control .gsc-resultsRoot {
		        padding-top : 6px;
		      }
		
		      /* for demonstration purposes ONLY. This is not ok by the terms */ 
		      div.search-control .gsc-ad-box {
		        display : none;
		      }
		
		      /* long form visible urls should be on */
		      .gsc-webResult div.gs-visibleUrl-long {
		        display : block;
		      }
		
		      .gsc-webResult div.gs-visibleUrl-short {
		        display : none;
		      }
		
		
		      .gsc-results .gsc-trailing-more-results {
		        display : none;
		      }	
		      
    		</style>
    		
		<script language="Javascript" type="text/javascript">

	   		 google.load("search", "1");
	
	   		function OnLoad() {
			      // Create a search control
			      var searchControl = new google.search.SearchControl();
			
			      var siteSearch = new GwebSearch();
			
				var options = new GsearcherOptions();
				options.setExpandMode(GSearchControl.EXPAND_MODE_OPEN);
				//alert(GSearchControl.EXPAND_MODE_OPEN);
				
				
				siteSearch.setResultSetSize(GSearch.LARGE_RESULTSET);
				
				
				siteSearch.setUserDefinedLabel("Результаты поиска");
				//siteSearch.setUserDefinedClassSuffix("siteSearch");
				siteSearch.setSiteRestriction("<xsl:value-of select="/page/content/siterestriction"/>");
				
				
				
				searchControl.addSearcher(siteSearch, options);
				//searchControl.addSearcher(siteSearch);
			
			
			
			      // Tell the searcher to draw itself and tell it where to attach
			      searchControl.draw(document.getElementById("searchcontrol"));
			
			      
			      // Execute an inital search
			      <xsl:if test="/page/content/q != ''">
			          searchControl.execute("<xsl:value-of select="/page/content/q"/>");
			      </xsl:if>
	   		 }
	    		google.setOnLoadCallback(OnLoad);

   		 </script>
		<style>
			.gs-result a 
			{
			cursor: pointer;
			color: #ae7a37;
			}
			
			.gsc-result .gs-title 
			{
			color: #ae7a37;
			height: 1.4em;
			overflow-x: hidden;
			overflow-y: hidden;
			}
			
			.gs-result .gs-title, .gs-result .gs-title * 
			{
			color: #ae7a37;
			text-decoration: underline;
			}
			
			.gs-result .gs-title, .gs-result .gs-title * 
			{
			color: #ae7a37;
			text-decoration: underline;
			}

			.gsc-trailing-more-results a:link, .gsc-trailing-more-results a:visited, .gsc-trailing-more-results a:active  {text-decoration:underline; color: #ae7a37;}

			.gsc-cursor-box .gsc-cursor .gsc-cursor-page * 
			{
			color: #ae7a37;
			text-decoration: underline;
			}

			td.gsc-input {border:none;}
			input.gsc-input {
				border:1px solid;
				border-color:#ae7a37;
				background-color: #FFFFFF;
				font-size: 12px;
				font-family: tahoma;
				color: #000000;
			}
        
   		 </style>
		<body>
			<div id="searchcontrol" class="search-control">Loading...</div>
		</body>
	</xsl:template>
</xsl:stylesheet>
