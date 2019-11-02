<?php
/**
   * Package configuration file
   * @package Libraries
   * @access  public
   **/
	 
/*
[PACKAGE]
PackagePath  =  {FrameworkPath}packages/libraries/    ## package  path
PackageName	 =	libraries      						  ## package name
PackageTitle =  Libraries							  ## package title
PackageURL	 =	{FrameworkURL}packages/{PackageName}/  		##	Package URL
ResourcePath   = {FrameworkPath}packages/{PackageName}/data/resources/		  ## resources directory
Backend_DefaultPage=itemslist                                               ##  Backend default page
Frontend_DefaultPage=itemslist                                              ##  Frontend default page

[PATH]
TemplatePath = {PackagePath}data/templates/{ComponentName}/
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}packages/{PackageName}/data/templates/{ComponentName}/
TemplatePath = {FrameworkPath}packages/libraries/data/templates/

ClassPath	 =  {PackagePath}classes/{ComponentName}/
ClassPath    =  {PackagePath}classes/
ClassPath    =  {FrameworkPath}packages/libraries/classes/{ComponentName}/
ClassPath    =  {FrameworkPath}packages/libraries/classes/

PagePath     =  {PackagePath}/pages/{ComponentName}/
PagePath     =  {PackagePath}/pages/
PagePath     =  {FrameworkPath}packages/libraries/pages/{ComponentName}/
PagePath     =  {FrameworkPath}packages/libraries/pages/

[LIBRARIES]
users=users
news=news
productcategories=productcategories
products=products
templates=templates
templatecategories=templatecategories
faqquestions=faqquestions
faqanswers=faqanswers
spamletters=spamletters
requests=requests
settings=settings
hotproposals=hotproposals

[MAIN]
useAuthentication  =  1
LibraryName        = users                         ## Default library name
LibrariesRoot      = {PackagePath}data/libraries/  ## Libraries config files directory
RecordsPerPage     = 5                             ## List records per page
Textarea_cols      = 70                            ## Textarea columns
Textarea_rows      = 6                             ## Textarea rows
Text_size          = 70                            ## Text field size

[AUTHORIZATION]
HREF_Access_Denied=?package=extranet&page=extranetlogon
HREF_Not_Logged=?package=extranet&page=extranetlogon
HREF_Default_Redirect=?

[DEFAULT]
DefaultPage=itemslist
*/
?>