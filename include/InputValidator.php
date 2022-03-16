<?php

class InputValidator
{
    public  const INPUT_VALIDATOR_ERRORS='validator_errors';
    public  const PASSWORD_ERROR_KEY='password';
    public  const EMAIL_ERROR_KEY='email';
    public  const PASSWORD_PATTERN='/^.{8,100}$/';
    public  const EMAIL_PATTERN='/^\w+@\w+(\.\w+)+$/';
    public  const PHONE_PATTERN='/^\+{0,1}(212)|0[658]\d{8}$/';
    public  const PHONE_ERROR_KEY ='phone' ;

    public static function flushErrors(){
            unset($_SESSION[self::INPUT_VALIDATOR_ERRORS]);
    }
    /**
     * validates the password against this criteria:
     * <ul>
     *  <li>can contain at least one lower case character a-z</li>
     *  <li>can contain at least one upper case character A-Z</li>
     *  <li>can contain at least one number 0-9 </li>
     *  <li>can contain at least a special character .<b>.</b>,@,&lt;,>,/,\,$ </li>
     * </ul>
     * <b>In Regex: <code>/^[\w\*\$@\+\.\,]{8,}$/</code></b>
     * @param string $password
     * @return bool
     */
    public static function validatePassword(string $password):bool{
        $res=preg_match(self::PASSWORD_PATTERN,$password);
        if(!$res){
            if(!isset($_SESSION[self::INPUT_VALIDATOR_ERRORS][self::PASSWORD_ERROR_KEY]))
                $_SESSION[self::INPUT_VALIDATOR_ERRORS][self::PASSWORD_ERROR_KEY]="<li>Password must be at least 8 characters long</li>";
            else
                $_SESSION[self::INPUT_VALIDATOR_ERRORS][self::PASSWORD_ERROR_KEY].="<li>Password must be at least 8 characters long</li>";
        }
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
        if(!$res){
            if(!isset($_SESSION[self::INPUT_VALIDATOR_ERRORS][self::EMAIL_ERROR_KEY]))
                $_SESSION[self::INPUT_VALIDATOR_ERRORS][self::EMAIL_ERROR_KEY]="<li>Invalid email address</li>";
            else
                $_SESSION[self::INPUT_VALIDATOR_ERRORS][self::EMAIL_ERROR_KEY].="<li>Invalid email address</li>";
        }
        return $res;
    }
    public static function validateEmailsMatch(string $email1,string $email2){
        $isEmailValide=self::validateEmail($email1);
        $isMatch=$email1==$email2 ;
        if(!$isMatch){
            if(!isset($_SESSION[self::INPUT_VALIDATOR_ERRORS][self::EMAIL_ERROR_KEY]))
                $_SESSION[self::INPUT_VALIDATOR_ERRORS][self::EMAIL_ERROR_KEY]="<li>Emails Must match</li>";
            else
                $_SESSION[self::INPUT_VALIDATOR_ERRORS][self::EMAIL_ERROR_KEY].="<li>Emails Must match</li>";
        }
        return $isMatch AND $isEmailValide;
    }
    public static function validatePasswordsMatch(string $password1,string $password2){
        $isPasswordValide=self::validatePassword($password1);
        $isPasswordsMatch=$password1==$password2 ;
        if(!$isPasswordsMatch){
            if(!isset($_SESSION[self::INPUT_VALIDATOR_ERRORS][self::PASSWORD_ERROR_KEY]))
                $_SESSION[self::INPUT_VALIDATOR_ERRORS][self::PASSWORD_ERROR_KEY]="<li>Passwords must match</li>";
            else
                $_SESSION[self::INPUT_VALIDATOR_ERRORS][self::PASSWORD_ERROR_KEY].="<li>Passwords must match</li>";
        }
        return $isPasswordsMatch AND $isPasswordValide;
    }
    public static function validatePhone(string $phoneNbr){
        $isPhoneValid=preg_match(self::PHONE_PATTERN,$phoneNbr);;
        if(!$isPhoneValid)
            $_SESSION[self::INPUT_VALIDATOR_ERRORS][self::PHONE_ERROR_KEY]="<li>Invalid phone number:must start with 212 or 0 and then 6,5 or 8 followed by 8 numbers  </li>";
        return $isPhoneValid;
    }
    public static function error(string $input_key){
        return $_SESSION[InputValidator::INPUT_VALIDATOR_ERRORS][$input_key]??false;
    }
    public static function validateStudentEmailExists( $exists){
        if(!$exists){
            if(!isset($_SESSION[self::INPUT_VALIDATOR_ERRORS][self::EMAIL_ERROR_KEY]))
                $_SESSION[self::INPUT_VALIDATOR_ERRORS][self::EMAIL_ERROR_KEY]="<li>Email address already in use by another student</li>";
            else
                $_SESSION[self::INPUT_VALIDATOR_ERRORS][self::EMAIL_ERROR_KEY].="<li>Email address already in use by another student</li>";
        }
        return !$exists;
    }
}