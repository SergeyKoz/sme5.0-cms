<?php /**

[GlobalErrors]
CANT_BE_EMPTY=Поле "{1}" не може бути порожнім
INVALID_LENGTH=Поле "{1}" не може містити більше ніж {2} символа(ів)
INVALID_DATE_RANGE=Невірно вказаний проміжок часу між {1} та {2}
INVALID_COMPARE=Поля {1} та {2} не співпадають
INVALID_FLOAT=Поле {1}   повинно містити ціле чи дрібне число з розділювачем "."
INVALID_INT=Поле {1} повинно містити ціле число
INVALID_PASSWORD=Поле {1} має містити лише латинські символи або цифри та бути не коротше 6 символів і починатися з літери.
INVALID_EMAIL=Поле {1} повинно містити вірну адресу електронної пошти
RECORD_EXISTS=В базі вже існують записи з такими значеннями полів

[LIBRARY]
EMPTY_LIBRARY_ID=Не вказано бібліотеку
FILE_NOT_FOUND=Не знайдено файл настроєк бібліотеки {1}
EMPTY_LIBRARY_SETTINGS=Порожній файл настроєк бібліотеки {1}
EMPTY_TABLE_SETTINGS=Відсутнє ім'я таблиці бібліотеки {1}  [MAIN] -> TABLE
EMPTY_RECORDCOUNT_SETTINGS=Відсутня кількість полів списку бібліотеки {1} [LIST] -> FIELDS_COUNT
EMPTY_KEYFIELD_SETTINGS=Не вказане ключове поле таблиці бібліотеки {1} [MAIN] -> KEY_FIELD
EMPTY_FIELDNAME_SETTINGS=Не вказана назва поля №{2} бібліотеки {1} [FIELD_{2}] -> FIELD_NAME
EMPTY_SORT_SETTINGS=Не вказаний флаг сортування поля №{2} бібліотеки {1} [FIELD_{2}] -> SORT
EMPTY_CONTROL_SETTINGS=Не вказаний контрол поля №{2} бібліотеки {1} [FIELD_{2}] -> CONTROL
EMPTY_EDIT_CONTROL_SETTINGS=Не вказаний контрол редагування поля №{2} бібліотеки {1} [FIELD_{2}] -> EDIT_CONTROL
EMPTY_FULLDATE_SETTINGS=Не вказаний флаг повноти виведення дати поля №{2} бібліотеки {1} [FIELD_{2}] -> FULLDATE
EMPTY_EDIT_FULLDATE_SETTINGS=Не вказаний флаг повноти виведення при редагуванні дати поля №{2} бібліотеки {1} [FIELD_{2}] -> FULLDATE
EMPTY_PARENTFIELD_SETTINGS=Не вказане поле таблиці що містить індекс батбківського запису бібліотеки {1} [MAIN] -> FIELD_PARENT
EMPTY_SUB_CATEGORIES_COUNT=Не вказана кількість асоційованих підкатегорій багаторівневого каталогу {1} [MAIN] -> SUB_CATEGORIES_COUNT
EMPTY_SUB_CATEGORY_LIBRARY=Не вказана бібліотека асоційованої підкатегоріі каталогу {1} [SUB_CATEGORY_{2}] -> APPLY_LIBRARY
EMPTY_SUB_CATEGORY_LINK_FIELD=Не вказане поле звязку асоційованої підкатегоріі каталогу {1} [SUB_CATEGORY_{2}] -> LINK_FIELD
EMPTY_CAPTIONFIELD_SETTINGS=Не вказане поле з назвою гілки каталогу {1} [MAIN] -> CAPTION_FIELD

EMPTY_CHECKON_SETTINGS=Не вказане значення вибору поля №{2} бібліотеки {1} [FIELD_{2}] -> CHECKON
EMPTY_CHECKOFF_SETTINGS=Не вказане значення невибораного поля №{2} бібліотеки {1} [FIELD_{2}] -> CHECKOFF

[ItemsListPage]

[ItemsEditPage]


[MESSAGES]
MSG_ITEM_DELETED=Запис успішно видалено
MSG_ITEMS_DELETED=Виділені записи успішно видалено
MSG_ITEMS_COPIED=Виділені записи успішно скопійовано
MSG_ITEMS_EDITED=Виділені записи успішно змінено
MSG_CHANGES_APPLIED=Записи оновлено
NOT_EMPTY_NODE=Ви не можете видалити непусту гілку. Видаліть всі дочерні гілки щодо гілки {1} каталогу.
NOT_EMPTY_SUB_CATEGORY=Неможливо видалити гілку тому {1} що вона вміщуе записи. Видаліть всі асоційовані з гілкою {1} записи.
MSG_MEGA_DELETE_APPLIED=Всі гілки каталогу видалено
MEGA_DELETE_SUB_CATEGORY_APPLIED=Всі асоційовані категорії обраних гілок  видалено.
MOVE_NODES_APPLIED=Обрані вами елементи успішно перенесено до гілки {1}
EMPTY_MOVE_LIST=Перенесення не відбулося. Вкажіть які саме гілки ви хочете перенести.
LIBRARY_DISABLED_ADD=Додавання нових записів до списку заборонено.
LIBRARY_DISABLED_EDIT=Редагування записів данного списку заборонено.
LIBRARY_DISABLED_DELETE=Видалення записів данного списку заборонено.
SELF_NESTED_NODE_CONFLICT=Перенесення гілки {1} в себе саму заборонено.
MSG_ITEM_COPIED=Копія запису створена
MSG_ITEM_MOVED=Запис перенесено
FEEDBACK_SENT=Ваш лист відіслано. Дякуємо, що скористалися формою зворотнього зв'язку.
FEEDBACK_NOT_SENT=Ваш лист не було відіслано через внутрышню помилку сервера. Перепрошуємо за незручність.
FILE_DELETED = Файл видалений
FILE_TOO_BIG=Файл що закачано перевищює дозволений розмiр у {1} байтiв
FORBIDDEN_TYPE=Закачиваемый файл имеет недопустимый тип ({1})
EDIT_ITEM_SAVED = Дані збережено
EDIT_ITEM_APPLIED = Дані збережено
EDIT_ITEM_CREATED = Дані додано

*/ ?>