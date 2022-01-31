<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * configures file mode can be either of value 'JSON' for JSON files or 'CSV' for CSV file format
 */
define('FILE_MODE','JSON');
$STUDENTS_JSON_FILE_PATH='data/students.json';
$PAYMENTS_JSON_FILE='data/payments.json';
/**
 * constants for students data in the forms and the files (JSON/CSV)
 */
$STUDENT_ID='sid';
$STUDENT_NAME='student_name';
$STUDENT_EMAIL='student_email';
$STUDENT_PHONE='student_phone';
$STUDENT_ENROLL_NBR='enroll_number';
$STUDENT_ADMISSION_DATE='date_admission';

/**
 * @param string $json_file_name
 * @return array an associative array containing loaded data from the json file
 */
function loadAndDecodeJsonFile(string $json_file_name):array{
    if(!file_exists($json_file_name))
        file_put_contents($json_file_name,'');
    $data=json_decode(file_get_contents($json_file_name),true);
    return $data==null ? array():$data;
}
/**
 * @param string $csv_filen_name
 * @return array
 */
function loadAndDecodeCSVFIle(string $csv_filen_name):array{
    $file =fopen($csv_filen_name,'r');
    $data=array();
    while(!feof($file)){
        $data[]=fgetcsv($file);
    }
    fclose($file);
    return $data;
}
/**
 * used to retreive students's data from the data
 * @return array
 */
function getStudentsData():array{
    if(constant('FILE_MODE')=='JSON'){
        return loadAndDecodeJsonFile($GLOBALS['STUDENTS_JSON_FILE_PATH']);
    }elseif(constant('FILE_MODE')=='CSV'){
        $csvArray=loadAndDecodeCSVFIle('data/students.csv');
        for($i=1;$i<sizeof($csvArray)-1;$i++) {
            $data[]=array(
                'id'=>$csvArray[$i][0],
                'name'=>$csvArray[$i][1],
                'email'=>$csvArray[$i][2],
                'phone'=>$csvArray[$i][3],
                'enrolNbr'=>$csvArray[$i][4],
                'dateAdmission'=>$csvArray[$i][5]);
        }
        return $data;
    }
    else return array();
}
/**
 * used to retreive payments's data from the data
 * @return array
 */
function getPaymentsData():array{
    if(constant('FILE_MODE')=='JSON'){
        return loadAndDecodeJsonFile($GLOBALS['PAYMENTS_JSON_FILE']);
    }elseif(constant('FILE_MODE')=='CSV'){

        $csvArray=loadAndDecodeCSVFIle('data/payments.csv');
        for($i=1;$i<sizeof($csvArray)-1;$i++) {
            $data[]=array(
                'id'=>$csvArray[$i][0],
                'name'=>$csvArray[$i][1],
                'paymentSchudule'=>$csvArray[$i][2],
                'billNumber'=>$csvArray[$i][3],
                'amountPaid'=>$csvArray[$i][4],
                'balanceAmount'=>$csvArray[$i][5],
                'date'=>$csvArray[$i][6]);
        }
        return $data;
    }

    else return array();
}
function getStudentsIndex():int{
    $file_path='data/studentsCount';
    if(!file_exists($file_path)) {
        $file_pointer=fopen($file_path,'w');
        fclose($file_pointer);
    }
    $index=file_get_contents($file_path);
    return $index !=null? $index:0;
}
function increamentStudentsIndex(){
    $index=getStudentsIndex()+1;
    return file_put_contents('data/studentsCount',$index);
}
function addStudentInCSV(array $studentData){

}
/**
 * takes post data and adds astudent with it or shows an error
 * @param array $studentData an array containing the student data
 * @return bool weather the opertaion was successfull or not
 */
function addStudentFromPostFields(){
    global $STUDENT_ID,$STUDENT_NAME,$STUDENT_EMAIL,$STUDENT_PHONE,$STUDENT_ENROLL_NBR,$STUDENT_ADMISSION_DATE;
    $new_student=array(
        $STUDENT_ID=>increamentStudentsIndex(),
        $STUDENT_NAME=>$_POST[$STUDENT_NAME],
        $STUDENT_EMAIL=>$_POST[$STUDENT_EMAIL],
        $STUDENT_PHONE=>$_POST[$STUDENT_PHONE],
        $STUDENT_ENROLL_NBR=>uniqid(),
        $STUDENT_ADMISSION_DATE=>date('d-M,Y\s'));
    if(constant('FILE_MODE')=='JSON')
        addStudentToJson($new_student);
}
function addStudentToJson(array $studentToAdd){
    global $STUDENTS_JSON_FILE_PATH;
    $students=loadAndDecodeJsonFile($STUDENTS_JSON_FILE_PATH);
    $students[]=$studentToAdd;
    file_put_contents($STUDENTS_JSON_FILE_PATH,json_encode($students));
}


function areAllSuserAddFieldsSetAndValid():bool{
    global $STUDENT_NAME,$STUDENT_EMAIL,$STUDENT_PHONE;
    $studentFields=array($STUDENT_NAME,$STUDENT_EMAIL,$STUDENT_PHONE);
    return areAllFieldsSet($studentFields,'POST');
}

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

function deleteStudent($id){
    if(constant('FILE_MODE')=='JSON'){
        global  $STUDENTS_JSON_FILE_PATH,$STUDENT_ID;
        $students=loadAndDecodeJsonFile($STUDENTS_JSON_FILE_PATH);
        $index=-1;
        foreach ($students as $k => $v){
            if($v[$STUDENT_ID]==$id) {
                $index =$k;
                echo 'user found in index:'.$k;
                break;
            }
        }
        if($index!=-1){
            echo '<br>students length before:'.count($students);
            unset($students[$index]);
            echo '<br>students length after:'.count($students);
            file_put_contents($STUDENTS_JSON_FILE_PATH,json_encode($students));
        }else{
            die ('trying to delete a student that does not exist!');
        }
    }
}