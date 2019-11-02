<?php
/**
   * Package configuration file
   * @package Search
   * @access  public
   **/

/*
[PACKAGE]
PackagePath  =  {FrameworkPath}packages/search/    ## package  path
PackageName  =  search                             ## package name
PackageTitle =  Search                             ## package title
PackageURL   =  {FrameworkURL}packages/{PackageName}/       ##  Package URL
##ResourcePath   = {ModulePath}packages/search/data/resources/       ## resources directory
ResourcePath = {FrameworkPath}packages/{PackageName}/data/resources/        ## resources directory
ResourcePath = {FrameworkPath}packages/libraries/data/resources/                ## resources directory

Backend_DefaultPage=search        ##  Backend default page
Frontend_DefaultPage=search       ##  Frontend default page

[PATH]
TemplatePath = {ModulePath}data/templates/
TemplatePath = {ModulePath}packages/search/data/templates/
TemplatePath = {ModulePath}packages/main/data/templates/
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}packages/libraries/data/templates/
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}packages/search/data/templates/

ClassPath    =  {ModulePath}packages/search/classes/
ClassPath    =  {ModulePath}packages/main/classes/
ClassPath    =  {PackagePath}classes/{ComponentName}/
ClassPath    =  {PackagePath}classes/
ClassPath    =  {FrameworkPath}packages/search/classes/{ComponentName}/
ClassPath    =  {FrameworkPath}packages/search/classes/

PagePath     =  {ModulePath}packages/search/pages/
PagePath     =  {ModulePath}packages/main/pages/
PagePath     =  {PackagePath}/pages/{ComponentName}/
PagePath     =  {PackagePath}/pages/
PagePath     =  {FrameworkPath}packages/search/pages/{ComponentName}/
PagePath     =  {FrameworkPath}packages/search/pages/


[INDEXER]
IndexerPath  =  {PackagePath}lib/
LoggingPath  =  {ModulePath}debug/
IndexindEntryPoint = {SiteURL}      ## ends with /

NoTitle = No Title - {SiteName}
StartIndexingFrom = <!--begin:search\/\/-->  ## preg_match compatible pattern
EndIndexingTo =  <!--end:search\/\/-->       ## preg_match compatible pattern

SecureSignature = qwertyy

[URLS]
BadUrl = .gif
BadUrl = .jpg
BadUrl = .swf
BadUrl = .zip
BadUrl = .psd
BadUrl = .doc
BadUrl = .xls
BadUrl = .rar
BadUrl = .exe
BadUrl = .msi
BadUrl = .pdf
BadUrl = .ppt
BadUrl = PrintWindow
BadUrl = /extranet/
BadUrl = /forum
BadUrl = camefrom=
BadUrl = ACCESS_DENIED
BadUrl = r.php
BadUrl = mode=
BadUrl = onclick
BadUrl = void

[MAIN]
useAuthentication  =  1
LibraryName        = users                         ## Default library name
LibrariesRoot      = {PackagePath}data/libraries/  ## Libraries config files directory
RecordsPerPage     = 10                             ## List records per page
Textarea_cols      = 70                            ## Textarea columns
Textarea_rows      = 6                             ## Textarea rows
Text_size          = 70                            ## Text field size


[AUTHORIZATION]
HREF_Access_Denied=?package=extranet&page=extranetlogon
HREF_Not_Logged=?package=extranet&page=extranetlogon
HREF_Default_Redirect=?

*/
?>