<?/*
[MAIN]
COMMANDS_COUNT=7

[COMMAND_0]
NAME=edit
TYPE = item
URL = extranet/frame.php
PARAMETER =package|calendar
PARAMETER =page|admineventsedit
PARAMETER =library|events
PARAMETER =event|EditItem
PARAMETER =item_id|{item_id}
CAPTION_UA = Редагувати подію
CAPTION_RU = Редактировать событие
CAPTION_EN = Edit event
ACCESS = CALENDAR_EDITOR
MODE = frame
ICON_CLASS = menu_item_edit

[COMMAND_1]
NAME=activate
TYPE = item
URL = extranet/frame.php
PARAMETER = package|calendar
PARAMETER = event|EventActivation
PARAMETER = item_id|{category_id}
CAPTION_UA = Активувати подію
CAPTION_RU = Активировать событие
CAPTION_EN = Activate event
ACCESS = CALENDAR_EDITOR
MODE = ajax
ICON_CLASS = menu_item_activate

[COMMAND_2]
NAME=deactivate
TYPE = item
URL = extranet/frame.php
PARAMETER = package|calendar
PARAMETER = event|EventDeactivation
PARAMETER = item_id|{item_id}
CAPTION_UA = Деактивувати подію
CAPTION_RU = Деактивировать событие
CAPTION_EN = Deactivate event
CONFIRM_UA = Ви впевнені що бажаете деаактивувати подію?
CONFIRM_RU = Вы уверены что хотите деактивировать событие?
CONFIRM_EN = Are you sure you want to deactivate the event?
ACCESS = CALENDAR_EDITOR
MODE = ajax
ICON_CLASS = menu_item_deactivate

[COMMAND_3]
NAME=delete
URL = extranet/frame.php
PARAMETER = package|calendar
PARAMETER = event|EventDelete
PARAMETER = item_id|{item_id}
CAPTION_UA = Видалити подію
CAPTION_RU = Удалить событие
CAPTION_EN = Delete event
CONFIRM_UA = Ви впевнені що бажаете видалити подію?
CONFIRM_RU = Вы уверены что хотите удалить событие?
CONFIRM_EN = Are you sure you want to delete the event?
ACCESS = CALENDAR_EDITOR
MODE = ajax
ICON_CLASS = menu_item_delete

[COMMAND_4]
NAME=separator1
TYPE = separator
ACCESS = CALENDAR_EDITOR,COMMENTS_MANAGER
PACKAGE = comments

[COMMAND_5]
NAME=commentsenable
URL = extranet/frame.php
PARAMETER = package|calendar
PARAMETER = event|CommentsEnable
PARAMETER = item_id|{item_id}
CAPTION_UA = Дозволити коментарі
CAPTION_RU = Разрешить комментарии
CAPTION_EN = Comments enable
ACCESS = CALENDAR_EDITOR,COMMENTS_MANAGER
MODE = ajax
ICON_CLASS = menu_item_activate
PACKAGE = comments

[COMMAND_6]
NAME=commentsdisable
URL = extranet/frame.php
PARAMETER = package|calendar
PARAMETER = event|CommentsDisable
PARAMETER = item_id|{item_id}
CAPTION_UA = Заборонити коментарі
CAPTION_RU = Запретить комментарии
CAPTION_EN = Disable comments
ACCESS = CALENDAR_EDITOR,COMMENTS_MANAGER
MODE = ajax
ICON_CLASS = menu_item_deactivate
PACKAGE = comments

*/
?>