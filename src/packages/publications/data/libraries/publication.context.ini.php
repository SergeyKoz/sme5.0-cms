<?/*
[MAIN]
COMMANDS_COUNT=7

[COMMAND_0]
NAME=edit
URL = extranet/frame.php
PARAMETER =package|publications
PARAMETER =page|publicationsedit
PARAMETER =event|EditItem
PARAMETER =item_id|{item_id}
PARAMETER =library|publications
PARAMETER =publications_parent_id|{parent_id}
CAPTION_UA = Редагувати
CAPTION_RU = Редактировать
CAPTION_EN = Edit
ACCESS = PUBLICATIONS_MANAGER
MODE = frame
ICON_CLASS = menu_item_edit

[COMMAND_1]
NAME=activate
URL = extranet/frame.php
PARAMETER = package|publications
##PARAMETER = page|publicationscontext
PARAMETER = event|PublicationActivation
PARAMETER = item_id|{item_id}
PARAMETER = language|{language}
CAPTION_UA = Активувати (Укр)
CAPTION_RU = Активировать (Рус)
CAPTION_EN = Activate (Eng)
ACCESS = PUBLICATIONS_MANAGER
MODE = ajax
ICON_PACKAGE = context
ICON_PATH = img/ico_activate.gif
ICON_CLASS = menu_item_activate

[COMMAND_2]
NAME=deactivate
URL = extranet/frame.php
PARAMETER = package|publications
##PARAMETER = page|publicationscontext
PARAMETER = event|PublicationDeactivation
PARAMETER = item_id|{item_id}
PARAMETER = language|{language}
CAPTION_UA = Деактивувати (Укр)
CAPTION_RU = Деактивировать (Рус)
CAPTION_EN = Deactivate (Eng)
ACCESS = PUBLICATIONS_MANAGER
MODE = ajax
##ICON_PACKAGE = context
##ICON_PATH = img/ico_deactivate.gif
ICON_CLASS = menu_item_deactivate


[COMMAND_3]
NAME=delete
URL = extranet/frame.php
PARAMETER = package|publications
##PARAMETER = page|publicationscontext
PARAMETER = event|PublicationDelete
PARAMETER = item_id|{item_id}
CAPTION_UA = Видалити
CAPTION_RU = Удалить
CAPTION_EN = Delete
CONFIRM_UA = Ви впевнені що бажаете видалити публікацію?
CONFIRM_RU = Вы уверены что хотите удалить публикацию?
CONFIRM_EN = Are you sure you want to delete the publication?
ACCESS = PUBLICATIONS_MANAGER
MODE = ajax
ICON_CLASS = menu_item_delete
##PACKAGE = publications

[COMMAND_4]
NAME=separator1
TYPE = separator
ACCESS = CALENDAR_EDITOR,COMMENTS_MANAGER
PACKAGE = comments

[COMMAND_5]
NAME=commentsenable
URL = extranet/frame.php
PARAMETER = package|publications
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
PARAMETER = package|publications
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