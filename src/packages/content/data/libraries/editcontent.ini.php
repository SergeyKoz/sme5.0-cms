<?/*
[MAIN]
TABLE=ContentTable
KEY_FIELD=id

USE_CUSTOM_EDIT_CAPTION=1
CUSTOM_EDIT_CAPTION_TABLE=ContentTable
CUSTOM_EDIT_CAPTIONID_FIELD=id
CUSTOM_EDIT_CAPTION=title_%s

[LIST]
RECORDS_PER_PAGE=20
FIELDS_COUNT=3

[FIELD_0]
FIELD_NAME=
CONTROL=null
EDIT_CONTROL=spaweditor
IN_LIST=0

[FIELD_1]
FIELD_NAME=lng
CONTROL=null
EDIT_CONTROL=hidden
VALUE =

[FIELD_2]
FIELD_NAME=
CONTROL=null
EDIT_CONTROL=autocomplete
FIELD_TABLE = TagsTable
FIELD_WORDS_NAME=
FIELD_ITEM_TYPE = content
ENABLE_CREATE_NEW_ITEMS = 1
IN_LIST=0
SORT=0
MULTIPLE=1
PACKAGE = tags

*/
?>