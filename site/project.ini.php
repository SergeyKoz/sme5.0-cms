<?php
/*
[MODULE]
Host =  http://127.0.0.1:8000/         ## server host
Url  =  {Host}{RelativeURL}  ## site root URL
Path =  /opt/           ## site root path
ModuleURL     =  {Url}project/       ## site sources URL
ModulePath    =  {Path}project/      ## site sources path
SiteURL       =  {Url}               ## site web URL
SitePath      =  {Path}              ## site web path
RelativeURL   =             ## site relative URL

SiteName      =  Typical SME site         ## Site name

FrameworkURL = http://127.0.0.1:8000/project/engine/
FrameworkPath = /opt/project/engine/

ResourcePath  =  {ModulePath}data/resources/     ## resources directory

[PATH]
TemplatePath  =  {ModulePath}data/templates/      ## module/site template directory
TemplatePath  =  {FrameworkPath}data/templates/   ## framework template directory

ClassPath  = {ModulePath}classes/           ## module classes directory
ClassPath  = {FrameworkPath}classes/        ## framework classes directory
ClassPath  = {ModulePath}pages/             ## framework classes directory
ClassPath  = {FrameworkPath}pages/          ## framework classes directory

PagePath   =  {ModulePath}pages/           ## Module pages directory
PagePath   =  {FrameworkPath}pages/        ## Framework pages directory

[LANGUAGE]
_Language  =  en                         ## module language
_LangShortName  =  eng                   ## language short name
_LangLongName   =  English version       ## language long name

[SETTINGS]
FileStoragePath     =    {SitePath}files/  ##File storage system path
FileStorageURL      =    {SiteURL}files/   ##File storage URL
MaxFileSize         =   4000000
FileMode            =   0777                ## Permissions for uploaded files
DirMode             =   0777                ## Permissions for created by script directories

SecureCodeFont={FrameworkPath}fonts/lucon.ttf
SecureCodeWidth = 130
SecureCodeHeight = 36

[MAIN]
Text_size =40           ## Text field default size
Textarea_cols = 60      ## Textarea columns
Textarea_rows = 5       ## Textarea rows

PHPSystemPath = /usr/local/php5/bin/

[DATABASE]
##Connection string
ConnectionString=mysql://database?user=docker&database=sme_site&password=docker         ##Connection string

TablesPrefix=cms_    ##Tables prefix
ProjectTable=null

[PACKAGES]
## Framework basic packages
libraries={FrameworkPath}packages/libraries/package.ini.php
system={FrameworkPath}packages/system/package.ini.php
context={FrameworkPath}packages/context/package.ini.php
content={FrameworkPath}packages/content/package.ini.php
publications={FrameworkPath}packages/publications/package.ini.php
calendar={FrameworkPath}packages/calendar/package.ini.php
comments={FrameworkPath}packages/comments/package.ini.php
banner={FrameworkPath}packages/banner/package.ini.php
extranet={FrameworkPath}packages/extranet/package.ini.php
tags={FrameworkPath}packages/tags/package.ini.php
subscribe={FrameworkPath}packages/subscribe/package.ini.php
polls={FrameworkPath}packages/polls/package.ini.php

[DEFAULT]
useDB               =  1                    ## Use database, flag
DefaultPackage      =  extranet             ## Default package name
DefaultPage         =  default              ## default page name
ClassExt            =  .php                 ## default class extension
PageExt             =  .php                 ## default page extension
TemplateExt         =  .xsl                 ## default template extension
ShowDebug           =  1                    ## Show debug information flag
WriteLogs           =  1                    ## Write logs flag
useAuthentication   =  1                    ## Use authentication every request process
UseCache            =  0                    ## Use cache, flag
MenuType            =  default              ## Frontend menu type
MultiLanguage       =  0
HightlightWords     = <b>%s</b>
DefaultRegion       =  1

[EMAIL]
FROM= mail@mail.com                         ## Email from
ENCODING=utf-8                     ## Email Encoding
CONTENT-TYPE=text/plain                   ## Email content-type

[ERRORS]
SuppressErrors      =   0     ## Suppress errors messages
ShowErrors          =   1     ## Show or not error messages
LogErrors           =   0     ## Log or not errors
EmailErrors         =   0     ## Email or not errors

[XSLT_PROCESSOR]
OMIT_HTML_DECLARATION=1         ## choose if to cut out html declaration

[AUTHORIZATION]
##Backend redirects (already defined in extranet package)
Backend_HREF_Access_Denied_project=?package=extranet&page=extranetlogon&MESSAGE[]=ACCESS_DENIED
Backend_HREF_Not_Logged_project=?package=extranet&page=extranetlogon
Backend_HREF_Default_Redirect_project=?page=framelist

##Frontend redirects
Frontend_HREF_Access_Denied_project={SiteURL}logon/?MESSAGE[]=ACCESS_DENIED
Frontend_HREF_Default_Redirect_project={SiteURL}?
Frontend_HREF_PageNotFound_Redirect_project={SiteURL}404/

##SYSTEM ROLES (added internal when authentication process started) - DO NOT UNCOMMENT AFTER THIS LINE
[ROLES]
ANONYMOUS = Anonymous user (not registered)|Frontend
REGISTERED_USER = Registered user |Frontend

[TINYMCE]
Dir={ModuleURL}standalone/tinymce/       ## TinyMCE html-editor relative URL
Theme = advanced                         ## Theme (advanced, simple)
Skin = default                           ## Skin (default,o2k7,silver,black)

[GSEARCH]
SiteRestriction = sme-site.com
SearchAPIKey =


*/
?>