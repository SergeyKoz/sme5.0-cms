<?php
/*
[PACKAGE]
PackagePath  =  {FrameworkPath}packages/filesystem/		   											## package  path
PackageName  =  filesystem		                       		 										## package name
PackageTitle =  �������� �������											     					## package title
PackageURL   =  {FrameworkURL}packages/{PackageName}/  												##  Package URL
ResourcePath =  {FrameworkPath}packages/{PackageName}/data/resources/        						## resources directory                                                                                                                                                
FileManagerURL  = {FrameworkURL}/standalone/filemanager/											    ## filemanager script url 
FileManagerPath = {FrameworkPath}/standalone/filemanager/											    ## filemanager script directory

[PATH]
TemplatePath = {PackagePath}data/templates/
TemplatePath = {FrameworkPath}packages/libraries/data/templates/
ClassPath    = {PackagePath}classes/
PagePath     = {PackagePath}/pages/

[MAIN]
useAuthentication  =  1


[AUTHORIZATION]
HREF_Access_Denied=?package=extranet&page=extranetlogon&MESSAGE[]=ACCESS_DENIED
HREF_Not_Logged=?package=extranet&page=extranetlogon
HREF_Default_Redirect=?page=framelist

[DEFAULT]
DefaultPage=filemanager                             								##  Backend default page

[ROLES]
FILE_MANAGER=File manager|Backend


*/
?>