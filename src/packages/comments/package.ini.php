<?php
/*
[PACKAGE]
PackagePath  =  {FrameworkPath}packages/comments/          ## package  path
PackageName  =  comments                                       ## package name
PackageTitle =  Comments                                                           ## package title
PackageURL   =  {FrameworkURL}packages/{PackageName}/  ##  Package URL
ResourcePath = {FrameworkPath}packages/{PackageName}/data/resources/        ## resources directory
ResourcePath = {FrameworkPath}packages/libraries/data/resources/                ## resources directory
                                                                                                                                                 ##  Frontend default page
[PATH]
TemplatePath = {ModulePath}data/templates/
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}packages/libraries/data/templates/

ClassPath = {PackagePath}classes/
ClassPath = {FrameworkPath}packages/libraries/classes/
ClassPath = {FrameworkPath}packages/content/classes/

PagePath     =  {PackagePath}/pages/
PagePath     =  {FrameworkPath}packages/libraries/pages/

[DATABASE]
CommentGroupsTable={TablesPrefix}comment_groups
CommentsTable={TablesPrefix}comments
CommentsVotesTable={TablesPrefix}comments_votes

[MAIN]
useAuthentication  =  1
LibraryName        = commentgroups                 ## Default library name
LibrariesRoot      = {PackagePath}data/libraries/  ## Libraries config files directory
RecordsPerPage     = 5                             ## List records per page
Textarea_cols      = 70                            ## Textarea columns
Textarea_rows      = 6                             ## Textarea rows
Text_size          = 70                            ## Text field size

[AUTHORIZATION]
Backend_HREF_Access_Denied=?package=extranet&page=extranetlogon&MESSAGE[]=ACCESS_DENIED
Backend_HREF_Not_Logged=?package=extranet&page=extranetlogon
Backend_HREF_Default_Redirect=?page=framelist

[ROLES]     ##Package roles
COMMENTS_MANAGER=Comments manager|Backend
COMMENTS_MODERATOR=Comments moderator|Frontend

[DEFAULT]
DefaultPage=itemslist                                                   ##   default page


*/
?>