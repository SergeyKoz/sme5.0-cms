<?/*
[MAIN]
TABLE=SubscribeTemplateTable
KEY_FIELD=template_id

DISABLED_DELETE=1
DISABLED_EDIT=0
DISABLED_ADD=1
DISABLED_COPY=1
DISABLED_APPLY=1

IS_MULTILEVEL=0

[ACCESS]
ROLES = SUBSCRIBE_MANAGER

[LIST]
RECORDS_PER_PAGE=20
FIELDS_COUNT=4

[FIELD_0]
FIELD_NAME=template_id
SORT=1
CONTROL=null
EDIT_CONTROL=null
IN_LIST=0
LENGTH=0

[FIELD_1]
FIELD_NAME=name_%s
SORT=1
CONTROL=link
EDIT_CONTROL=null
IN_LIST=1
LENGTH=0
IS_MULTILANG=1

[FIELD_2]
FIELD_NAME=template_text_%s
SORT=1
CONTROL=link
EDIT_CONTROL=textarea
IN_LIST=0
IS_MULTILANG=1

[FIELD_3]
FIELD_NAME=active
SORT=0
CONTROL=checkbox
EDIT_CONTROL=null //
CHECKON=1
CHECKOFF=0
IN_LIST=0
ALIGN=center

*/
?>