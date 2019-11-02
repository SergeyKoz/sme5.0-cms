<?php /**

[GlobalErrors]
CANT_BE_EMPTY=Field "{1}" can't be empty
INVALID_LENGTH=Field "{1}" length exceed {2} char(s)
INVALID_DATE_RANGE=Invalid date range between {1} and {2}
INVALID_COMPARE=Fields  {1} and {2} not identicaly
INVALID_FLOAT=Field  {1}  must contain  integer or float with separator"."
INVALID_INT=Field {1} must be a integer
INVALID_PASSWORD=Field  {1} must contain only latin symbols, digits and length must be at least 6 symbols.
INVALID_EMAIL=Field {1} must contain a valid e-mail address
RECORD_EXISTS= In base already there are records with such meanings of fields

[LIBRARY]
EMPTY_LIBRARY_ID=Library ID is empty
FILE_NOT_FOUND=Library {1} setup file was not found
EMPTY_LIBRARY_SETTINGS=Library {1} settings file is empty
EMPTY_TABLE_SETTINGS=Library {1} table settings file is empty  [MAIN] -> TABLE
EMPTY_RECORDCOUNT_SETTINGS=Library {1} fields count list is empty [LIST] -> FIELDS_COUNT
EMPTY_KEYFIELD_SETTINGS=No library {1} table key field indicated [MAIN] -> KEY_FIELD
EMPTY_FIELDNAME_SETTINGS=No library {1} field No{2} name indicated [FIELD_{2}] -> FIELD_NAME
EMPTY_SORT_SETTINGS=No sorting flag indicated for field No {2} of library {1} [FIELD_{2}] -> SORT
EMPTY_CONTROL_SETTINGS=No control indicated for field No{2} of library {1} [FIELD_{2}] -> CONTROL
EMPTY_EDIT_CONTROL_SETTINGS=No edit control indicated for field No {2} of library {1} [FIELD_{2}] -> EDIT_CONTROL
EMPTY_FULLDATE_SETTINGS=No flag of date settings indicated for field No {2} of library {1} [FIELD_{2}] -> FULLDATE
EMPTY_EDIT_FULLDATE_SETTINGS=No flag of date settings when editing field date, was indicated for field No {2} of library {1} [FIELD_{2}] -> FULLDATE
EMPTY_PARENTFIELD_SETTINGS=No parent field indicated for library {1} [MAIN] -> FIELD_PARENT
EMPTY_SUB_CATEGORIES_COUNT=No quantity of associated subcategories indicated for multilevel directory {1} [MAIN] -> SUB_CATEGORIES_COUNT
EMPTY_SUB_CATEGORY_LIBRARY=No library indicated for associated subcategory of directory {1} [SUB_CATEGORY_{2}] -> APPLY_LIBRARY
EMPTY_SUB_CATEGORY_LINK_FIELD=No link field indicated for associated subcategory of directory {1} [SUB_CATEGORY_{2}] -> LINK_FIELD
EMPTY_CAPTIONFIELD_SETTINGS=No caption field indicated for subdirectory of directory {1} [MAIN] -> CAPTION_FIELD

EMPTY_CHECKON_SETTINGS=No check-on settings indicated for field No {2} of library {1} [FIELD_{2}] -> CHECKON
EMPTY_CHECKOFF_SETTINGS=No check-off settings indicated for field No {2} of library {1} [FIELD_{2}] -> CHECKOFF

EMPTY_ENTRIES_TABLE= No Entries table defined for DBTreeComBoBox +USE_CATEGORIES of field ¹{2} library {1} [FIELD_{2} -> ENTRIES_TABLE]
EMPTY_ENTRIESVALUE_NAME=No field defined to link to category for DBTreeComBoBox +USE_CATEGORIES of field ¹{2} library {1} [FIELD_{2} -> ENTRIESVALUE_NAME]
EMPTY_ENTRIESVALUE_CAPTION=No caption field defined while linking entry to category for DBTreeComBoBox +USE_CATEGORIES of field ¹{2} library {1} [FIELD_{2} -> ENTRIESVALUE_CAPTION]

[ItemsListPage]

[ItemsEditPage]

[MESSAGES]
MSG_ITEM_DELETED=Message item deleted
MSG_ITEMS_DELETED=Selected items successfully deleted
MSG_ITEMS_COPIED=Selected items successfully copied
MSG_ITEMS_EDITED=Selected items successfully changed
MSG_CHANGES_APPLIED=Items changed
NOT_EMPTY_NODE=You cannot delete non-empty thread. Please delete all associated threads of thread {1} of directory.
NOT_EMPTY_SUB_CATEGORY=Can't delete thread {1} because it contain items.Please delete all items  associated with thread {1}.
MSG_MEGA_DELETE_APPLIED=All threads of directory deleted
MEGA_DELETE_SUB_CATEGORY_APPLIED=All associated categories of selected threads were deleted.
MOVE_NODES_APPLIED=Selected items were moved to thread {1}
EMPTY_MOVE_LIST=Please indicate which threads you want to move.
LIBRARY_DISABLED_ADD=Adding of new entries to the current list is disabled.
LIBRARY_DISABLED_EDIT=Editing of entries of the current list is disabled.
LIBRARY_DISABLED_DELETE=Deleting of entries of the current list is disabled.
SELF_NESTED_NODE_CONFLICT=You cannot move thread {1} into itself.
MSG_ITEM_COPIED=Copy of record created
MSG_ITEM_MOVED=Record moved
FEEDBACK_SENT=Feedback has been sent. Thank you for using Feedback form.
FEEDBACK_NOT_SENT=Feedback has not been sent due to server misconfiguration. We apologise for incovinience.
FILE_DELETED = File deleted
FILE_TOO_BIG=Uploaded file exceeds allowed file size of {1} bytes
FORBIDDEN_TYPE=Uploaded file has forbidden type ({1})
EDIT_ITEM_SAVED = Data is saved
EDIT_ITEM_APPLIED = Data is saved
EDIT_ITEM_CREATED = Data added

[FileStorageDlgPage]
ACCESS_DENIED=Access to the extranet is denied

*/ ?>