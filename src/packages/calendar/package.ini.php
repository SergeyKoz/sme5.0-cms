<?php
/*
[PACKAGE]
PackageName  =  calendar                            ## package name
PackageTitle =  Calendar     						## package title
PackagePath  =  {FrameworkPath}packages/{PackageName}/ 	## package  path
PackageURL   =  {FrameworkURL}packages/{PackageName}/  	##  Package URL

ResourcePath =  {PackagePath}data/resources/        	## resources directory
ResourcePath =  {FrameworkPath}packages/libraries/data/resources/         ## resources directory

[PATH]
TemplatePath = {ModulePath}data/templates/
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}data/templates/
TemplatePath = {FrameworkPath}packages/libraries/data/templates/

ClassPath    =  {ModulePath}classes/
ClassPath    =  {PackagePath}classes/
ClassPath    =  {FrameworkPath}packages/libraries/classes/
ClassPath    =  {FrameworkPath}packages/tags/classes/

PagePath     =  {PackagePath}/pages/
PagePath     =  {FrameworkPath}packages/libraries/pages/

[DATABASE]
CalendarCategoriesTable={TablesPrefix}calendar_categories
CalendarEventsTable={TablesPrefix}calendar_events

[EVENTSLISTTHUMBS]
width = 80
height = 80
color = FFFFFF
method = PerfectScaleImage

[EVENTSDETAILTHUMBS]
width = 150
height = 150
color = FFFFFF
method = PerfectScaleImage

[EVENTSBLOCKTHUMBS]
width = 50
height = 50
color = FFFFFF
method = PerfectScaleImage

[MAIN]
useAuthentication  =  1
LibraryName        = 		                       ## Default library name
LibrariesRoot      = {PackagePath}data/libraries/  ## Libraries config files directory
RecordsPerPage     = 5                             ## List records per page
Textarea_cols      = 70                            ## Textarea columns
Textarea_rows      = 6                             ## Textarea rows
Text_size          = 70                            ## Text field size

EventsRPP          = 10
LastEventsCount    = 5
DefaultEventsCount = 10

[AUTHORIZATION]
HREF_Access_Denied=?package=extranet&page=extranetlogon&MESSAGE[]=ACCESS_DENIED
HREF_Not_Logged=?package=extranet&page=extranetlogon
HREF_Default_Redirect=?page=framelist

[DEFAULT]
DefaultPage=itemslist

[ROLES]
CALENDAR_EDITOR = Calendar editor|Backend

*/
?>