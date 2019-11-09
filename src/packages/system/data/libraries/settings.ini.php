<?/*
[MAIN]
TABLE=SettingsTable
KEY_FIELD=settingid


ICON_FILE=img/libraries/ico_properties.gif

GROUP_NAME = comments
GROUP_TITLE_EN = Сomments
GROUP_TITLE_UA = Коментарі
GROUP_TITLE_RU = Комментарии

[LIST]
RECORDS_PER_PAGE=20
FIELDS_COUNT=12

[FIELD_0]
FIELD_NAME=settingid
CONTROL=null
EDIT_CONTROL=hidden
value = 1

[FIELD_1]
FIELD_NAME=title_%s
CONTROL=null
EDIT_CONTROL=text
IS_MULTILANG = 1

[FIELD_2]
FIELD_NAME=email
CONTROL=null
EDIT_CONTROL=text
BOLD=1

[FIELD_3]
FIELD_NAME=rpp
CONTROL=null
EDIT_CONTROL=text
BOLD=1

[FIELD_4]
FIELD_NAME=meta_keywords_%s
CONTROL=null
EDIT_CONTROL=textarea
IS_MULTILANG = 1

[FIELD_5]
FIELD_NAME=meta_description_%s
CONTROL=null
EDIT_CONTROL=textarea
IS_MULTILANG = 1

[FIELD_6]
FIELD_NAME=comments_auto_publishing
CONTROL=null
EDIT_CONTROL=checkbox
CHECKON=1
CHECKOFF=0
GROUP = comments
PACKAGE = comments

[FIELD_7]
FIELD_NAME=comments_only_register
CONTROL=null
EDIT_CONTROL=checkbox
CHECKON=1
CHECKOFF=0
GROUP = comments
PACKAGE = comments

[FIELD_8]
FIELD_NAME=comments_voting
CONTROL=null
EDIT_CONTROL=checkbox
CHECKON=1
CHECKOFF=0
GROUP = comments
PACKAGE = comments

[FIELD_9]
FIELD_NAME=comments_emails
CONTROL=null
EDIT_CONTROL=textarea
GROUP = comments
PACKAGE = comments

[FIELD_10]
FIELD_NAME=comments_length
CONTROL=null
EDIT_CONTROL=text
BOLD=1
GROUP = comments
PACKAGE = comments

[FIELD_11]
FIELD_NAME=comments_pp
CONTROL=null
EDIT_CONTROL=text
BOLD=1
GROUP = comments
PACKAGE = comments

*/
?>