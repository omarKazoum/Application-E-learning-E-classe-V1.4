<?php
require_once 'config.php';
require_once 'DBContract.php';

    ini_set('display_errors', !$PRODUCTION);
    ini_set('display_startup_errors', !$PRODUCTION);
    error_reporting((!$PRODUCTION) ?E_ALL:0);
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
        DBManager::$instance->install();
        return DBManager::$instance;
    }
    /**
     * connect to database and stores a link object in DBManager::$db_connection
     * @return void
     */
    private function connectToDb(){
        DBManager::$db_connection = new mysqli($GLOBALS['db_host_name'] ,
            $GLOBALS['db_user_name'],
            $GLOBALS['db_password'],
            $GLOBALS['db_name']
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
        if(DBManager::$server_connection->connect_error && !$PRODUCTION)
            die(DBManager::$server_connection->connect_error);
        /*else
            echo 'the connection with db '.(DBManager::$server_connection!=null?'established ':'failed');
        */

    }
    /** creates the database
     * @return void
     */
    private function createDB(){
         $result=DBManager::$server_connection->query('CREATE DATABASE '.$GLOBALS['db_name']);
        DBManager::$server_connection->close();
         return $result;
    }

    /**
     * create the required tables
     * @return bool
     */
    private function createTables(){
            $students_table_query='CREATE TABLE '.DBContract::$Students_TableName.'('
                .DBContract::$Students_Col_Id.' INT PRIMARY KEY AUTO_INCREMENT,'
                .DBContract::$Students_Col_Name.' VARCHAR(20),'
                .DBContract::$Students_Col_Image.' TEXT,'
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

            $courses_table_query='CREATE TABLE '.DBContract::$Courses_TableName.'('
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
    private function install(){
        $this->connectToServer();
        DBManager::$instance->createDB();
        $this->connectToDb();
        DBManager::$instance->createTables();
    }

    public function getUserbyEmail()
    {

    }

    /**
     * unused
     * @return DBManager|null
     */
    private function connect(){
        $this->connectToDb();
        return DBManager::$instance;
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
                .DBContract::$Students_Col_Image.','
                .DBContract::$Students_Col_Email.' ,'
                .DBContract::$Students_Col_Phone.' ,'
                .DBContract::$Students_Col_EnrollNbr.','
                .DBContract::$Students_Col_DateAdmission.')'
                .' VALUES(? , ?, ?, ?, ?,?)';
        $statment=DBManager::$db_connection->prepare($query);
        $statment->bind_param('ssssss',
            $student[DBContract::$Students_Col_Name],
            $student[DBContract::$Students_Col_Image],
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
        $query='UPDATE '.DBContract::$Students_TableName.' SET '.
            DBContract::$Students_Col_Image.'=?,'
            .DBContract::$Students_Col_Name.'=?,'
            .DBContract::$Students_Col_Email.'=? ,'
            .DBContract::$Students_Col_Phone.'=? ,'
            .DBContract::$Students_Col_EnrollNbr.'=?,'
            .DBContract::$Students_Col_DateAdmission.'=?'
            .' WHERE '.DBContract::$Students_Col_Id.'=?;';
        $statment=DBManager::$db_connection->prepare($query);
        $statment->bind_param('ssssssi',
            $student[DBContract::$Students_Col_Image],
            $student[DBContract::$Students_Col_Name],
            $student[DBContract::$Students_Col_Email],
            $student[DBContract::$Students_Col_Phone],
            $student[DBContract::$Students_Col_EnrollNbr],
            $student[DBContract::$Students_Col_DateAdmission],$studentId);
        return $statment->execute();
    }

    /**
     * returns an array containing the data of the student with the given id
     * @param int $studentId
     * @return array
     */
    public function getStudentById(int $studentId):array{
        $query='SELECT * FROM '.DBContract::$Students_TableName.' WHERE '.DBContract::$Students_Col_Id.' ='.$studentId;
        $result=DBManager::$db_connection->query($query);
        $student=null;
        while ($row =$result->fetch_assoc())
            $student=array(
                DBContract::$Students_Col_Image=>$row[DBContract::$Students_Col_Image],
                DBContract::$Students_Col_Id=>$row[DBContract::$Students_Col_Id],
                DBContract::$Students_Col_Name=>$row[DBContract::$Students_Col_Name],
                DBContract::$Students_Col_Email=>$row[DBContract::$Students_Col_Email],
                DBContract::$Students_Col_Phone=>$row[DBContract::$Students_Col_Phone],
                DBContract::$Students_Col_EnrollNbr=>$row[DBContract::$Students_Col_EnrollNbr],
                DBContract::$Students_Col_DateAdmission=>$row[DBContract::$Students_Col_DateAdmission]
            );
        return $student;
    }
    /**
     * retreves an array of all students info
     * @param string order either @ASC for ascending or @DESC for descending
     * @return array
     */
    public function getAllStudents(string $order='ASC'):array{
        $query='SELECT * FROM '.DBContract::$Students_TableName.' ORDER BY '.DBContract::$Students_Col_DateAdmission.' '.$order;;
        $result=DBManager::$db_connection->query($query);
        $students=array();
        while ($row =$result->fetch_assoc())
            $students[]=array(
                DBContract::$Students_Col_Image=>$row[DBContract::$Students_Col_Image],
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

    /**
     * to insert a new course entry in the courses table
     * @param array $courseToInsert contains all the fields in the corresponding table
     * @return void
     */
    public function insertCourse(array $courseToInsert){
        $query='INSERT INTO '.DBContract::$Courses_TableName.'('
            .DBContract::$Courses_Col_Title.' ,'
            .DBContract::$Courses_Col_MentorName.' ,'
            .DBContract::$Courses_Col_Date.','
            .DBContract::$Courses_Col_Duration.')'
            .' VALUES(? , ?, ?, ?)';
        $statment=DBManager::$db_connection->prepare($query);
        $statment->bind_param('ssss',
            $courseToInsert[DBContract::$Courses_Col_Title],
            $courseToInsert[DBContract::$Courses_Col_MentorName],
            $courseToInsert[DBContract::$Courses_Col_Date],
            $courseToInsert[DBContract::$Courses_Col_Duration]
        );
        $statment->execute();
    }
    /**
     * to insert a new course entry in the courses table
     * @param array $courseToInsert contains all the fields in the corresponding table
     * @return void
     */
    public function updateCourse(int $courseId,array $courseToInsert){
        $query='UPDATE '.DBContract::$Courses_TableName.' SET '
            .DBContract::$Courses_Col_Title.'=? ,'
            .DBContract::$Courses_Col_MentorName.'=? ,'
            .DBContract::$Courses_Col_Date.'=? ,'
            .DBContract::$Courses_Col_Duration.'=? '
            .'WHERE '.DBContract::$Courses_Col_Id.'=?';
        ;
        $statment=DBManager::$db_connection->prepare($query);
        $statment->bind_param('ssssi',
            $courseToInsert[DBContract::$Courses_Col_Title],
            $courseToInsert[DBContract::$Courses_Col_MentorName],
            $courseToInsert[DBContract::$Courses_Col_Date],
            $courseToInsert[DBContract::$Courses_Col_Duration],
            $courseId
        );
        return $statment->execute();
    }

    /**
     * delete the course with the given id
     * @param $CourseId
     * @return mixed
     */
    public function deleteCourse($CourseId){
        $query='DELETE FROM '.DBContract::$Courses_TableName.' WHERE '.DBContract::$Courses_Col_Id.'='.$CourseId;
        return DBManager::$db_connection->query($query);
    }

    /**
     * returns an array containing all available courses
     * @param string order either @ASC for ascending or @DESC for descending
     * @return array
     */
    public function getAllCourses(string $order='ASC'):array{
        $query='SELECT * FROM '.DBContract::$Courses_TableName.' ORDER BY '.DBContract::$Courses_Col_Date.' '.$order;;
        $result=DBManager::$db_connection->query($query);
        $courses=array();
        while ($row =$result->fetch_assoc())
            $courses[]=array(
                DBContract::$Courses_Col_Id=>$row[DBContract::$Courses_Col_Id],
                DBContract::$Courses_Col_Title=>$row[DBContract::$Courses_Col_Title],
                DBContract::$Courses_Col_MentorName=>$row[DBContract::$Courses_Col_MentorName],
                DBContract::$Courses_Col_Date=>$row[DBContract::$Courses_Col_Date],
                DBContract::$Courses_Col_Duration=>$row[DBContract::$Courses_Col_Duration]
            );
        return $courses;
    }

    /**
     * @param int $courseId
     * @return array
     */
    public function getCourseById(int $courseId):array{
        $query='SELECT * FROM '.DBContract::$Courses_TableName.' WHERE '.DBContract::$Courses_Col_Id.'='.$courseId;
        $result=DBManager::$db_connection->query($query);
        $row =$result->fetch_assoc();
        $course=array(
            DBContract::$Courses_Col_Id=>$row[DBContract::$Courses_Col_Id],
            DBContract::$Courses_Col_Title=>$row[DBContract::$Courses_Col_Title],
            DBContract::$Courses_Col_MentorName=>$row[DBContract::$Courses_Col_MentorName],
            DBContract::$Courses_Col_Date=>$row[DBContract::$Courses_Col_Date],
            DBContract::$Courses_Col_Duration=>$row[DBContract::$Courses_Col_Duration]
        );
        return $course;
    }

    /**
     * insert a payment
     * @param array $payment
     * @return void
     */
    public function insertPayment(array $payment){
        $query='INSERT INTO '.DBContract::$PaymentDetails_TableName.'('
                    .DBContract::$PaymentDetails_Col_Name.' ,'
                    .DBContract::$PaymentDetails_Col_PaymentSchechule.' ,'
                    .DBContract::$PaymentDetails_Col_BillNbr.','
                    .DBContract::$PaymentDetails_Col_AmountPaid.','
                    .DBContract::$PaymentDetails_Col_BalanceAmount.','
                    .DBContract::$PaymentDetails_Col_Date
                .')'
                .' VALUES(? , ?, ?, ?, ?, ?)';
        $statment=DBManager::$db_connection->prepare($query);
        $statment->bind_param('sssdds',
            $payment[DBContract::$PaymentDetails_Col_Name],
            $payment[DBContract::$PaymentDetails_Col_PaymentSchechule],
            $payment[DBContract::$PaymentDetails_Col_BillNbr],
            $payment[DBContract::$PaymentDetails_Col_AmountPaid],
            $payment[DBContract::$PaymentDetails_Col_BalanceAmount],
            $payment[DBContract::$PaymentDetails_Col_Date]
        );
        $statment->execute();
    }

    /**
     * returns an array containing all available payments
     * @param string order either @ASC for ascending or @DESC for descending
     * @return array
     */
    public function getAllPayments(string $order='ASC'){
        $query='SELECT * FROM '.DBContract::$PaymentDetails_TableName.' ORDER BY '.DBContract::$PaymentDetails_Col_AmountPaid.' '.$order;
        $result=DBManager::$db_connection->query($query);
        $payments=array();
        while ($row =$result->fetch_assoc())
            $payments[]=array(
                DBContract::$PaymentDetails_Col_Id=>$row[DBContract::$PaymentDetails_Col_Id],
                DBContract::$PaymentDetails_Col_Name=>$row[DBContract::$PaymentDetails_Col_Name],
                DBContract::$PaymentDetails_Col_PaymentSchechule=>$row[DBContract::$PaymentDetails_Col_PaymentSchechule],
                DBContract::$PaymentDetails_Col_BillNbr=>$row[DBContract::$PaymentDetails_Col_BillNbr],
                DBContract::$PaymentDetails_Col_AmountPaid=>$row[DBContract::$PaymentDetails_Col_AmountPaid],
                DBContract::$PaymentDetails_Col_BalanceAmount=>$row[DBContract::$PaymentDetails_Col_BalanceAmount],
                DBContract::$PaymentDetails_Col_Date=>$row[DBContract::$PaymentDetails_Col_Date]

            );
        return $payments;
    }

    /**
     * get payments details for the given id
     * @param int $paymentId
     * @return array
     */
    public function getPaymentById(int $paymentId):array{
        $query='SELECT * FROM '.DBContract::$PaymentDetails_TableName.' WHERE '.DBContract::$PaymentDetails_Col_Id.' ='.$paymentId;
        $result=DBManager::$db_connection->query($query);
        //$statment->bind_param('i',$paymentId);
        $payment=null;
        //$result=$statment->execute();
        while ($row =$result->fetch_assoc())
            $payment=array(
                DBContract::$PaymentDetails_Col_Id=>$row[DBContract::$PaymentDetails_Col_Id],
                DBContract::$PaymentDetails_Col_Name=>$row[DBContract::$PaymentDetails_Col_Name],
                DBContract::$PaymentDetails_Col_PaymentSchechule=>$row[DBContract::$PaymentDetails_Col_PaymentSchechule],
                DBContract::$PaymentDetails_Col_BillNbr=>$row[DBContract::$PaymentDetails_Col_BillNbr],
                DBContract::$PaymentDetails_Col_AmountPaid=>$row[DBContract::$PaymentDetails_Col_AmountPaid],
                DBContract::$PaymentDetails_Col_BalanceAmount=>$row[DBContract::$PaymentDetails_Col_BalanceAmount],
                DBContract::$PaymentDetails_Col_Date=>$row[DBContract::$PaymentDetails_Col_Date]

            );
        return $payment;
    }
    /**
     * get students and user count
     * @return int
     */
    public function getStudentsCount():int{
        $count_students_query='SELECT COUNT(*) AS count FROM '.DBContract::$Students_TableName;

        return DBManager::$db_connection->query($count_students_query)->fetch_assoc()['count'];
    }
    public function getCoursesCount():int{
        $count_courses_query='SELECT COUNT(*) AS count FROM '.DBContract::$Courses_TableName;
        return DBManager::$db_connection->query($count_courses_query)->fetch_assoc()['count'];
    }
    public function getPaymentsTotalAmount():int{
        $payments_total_query='SELECT SUM('.DBContract::$PaymentDetails_Col_AmountPaid.') AS sum FROM '.DBContract::$PaymentDetails_TableName;
        return DBManager::$db_connection->query($payments_total_query)->fetch_assoc()['sum'];
    }
    public function getUsersCount(){
        return $this->getStudentsCount();
    }
}