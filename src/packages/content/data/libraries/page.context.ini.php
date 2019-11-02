<?/*
[MAIN]
COMMANDS_COUNT=4

[COMMAND_0]
NAME=add
URL = extranet/frame.php
PARAMETER =package|content
PARAMETER =page|new
PARAMETER =parent_id|{item_id}
PARAMETER =event|AddItem
CAPTION_UA = ������ �������
CAPTION_RU = �������� ��������
CAPTION_EN = Add page
ACCESS = STRUCTURE_MANAGER
MODE = frame
ICON_CLASS = menu_item_add

##[COMMAND_1]
##NAME=activate
##URL = extranet/frame.php
##PARAMETER = package|content
##PARAMETER = event|PageActivation
##PARAMETER = item_id|{item_id}
##CAPTION_UA = ���������� �������
##CAPTION_RU = ������������ ��������
##CAPTION_EN = �ctivate page
##ACCESS = STRUCTURE_MANAGER
##MODE = ajax
##ICON_CLASS = menu_item_activate

[COMMAND_1]
NAME=deactivate
URL = extranet/frame.php
PARAMETER = package|content
PARAMETER = event|PageDeactivation
PARAMETER = item_id|{item_id}
CAPTION_UA = ������������ �������
CAPTION_RU = �������������� ��������
CAPTION_EN = Deactivate page
CONFIRM_UA = �� ������� �� ������� ������������ �������?
CONFIRM_RU = �� ������� ��� ������ �������������� ��������?
CONFIRM_EN = Are you sure you want to deactiv�te the page?
ACCESS = STRUCTURE_MANAGER
MODE = ajax
ICON_CLASS = menu_item_deactivate

[COMMAND_2]
NAME=delete
URL = extranet/frame.php
PARAMETER = package|content
PARAMETER = event|PageDelete
PARAMETER = item_id|{item_id}
CAPTION_UA = �������� �������
CAPTION_RU = ������� ��������
CAPTION_EN = Delete page
CONFIRM_UA = �� ������� �� ������� �������� �������?
CONFIRM_RU = �� ������� ��� ������ ������� ��������?
CONFIRM_EN = Are you sure you want to delete the page?
ACCESS = STRUCTURE_MANAGER
MODE = ajax
ICON_CLASS = menu_item_delete

[COMMAND_3]
NAME=edit
URL = extranet/frame.php
PARAMETER =package|content
PARAMETER =page|props
PARAMETER =id|{item_id}
CAPTION_UA = ���������� �������
CAPTION_RU = �������� ��������
CAPTION_EN = Page properties
ACCESS = STRUCTURE_MANAGER
MODE = frame
ICON_CLASS = menu_item_edit

*/
?>