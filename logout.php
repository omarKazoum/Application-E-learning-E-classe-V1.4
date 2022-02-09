<?php
require_once 'include/AccountManager.php';
AccountManager::getInstance()->logOut();
header('location:index.php');
