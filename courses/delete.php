<?php
require_once '../include/DBManager.php';
require_once '../include/utils.php';
require_once '../courses/constants.php';
require_once 'constants.php';
require_once '../include/AccountManager.php';
$am=AccountManager::getInstance();

redirectToLoginIfNotLogged();
if(!$am->isLoggedInUserAnAdmin())
    redirectWithMessage('courses.php',MESSAGE_TYPE_ERROR,"You don't have sufficient privileges");
$db_manager=DBManager::getInstance();
$db_manager->deleteCourse($selected_course_id);
redirectWithMessage(getUrlFor('courses.php'),MESSAGE_TYPE_SUCCESS,"course deleted successfully");
