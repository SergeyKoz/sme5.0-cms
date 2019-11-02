<?php
/*
[PACKAGE]
PackagePath  =  {FrameworkPath}packages/feedback/  ## package  path
PackageName  =  feedback   ## package name
PackageTitle =  Feedback   ## package title
PackageURL   =  {FrameworkURL}packages/{PackageName}/    ##  Package URL
ResourcePath = {FrameworkPath}packages/{PackageName}/data/resources/        ## resources directory
ResourcePath = {FrameworkPath}packages/libraries/data/resources/     ## resources directory


[PATH]
TemplatePath = {ModulePath}data/templates/
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}packages/libraries/data/templates/

ClassPath    =  {PackagePath}classes/
ClassPath = {FrameworkPath}packages/libraries/classes/

PagePath     =  {PackagePath}/pages/
PagePath     =  {FrameworkPath}packages/libraries/pages/

[DATABASE]
SubjectsTable={TablesPrefix}feedback_subjects
DepartmentsTable={TablesPrefix}feedback_departments
DepartmentSubjectsRelationTable={TablesPrefix}feedback_departments_subjects_relation
FeedbackFormTable={TablesPrefix}feedback_form


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
DefaultPage=feedback                             ##  Backend default page

*/
?>