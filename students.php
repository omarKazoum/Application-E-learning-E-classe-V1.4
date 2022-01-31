<?php

require_once 'include/utils.php';
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

$user_delete_key='user_delete';
if($action==$ACTION_ADD_SUBMIT) {
    if (areAllSuserAddFieldsSetAndValid()) {
        addStudentFromPostFields();
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
                <div class="col-12 main-content-toolbar d-flex pb-2 justify-content-between align-items-center border-bottom-light">
                    <?php
                        //starting the condition for changing page functionality
                        if($action==$ACTION_VIEW){?>
                    <h1 class="h5 fw-bold">Students List</h1>
                    <div class="toolbar-left-part">
                        <button class="sort ic ic-sort btn btn-sort" title="sort button"></button>
                        <a class="btn btn-primary btn-add-students" title="add student button"  href="students.php?<?=$ACTION_GET_KEY.'='.$ACTION_ADD_FORM?>">ADD NEW STUDENT</a>
                    </div>
                </div>
                    <?php if($user_add_result==$USER_ADD_SUCCESS){
                        ?>
                        <p class="alert alert-success">
                            Student is added successfully !
                        </p>
                    <?php }?>
                    <?php
                        if(isset($_GET["$user_delete_key"])){
                            ?>
                            <p class="alert alert-success">
                                Student is deleted successfully !
                            </p>
                    <?php
                        }
                    ?>
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
                        $students=getStudentsData();
                        // now let's print the data
                        foreach($students as $student){
                    ?>
                    <div class="col-12">
                         <div class="card shadow">
                        <div class="card-body d-flex flex-column flex-md-row">
                            <span class="col-md-1 col-auto">
                                <img src="images/student-img.jfif" alt="" class="w-100">
                            </span>
                            <span class="col-lg-2 text-start">
                                <?php echo $student[$GLOBALS['STUDENT_NAME']];?>
                            </span>
                            <span class="col-lg-2 text-start">
                                <?php echo $student[$GLOBALS['STUDENT_EMAIL']];?>
                            </span>
                            <span class="col-lg-2 text-start">
                                <?php echo $student[$GLOBALS['STUDENT_PHONE']];?>
                            </span>
                            <span class="col-lg-2 text-start">
                                <?php echo $student[$GLOBALS['STUDENT_ENROLL_NBR']];?>
                            </span>
                            <span class="col-lg-2 text-start">
                                <?php echo $student[$GLOBALS['STUDENT_ADMISSION_DATE']];?>
                            </span>
                            <span class="col-lg-1 btns">
                                <a class="ic ic-edit btn btn-edit" title="edit button" href="students.php?<?= $GLOBALS['STUDENT_ID'].'='.$student[$GLOBALS['STUDENT_ID']].'&'.$ACTION_GET_KEY.'='.$ACTION_EDIT ?>">
                                </a>
                                <a class="ic ic-delete btn btn-delete" title="delete button" href="student_delete.php?id=<?= $student[$GLOBALS['STUDENT_ID']] ?>">
                                </a>
                            </span>
                        </div>
                    </div>
                    </div>
                    <?php }?>
                    <?php
                    }// end of the first action (view) content
                    elseif($action==$ACTION_ADD_FORM){
                        ?>
                        <form action="students.php?<?=$ACTION_GET_KEY.'='.$ACTION_ADD_SUBMIT?>" method="post" class=" col-12 col-md-6 offset-md-3">

                            <div class="form-group justify-content-between">
                                <label for="<?= $GLOBALS['STUDENT_NAME'] ;?>">Student name:</label>
                                <input type="text" class="form-control"  required name="<?= $GLOBALS['STUDENT_NAME'] ;?>">
                            </div>
                            <div class="form-group justify-content-between">
                                <label for="<?= $GLOBALS['STUDENT_EMAIL'] ;?>">Student Email</label>
                                <input type="email" class="form-control" required name="<?= $GLOBALS['STUDENT_EMAIL'] ;?>">
                            </div>
                            <div class="form-group  justify-content-between">
                                <label for="<?= $GLOBALS['STUDENT_PHONE'] ;?>">Student Phone Number</label>
                                <input type="phone" class="form-control" required name="<?= $GLOBALS['STUDENT_PHONE'] ;?>">
                            </div>
                            <input type="submit" value="ADD STUDENT" class="btn btn-primary">
                        </form>
                    <?php }
                        elseif($action==$ACTION_ADD_SUBMIT){
                            ?>
                        <script>
                            window.location.href="./students.php?+<?="$ACTION_GET_KEY=$ACTION_VIEW&$USER_ADD_KEY=$user_add_result" ?>";
                        </script>
                    <?php
                        }elseif($action==$ACTION_EDIT){
                            $student=getSt
                            ?>
                        <form action="students.php?<?=$ACTION_GET_KEY.'='.$ACTION_ADD_SUBMIT?>" method="post" class=" col-12 col-md-6 offset-md-3">

                            <div class="form-group justify-content-between">
                                <label for="<?= $GLOBALS['STUDENT_NAME'] ;?>">Student name:</label>
                                <input type="text" class="form-control"  required name="<?= $GLOBALS['STUDENT_NAME'] ;?>" >
                            </div>
                            <div class="form-group justify-content-between">
                                <label for="<?= $GLOBALS['STUDENT_EMAIL'] ;?>">Student Email</label>
                                <input type="email" class="form-control" required name="<?= $GLOBALS['STUDENT_EMAIL'] ;?>">
                            </div>
                            <div class="form-group  justify-content-between">
                                <label for="<?= $GLOBALS['STUDENT_PHONE'] ;?>">Student Phone Number</label>
                                <input type="phone" class="form-control" required name="<?= $GLOBALS['STUDENT_PHONE'] ;?>">
                            </div>
                            <input type="submit" value="ADD STUDENT" class="btn btn-primary">
                        </form>

                    <?php }elseif($action==$ACTION_EDIT_SUBMIT){ ?>

                        handle the edit request
                    <?php }?>
                </div>

            </div>
        </div>
    </div>
</main>
<?php include 'footer.php'?>

</body>
</html>