<?/*
[MAIN]
TABLE=FeedbackFormTable
KEY_FIELD=field_id
ICON_FILE=/img/libraries/ico_catalog.gif

DISABLED_DELETE=0
DISABLED_EDIT=0
DISABLED_ADD=0

IS_READONLY=0

DISABLED_MOVE=0

IS_MULTILEVEL=0

[LIST]
RECORDS_PER_PAGE=100
FIELDS_COUNT=8

[FIELD_0]
FIELD_NAME=field_id
SORT=1
CONTROL=string
EDIT_CONTROL=null
IN_LIST=1
LENGTH=0

[FIELD_1]
FIELD_NAME=caption_%s
SORT=1
CONTROL=link
EDIT_CONTROL=text
IN_LIST=1
LENGTH=255
IS_MULTILANG=1

[FIELD_2]
FIELD_NAME=default_value_%s
SORT=1
CONTROL=link
EDIT_CONTROL=text
IN_LIST=0
LENGTH=255
IS_MULTILANG=1

[FIELD_3]
FIELD_NAME=not_null
SORT=1
CONTROL=checkbox
EDIT_CONTROL=checkbox
CHECKON=1
CHECKOFF=0
IN_LIST=1
ALIGN=center

[FIELD_4]
FIELD_NAME=max_length
SORT=1
CONTROL=string
EDIT_CONTROL=text
IN_LIST=1
SIZE=10
LENGTH=10

[FIELD_5]
FIELD_NAME=field_type
SORT=1
CONTROL=link
EDIT_CONTROL=combobox
OPTIONS=Text|text
OPTIONS=Text Block|textarea
OPTIONS=E-Mail|email
IN_LIST=0


[FIELD_6]
FIELD_NAME=active
SORT=1
CONTROL=checkbox
EDIT_CONTROL=checkbox
CHECKON=1
CHECKOFF=0
IN_LIST=1
ALIGN=center

[FIELD_7]
FIELD_NAME=_lastmodified
SORT=1
CONTROL=date
EDIT_CONTROL=null
FULLDATE=1
IN_LIST=1
ALIGN=center



*/
?>