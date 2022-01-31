<?php
require_once 'config.php';
require_once 'DBContract.php';
class DBManager
{
    private static ?DBManager $instance=null;
    private static $db_connection=null;
    public function __construct()
    {
        if(!DBManager::$db_connection)
            $this->connectToDb();
    }
    public static function getInstance(){
             if(!DBManager::$instance){
            DBManager::$instance=new DBManager();
        }
        return DBManager::$instance;
    }

    private function connectToDb(){

            DBManager::$db_connection = new mysqli($GLOBALS['db_host_name'] ,
                $GLOBALS['db_user_name'],
                $GLOBALS['db_password']);
            if(DBManager::$db_connection->connect_error)
                die(DBManager::$db_connection->connect_error);
            else
                echo 'the connection value is '.(DBManager::$db_connection!=null?'not':'').' null';

    }
    private function createTables(){

    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}