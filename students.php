<?php
require_once 'include/DBManager.php';
require_once 'include/utils.php';
require_once 'students/constants.php';
redirectToLoginIfNotLogged();
$db_manager=DBManager::getInstance();
if($action==$ACTION_ADD_SUBMIT) {
    if (areAllStudentAddFieldsSetAndValid()) {
        $path=upload_profile_image();
        if(!$path){
            die('invalid image');
        }
        $db_manager->insertStudent(array(
            DBContract::$Students_Col_Name=>$_POST[DBContract::$Students_Col_Name],
            DBContract::$Students_Col_Image=>$path,
            DBContract::$Students_Col_Email=>$_POST[DBContract::$Students_Col_Email],
            DBContract::$Students_Col_Phone=>$_POST[DBContract::$Students_Col_Phone],
            DBContract::$Students_Col_EnrollNbr=>uniqid(),
            DBContract::$Students_Col_DateAdmission=>date('Y-m-d')
        ));
        $user_add_result = $USER_ADD_SUCCESS;
    } else
        $user_add_result = $USER_ADD_FAILED;
}else
    $user_add_result=$_GET[$USER_ADD_KEY]??$USER_ADD_NOT_SET;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/student.css">
</head>
<body>
<main class="container-fluid bg-gray">
    <div class="row">
        <?php include 'sidebar.php';?>
        <div class="col content">
            <?php include 'header.php';?>
                <div class="main-content row p-2 d-flex align-items-center">
                         <?php  if($action==$ACTION_VIEW){
                                 ?>
                             <?php if($user_add_result==$USER_ADD_SUCCESS){
                             ?>
                             <p class="alert alert-success col-12">
                                 Student is added successfully !
                             </p>
                         <?php }
                         if(isset($_GET["$user_delete_key"])){
                             ?>
                             <p class="alert alert-success col-12">
                                 Student is deleted successfully !
                             </p>
                             <?php
                         } ?>
                            <div class="col-12 main-content-toolbar d-flex pb-2 justify-content-between align-items-center border-bottom-light">
                                <h1 class="h5 fw-bold">Students List</h1>
                                <div class="toolbar-left-part">
                                    <a class="sort ic ic-sort btn btn-sort" title="sort button" href="students.php?<?= "$ORDER_KEY=$order_value_opposite"?>"></a>
                                    <a class="btn btn-primary btn-add-students" title="add student button"  href="students/student_dialog_forms.php?<?=$ACTION_GET_KEY.'='.$ACTION_ADD_FORM?>">ADD NEW STUDENT</a>
                                </div>
                            </div>
                            <div class="table-header row mb-2 d-none d-lg-flex">
                                <span class="offset-1 col-2 text-start">
                                    Name
                                </span>
                                <span class="col-2 text-start">
                                    Email
                                </span>
                                <span class="col-2 text-start">
                                    Phone
                                </span>
                                <span class="col-2 text-start">
                                    Enroll Number
                                </span>
                                <span class="col-3 text-start">
                                    Date of admission
                                </span>
                            </div>

                        <div class="row col-12 cards">
                            <?php
                                // let's fill the array with the students data
                                $students=$db_manager->getAllStudents($order_value);
                                // now let's print the data
                                foreach($students as $student){
                            ?>
                            <div class="col-12">
                                 <div class="card shadow">
                                <div class="card-body d-flex flex-column flex-md-row">
                                    <span class="col-md-1 col-auto d-flex justify-content-center">
                                        <img src="<?= $student[DBContract::$Students_Col_Image]?>" alt="" class="w-100 student-profile-image">
                                    </span>
                                    <span class="col-md-2 text-start userName">
                                        <?= $student[DBContract::$Students_Col_Name]?>
                                    </span>
                                    <span class="col-md-2 text-start">
                                        <?= $student[DBContract::$Students_Col_Email]?>
                                    </span>
                                    <span class="col-md-2 text-start">
                                        <?= $student[DBContract::$Students_Col_Phone]?>
                                    </span>
                                    <span class="col-md-2 text-start">
                                        <?= $student[DBContract::$Students_Col_EnrollNbr]?>
                                    </span>
                                    <span class="col-md-1 text-start">
                                        <?= $student[DBContract::$Students_Col_DateAdmission]?>
                                    </span>
                                    <span class="col-md-2 btns">
                                        <a class="ic ic-edit btn btn-edit" title="edit button" href="students/student_dialog_forms.php?<?= DBContract::$Students_Col_Id.'='.$student[DBContract::$Students_Col_Id].'&'.$ACTION_GET_KEY.'='.$ACTION_EDIT ?>">
                                        </a>
                                        <a class="ic ic-delete btn btn-delete" title="delete button" href="student_delete.php?<?= DBContract::$Students_Col_Id.'='.$student[DBContract::$Students_Col_Id] ?>">
                                        </a>
                                    </span>
                                </div>
                            </div>
                            </div>
                            <?php }?>
                        </div>
            <?php }
                                elseif($action==$ACTION_ADD_SUBMIT){
                            ?>
                        <script>
                           window.location.href="./students.php?<?="$ACTION_GET_KEY=$ACTION_VIEW&$USER_ADD_KEY=$user_add_result" ?>";
                        </script>
                    <?php } elseif($action==$ACTION_EDIT_SUBMIT){
                                    //now that we have the updated data let's save it
                                    $selected_student_id=$_GET[DBContract::$Students_Col_Id]??false;
                                        if(!$selected_student_id){
                                            echo 'no student id specified !';
                                            exit();
                                        }
                                        elseif(!areAllStudentAddFieldsSetAndValid()){
                                            echo 'please fill all the required fields';
                                            exit();
                                        }

                                        $old_student=$db_manager->getStudentByIdAsArray($selected_student_id);
                                        $profile_img_path=isset($_FILES[DBContract::$Students_Col_Image])?upload_profile_image():$old_student[DBContract::$Students_Col_Image];
                                        $db_manager->updateStudent($selected_student_id,array(
                                            DBContract::$Students_Col_Image=>$profile_img_path,
                                            DBContract::$Students_Col_Name=>$_POST[DBContract::$Students_Col_Name],
                                            DBContract::$Students_Col_Email=>$_POST[DBContract::$Students_Col_Email],
                                            DBContract::$Students_Col_Phone=>$_POST[DBContract::$Students_Col_Phone],
                                            DBContract::$Students_Col_EnrollNbr=>$old_student[DBContract::$Students_Col_EnrollNbr],
                                            DBContract::$Students_Col_DateAdmission=>$old_student[DBContract::$Students_Col_DateAdmission]
                                        ));
                                        redirect_with_js("students.php?$ACTION_GET_KEY=$ACTION_VIEW");
                                     }?>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody">

            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'?>
<script src="js/students.js"></script>

</body>
</html>