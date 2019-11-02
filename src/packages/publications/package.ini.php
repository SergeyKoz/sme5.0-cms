<?php
/*
[PACKAGE]
PackagePath  =  {FrameworkPath}packages/publications/           ## package  path
PackageName  =  publications                  ## package name
PackageTitle =  Publications                  ## package title
PackageURL   =  {FrameworkURL}packages/{PackageName}/  ##  Package URL
ResourcePath = {FrameworkPath}packages/{PackageName}/data/resources/        ## resources directory
ResourcePath = {FrameworkPath}packages/libraries/data/resources/                ## resources directory
Backend_DefaultPage=pageslist                                                   ##  Backend default page
                                                                                                                                                 ##  Frontend default page

[PATH]
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}packages/libraries/data/templates/

ClassPath = {PackagePath}classes/
ClassPath = {FrameworkPath}packages/system/classes/
ClassPath = {FrameworkPath}packages/libraries/classes/
ClassPath = {FrameworkPath}packages/banner/classes/
ClassPath = {FrameworkPath}packages/content/classes/
ClassPath = {FrameworkPath}packages/tags/classes/
PagePath  = {PackagePath}pages/
PagePath  = {FrameworkPath}packages/libraries/pages/

[MAIN]
useAuthentication  =  1
LibraryName        = structure                     ## Default library name
LibrariesRoot      = {PackagePath}data/libraries/  ## Libraries config files directory
RecordsPerPage     = 5                             ## List records per page
Textarea_cols      = 70                            ## Textarea columns
Textarea_rows      = 6                             ## Textarea rows
Text_size          = 70                            ## Text field size

[DATABASE]
TemplatesTable={TablesPrefix}publications_templates
TemplateParamsTable={TablesPrefix}publications_template_parameters
PublicationsTable={TablesPrefix}publications_tree
PublicationParamsTable={TablesPrefix}publications_tree_parameters
MappingTable={TablesPrefix}publications_mapping

[AUTHORIZATION]
HREF_Access_Denied=?package=extranet&page=extranetlogon&MESSAGE[]=ACCESS_DENIED
HREF_Not_Logged=?package=extranet&page=extranetlogon
HREF_Default_Redirect=?page=framelist


[ROLES]
PUBLICATIONS_EDITOR=Publications content editor|Backend
PUBLICATIONS_PUBLISHER=Publications content publisher|Backend
PUBLICATIONS_MANAGER=Publications structure administrator|Backend

[COMMON]
PublicationsTemplatesPath = {ModulePath}data/templates/publications/    ## absolute path to publications objects xsl-templates

*/
?>