<?/*
[MAIN]
TABLE=PublicationsTable
KEY_FIELD=publication_id
UNIQUE_FIELDS = system

DISABLED_DELETE=0
DISABLED_EDIT=0
DISABLED_ADD=0
DISABLED_COPY=1
DISABLED_MOVE=0

IS_READONLY=0

IS_MULTILEVEL=1
PARENT_FIELD=parent_id
TREE_SELECT_METHOD=GetCategoriesTree
ENABLE_MEGA_DELETE=1
ENABLE_NODE_MOVE=1
CAPTION_FIELD = _sort_caption_%s
USE_TREE_PATH=1

USE_SUB_CATEGORIES=1
SUB_CATEGORIES_COUNT=1

[ACCESS]
ROLES = PUBLICATIONS_MANAGER

[SUB_CATEGORY_0]
APPLY_LIBRARY=mapping
LINK_FIELD=publication_id
ENABLED_NODE_LEVELS=1..*

[LIST]
RECORDS_PER_PAGE=20
FIELDS_COUNT=16
GET_ORDERS = _priority 1

[FIELD_0]
FIELD_NAME=publication_id
SORT=1
CONTROL=string
EDIT_CONTROL=null
IN_LIST=1
LENGTH=0

[FIELD_1]
FIELD_NAME=_sort_caption_%s
SORT=1
CONTROL=link
EDIT_CONTROL=null
IN_LIST=1
IS_MULTILANG=1
BOLD=1
FIELD_PREPROCESSOR=GetOriginaPublication
FIELD_PREPROCESSOR_DOMAIN=table

[FIELD_2]
FIELD_NAME=caption
SORT=1
CONTROL=string
EDIT_CONTROL=text
IN_LIST=0
##DBFIELD_NOTNULL=0
BOLD=1

[FIELD_3]
FIELD_NAME=system
CONTROL=null
EDIT_CONTROL=text

[FIELD_4]
FIELD_NAME=target_entry_point
CONTROL=dbtreepath
FIELD_TABLE = ContentTable
FIELDVALUE_NAME=page_id
FIELDVALUE_CAPTION=title_%s
EDIT_CONTROL=dbtreecombobox
PARENTVALUE_NAME=parent_id
FIELDVALUE_PARENT=page_id
GET_ORDERS = order_num 0
MULTIPLE=0
IN_LIST=0
SORT=0

USE_ENTRIES=1
ENTRIES_TABLE = ContentTable
ENTRIESVALUE_NAME = id
ENTRIESVALUE_CAPTION = path
ALLOW_CATEGORY_SELECT = 0

USE_ROOT_CAPTION=1

[FIELD_5]
FIELD_NAME=template_id
SORT=1
CONTROL=dbtext
EDIT_CONTROL=dbcombobox
FIELD_TABLE=TemplatesTable
FIELDVALUE_NAME=template_id
FIELDVALUE_CAPTION=caption
GET_ORDERS=caption 1
FIELD_EVENT=onChange changeTemplate();
IN_LIST=1
##SIZE=10
LENGTH=255

[FIELD_6]
FIELD_NAME=template_id_preset
CONTROL=null
EDIT_CONTROL=dbcombobox
FIELD_TABLE=TemplatesTable
FIELDVALUE_NAME=template_id
FIELDVALUE_CAPTION=caption
GET_ORDERS=caption 1
IN_LIST=0
USE_ROOT_CAPTION=1

[FIELD_7]
FIELD_NAME=is_priveledged
SORT=1
CONTROL=checkbox
EDIT_CONTROL=checkbox
CHECKON=1
CHECKOFF=0
IN_LIST=1
ALIGN=center
CAPTION_PREFIX=ls_

[FIELD_8]
FIELD_NAME=disable_comments
SORT=1
CONTROL=checkbox
EDIT_CONTROL=checkbox
CHECKON=1
CHECKOFF=0
IN_LIST=0
ALIGN=center
CAPTION_PREFIX=ls_

[FIELD_9]
FIELD_NAME=active_%s
SORT=1
CONTROL=checkbox
EDIT_CONTROL=checkbox
CHECKON=1
CHECKOFF=0
IN_LIST=1
ALIGN=center
IS_MULTILANG=1

[FIELD_10]
FIELD_NAME=_sort_date
SORT=1
CONTROL=date
EDIT_CONTROL=null
FULLDATE=1
IN_LIST=1
ALIGN=center

[FIELD_11]
FIELD_NAME=_lastmodified
SORT=1
CONTROL=date
EDIT_CONTROL=null
FULLDATE=1
IN_LIST=1
ALIGN=center

[FIELD_12]
FIELD_NAME=_modified_by
SORT=1
CONTROL=dbtext
EDIT_CONTROL=null
FIELD_TABLE = UsersTable
FIELDVALUE_NAME = user_id
FIELDVALUE_CAPTION = user_login
IN_LIST=1
ALIGN=center

[FIELD_13]
FIELD_NAME=is_modified
SORT=1
CONTROL=hidden
EDIT_CONTROL=null
IN_LIST=1
ALIGN=center

[FIELD_14]
FIELD_NAME=original_publication_caption
SORT=1
CONTROL=hidden
EDIT_CONTROL=null
IN_LIST=1
ALIGN=center

[FIELD_15]
FIELD_NAME=is_declined
SORT=0
CONTROL=hidden
EDIT_CONTROL=null
IN_LIST=1

*/
?>