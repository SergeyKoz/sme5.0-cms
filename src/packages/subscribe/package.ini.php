<?php
/*
[PACKAGE]

PackageName  =  subscribe   ## package name
PackageTitle =  subscribe   ## package title

PackagePath  = {FrameworkPath}packages/{PackageName}/                  ## package  path
PackageURL   = {FrameworkURL}packages/{PackageName}/                   ## Package URL

ResourcePath = {FrameworkPath}packages/{PackageName}/data/resources/
ResourcePath = {FrameworkPath}packages/libraries/data/resources/                        ## resources directory

[PATH]
TemplatePath = {ModulePath}data/templates/
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}data/templates/
TemplatePath = {FrameworkPath}packages/libraries/data/templates/

ClassPath = {PackagePath}classes/
ClassPath = {FrameworkPath}packages/libraries/classes/
ClassPath = {FrameworkPath}packages/content/classes/

PagePath     =  {PackagePath}pages/
PagePath     =  {FrameworkPath}packages/libraries/pages/

FilePath = {PackagePath}files/

[DATABASE]
SubscribeThemesTable={TablesPrefix}subscribe_themes
SubscribeUserTable={TablesPrefix}subscribe_user
SubscribeContentTable={TablesPrefix}subscribe_content
SubscribeRelationTable={TablesPrefix}subscribe_relation
SubscribeTemplateTable={TablesPrefix}subscribe_template
SubscribeCountryTable={TablesPrefix}subscribe_country

[MAIN]
useAuthentication  =  1
LibraryName        = regsubscribeuser                     ## Default library name
LibrariesRoot      = {PackagePath}data/libraries/  ## Libraries config files directory
RecordsPerPage     =                              ## List records per page
Textarea_cols      = 70                            ## Textarea columns
Textarea_rows      = 6                             ## Textarea rows
Text_size          = 70                            ## Text field size

[MESSAGE_PAGES]
register_page = sub_registered.php
confirm_page = sub_confirm.php
unsubscribe_page = unsubscribe.php
unsubscribeteam_page = unsubscribeteam.php

[AUTHORIZATION]
HREF_Access_Denied=?package=extranet&page=extranetlogon&MESSAGE[]=ACCESS_DENIED
HREF_Not_Logged=?package=extranet&page=extranetlogon
HREF_Default_Redirect=?page=framelist

[ROLES]
SUBSCRIBE_MANAGER = Subscribe manager|Backend
SUBSCRIBE_EDITOR =  Subscribe editor|Backend

*/
?>