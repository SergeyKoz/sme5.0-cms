<?php
/*
[PACKAGE]
PackageName  = tags                  ## package name
PackageTitle = Tags                  ## package title
PackagePath  = {FrameworkPath}packages/tags/           ## package  path
PackageURL   = {FrameworkURL}packages/{PackageName}/  ##  Package URL
ResourcePath = {FrameworkPath}packages/{PackageName}/data/resources/        ## resources directory
ResourcePath = {FrameworkPath}packages/libraries/data/resources/                ## resources directory
Backend_DefaultPage=pageslist                                                   ##  Backend default page

[PATH]
TemplatePath = {ModulePath}data/templates/
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}packages/libraries/data/templates/

ClassPath = {PackagePath}classes/
ClassPath = {FrameworkPath}packages/libraries/classes/
ClassPath = {PackagePath}pages/

PagePath  = {PackagePath}pages/
PagePath  = {FrameworkPath}packages/libraries/pages/

[MAIN]
useAuthentication  =  1
LibraryName        = tags                          ## Default library name
LibrariesRoot      = {PackagePath}data/libraries/  ## Libraries config files directory
RecordsPerPage     = 5                             ## List records per page
Textarea_cols      = 70                            ## Textarea columns
Textarea_rows      = 6                             ## Textarea rows
Text_size          = 70                            ## Text field size

[DATABASE]
TagsTable={TablesPrefix}tags
TagsItemsTable = {TablesPrefix}tags_items

[AUTHORIZATION]
HREF_Access_Denied=?package=extranet&page=extranetlogon&MESSAGE[]=ACCESS_DENIED
HREF_Not_Logged=?package=extranet&page=extranetlogon
HREF_Default_Redirect=?page=framelist


[ROLES]
TAGS_EDITOR=Tags editor|Backend

*/
?>