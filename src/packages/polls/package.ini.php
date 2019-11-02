<?php
/*
[PACKAGE]
PackageName  =  polls   ## package name
PackageTitle =  polls   ## package title

PackagePath  = {FrameworkPath}packages/{PackageName}/                  ## package  path
PackageURL   = {FrameworkURL}packages/{PackageName}/                   ## Package URL
ResourcePath = {FrameworkPath}packages/{PackageName}/data/resources/   ## resources directory
ResourcePath = {FrameworkPath}packages/libraries/data/resources/                        ## resources directory

[PATH]
TemplatePath = {ModulePath}data/templates/
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}packages/libraries/data/templates/

ClassPath    =  {PackagePath}classes/
ClassPath = {FrameworkPath}packages/libraries/classes/
ClassPath = {FrameworkPath}packages/content/classes/
ClassPath = {FrameworkPath}packages/tags/classes/

PagePath     =  {PackagePath}pages/
PagePath     =  {FrameworkPath}packages/libraries/pages/

FilePath = {PackagePath}files/

[DATABASE]
PollsTable={TablesPrefix}polls
PollsPagesRelationsTable={TablesPrefix}polls_pages_relations
PollsVariantsTable={TablesPrefix}polls_variants

[MAIN]
useAuthentication  =  1
LibraryName        =                               ## Default library name
LibrariesRoot      = {PackagePath}data/libraries/  ## Libraries config files directory
RecordsPerPage     = 10                            ## List records per page
Textarea_cols      = 70                            ## Textarea columns
Textarea_rows      = 6                             ## Textarea rows
Text_size          = 70                            ## Text field size

[AUTHORIZATION]
HREF_Access_Denied=?package=extranet&page=extranetlogon&MESSAGE[]=ACCESS_DENIED
HREF_Not_Logged=?package=extranet&page=extranetlogon
HREF_Default_Redirect=?page=framelist

[ROLES]
POLLS_MSNAGER = Polls system manager|Backend
POLLS_EDITOR = Polls editor|Backend
*/
?>