<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';
require_once 'DBContract.php';
class DBManager
{
    private static ?DBManager $instance=null;
    private static $db_connection=null;
    private static $server_connection=null;
    private function __construct()
    {
    }
    public static function getInstance(){
         if(!DBManager::$instance){
            DBManager::$instance=new DBManager();
         }
        return DBManager::$instance;
    }
    /**
     * connectq to database and stores a link object in DBManager::$db_connection
     * @return void
     */
    private function connectToDb(){
        DBManager::$db_connection = new mysqli($GLOBALS['db_host_name'] ,
            $GLOBALS['db_user_name'],
            $GLOBALS['db_password'],
            DBContract::$DB_NAME
        );
        if(DBManager::$db_connection->connect_error)
            die(DBManager::$db_connection->connect_error);
        /*else
            echo 'the connection with db '.(DBManager::$db_connection!=null?'established ':'failed').'';
        */
    }


    private function connectToServer(){
        DBManager::$server_connection = new mysqli($GLOBALS['db_host_name'] ,
            $GLOBALS['db_user_name'],
            $GLOBALS['db_password']);
        if(DBManager::$server_connection->connect_error)
            die(DBManager::$server_connection->connect_error);
        /*else
            echo 'the connection with db '.(DBManager::$server_connection!=null?'established ':'failed');
        */

    }
    /** creates the database
     * @return void
     */
    private function createDB(){
         $result=DBManager::$server_connection->query('CREATE DATABASE '.DBContract::$DB_NAME);
        DBManager::$server_connection->close();
         return $result;
    }

    /**
     * create the required tables
     * @return bool
     */
    public function createTables(){
            $students_table_query='CREATE TABLE '.DBContract::$Students_TableName.'('
                .DBContract::$Students_Col_Id.' INT PRIMARY KEY AUTO_INCREMENT,'
                .DBContract::$Students_Col_Name.' VARCHAR(20),'
                .DBContract::$Students_Col_Email.' TEXT ,'
                .DBContract::$Students_Col_Phone.' VARCHAR(12) ,'
                .DBContract::$Students_Col_EnrollNbr.' TEXT ,'
                .DBContract::$Students_Col_DateAdmission.' DATE '.
            ')';
            $payments_table_query='CREATE TABLE '.DBContract::$PaymentDetails_TableName.'('
                        .DBContract::$PaymentDetails_Col_Id.' INT PRIMARY KEY AUTO_INCREMENT,'
                        .DBContract::$PaymentDetails_Col_Name.' VARCHAR(20),'
                        .DBContract::$PaymentDetails_Col_PaymentSchechule.' INT,'
                        .DBContract::$PaymentDetails_Col_BillNbr.' VARCHAR(30),'
                        .DBContract::$PaymentDetails_Col_AmountPaid.' FLOAT(10),'
                        .DBContract::$PaymentDetails_Col_BalanceAmount.' FLOAT(10),'
                        .DBContract::$PaymentDetails_Col_Date.' DATE'.
                    ')';

            $courses_table_query='CREATE TABLE '.DBContract::$Courses_Col_TableName.'('
                .DBContract::$Courses_Col_Id.' INT PRIMARY KEY AUTO_INCREMENT,'
                .DBContract::$Courses_Col_Title.' VARCHAR(30),'
                .DBContract::$Courses_Col_MentorName.' VARCHAR(20),'
                .DBContract::$Courses_Col_Date.' DATETIME,'
                .DBContract::$Courses_Col_Duration.' TIME'
            .')';

            //echo '<br>payments table query : '.$payments_table_query;
            //echo '<br>courses table query : '.$courses_table_query;
            $r1=DBManager::$db_connection->query($students_table_query);
            $r2=DBManager::$db_connection->query($payments_table_query);
            $r3=DBManager::$db_connection->query($courses_table_query);
            return $r1 && $r2 && $r3;
        }

    /**
     * create the database and all the required tables
     * @return void
     */
    public function install(){
        $this->connectToServer();
        //echo '<br>database creation :'.json_encode( DBManager::$instance->createDB());
        $this->connectToDb();
        //echo '<br>students table creation:'.json_encode(DBManager::$instance->createTables());
    }
    public function connect(){
        $this->connectToDb();
    }

    /**
     * close all connections when they are no longer needed
     */
    public function __destruct()
    {
           //mysqli_close(DBManager::$server_connection);
           mysqli_close(DBManager::$db_connection);

    }

    /**
     * insert a new student
     */
    public function insertStudent(array $student){
        $query='INSERT INTO '.DBContract::$Students_TableName.'('
                .DBContract::$Students_Col_Name.','
                .DBContract::$Students_Col_Email.' ,'
                .DBContract::$Students_Col_Phone.' ,'
                .DBContract::$Students_Col_EnrollNbr.','
                .DBContract::$Students_Col_DateAdmission.')'
                .' VALUES(? , ?, ?, ?, ?)';
        $statment=DBManager::$db_connection->prepare($query);
        $statment->bind_param('sssss',
            $student[DBContract::$Students_Col_Name],
            $student[DBContract::$Students_Col_Email],
            $student[DBContract::$Students_Col_Phone],
            $student[DBContract::$Students_Col_EnrollNbr],
            $student[DBContract::$Students_Col_DateAdmission]
        );
        $statment->execute();
    }

    /**
     * update the student with the given id
     * @param $studentId
     * @param array $student (must contain all the required fields except the id)
     * @return mixed
     */
    public function updateStudent($studentId,array $student){
        $query='UPDATE '.DBContract::$Students_TableName.' SET '
            .DBContract::$Students_Col_Name.'=?,'
            .DBContract::$Students_Col_Email.'=? ,'
            .DBContract::$Students_Col_Phone.'=? ,'
            .DBContract::$Students_Col_EnrollNbr.'=?,'
            .DBContract::$Students_Col_DateAdmission.'=?'
            .' WHERE '.DBContract::$Courses_Col_Id.'=?;';
        $statment=DBManager::$db_connection->prepare($query);
        $statment->bind_param('sssssi',
            $student[DBContract::$Students_Col_Name],
            $student[DBContract::$Students_Col_Email],
            $student[DBContract::$Students_Col_Phone],
            $student[DBContract::$Students_Col_EnrollNbr],
            $student[DBContract::$Students_Col_DateAdmission],$studentId);
        return $statment->execute();
    }

    /**
     * retreves an array of all students info
     * @return array
     */
    public function getAllStudents():array{
        $query='SELECT * FROM '.DBContract::$Students_TableName;
        $result=DBManager::$db_connection->query($query);
        $students=array();
        while ($row =$result->fetch_assoc())
            $students[]=array(
                DBContract::$Students_Col_Name=>$row[DBContract::$Students_Col_Name],
                DBContract::$Students_Col_Email=>$row[DBContract::$Students_Col_Email],
                DBContract::$Students_Col_Phone=>$row[DBContract::$Students_Col_Phone],
                DBContract::$Students_Col_EnrollNbr=>$row[DBContract::$Students_Col_EnrollNbr],
                DBContract::$Students_Col_DateAdmission=>$row[DBContract::$Students_Col_DateAdmission],
                DBContract::$Students_Col_Id=>$row[DBContract::$Students_Col_Id]
            );
        return $students;

    }

    /**
     * delete the student with the given id
     * @param $studentId
     * @return mixed
     */
    public function deleteStudent($studentId){
        $query='DELETE FROM '.DBContract::$Students_TableName.' WHERE '.DBContract::$Students_Col_Id.'='.$studentId;
        return DBManager::$db_connection->query($query);
    }

    public function insertCourse(array $courseToInsert){


    }

}