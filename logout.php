<?php
require_once 'include/AccountManager.php';
$am=AccountManager::getInstance();
if($am->isLoggedIn()) {
    AccountManager::getInstance()->logOut();
 }
header('location:index.php');