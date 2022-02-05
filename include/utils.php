<?php
/**
 * repetitive code amongst all the pages
 **/
 $ORDER_KEY='o';
$ORDER_ASC='ASC';
$ORDER_DESC='DESC';
$order_value=isset($_GET[$ORDER_KEY]) && ($_GET[$ORDER_KEY] ==$ORDER_ASC OR $_GET[$ORDER_KEY] ==$ORDER_DESC )? $_GET[$ORDER_KEY]:$ORDER_DESC;
$order_value_opposite=$order_value==$ORDER_ASC?$ORDER_DESC:$ORDER_ASC;


function areAllStudentAddFieldsSetAndValid():bool{
    $studentFields=array(DBContract::$Students_Col_Name,DBContract::$Students_Col_Email,DBContract::$Students_Col_Phone);
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
    return $new_path;
}