<?php
require_once 'config.php';
class DbManager
{
    private static ?DbManager $instance=null;
    private static $db_connection=null;
    public function __construct()
    {
        if(!DbManager::$db_connection)
            $this->connectToDb();
    }
    public static function getInstance(){
             if(!DbManager::$instance){
            DbManager::$instance=new DbManager();
        }
        return DbManager::$instance;
    }

    private function connectToDb(){
        try {
            DbManager::$db_connection = new PDO('mysql:host='
                . $GLOBALS['db_host_name'] . ';dbname='
                . $GLOBALS['db_name'] . ';charset=utf8',
                $GLOBALS['db_user_name'],
                $GLOBALS['db_password']);
        }catch(PDOException $e){
            die($e->errorInfo);
        } finally {
            echo 'the connection value is '.(DbManager::$db_connection!=null?'not':'').' null';
        }
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }
}