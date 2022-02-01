<pre>
<?php
    require_once('include/DBManager.php');
    $db_manager=DBManager::getInstance();
    //$db_manager->install();//optional
    $db_manager->connect();
    /*
    $db_manager->insertStudent(array(
            DBContract::$Students_Col_Name=>'omar',
        DBContract::$Students_Col_Email=>'omar@kazoum.com',
        DBContract::$Students_Col_DateAdmission=>date('Y-m-d'),
        DBContract::$Students_Col_EnrollNbr=>uniqid(),
        DBContract::$Students_Col_Phone=>'0610204662'
        ));
    */
    //print_r($db_manager->getAllStudents());
    /*$s=array(
        DBContract::$Students_Col_Name=>'khalil',
        DBContract::$Students_Col_Email=>'email@gmail.com',
        DBContract::$Students_Col_Phone=>'9988887',
        DBContract::$Students_Col_EnrollNbr=>uniqid(),
        DBContract::$Students_Col_DateAdmission=>date('Y-m-d'));
    echo '<br>we will upate with <br>';
    print_r($s);
    $db_manager->updateStudent(3,$s);
    */
    //$db_manager->deleteStudent(6);
    /*$db_manager->insertCourse(array(DBContract::$Courses_Col_Title=>'some course title',
        DBContract::$Courses_Col_MentorName=> 'omar is a mentor',
        DBContract::$Courses_Col_Date=>date('Y-m-d'),
        DBContract::$Courses_Col_Duration=>date('Y-d-m ')));
    print_r($db_manager->getAllCourses());
    */
    //$db_manager->deleteCourse(1);
    /*$db_manager->insertPayment(array(DBContract::$PaymentDetails_Col_Name=>'1th',
        DBContract::$PaymentDetails_Col_PaymentSchechule=>'sche',
        DBContract::$PaymentDetails_Col_BillNbr=>'sdqsd88776',
        DBContract::$PaymentDetails_Col_AmountPaid=>1212.09,
        DBContract::$PaymentDetails_Col_BalanceAmount=>6466.9,
        DBContract::$PaymentDetails_Col_Date=>date('Y-m-d')));
    print_r($db_manager->getAllPayments());
    */
    //echo 'done';
    //echo 'search with id \n';
    //print_r($db_manager->getPaymentById(4));

?>
</pre>

