<?/*
[MAIN]
TABLE=DepartmentsTable
KEY_FIELD=department_id
ICON_FILE=/img/libraries/ico_catalog.gif

DISABLED_DELETE=0
DISABLED_EDIT=0
DISABLED_ADD=0

IS_READONLY=0

IS_MULTILEVEL=0

DISABLED_MOVE=0

GROUP_NAME=relation
GROUP_TITLE_RU=�������� ���
GROUP_TITLE_UA=����'���� ���
GROUP_TITLE_EN=Subject mappings

[LIST]
RECORDS_PER_PAGE=100
FIELDS_COUNT=9

[FIELD_0]
FIELD_NAME=department_id
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
FIELD_NAME=description_%s
SORT=1
CONTROL=link
EDIT_CONTROL=textarea
IN_LIST=0
IS_MULTILANG=1


[FIELD_3]
FIELD_NAME=subject_id
SORT=0
CONTROL=null
EDIT_CONTROL=dbcombobox
IN_LIST=0
FIELD_TABLE = SubjectsTable
FIELDVALUE_NAME=subject_id
FIELDVALUE_CAPTION=subject_%s
RELATIONS_TABLE=DepartmentSubjectsRelationTable
MULTIPLE=1
GROUP=relation

[FIELD_4]
FIELD_NAME=emails
SORT=1
CONTROL=link
EDIT_CONTROL=textarea
IN_LIST=0

[FIELD_5]
FIELD_NAME=content_type
SORT=1
CONTROL=link
EDIT_CONTROL=combobox
OPTIONS=PLAIN TEXT|0
OPTIONS=HTML|1
IN_LIST=0

[FIELD_6]
FIELD_NAME=encoding
SORT=1
CONTROL=link
EDIT_CONTROL=combobox
OPTIONS=Windows-1251|windows-1251
OPTIONS=koi8-r|koi8-r
IN_LIST=0

[FIELD_7]
FIELD_NAME=active
SORT=1
CONTROL=checkbox
EDIT_CONTROL=checkbox
CHECKON=1
CHECKOFF=0
IN_LIST=1
ALIGN=center

[FIELD_8]
FIELD_NAME=_lastmodified
SORT=1
CONTROL=date
EDIT_CONTROL=null
FULLDATE=1
IN_LIST=1
ALIGN=center



*/
?>