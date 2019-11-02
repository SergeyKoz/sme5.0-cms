<?php
/*
[PACKAGE]
PackagePath  = {FrameworkPath}packages/diagnostic/  ## package  path
PackageName  = diagnostic   ## package name
PackageTitle = Diagnostic site states   ## package title
PackageURL   = {FrameworkURL}packages/{PackageName}/    ##  Package URL
ResourcePath = {FrameworkPath}packages/{PackageName}/data/resources/        ## resources directory
ResourcePath = {FrameworkPath}packages/libraries/data/resources/     ## resources directory


[PATH]
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}packages/libraries/data/templates/

ClassPath    = {PackagePath}classes/
ClassPath    = {FrameworkPath}packages/libraries/classes/
ClassPath    = {FrameworkPath}packages/banner/classes/

PagePath     = {PackagePath}/pages/
PagePath     = {FrameworkPath}packages/libraries/pages/

[DATABASE]
PackageTablesPrefix = diagnostic_
SitesTable={PackageTablesPrefix}sites
TestsTable={PackageTablesPrefix}tests
SiteTestsTable = {PackageTablesPrefix}site_tests
SiteEmailsTable = {PackageTablesPrefix}site_emails

[MAIN]
useAuthentication  =  1
LibraryName        = sites                     ## Default library name
LibrariesRoot      = {PackagePath}data/libraries/  ## Libraries config files directory
RecordsPerPage     = 5                             ## List records per page
Textarea_cols      = 70                            ## Textarea columns
Textarea_rows      = 6                             ## Textarea rows
Text_size          = 70                            ## Text field size


[AUTHORIZATION]
HREF_Access_Denied=?package=extranet&page=extranetlogon&MESSAGE[]=ACCESS_DENIED
HREF_Not_Logged=?package=extranet&page=extranetlogon
HREF_Default_Redirect=?page=framelist


[DEFAULT]
DefaultPage=status                             ##  Backend default page

[EMAIL]
EMAIL_NOTIFY_SUBJECT=SITES STATUS NOTIFICATION

*/
?>