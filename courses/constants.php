<?php
$ACTION_COURSES_LIST='courses_view';
$ACTION_COURSES_EDIT_FORM='cef';
$ACTION_COURSES_EDIT_SUBMIT='ces';
$ACTION_COURSES_ADD_FORM='caf';
$ACTION_COURSES_ADD_SUBMIT='cas';
$ACTION_COURSES_DELETE='cd';
$ACTION_COURSES_KEY='a';
$SELECTED_COURSE_ID_KEY='c';
$selected_course_id=isset($_GET[$SELECTED_COURSE_ID_KEY])?$_GET[$SELECTED_COURSE_ID_KEY]:-1;
$action=isset($_GET[$ACTION_COURSES_KEY])?$_GET[$ACTION_COURSES_KEY]:$ACTION_COURSES_LIST;

$MSG_KEY='m';
$msg=isset($_GET[$MSG_KEY])?$_GET[$MSG_KEY]:false;
$MSG_TYPE_KEY='mt';
$MSG_TYPE_POSITIVE='mtp';
$MSG_TYPE_NEGATIVE='mtn';
$msg_type=isset($_GET[$MSG_TYPE_KEY])?$_GET[$MSG_TYPE_KEY]:false;
