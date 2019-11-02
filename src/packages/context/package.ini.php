<?php
/*
[PACKAGE]
PackageName  = context                  ## package name
PackageTitle = Context                  ## package title
PackagePath  = {FrameworkPath}packages/context/           ## package  path
PackageURL   = {FrameworkURL}packages/{PackageName}/  ##  Package URL
ResourcePath = {FrameworkPath}packages/{PackageName}/data/resources/        ## resources directory
ResourcePath = {FrameworkPath}packages/libraries/data/resources/                ## resources directory


[PATH]
TemplatePath = {ModulePath}data/templates/
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}packages/libraries/data/templates/

ClassPath = {PackagePath}classes/
ClassPath = {FrameworkPath}packages/libraries/classes/
ClassPath = {FrameworkPath}packages/extranet/classes/

PagePath  = {PackagePath}pages/
PagePath  = {FrameworkPath}packages/libraries/pages/

[MAIN]
useAuthentication  =  1
LibraryName        =                           		## Default library name
LibrariesRoot      = {PackagePath}data/libraries/  ## Libraries config files directory
RecordsPerPage     = 5                             ## List records per page
Textarea_cols      = 70                            ## Textarea columns
Textarea_rows      = 6                             ## Textarea rows
Text_size          = 70                            ## Text field size

Menu_IniFile     = {FrameworkPath}packages/{PackageName}/data/resources/menu.ini.php  ##  Top menu INI-file

[DATABASE]

[AUTHORIZATION]
HREF_Access_Denied=?package=extranet&page=extranetlogon&MESSAGE[]=ACCESS_DENIED
HREF_Not_Logged=?package=extranet&page=extranetlogon
HREF_Default_Redirect=?page=framelist

[ROLES]

*/
?>