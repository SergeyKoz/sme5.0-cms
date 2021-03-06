<?/*
[MAIN]
TABLE=SiteTestsTable
KEY_FIELD=site_test_id
ICON_FILE=img/libraries/ico_catalog.gif

DISABLED_DELETE=0
DISABLED_EDIT=0
DISABLED_ADD=0
DISABLED_APPLY=0
IS_READONLY=0



USE_CUSTOM_TREE_PATH=1
CUSTOM_TREE_PATH_TABLE=SitesTable
HTTPVAR_NODE_HOLDER=sites_parent_id
CUSTOM_TREE_PATH_PARENT=parent_id
CUSTOM_TREE_PATH_CAPTION=caption


IS_MULTILEVEL=0

[LIST]
RECORDS_PER_PAGE=100
FIELDS_COUNT=6

[FIELD_0]
FIELD_NAME=site_test_id
SORT=1
CONTROL=string
EDIT_CONTROL=null
IN_LIST=1
LENGTH=0

[FIELD_1]
FIELD_NAME=test_id
SORT=1
CONTROL=dbtext
EDIT_CONTROL=dbcombobox
IN_LIST=1
FIELD_TABLE = TestsTable
FIELDVALUE_NAME= test_id
FIELDVALUE_CAPTION= caption
USE_ROOT_CAPTION=1
FIELD_EVENT=onChange changeTest(this.selectedIndex);

[FIELD_2]
FIELD_NAME=init
SORT=1
CONTROL=link
EDIT_CONTROL=textarea
IN_LIST=0
COLS=80
ROWS=4

[FIELD_3]
FIELD_NAME=send_emails
SORT=1
CONTROL=checkbox
EDIT_CONTROL=checkbox
CHECKON=1
CHECKOFF=0
IN_LIST=1
ALIGN=center
CAPTION_PREFIX=ls_


[FIELD_4]
FIELD_NAME=active
SORT=1
CONTROL=checkbox
EDIT_CONTROL=checkbox
CHECKON=1
CHECKOFF=0
IN_LIST=1
ALIGN=center

[FIELD_5]
FIELD_NAME=_lastmodified
SORT=1
CONTROL=date
EDIT_CONTROL=null
FULLDATE=1
IN_LIST=1
ALIGN=center


*/
?>