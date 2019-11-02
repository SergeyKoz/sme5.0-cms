<?php
/*
[PACKAGE]
PackageName  =  fotocontest   ## package name
PackageTitle =  Foto Contest   ## package title

PackagePath  = {FrameworkPath}packages/{PackageName}/                  ## package  path
PackageURL   = {FrameworkURL}packages/{PackageName}/                   ## Package URL
ResourcePath = {FrameworkPath}packages/{PackageName}/data/resources/   ## resources directory
ResourcePath = {FrameworkPath}packages/libraries/data/resources/                        ## resources directory


[PATH]
TemplatePath = {ModulePath}packages/fotocontest/data/templates/
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}packages/libraries/data/templates/

ClassPath    =  {PackagePath}classes/
ClassPath = {FrameworkPath}packages/libraries/classes/

PagePath     =  {PackagePath}/pages/
PagePath     =  {FrameworkPath}packages/libraries/pages/

[DATABASE]
FotoContestsTable={TablesPrefix}foto_contest
FotosTable={TablesPrefix}foto

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
DefaultPage=default                             ##  Backend default page


[FOTOSETTINGS]
INTERVAL_SETTING_ID = 40

*/
?>