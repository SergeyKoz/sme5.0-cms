<?/*
[MAIN]
TABLE=MappingTable
KEY_FIELD=mapping_id
COPY_NAME_FIELD=caption

GROUP_NAME=list_settings
GROUP_TITLE_RU=��������� ������
GROUP_TITLE_UA=������������ ������
GROUP_TITLE_EN=List settings

GROUP_NAME=template_settings
GROUP_TITLE_RU=XSL ������
GROUP_TITLE_UA=XSL ������
GROUP_TITLE_EN=XSL temlpate

[ACCESS]
ROLES = PUBLICATIONS_MANAGER

[LIST]
RECORDS_PER_PAGE=20
FIELDS_COUNT=21
GET_ORDERS=_priority 1

[FIELD_0]
FIELD_NAME=mapping_id
SORT=1
CONTROL=string
EDIT_CONTROL=null
IN_LIST=1
LENGTH=0

[FIELD_1]
FIELD_NAME=caption
SORT=1
CONTROL=link
EDIT_CONTROL=text
IN_LIST=1
LENGTH=255
BOLD=1

[FIELD_2]
FIELD_NAME=system_name
SORT=1
CONTROL=string
EDIT_CONTROL=text
IN_LIST=1
LENGTH=255


[FIELD_3]
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


[FIELD_4]
FIELD_NAME=publication_type
SORT=1
CONTROL=caption
EDIT_CONTROL=combobox
IN_LIST=1

[FIELD_5]
FIELD_NAME=page_id
CONTROL=dbtreepath
FIELD_TABLE = ContentTable
FIELDVALUE_NAME=id
FIELDVALUE_CAPTION=title_%s
EDIT_CONTROL=dbtreecombobox
PARENTVALUE_NAME=parent_id
FIELDVALUE_PARENT=parent_id
GET_ORDERS = order_num 0
MULTIPLE=0
IN_LIST=1
SORT=0
CAPTION_PREFIX=ls_
USE_ROOT_CAPTION=1

[FIELD_6]
FIELD_NAME=sort_field
SORT=1
CONTROL=caption
EDIT_CONTROL=combobox
IN_LIST=0
GROUP=list_settings

[FIELD_7]
FIELD_NAME=sort_order
SORT=1
CONTROL=caption
EDIT_CONTROL=combobox
IN_LIST=0
GROUP=list_settings

[FIELD_8]
FIELD_NAME=start_index
SORT=1
CONTROL=string
EDIT_CONTROL=text
IN_LIST=0
LENGTH=10
SIZE=10
GROUP=list_settings

[FIELD_9]
FIELD_NAME=end_index
SORT=1
CONTROL=string
EDIT_CONTROL=text
IN_LIST=0
LENGTH=10
SIZE=10
GROUP=list_settings

[FIELD_10]
FIELD_NAME=records_per_page
SORT=1
CONTROL=string
EDIT_CONTROL=text
IN_LIST=0
LENGTH=10
SIZE=10
GROUP=list_settings

[FIELD_11]
FIELD_NAME=pages_per_decade
SORT=1
CONTROL=string
EDIT_CONTROL=text
IN_LIST=0
LENGTH=10
SIZE=10
GROUP=list_settings

[FIELD_12]
FIELD_NAME=xsl_template
SORT=1
CONTROL=string
EDIT_CONTROL=fileslistbox
DIRECTORY={ModulePath}data/templates/publications
SHOW_FILES=1
FILES_FILTER=/.*?\.xsl/
DIRS_FILTER=/.*?/
USE_ROOT_CAPTION=1
ALLOW_DIRS_SELECT=0
IN_LIST=0
MULTIPLE=0
RELATIONS_TABLE=cms_rel_table
GROUP=template_settings

##[FIELD_13]
##FIELD_NAME=include_template
##SORT=1
##CONTROL=checkbox
##EDIT_CONTROL=checkbox
##CHECKON=1
##CHECKOFF=0
##IN_LIST=1
##ALIGN=center
##GROUP=template_settings
##CAPTION_PREFIX=ls_

[FIELD_13]
FIELD_NAME=expose
SORT=1
CONTROL=checkbox
EDIT_CONTROL=checkbox
CHECKON=1
CHECKOFF=0
IN_LIST=1
ALIGN=center
CAPTION_PREFIX=ls_

[FIELD_14]
FIELD_NAME=active
SORT=1
CONTROL=checkbox
EDIT_CONTROL=checkbox
CHECKON=1
CHECKOFF=0
IN_LIST=1
ALIGN=center

[FIELD_15]
FIELD_NAME=_lastmodified
SORT=1
CONTROL=string
EDIT_CONTROL=null
IN_LIST=0

[FIELD_16]
FIELD_NAME=navigation
SORT=1
CONTROL=checkbox
EDIT_CONTROL=checkbox
CHECKON=1
CHECKOFF=0
IN_LIST=1
ALIGN=center
CAPTION_PREFIX=ls_

[FIELD_17]
FIELD_NAME=_modified_by
SORT=1
CONTROL=dbtext
EDIT_CONTROL=null
FIELD_TABLE = UsersTable
FIELDVALUE_NAME= user_id
FIELDVALUE_CAPTION= user_login
IN_LIST=1
ALIGN=center

[FIELD_18]
FIELD_NAME=enable_comments
SORT=1
CONTROL=checkbox
EDIT_CONTROL=checkbox
CHECKON=1
CHECKOFF=0
IN_LIST=0
ALIGN=center

[FIELD_19]
FIELD_NAME=tags_%s
CONTROL=null
EDIT_CONTROL=autocomplete
FIELD_TABLE = TagsTable
##FIELD_RELATION_NAME=mapping_id
FIELD_WORDS_NAME=tag_%s
FIELD_ITEM_TYPE = mapping
##AUTOCOMPLETE_METHOD = GetAutocompleteWords
ENABLE_CREATE_NEW_ITEMS = 1
##WORDS_DELIMETER = |
IN_LIST=0
SORT=0
IS_MULTILANG=1
MULTIPLE=1

[FIELD_20]
FIELD_NAME=priveledged_only
SORT=1
CONTROL=checkbox
EDIT_CONTROL=checkbox
CHECKON=1
CHECKOFF=0
IN_LIST=0
ALIGN=center
GROUP=list_settings
*/
?>