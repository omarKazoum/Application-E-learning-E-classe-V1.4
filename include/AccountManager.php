<?php
require_once 'config/config.php';
require_once 'include/DBManager.php';
require_once 'include/DBContract.php';
require_once 'include/InputValidator.php';
class AccountManager
{
    private const  CONNECTED_USER_ID_KEY='connected_user_id';
    private  string $connectedUserId='';
    private  $logged_in=false;
    private static ?AccountManager $instance=null;
    private function __construct()
    {
        global $session_time_out_minutes;
        //this line has no effect as it's not taken into account by the server
        $server_result=ini_set('session.gc_maxlifetime', 60*60*24);
        // each client should remember their session id for for a certain number of seconds
        $client_result=session_set_cookie_params(60*60*24);
        session_start();
        InputValidator::flushErrors();
        $this->logged_in=isset($_SESSION[self::CONNECTED_USER_ID_KEY]) AND !empty($_SESSION[self::CONNECTED_USER_ID_KEY]);
        if($this->logged_in){
            $this->connectedUserId=$_SESSION[self::CONNECTED_USER_ID_KEY];
        }
    }
    public function login(string $userId){
        global $session_time_out_minutes;
        // server should keep session data for a certain number of seconds
        $_SESSION[self::CONNECTED_USER_ID_KEY]=$userId;
        //echo 'suer id '.$_SESSION[self::CONNECTED_USER_ID_KEY];


    }
    public function logOut(){
        session_unset();
        session_destroy();
    }
    public function isLoggedIn():bool{
        return $this->logged_in;
    }
    public function getLoggedInUserId(){
        return $this->connectedUserId;
    }  /**
     * creates a new instance and stores it in the $instance static variable
     * @return AccountManager
     */
    public static function getInstance():AccountManager{
        if(!AccountManager::$instance)
            AccountManager::$instance=new AccountManager();
        return AccountManager::$instance;
    }





}