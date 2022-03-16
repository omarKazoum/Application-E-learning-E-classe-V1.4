<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/include/AccountManager.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/include/DBContract.php';
/**
 * repetitive code amongst all the pages
 **/
$ORDER_KEY='o';
$ORDER_ASC='ASC';
$ORDER_DESC='DESC';
$order_value=isset($_GET[$ORDER_KEY]) && ($_GET[$ORDER_KEY] ==$ORDER_ASC OR $_GET[$ORDER_KEY] ==$ORDER_DESC )? $_GET[$ORDER_KEY]:$ORDER_DESC;
$order_value_opposite=$order_value==$ORDER_ASC?$ORDER_DESC:$ORDER_ASC;

const MESSAGE_TYPE_KEY='message_type';
const MESSAGE_TYPE_SUCCESS='message_type_succes';
const MESSAGE_TYPE_ERROR='message_type_error';
const MESSAGE_TXT_KEY='message_text';

function areAllStudentAddFieldsSetAndValid():bool{
    $studentFields=array(DBContract::$Students_Col_Name,DBContract::$Students_Col_Email,DBContract::$Students_Col_Phone);
    return areAllFieldsSet($studentFields,'POST');
}
function AreAllStudentSignUpFieldsSet():bool{
    $studentFields=array(
        DBContract::$Students_Col_Name,
        DBContract::$Students_Col_Email,
        DBContract::$Students_Col_Email2,
        DBContract::$Students_Col_Phone,
        DBContract::$Students_Col_Password,
        DBContract::$Students_Col_Password2,
    );
    return areAllFieldsSet($studentFields,'POST');
}
function areAllCourseFieldsSetAndValid():bool{
    $courseFields=array(
        DBContract::$Courses_Col_Title
        ,DBContract::$Courses_Col_MentorName
        ,DBContract::$Courses_Col_Date
        ,DBContract::$Courses_Col_Duration);
    return areAllFieldsSet($courseFields,'POST');

}
/**
 * prints a Javascript code that will change window location to the given location
 * @param $location
 * @return void
 */
function redirect_with_js($location){
    ?>
    <script>
        window.location.href='<?=$location ?>';
    </script>
<?php }
/**
 * checks if all the request data is supplied in the required method
 * @param array $fields
 * @param string $method
 * @return bool
 */
function areAllFieldsSet(array $fields,string $method) :bool{

    foreach ($fields as $field){
        if(($method =='GET' and !isset($_GET[$field])) or ($method =='POST' and !isset($_POST[$field]) ))
            return false;
    }
    return true;
}
function upload_profile_image($img_old_name=false):string{
    if(isset($_FILES[DBContract::$Students_Col_Image])) {
        $temp_path = $_FILES[DBContract::$Students_Col_Image]['tmp_name'];
        $img_data = getimagesize($temp_path);
        $img_type=basename($img_data['mime']);
        echo 'type '.$img_type;
        if ($img_data and in_array($img_type, DBContract::$Students_ProfileImgAcceptedTypes)) {
            if(!$img_old_name) {
                $new_path = 'uploads/images/profile_' . time() . rand(0, 100000) . '_img.' . $img_type;
                while (file_exists($new_path)) {
                    $new_path = 'uploads/images/profile_' . time() . rand(0, 100000) . '_img.' . $img_type;
                }
            }else{
                $new_path=$img_old_name;
            }
            if (move_uploaded_file($temp_path,$new_path )) {
                echo 'file moved to the dir';
            };
        } else
            return false;
    }
    return $new_path??'';
}
function redirectToLoginIfNotLogged(){
    if(!AccountManager::getInstance()->isLoggedIn()){
        header('location:index.php');
        exit();
    }
}
function saveLoginDataInACookie(){
    $cookie_life_time_seconds=365*24*60*60;
    setcookie(DBContract::$Users_RememberMe, isset($_POST[DBContract::$Users_RememberMe]),time()+$cookie_life_time_seconds,'/','',false,true);
    setcookie(DBContract::$Users_RememberMe_Email,$_POST[DBContract::$Users_Col_Email],time()+$cookie_life_time_seconds,'/','',false,true);
    setcookie(AccountManager::IS_ADMIN_KEY,isset($_POST[AccountManager::IS_ADMIN_KEY]),time()+$cookie_life_time_seconds,'/','',false,true);
    setcookie(DBContract::$Users_RememberMe_Pass,$_POST[DBContract::$Users_Password],time()+$cookie_life_time_seconds,'/','',false,true);

}
function deleteLoginDataInCookie(){
    setcookie(DBContract::$Users_RememberMe,'',time()-10);
    setcookie(DBContract::$Users_RememberMe_Email,'',time()-10);
    setcookie(AccountManager::IS_ADMIN_KEY,'',time()-10);
    setcookie(DBContract::$Users_RememberMe_Pass,'',time()-10);

}
function loadLoggingDataFromACookie(){
    $GLOBALS[DBContract::$Users_RememberMe_Email]=$_COOKIE[DBContract::$Users_RememberMe_Email]??null;
    $GLOBALS[DBContract::$Users_RememberMe_Pass]=$_COOKIE[DBContract::$Users_RememberMe_Pass]??null;
    $GLOBALS[DBContract::$Users_RememberMe]=$_COOKIE[DBContract::$Users_RememberMe]??false;
    $GLOBALS[AccountManager::IS_ADMIN_KEY]=$_COOKIE[AccountManager::IS_ADMIN_KEY]??null;
}
function printMessageIfexists($optionalCssClassForTheAlert=''){
    if(isset($_GET[MESSAGE_TXT_KEY])){?>
        <div class="alert alert-<?=
        (isset($_GET[MESSAGE_TYPE_KEY]) ?($_GET[MESSAGE_TYPE_KEY]==MESSAGE_TYPE_SUCCESS?'success':'danger'):'warning').' '.$optionalCssClassForTheAlert ?>">
            <?= $_GET[MESSAGE_TXT_KEY] ?? ''?>
        </div>
        <?php
    }
}
function redirectWithMessage($url,$messageType,$message){
    header("location:$url".(strpos($url,'?')!==false?'&':'?').MESSAGE_TXT_KEY.'='.$message.'&'.MESSAGE_TYPE_KEY.'='.$messageType);
}
function getUrlFor($url_relative_to_root):string{
    return "http://" . $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/'.$url_relative_to_root;
}
