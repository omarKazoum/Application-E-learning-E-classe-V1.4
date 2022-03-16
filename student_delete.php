<?php
require_once 'include/DBManager.php';
require_once 'include/utils.php';
if(isset($_GET['id'])){
    //echo 'id passed is '.$_GET['id'].'<br>';
    DBManager::getInstance()->deleteStudent($_GET['id']);
    redirectWithMessage(getUrlFor('students.php'),MESSAGE_TYPE_SUCCESS,'Student deleted successfully!');
}else
    redirectWithMessage(getUrlFor('students.php'),MESSAGE_TYPE_ERROR,'Student Id not supported or insufficient privileges!');