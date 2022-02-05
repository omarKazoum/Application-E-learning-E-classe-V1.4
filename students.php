<?php

require_once 'include/DBManager.php';
require_once 'include/utils.php';
$db_manager=DBManager::getInstance();
$ORDER_BY_KEY='ob';
$ORDER_BY_ASC='oba';
$ORDER_BY_DESC='obd';
$ACTION_VIEW='av';
$ACTION_VIEW='av';
$ACTION_ADD_FORM='aaf';
$ACTION_ADD_SUBMIT='aas';
$ACTION_EDIT='ase';
$ACTION_EDIT_SUBMIT='ases';
$ACTION_GET_KEY='a';
$action=isset($_GET[$ACTION_GET_KEY])?$_GET[$ACTION_GET_KEY]:$ACTION_VIEW;
$USER_ADD_SUCCESS='user-add-success';
$USER_ADD_FAILED='user-add-failed';
$USER_ADD_NOT_SET=false;
$USER_ADD_KEY='user-add';
$user_add_result=isset($_GET[$USER_ADD_KEY])?$_GET[$USER_ADD_KEY]:$USER_ADD_NOT_SET;
//saving newly added student
$user_delete_key='user_delete';
if($action==$ACTION_ADD_SUBMIT) {
    if (areAllStudentAddFieldsSetAndValid()) {
        // let's handle the image download if it's provided
        $path=upload_profile_image();
        if(!$path){
            //the image is not of a valid format
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
    $user_add_result=isset($_GET[$USER_ADD_KEY])?$_GET[$USER_ADD_KEY]:$USER_ADD_NOT_SET;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Students</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
                            <div class="col-12 main-content-toolbar d-flex pb-2 justify-content-between align-items-center border-bottom-light">
                                <h1 class="h5 fw-bold">Students List</h1>
                                <div class="toolbar-left-part">
                                    <a class="sort ic ic-sort btn btn-sort" title="sort button" href="students.php?<?= "$ORDER_KEY=$order_value_opposite"?>"></a>
                                    <a class="btn btn-primary btn-add-students" title="add student button"  href="students.php?<?=$ACTION_GET_KEY.'='.$ACTION_ADD_FORM?>">ADD NEW STUDENT</a>
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
                        <?php if($user_add_result==$USER_ADD_SUCCESS){
                            ?>
                            <p class="alert alert-success">
                                Student is added successfully !
                            </p>
                        <?php }
                        if(isset($_GET["$user_delete_key"])){
                            ?>
                            <p class="alert alert-success">
                                Student is deleted successfully !
                            </p>
                            <?php
                        } ?>
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
                                    <span class="col-md-1 col-auto">
                                        <img src="<?= $student[DBContract::$Students_Col_Image]?>" alt="" class="w-100">
                                    </span>
                                    <span class="col-md-2 text-start">
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
                                        <a class="ic ic-edit btn btn-edit" title="edit button" href="students.php?<?= DBContract::$Students_Col_Id.'='.$student[DBContract::$Students_Col_Id].'&'.$ACTION_GET_KEY.'='.$ACTION_EDIT ?>">
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
                                elseif($action==$ACTION_ADD_FORM){
                                ?>
                                <form action="students.php?<?=$ACTION_GET_KEY.'='.$ACTION_ADD_SUBMIT?>" method="post" class=" col-12 col-md-6 offset-md-3" enctype="multipart/form-data">
                                    <h1 class="h5 fw-bold">Add a new Student</h1>
                                    <div class="form-group justify-content-between">
                                        <label for="<?= DBContract::$Students_Col_Name;?>">Student name:</label>
                                        <input type="text" class="form-control"  required name="<?= DBContract::$Students_Col_Name ;?>">
                                    </div>
                                    <div class="form-group justify-content-between">
                                        <label for="<?= DBContract::$Students_Col_Image;?>">Student image:</label>
                                        <input type="file" placeholder="JPG/PNG" class="form-control-file" name="<?= DBContract::$Students_Col_Image ;?>">
                                    </div>
                                    <div class="form-group justify-content-between">
                                        <label for="<?= DBContract::$Students_Col_Email ;?>">Student Email</label>
                                        <input type="email" class="form-control" required name="<?= DBContract::$Students_Col_Email ;?>">
                                    </div>
                                    <div class="form-group  justify-content-between">
                                        <label for="<?= DBContract::$Students_Col_Phone ;?>">Student Phone Number</label>
                                        <input type="phone" class="form-control" required name="<?= DBContract::$Students_Col_Phone ;?>">
                                    </div>
                                    <input type="submit" value="ADD STUDENT" class="btn btn-primary" name="submit">
                                </form>
                                    <?php }
                                elseif($action==$ACTION_ADD_SUBMIT){
                            ?>
                        <script>
                           window.location.href="./students.php?<?="$ACTION_GET_KEY=$ACTION_VIEW&$USER_ADD_KEY=$user_add_result" ?>";
                        </script>
                    <?php
                        }
                                elseif($action==$ACTION_EDIT){
                                    if(!isset($_GET[DBContract::$Students_Col_Id])){
                                ?>
                                    <div class="alert alert-warning">
                                        No Student specified
                                    </div>
                                 <?php }
                                    else{
                                            $student=$db_manager->getStudentById($_GET[DBContract::$Students_Col_Id])
                                            ?>

                                            <form action="students.php?<?=$ACTION_GET_KEY.'='.$ACTION_EDIT_SUBMIT.'&'.DBContract::$Students_Col_Id.'='.$student[DBContract::$Students_Col_Id]?>" method="post" class=" col-12 col-md-6 offset-md-3" enctype="multipart/form-data">
                                                    <h1 class="h5 fw-bold">Edit Student</h1>
                                                    <div class="form-group  justify-content-between">
                                                        <label for="<?= DBContract::$Students_Col_EnrollNbr ;?>">Student Enroll Number</label>
                                                        <input type="text" class="form-control" disabled value="<?= $student[DBContract::$Students_Col_EnrollNbr] ?>">
                                                    </div>
                                                    <div class="form-group justify-content-between">
                                                        <label for="<?= DBContract::$Students_Col_Name ;?>">Student name:</label>
                                                        <input type="text" class="form-control"  required name="<?= DBContract::$Students_Col_Name ;?>" value="<?= $student[DBContract::$Students_Col_Name] ?>" >
                                                    </div>
                                                    <div class="form-group justify-content-between">
                                                        <label for="<?= DBContract::$Students_Col_Image;?>">Student image:</label>
                                                        <img src="<?= $student[DBContract::$Students_Col_Image] ?>" width='100px' height="100px" alt="profile image">
                                                        <input type="file" class="form-control-file" name="<?= DBContract::$Students_Col_Image ;?>">
                                                    </div>
                                                    <div class="form-group  justify-content-between">
                                                        <label for="<?= DBContract::$Students_Col_DateAdmission ;?>">Student Admission Date</label>
                                                        <input type="date" class="form-control" disabled value="<?= $student[DBContract::$Students_Col_DateAdmission] ?>">
                                                    </div>

                                                    <div class="form-group justify-content-between">
                                                        <label for="<?= DBContract::$Students_Col_Email ;?>">Student Email</label>
                                                        <input type="email" class="form-control" required name="<?= DBContract::$Students_Col_Email ;?>" value="<?= $student[DBContract::$Students_Col_Email] ?>">
                                                    </div>
                                                    <div class="form-group  justify-content-between">
                                                        <label for="<?= DBContract::$Students_Col_Phone ;?>">Student Phone Number</label>
                                                        <input type="phone" class="form-control" required name="<?= DBContract::$Students_Col_Phone ;?>" value="<?= $student[DBContract::$Students_Col_Phone] ?>">
                                                    </div>

                                                    <input type="submit" value="SAVE" class="btn btn-primary">
                                             </form>

                                        <?php }
                                                }
                                elseif($action==$ACTION_EDIT_SUBMIT){
                                    //now that we have the updated data let's save it
                                    $selected_student_id=isset($_GET[DBContract::$Students_Col_Id])?$_GET[DBContract::$Students_Col_Id]:false;
                                        if(!$selected_student_id){
                                            echo 'no student id specified !';
                                            exit();
                                        }
                                        elseif(!areAllStudentAddFieldsSetAndValid()){
                                            echo 'please fill all the required fields';
                                            exit();
                                        }

                                        $old_student=$db_manager->getStudentById($selected_student_id);
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
<?php include 'footer.php'?>

</body>
</html>