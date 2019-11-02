<?php
/**
   * Package configuration file
   * @package Extranet
   * @access  public
   **/
/*
[PACKAGE]
PackagePath  =  {FrameworkPath}packages/extranet/      ## package  path
PackageName  =  extranet                               ## package name
PackageTitle =  SMEngine v2.4                         ## package title
PackageURL   = {FrameworkURL}packages/{PackageName}/  ##  Package URL
ResourcePath = {FrameworkPath}packages/{PackageName}/data/resources/     ## resources directory
                                                                                                                                                 ##  Frontend default page

[PATH]
TemplatePath = {PackagePath}data/templates/{ComponentName}/
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}packages/{PackageName}/data/templates/{ComponentName}/
TemplatePath = {FrameworkPath}packages/libraries/data/templates/

ClassPath    =  {PackagePath}classes/{ComponentName}/
ClassPath    =  {PackagePath}classes/
ClassPath    =  {FrameworkPath}packages/libraries/classes/{ComponentName}/
ClassPath    =  {FrameworkPath}packages/libraries/classes/

PagePath     =  {PackagePath}/pages/{ComponentName}/
PagePath     =  {PackagePath}/pages/
PagePath     =  {FrameworkPath}packages/libraries/pages/{ComponentName}/
PagePath     =  {FrameworkPath}packages/libraries/pages/




[MAIN]
useAuthentication  =  1                                                     ##   Use authentication every request process
LeftMenu_IniFile    =   {ResourcePath}/leftmenu.ini.php ##   Left menu INI-file
TopMenu_IniFile     = {ResourcePath}/topmenu.ini.php  ##  Top menu INI-file

LibrariesRoot      = {ModulePath}data/libraries/

[AUTHORIZATION]
HREF_Access_Denied=?package=extranet&page=extranetlogon&MESSAGE[]=ACCESS_DENIED
HREF_Not_Logged=?package=extranet&page=extranetlogon
HREF_Default_Redirect=?page=framelist
FLG_EVAL_HREF_Default_Redirect=0

[DEFAULT]
DefaultPage=pageslist                             ##  Backend default page

*/
?>