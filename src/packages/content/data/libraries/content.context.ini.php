<?/*
[MAIN]
COMMANDS_COUNT=6

[COMMAND_0]
NAME=edit
URL = extranet/frame.php
PARAMETER =package|content
PARAMETER =page|editcontent
PARAMETER =id|{item_id}
PARAMETER =lng|{language}
CAPTION_UA = Редагувати контент сторінки (Укр)
CAPTION_RU = Редактировать контент страницы (Рус)
CAPTION_EN = Edit page content (Eng)
ACCESS = STRUCTURE_MANAGER
MODE = frame
ICON_CLASS = menu_item_edit

[COMMAND_1]
NAME=activate
URL = extranet/frame.php
PARAMETER = package|content
PARAMETER = event|ContentActivation
PARAMETER = item_id|{item_id}
PARAMETER = language|{language}
CAPTION_UA = Активувати контент (Укр)
CAPTION_RU = Активировать контент (Рус)
CAPTION_EN = Аctivate content (Eng)
ACCESS = CONTENT_EDITOR,STRUCTURE_MANAGER
MODE = ajax
ICON_CLASS = menu_item_activate

[COMMAND_2]
NAME=deactivate
URL = extranet/frame.php
PARAMETER = package|content
PARAMETER = event|ContentDeactivation
PARAMETER = item_id|{item_id}
PARAMETER = language|{language}
CAPTION_UA = Деактивувати контент (Укр)
CAPTION_RU = Деактивировать контент (Рус)
CAPTION_EN = Deactivate content (Eng)
ACCESS = CONTENT_EDITOR,STRUCTURE_MANAGER
MODE = ajax
ICON_CLASS = menu_item_deactivate

[COMMAND_3]
NAME=separator1
TYPE = separator
ACCESS = CONTENT_EDITOR,STRUCTURE_MANAGER,COMMENTS_MANAGER
PACKAGE = comments

[COMMAND_4]
NAME=commentsenable
URL = extranet/frame.php
PARAMETER = package|content
PARAMETER = event|CommentsEnable
PARAMETER = item_id|{item_id}
CAPTION_UA = Дозволити коментарі
CAPTION_RU = Разрешить комментарии
CAPTION_EN = Comments enable
ACCESS = CONTENT_EDITOR,STRUCTURE_MANAGER,COMMENTS_MANAGER
MODE = ajax
ICON_CLASS = menu_item_activate
PACKAGE = comments

[COMMAND_5]
NAME=commentsdisable
URL = extranet/frame.php
PARAMETER = package|content
PARAMETER = event|CommentsDisable
PARAMETER = item_id|{item_id}
CAPTION_UA = Заборонити коментарі
CAPTION_RU = Запретить комментарии
CAPTION_EN = Disable comments
ACCESS = CONTENT_EDITOR,STRUCTURE_MANAGER,COMMENTS_MANAGER
MODE = ajax
ICON_CLASS = menu_item_deactivate
PACKAGE = comments


*/
?>