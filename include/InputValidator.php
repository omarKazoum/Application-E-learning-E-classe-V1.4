<?php

class InputValidator
{
    public  const INPUT_VALIDATOR_ERRORS='validator_errors';
    public  const PASSWORD_ERROR_KEY='password';
    public  const EMAIL_ERROR_KEY='email';
    public  const PASSWORD_PATTERN='/^[\w\*\$@\+\.\,]{8,}$/';
    public  const EMAIL_PATTERN='/^([\w]{1,30})@([\w]{1,20})\.([\w]{1,20})$/';
    public static function flushErrors(){
            unset($_SESSION[self::INPUT_VALIDATOR_ERRORS]);
    }
    /**
     * validates the password against this criteria:
     * <ul>
     *  <li>must contain at least one lower case character a-z</li>
     *  <li>must contain at least one upper case character A-Z</li>
     *  <li>must contain at least one number 0-9 </li>
     *  <li>must contain at least one special charachter .<b>.</b>,@,&lt;,>,/,\,$ </li>
     * </ul>
     * <b>In Regex: <code>/^[\w\*\$@\+\.\,]{8,}$/</code></b>
     * @param string $password
     * @return bool
     */
    public static function validatePassword(string $password):bool{
        $res=preg_match(self::PASSWORD_PATTERN,$password);
        if(!$res)
        $_SESSION[self::INPUT_VALIDATOR_ERRORS][self::PASSWORD_ERROR_KEY]=<<<TEXT
            <ul>
                <li>Invalide password</li>
            </ul>
        TEXT;
        return $res;
    }
    /**
     * validates the password against this criteria:
     * <ul>
     *  <li>must be a valide email adress</li>
     * </ul>
     * <b>Regex used <code>^([\w]{1,30})@([\w]{1,20})\.([\w]{1,20})$</code></b>
     * @param string $email
     * @return bool
     */
    public static function validateEmail(string $email):bool{
        $res=preg_match(self::EMAIL_PATTERN,$email);
        if(!$res)
            $_SESSION[self::INPUT_VALIDATOR_ERRORS][self::EMAIL_ERROR_KEY]=<<<TEXT
            <ul>
            <li>Invalid email address</li>
            </ul>
        TEXT;
        return $res;
    }

    public static function error(string $input_key){
        return $_SESSION[InputValidator::INPUT_VALIDATOR_ERRORS][$input_key]??false;
    }

}