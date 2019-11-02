<?/*
[MAIN]
COMMANDS_COUNT=3

[COMMAND_0]
NAME=edit
TYPE = item
URL = extranet/frame.php
PARAMETER =package|comments
PARAMETER =page|itemsedit
PARAMETER =library|comments
PARAMETER =event|EditItem
PARAMETER =item_id|{item_id}
CAPTION_UA = Редагувати коментар
CAPTION_RU = Редактировать коментарий
CAPTION_EN = Edit comment
ACCESS = COMMENTS_MODERATOR
MODE = frame
ICON_CLASS = menu_item_edit

[COMMAND_1]
NAME=decline
TYPE = item
URL = extranet/frame.php
PARAMETER = package|comments
PARAMETER = event|CommentDecline
PARAMETER = item_id|{item_id}
CAPTION_UA = Відхилити коментар
CAPTION_RU = Отклонить комментарий
CAPTION_EN = Decline comment
CONFIRM_UA = Ви впевнені що бажаете відхилити коментар?
CONFIRM_RU = Вы уверены что хотите отклонить комментарий?
CONFIRM_EN = Are you sure you want to decline comment?
ACCESS = COMMENTS_MODERATOR
MODE = ajax
ICON_CLASS = menu_item_deactivate

[COMMAND_2]
NAME=delete
URL = extranet/frame.php
PARAMETER = package|comments
PARAMETER = event|CommentDelete
PARAMETER = item_id|{item_id}
CAPTION_UA = Видалити комментарий
CAPTION_RU = Удалить комментарий
CAPTION_EN = Delete comment
CONFIRM_UA = Ви впевнені що бажаете видалити комментарий?
CONFIRM_RU = Вы уверены что хотите удалить комментарий?
CONFIRM_EN = Are you sure you want to delete the comment?
ACCESS = COMMENTS_MODERATOR
MODE = ajax
ICON_CLASS = menu_item_delete

*/
?>