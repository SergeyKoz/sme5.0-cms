<?/*
[MAIN]
TABLE=StatTable
KEY_FIELD=id
ICON_FILE=/img/libraries/ico_catalog.gif
DISABLED_DELETE=1
DISABLED_VIEW=1
DISABLED_EDIT=1
DISABLED_COPY=1
DISABLED_ADD=1
IS_READONLY=0
DISABLED_MOVE=1
IS_MULTILEVEL=0
DISABLED_APPLY=1
LIST_EXTRACTOR_METHOD=GetPopularPagesList
LIST_COUNTER_METHOD=GetPopularPagesListCount

[LIST]
RECORDS_PER_PAGE=20
FIELDS_COUNT=3
GET_ORDERS=ref_count 0

[FIELD_0]
FIELD_NAME=id
SORT=0
CONTROL=string
EDIT_CONTROL=null
IN_LIST=0
LENGTH=0

[FIELD_1]
FIELD_NAME=req
SORT=0
CONTROL=string
EDIT_CONTROL=null
IN_LIST=1
LENGTH=0

[FIELD_2]
FIELD_NAME=req_count
##CUT_LIST_LENGTH=50
SORT=0
CONTROL=string
EDIT_CONTROL=null
IN_LIST=1
LENGTH=4096
*/
?>