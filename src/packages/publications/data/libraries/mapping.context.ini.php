<?/*
[MAIN]
COMMANDS_COUNT=3

[COMMAND_0]
NAME=additem
URL = extranet/frame.php

PARAMETER =package|publications
PARAMETER =page|publicationsedit
PARAMETER =event|AddItem
PARAMETER =library|publications
PARAMETER =publications_parent_id|{publication_id}

CAPTION_UA = Додати публікацію
CAPTION_RU = Добавить публикацию
CAPTION_EN = Add publication
ACCESS = PUBLICATIONS_MANAGER,PUBLICATIONS_PUBLISHER,PUBLICATIONS_EDITOR
MODE = frame
ICON_CLASS = menu_item_add

[COMMAND_1]
NAME=properties
URL = extranet/frame.php

PARAMETER =package|publications
PARAMETER =page|publicationsedit
PARAMETER =item_id|{item_id}
PARAMETER =event|EditItem
PARAMETER =library|mapping
PARAMETER =mapping_parent_id|{publication_id}
PARAMETER =custom_var|publication_id
PARAMETER =custom_val|{publication_id}
PARAMETER =host_library_ID|publications

CAPTION_UA = Налаштування списку
CAPTION_RU = Настройка списка
CAPTION_EN = List properties
ACCESS = PUBLICATIONS_MANAGER
MODE = frame
ICON_CLASS = menu_item_edit

[COMMAND_2]
NAME=deactivate
URL = extranet/frame.php
PARAMETER = package|publications
PARAMETER = event|MappingDeactivation
PARAMETER = item_id|{item_id}
CAPTION_UA = Деактивувати
CAPTION_RU = Деактивировать
CAPTION_EN = Deactivate
CONFIRM_UA = Ви впевнені що бажаете деактивувати список?
CONFIRM_RU = Вы уверены что хотите деактивировать список?
CONFIRM_EN = Are you sure you want to dectivate publications list?
ACCESS = PUBLICATIONS_MANAGER
MODE = ajax
ICON_CLASS = menu_item_deactivate

*/
?>