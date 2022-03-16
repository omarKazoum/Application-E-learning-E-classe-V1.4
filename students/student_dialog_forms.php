<?php
require_once '../include/utils.php';
require_once 'constants.php';

if($action==$ACTION_ADD_FORM){
    ?>
    <form action="students.php?<?=$ACTION_GET_KEY.'='.$ACTION_ADD_SUBMIT?>" method="post" class=" col-12 " enctype="multipart/form-data">
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
elseif($action==$ACTION_EDIT){
    if(!isset($_GET[DBContract::$Students_Col_Id])){
        ?>
        <div class="alert alert-warning">
            No Student specified
        </div>
    <?php }
    else{
        $db_manager=DBManager::getInstance();
        $student=$db_manager->getStudentByIdAsArray($_GET[DBContract::$Students_Col_Id])
        ?>
        <form action="students.php?<?=$ACTION_GET_KEY.'='.$ACTION_EDIT_SUBMIT.'&'.DBContract::$Students_Col_Id.'='.$student[DBContract::$Students_Col_Id]?>" method="post" class=" col-12 " enctype="multipart/form-data">
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
