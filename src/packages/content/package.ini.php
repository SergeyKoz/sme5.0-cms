<?php
/*
[PACKAGE]
PackagePath  =  {FrameworkPath}packages/content/                                                    ## package  path
PackageName  =  content                                                                                 ## package name
PackageTitle =  Content                                                                                                     ## package title
PackageURL   =  {FrameworkURL}packages/{PackageName}/                                           ##  Package URL
ResourcePath = {FrameworkPath}packages/{PackageName}/data/resources/        ## resources directory
ResourcePath = {FrameworkPath}packages/libraries/data/resources/                ## resources directory

[PATH]
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}packages/libraries/data/templates/

ClassPath = {ModulePath}packages/content/classes/
ClassPath = {PackagePath}classes/
ClassPath = {FrameworkPath}packages/libraries/classes/
ClassPath = {FrameworkPath}packages/banner/classes/
ClassPath = {FrameworkPath}packages/tags/classes/

PagePath     =  {PackagePath}pages/
PagePath     =  {FrameworkPath}packages/libraries/pages/

[DATABASE]
ContentTable={TablesPrefix}content

[MAIN]
useAuthentication  =  1
LibraryName        = structure                     ## Default library name
LibrariesRoot      = {PackagePath}data/libraries/  ## Libraries config files directory
RecordsPerPage     = 5                             ## List records per page
Textarea_cols      = 70                            ## Textarea columns
Textarea_rows      = 20                            ## Textarea rows
Text_size          = 70                            ## Text field size
FileMode           = 0777                                        ## Entry points file creation mode
DirMode                  = 0777                                      ## Entry points directory creation mode
Extensions         = html,  htm, php               ## Entry points allowed extensions
DefaultTemplate      = project.xsl                                   ## Templates, used for creation of entry point template (model of all templates)
CustomTemplatePath  = custom/                                            ## Relative path  to custom page templates, trailing slash is required

[AUTHORIZATION]
HREF_Access_Denied=?package={DefaultPackage}&page={DefaultPackage}logon&MESSAGE[]=ACCESS_DENIED
HREF_Not_Logged=?package={DefaultPackage}&page={DefaultPackage}logon
HREF_Default_Redirect=?page=framelist

[ROLES]
STRUCTURE_MANAGER=Structure administrator|Backend                                   ## Site structure manager
CONTENT_EDITOR=Content editor|Backend                                               ## Content editor role

[DEFAULT]
DefaultPage=pageslist                                                           ##  Backend default page

[FORBIDDEN_URL]                                                                                                     ## Forbidden URL for entry points
FUrl    =   /extranet/                                                                                              ## Extranet URL
FUrl    =   /admin/                                                                                              ## Extranet URL
FUrl    =   entry.php                                                                                                   ## Entry URL
FUrl    = project.ini.php                                                                                       ## Project ini-file
FUrl  = /project/                                                                                                   ## Project sources URL
FUrl  = /files/                                                                                                     ## Project sources URL

*/
?>