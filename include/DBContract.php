<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
class DBContract
{
    // for students table
    public static string $Students_TableName='students';
    public static string $Students_Col_Id='id';
    public static string $Students_Col_Image='image';
    public static string $Students_Col_Name='name';
    public static string $Students_Col_Email='email';
    public static string $Students_Col_Phone='phone';
    public static string $Students_Col_EnrollNbr='enrollNbr';
    public static string $Students_Col_DateAdmission='dateAdmission';
    public static string $Students_Col_PasswordHash='password_hash';
    //not stored
    public static string $Students_Col_Email2='email2';
    public static string $Students_Col_Password='password';
    public static string $Students_Col_Password2='password2';
    public static $Students_ProfileImgAcceptedTypes=['jpg','png','gif','jpeg'];
    //for users table
    public static string $Users_TableName='comptes';
    public static string $Users_Col_Id='id';
    public static string $Users_Col_Email='email';
    public static string $Users_Col_UserName='name';
    public static string $Users_Col_PasswordHash='pass_hash';
    public static string $Users_Password='pass';
    public static string $Users_RememberMe='rememberme';
    public static string $Users_RememberMe_Email='rememberme_email';
    public static string $Users_RememberMe_Pass='rememberme_pass';
    //for payment_details table
    public static string $PaymentDetails_TableName='payments_details';
    public static string $PaymentDetails_Col_Id='id';
    public static string $PaymentDetails_Col_Name='name';
    public static string $PaymentDetails_Col_PaymentSchechule='payments_schedule';
    public static string $PaymentDetails_Col_BillNbr='bill_number';
    public static string $PaymentDetails_Col_AmountPaid='amount_paid';
    public static string $PaymentDetails_Col_BalanceAmount='balance_amount';
    public static string $PaymentDetails_Col_Date='date';
    //for courses table
    public static string $Courses_TableName='courses';
    public static string $Courses_Col_Id='id';
    public static string $Courses_Col_Title='title';
    public static string $Courses_Col_MentorName='mentor_name';
    public static string $Courses_Col_Date='date';
    public static string $Courses_Col_Duration='duration';
    //not saved
    public static string $Users_IsAdmin='isAdmin';
}