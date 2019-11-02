<?/*
[MAIN]
TABLE=GuestbookMessagesTable
KEY_FIELD=message_id
ICON_FILE=/img/libraries/ico_catalog.gif
DISABLED_DELETE=0
DISABLED_EDIT=0
DISABLED_ADD=0
IS_READONLY=0
DISABLED_MOVE=0
IS_MULTILEVEL=0

[LIST]
RECORDS_PER_PAGE=20
FIELDS_COUNT=8
GET_DATA_FIELDS=language
GET_DATA_VALUES=%s
## see file "framework\sources\packages>braries\classes\web\controls\itemslistcontrol.php"
## modify line 360:  $this->data[sprintf($data_fields[$c], $this->Page->Kernel->Language)] = $data_values[$c];
## to: $this->data[sprintf($data_fields[$c], $this->Page->Kernel->Language)] = sprintf($data_values[$c], $this->Page->Kernel->Language);


[FIELD_0]
FIELD_NAME=message_id
SORT=1
CONTROL=string
EDIT_CONTROL=null
IN_LIST=1
LENGTH=0

[FIELD_1]
FIELD_NAME=signature
CUT_LIST_LENGTH=50
SORT=1
CONTROL=link
EDIT_CONTROL=text
IN_LIST=1
LENGTH=255

[FIELD_2]
FIELD_NAME=email
CUT_LIST_LENGTH=50
SORT=1
CONTROL=string
EDIT_CONTROL=text
IN_LIST=1
LENGTH=255

[FIELD_3]
FIELD_NAME=message
CUT_LIST_LENGTH=50
SORT=1
CONTROL=string
EDIT_CONTROL=textarea
IN_LIST=1
LENGTH=4096

[FIELD_4]
FIELD_NAME=comment
##CUT_LIST_LENGTH=50
SORT=1
CONTROL=string
EDIT_CONTROL=textarea
IN_LIST=0
LENGTH=4096
## BUG ##
##IS_MULTILANG=0

[FIELD_5]
FIELD_NAME=active
SORT=1
CONTROL=checkbox
EDIT_CONTROL=checkbox
CHECKON=1
CHECKOFF=0
IN_LIST=1
ALIGN=center

[FIELD_6]
FIELD_NAME=posted_date
SORT=1
CONTROL=date
EDIT_CONTROL=null
FULLDATE=1
IN_LIST=1
ALIGN=center

[FIELD_7]
FIELD_NAME=language
EDIT_CONTROL=hidden
*/
?>