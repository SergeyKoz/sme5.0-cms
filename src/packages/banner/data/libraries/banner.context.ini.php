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
CAPTION_UA = Редагувати банер
CAPTION_RU = Редактировать баннер
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
CAPTION_UA = Деактивувати банер
CAPTION_RU = Деактивировать баннер
CAPTION_EN = Deactivate banner
CONFIRM_UA = Ви впевнені що бажаете деактивувати баннер?
CONFIRM_RU = Вы уверены что хотите деактивировать банер?
CONFIRM_EN = Are you sure you want to deactivаte the banner?
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
CAPTION_UA = Деактивувати банер (Укр)
CAPTION_RU = Деактивировать баннер (Рус)
CAPTION_EN = Deactivate banner (Eng)
CONFIRM_UA = Ви впевнені що бажаете деактивувати баннер?
CONFIRM_RU = Вы уверены что хотите деактивировать банер?
CONFIRM_EN = Are you sure you want to deactivаte the banner?
ACCESS = BANNER_ADMINISTRATOR,BANNER_PUBLISHER
MODE = ajax
ICON_CLASS = menu_item_deactivate

[COMMAND_3]
NAME=delete
URL = extranet/frame.php
PARAMETER = package|banner
PARAMETER = event|BannerDelete
PARAMETER = item_id|{item_id}
CAPTION_UA = Видалити банер
CAPTION_RU = Удалить баннер
CAPTION_EN = Delete banner
CONFIRM_UA = Ви впевнені що бажаете видалити банер?
CONFIRM_RU = Вы уверены что хотите удалить баннер?
CONFIRM_EN = Are you sure you want to delete the banner?
ACCESS = BANNER_ADMINISTRATOR,BANNER_PUBLISHER
MODE = ajax
ICON_CLASS = menu_item_delete

*/
?>