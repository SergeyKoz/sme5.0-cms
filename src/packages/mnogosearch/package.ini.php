<?php
/*
[PACKAGE]
PackageName  =  mnogosearch   ## package name
PackageTitle =  mnogosearch   ## package title

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

PagePath     =  {PackagePath}pages/
PagePath     =  {FrameworkPath}packages/libraries/pages/

FilePath = {PackagePath}files/

[DATABASE]

[MAIN]
useAuthentication  =  1
LibraryName        = indexer                     ## Default library name
LibrariesRoot      = {PackagePath}data/libraries/  ## Libraries config files directory
RecordsPerPage     =                              ## List records per page
Textarea_cols      = 70                            ## Textarea columns
Textarea_rows      = 6                             ## Textarea rows
Text_size          = 70                            ## Text field size



[INDEXER_GLOBAL]
##Global parameters
PathToIndexer = /usr/local/sbin/indexer              ## Path to indexer of mnoGoSearch
OptionsCmd = -a -R                                               ## Options of command line for indexing

## Usage: indexer [OPTIONS]  [configfile]

## Indexing options:
##  -a              reindex all documents even if not expired (may be
##                  limited using -t, -u, -s, -c, -y and -f options)
##  -m              reindex expired documents even if not modified (may
##                  be limited using -t, -u, -c, -s, -y and -s options)
##  -e              index 'most expired' (oldest) documents first
##  -o              index documents with less depth (hops value) first
##  -r              do not try to reduce remote servers load by randomising
##                  url fetch list before indexing (-r recommended for very
##                  big number of URLs)
##  -n n            index only n documents and exit
##  -c n            index only n seconds and exit
##  -q              quick startup (do not add Server URLs)
##  -b              block starting more than one indexer instances
##  -i              insert new URLs (URLs to insert must be given using -u or -f)
##  -p n            sleep n seconds after each URL
##  -w              do not warn before clearing documents from database
##  -N n            run N threads

## Subsection control options (may be combined):
##  -s status       limit indexer to documents matching status (HTTP Status code)
##  -t tag          limit indexer to documents matching tag
##  -g category     limit indexer to documents matching category
##  -y content-type limit indexer to documents matching content-type
##  -L language     limit indexer to documents matching language
##  -u pattern      limit indexer to documents with URLs matching pattern
##                  (supports SQL LIKE wildcard '%')
##  -f filename     read URLs to be indexed/inserted/cleared from file (with -a
##                  or -C option, supports SQL LIKE wildcard '%'; has no effect
##                  when combined with -m option)
##  -f -            Use STDIN instead of file as URL list

## Logging options:
##  -l              do not log to stdout/stderr
##  -v n            verbose level, 0-5

## Misc. options:
##  -C              clear database and exit
##  -S              print statistics and exit
##  -j t            set current time for statistic (use with -S),
##                  YYYY-MM[-DD[ HH[:MM[:SS]]]]
##                  or time offset, e.g. 1d12h (see Period in indexer.conf)
##  -I              print referers and exit
##  -R              calculate popularity rank
##  -Ecreate        create SQL table structure and exit
##  -Edrop          drop SQL table structure and exit
##  -Ewordstat      create statistics for misspelled word suggestions
##  -h,-?           print help page and exit
##  -hh             print more help and exit
##  -d configfile   use given configfile instead of default one.
##                  This option is usefull when running indexer as an
##                  interpreter, e.g.: #!/usr/local/sbin/indexer -d

ConfigPath = {ModulePath}debug/                                  ## Path to folder with indexer.conf
Include =                                                        ## include another configuration file
VarDir =                                                         ## choose alternative working directory
DBAddr =                                                         ## connect to SQL database Created automatically
dbmode =                                                         ## Database mode. Default: single
LocalCharset = koi8-r
LocalCharset = iso-8859-5                                        ## Defines the charset which will be used
LocalCharset = x-mac-cyrillic                                    ## Default LocalCharset is iso-8859-1
LocalCharset = windows-1251
NewsExtensions =                                                 ## Whether to enable news extensions.Default 1
SyslogFacility =                                                 ## This is used if indexer was compiled with syslog support
ForceIISCharset1251 =                                            ## This option for users which deals with Cyrillic content Default 0
CrossWords =                                                     ## Whether to build CrossWords index. Default 0
StopwordFile =                                                   ## Load stop words from the given text file
LangMapFile =                                                    ## Load language map for charset and language guesser from the given file.
MinWordLength  =                                                 ## Word lengths.
MaxWordLength =
MaxDocSize =                                                     ## MaxDocSize bytes Default value 1048576 (1 Mb)
URLSelectCacheSize =                                             ## URLSelectCacheSize num Default value 128
WordCacheSize =                                                  ## WordCacheSize bytes Default value 8388608 (8 Mb)
HTTPHeader =                                                     ## Add your desired headers in indexer HTTP request
FlushServerTable =                                               ## flush server.active to inactive for all server table records
ServerTable =                                                    ## Load servers with all their parameters from the table
ChineseListCharset =                                             ## Load Chinese word frequency list
ChineseListDictionaryFile =
ThaiListCharset =                                                ## Load Thai word frequency list
ThaiListDictionaryFile =

##URL control configuration
[INDEXER_URL_CONTROL]
Allow =                                                          ## Use this to allow URLs that match
Disallow = */logon/*                                             ## Use this to disallow URLs that match
Disallow = *r.php?*
Disallow = */debug/*
Disallow = */files/*
CheckOnly =                                                      ## Indexer will use HEAD instead of GET HTTP method
HrefOnly =                                                       ## Use this to scan a HTML page for "href" tags
CheckMp3 =                                                       ## Document and try to find MP3 tags
CheckMP3Only =
HoldBadHrefs =                                                   ## How much time to hold URLs with erroneous status

##Mime types and external parsers
[INDEXER_EXTERNAL]
UseRemoteContentType =                                           ## This command specifies if the indexer should get content type
                                                                 ## from HTTP server headers (yes) or from it's AddType settings (no)
                                                                 ## Default 1
AddType =                                                        ## This command associates filename extensions
Mime =                                                           ## This is used to add support for parsing documents with mime types
ParserTimeOut = 300                                              ## Specify amount of time for parser execution

##Aliases configuration
[INDEXER_ALIASES]
Alias =                                                          ## organize search through master site by indexing a mirror site
AliasProg =                                                      ## Is an external program that can be called

##Servers configuration
[INDEXER_SERVERS]
Period =                                                         ## Set reindex period
Tag =                                                            ## Use this field for your own purposes
Category =                                                       ## Distribute documents between nested categories
DefaultLang =                                                    ## Default language for server
VaryLang =                                                       ## Specify languages list for multilingual servers indexing
                                                                 ## Created automatically
MaxHops =                                                        ## Maximum way in "mouse clicks" from start url Default 256
MaxNetErrors =                                                   ## Maximum network errors for each server. Default 16
ReadTimeOut =                                                    ## Connect timeout and stalled connections timeout Default 30s
DocTimeOut =                                                     ## Maximum amount of time indexer spends for one document downloading Default 90s
NetErrorDelayTime =                                              ## Specify document processing delay time if network error has occurred Default 1d
Robots =                                                         ## Allows/disallows using robots.txt Default 1
DetectClones =                                                   ## Allow/disallow clone detection Defaylt 1
Section =                                                        ## Document sections
IndexIf =                                                        ## Use this to allow documents
NoIndexIf =
Index =                                                          ## Prevent indexer from storing words into database Default 1
RemoteCharset =                                                  ## is default character set for the server in next "Server" command(s)
ProxyAuthBasic =                                                 ## Use HTTP proxy basic authorization
Proxy =                                                          ## Use proxy rather then connect directly
AuthBasic =                                                      ## Use basic HTTP authorization
MirrorRoot =                                                     ## Mirroring parameters commands
MirrorHeadersRoot =
MirrorPeriod =
ServerWeight =                                                   ## Server weight for Popularity Rank calculation Default 1
PopRankSkipSameSite =                                            ## Skip links from same site for Popularity Rank calculation. Default 0
PopRankFeedBack =                                                ## Calculate sites wights before Popularity Rank calculation Deafaul 0
Server = {SiteURL}                                               ## Describe web-space you want to index
Realm =                                                          ## It works almost like "Server" command but takes a regular expression
URL =                                                            ## Command inserts given URL into database

##Search control configuration
[SEARCH_CONTROL]
BrowserCharset = windows-1251
hlbeg = <font color="000088"><b>                                 ## Allocation of required expression
hlend = </b></font>
trackquery = 0
IspellData =                                                     ## Set for fuzzy search

[AUTHORIZATION]
HREF_Access_Denied=?package=extranet&page=extranetlogon&MESSAGE[]=ACCESS_DENIED
HREF_Not_Logged=?package=extranet&page=extranetlogon
HREF_Default_Redirect=?page=framelist

*/
?>