<?/*
[MAIN]
COMMANDS_COUNT=5

[COMMAND_0]
NAME=add
TYPE = item
URL = extranet/frame.php
PARAMETER =package|calendar
PARAMETER =page|admineventsedit
PARAMETER =library|events
PARAMETER =event|AddItem
PARAMETER =category_id|{category_id}
CAPTION_UA = ������ ����
CAPTION_RU = �������� �������
CAPTION_EN = Add event
ACCESS = CALENDAR_EDITOR
MODE = frame
ICON_CLASS = menu_item_add

[COMMAND_1]
NAME=separator1
TYPE = separator

[COMMAND_2]
NAME=categoryedit
TYPE = item
URL = extranet/frame.php
PARAMETER =package|calendar
PARAMETER =page|itemsedit
PARAMETER =library|categories
PARAMETER =event|EditItem
PARAMETER =item_id|{category_id}
CAPTION_UA = ���������� ��������
CAPTION_RU = ������������� ���������
CAPTION_EN = Category edit
ACCESS = CALENDAR_EDITOR
MODE = frame
ICON_CLASS = menu_item_edit

[COMMAND_3]
NAME=activate
URL = extranet/frame.php
PARAMETER = package|calendar
PARAMETER = event|EventsCategoryActivation
PARAMETER = item_id|{category_id}
CAPTION_UA = ���������� ��������
CAPTION_RU = ������������ ���������
CAPTION_EN = Activate category
ACCESS = CALENDAR_EDITOR
MODE = ajax
ICON_CLASS = menu_item_activate

[COMMAND_4]
NAME=deactivate
URL = extranet/frame.php
PARAMETER = package|calendar
PARAMETER = event|EventsCategoryDeactivation
PARAMETER = item_id|{category_id}
CAPTION_UA = ������������ ��������
CAPTION_RU = �������������� ���������
CAPTION_EN = Deactivate category
ACCESS = CALENDAR_EDITOR
MODE = ajax
ICON_CLASS = menu_item_deactivate

*/
?>