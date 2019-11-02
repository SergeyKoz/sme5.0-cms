<?php
/*
[PACKAGE]
PackagePath  =  {FrameworkPath}packages/banner/		   	 ## package  path
PackageName  =  banner		                        		 ## package name
PackageTitle =  Banner														     ## package title
PackageURL   =  {FrameworkURL}packages/{PackageName}/  ##  Package URL
ResourcePath = {FrameworkPath}packages/{PackageName}/data/resources/        ## resources directory
ResourcePath = {FrameworkPath}packages/libraries/data/resources/         		## resources directory
                                                                                                                                                 ##  Frontend default page

[PATH]
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}packages/libraries/data/templates/

ClassPath = {PackagePath}classes/
ClassPath = {FrameworkPath}packages/libraries/classes/
ClassPath = {FrameworkPath}packages/content/classes/

PagePath     =  {PackagePath}/pages/
PagePath     =  {FrameworkPath}packages/libraries/pages/

[DATABASE]
BannerGroupsTable={TablesPrefix}banner_groups
BannerPlacesTable={TablesPrefix}banner_places
BannersTable={TablesPrefix}banners
BannerPlacesRelationTable={TablesPrefix}banner_placerelations
BannerPagesTable={TablesPrefix}banner_pages
BannerEventsTable={TablesPrefix}banner_events
BannerLanguagesTable={TablesPrefix}banner_languages

[MAIN]
useAuthentication  =  1
LibraryName        = bannergroups                  ## Default library name
LibrariesRoot      = {PackagePath}data/libraries/  ## Libraries config files directory
RecordsPerPage     = 5                             ## List records per page
Textarea_cols      = 70                            ## Textarea columns
Textarea_rows      = 6                             ## Textarea rows
Text_size          = 70                            ## Text field size


[AUTHORIZATION]
Backend_HREF_Access_Denied=?package=extranet&page=extranetlogon&MESSAGE[]=ACCESS_DENIED
Backend_HREF_Not_Logged=?package=extranet&page=extranetlogon
Backend_HREF_Default_Redirect=?page=framelist

[ROLES]		##Package roles
BANNER_ADMINISTRATOR=Banner system administrator|Backend        								
BANNER_PUBLISHER=Banners publisher|Backend

[DEFAULT]
DefaultPage=itemslist                                            		##   default page

*/
?>