<?php
require_once 'include/InputValidator.php';
if(preg_match(InputValidator::PHONE_PATTERN,"0610204662")){
    echo 'match';
}else
    echo 'no match';