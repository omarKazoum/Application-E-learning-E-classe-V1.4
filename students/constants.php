<?php
$ACTION_VIEW='av';
$ACTION_ADD_FORM='aaf';
$ACTION_ADD_SUBMIT='aas';
$ACTION_EDIT='ase';
$ACTION_EDIT_SUBMIT='ases';
$ACTION_GET_KEY='a';
$action=$_GET[$ACTION_GET_KEY]??$ACTION_VIEW;
$USER_ADD_SUCCESS='user-add-success';
$USER_ADD_FAILED='user-add-failed';
$USER_ADD_NOT_SET=false;
$USER_ADD_KEY='user-add';
$user_add_result=$_GET[$USER_ADD_KEY]??$USER_ADD_NOT_SET;
//saving newly added student
$user_delete_key='user_delete';

