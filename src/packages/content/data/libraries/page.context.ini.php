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
CAPTION_UA = Додати сторінку
CAPTION_RU = Добавить страницу
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
##CAPTION_UA = Активувати сторінку
##CAPTION_RU = Активировать страницу
##CAPTION_EN = Аctivate page
##ACCESS = STRUCTURE_MANAGER
##MODE = ajax
##ICON_CLASS = menu_item_activate

[COMMAND_1]
NAME=deactivate
URL = extranet/frame.php
PARAMETER = package|content
PARAMETER = event|PageDeactivation
PARAMETER = item_id|{item_id}
CAPTION_UA = Деактивувати сторінку
CAPTION_RU = Деактивировать страницу
CAPTION_EN = Deactivate page
CONFIRM_UA = Ви впевнені що бажаете деактивувати сторінку?
CONFIRM_RU = Вы уверены что хотите деактивировать страницу?
CONFIRM_EN = Are you sure you want to deactivаte the page?
ACCESS = STRUCTURE_MANAGER
MODE = ajax
ICON_CLASS = menu_item_deactivate

[COMMAND_2]
NAME=delete
URL = extranet/frame.php
PARAMETER = package|content
PARAMETER = event|PageDelete
PARAMETER = item_id|{item_id}
CAPTION_UA = Видалити сторінку
CAPTION_RU = Удалить страницу
CAPTION_EN = Delete page
CONFIRM_UA = Ви впевнені що бажаете видалити сторінку?
CONFIRM_RU = Вы уверены что хотите удалить страницу?
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
CAPTION_UA = Властивості сторінки
CAPTION_RU = Свойства страницы
CAPTION_EN = Page properties
ACCESS = STRUCTURE_MANAGER
MODE = frame
ICON_CLASS = menu_item_edit

*/
?>