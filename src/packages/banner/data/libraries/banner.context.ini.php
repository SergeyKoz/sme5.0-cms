<?/*
[MAIN]
COMMANDS_COUNT=4

[COMMAND_0]
NAME=edit
URL = extranet/frame.php
PARAMETER =package|banner
PARAMETER =page|bannersedit
PARAMETER =library|banners
PARAMETER =event|EditItem
PARAMETER =item_id|{item_id}
PARAMETER =banners_parent_id|{group_id}
PARAMETER =custom_var|group_id
PARAMETER =custom_val|{group_id}
PARAMETER =host_library_ID|banner_groups
CAPTION_UA = ���������� �����
CAPTION_RU = ������������� ������
CAPTION_EN = Edit banner
ACCESS = BANNER_ADMINISTRATOR,BANNER_PUBLISHER
MODE = frame
ICON_CLASS = menu_item_edit

[COMMAND_1]
NAME=deactivate
URL = extranet/frame.php
PARAMETER = package|banner
PARAMETER = event|BannerDeactivation
PARAMETER = item_id|{item_id}
CAPTION_UA = ������������ �����
CAPTION_RU = �������������� ������
CAPTION_EN = Deactivate banner
CONFIRM_UA = �� ������� �� ������� ������������ ������?
CONFIRM_RU = �� ������� ��� ������ �������������� �����?
CONFIRM_EN = Are you sure you want to deactiv�te the banner?
ACCESS = BANNER_ADMINISTRATOR,BANNER_PUBLISHER
MODE = ajax
ICON_CLASS = menu_item_deactivate

[COMMAND_2]
NAME=deactivatemultilang
URL = extranet/frame.php
PARAMETER = package|banner
PARAMETER = event|BannerDeactivateMultiLanguage
PARAMETER = item_id|{item_id}
PARAMETER = language|{language}
CAPTION_UA = ������������ ����� (���)
CAPTION_RU = �������������� ������ (���)
CAPTION_EN = Deactivate banner (Eng)
CONFIRM_UA = �� ������� �� ������� ������������ ������?
CONFIRM_RU = �� ������� ��� ������ �������������� �����?
CONFIRM_EN = Are you sure you want to deactiv�te the banner?
ACCESS = BANNER_ADMINISTRATOR,BANNER_PUBLISHER
MODE = ajax
ICON_CLASS = menu_item_deactivate

[COMMAND_3]
NAME=delete
URL = extranet/frame.php
PARAMETER = package|banner
PARAMETER = event|BannerDelete
PARAMETER = item_id|{item_id}
CAPTION_UA = �������� �����
CAPTION_RU = ������� ������
CAPTION_EN = Delete banner
CONFIRM_UA = �� ������� �� ������� �������� �����?
CONFIRM_RU = �� ������� ��� ������ ������� ������?
CONFIRM_EN = Are you sure you want to delete the banner?
ACCESS = BANNER_ADMINISTRATOR,BANNER_PUBLISHER
MODE = ajax
ICON_CLASS = menu_item_delete

*/
?>