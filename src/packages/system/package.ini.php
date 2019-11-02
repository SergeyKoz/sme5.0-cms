<?php
/*
[PACKAGE]
PackagePath  =  {FrameworkPath}packages/system/            ## package  path
PackageName  =  system                                       ## package name
PackageTitle =  System                                                           ## package title
PackageURL   =  {FrameworkURL}packages/{PackageName}/  ##  Package URL
ResourcePath = {FrameworkPath}packages/{PackageName}/data/resources/        ## resources directory
ResourcePath = {FrameworkPath}packages/libraries/data/resources/                ## resources directory
                                                                                                                                                 ##  Frontend default page

[PATH]
TemplatePath = {ModulePath}data/templates/
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}packages/libraries/data/templates/
TemplatePath = {FrameworkPath}data/templates/

ClassPath    =  {PackagePath}classes/
ClassPath    =  {FrameworkPath}packages/libraries/classes/
ClassPath    =  {FrameworkPath}packages/banner/classes/

PagePath     =  {PackagePath}/pages/
PagePath     =  {FrameworkPath}packages/libraries/pages/

[DATABASE]
UserGroupsTable={TablesPrefix}user_groups
UsersTable={TablesPrefix}users
SettingsTable={TablesPrefix}settings
UserRolesTable={TablesPrefix}user_roles

[MAIN]
useAuthentication  =  1
LibraryName        = users                           ## Default library name
LibrariesRoot      = {PackagePath}data/libraries/  ## Libraries config files directory
RecordsPerPage     = 5                             ## List records per page
Textarea_cols      = 70                            ## Textarea columns
Textarea_rows      = 6                             ## Textarea rows
Text_size          = 70                            ## Text field size




[AUTHORIZATION]                       ##System authorization
AuthorizeTable={UsersTable}           ## Authorization table
FLG_MD5_PASSWORD=0                    ## Encrypting md5 password flag
FLG_SESSIONS=1                        ## Use sessions flag
FLG_EVAL_HREF_Not_Logged=0
FLG_EVAL_HREF_Default_Redirect=0
FLG_EVAL_HREF_Access_Denied=0
SESSION_Var_Login=l
SESSION_Var_Password=p
SESSION_Var_UserId=member_id
FLD_user_id=user_id
FLD_password=user_password
FLD_login=user_login
FLD_user_group=group_id

FLG_USE_COOKIES=1


## Backend redirects (as example)
Backend_HREF_Access_Denied=?package=extranet&page=extranetlogon&MESSAGE[]=ACCESS_DENIED
Backend_HREF_Not_Logged=?package=extranet&page=extranetlogon
Backend_HREF_Default_Redirect=?page=framelist

## Frontend redirects
##Frontend_HREF_Access_Denied={SiteURL}/logon.php?MESSAGE[]=ACCESS_DENIED
##Frontend_HREF_Not_Logged={SiteURL}/logon.php?MESSAGE[]=ACCESS_DENIED
##Frontend_HREF_Default_Redirect={SiteURL}/index.php


[ROLES]     ##Package roles
ADMIN=Administrator|Backend                                     ## Administrator group ID

[DEFAULT]
DefaultPage=userslist

*/
?>