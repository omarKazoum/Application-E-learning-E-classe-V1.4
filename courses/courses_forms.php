<?php
require_once '../include/DBContract.php';
require_once '../include/DBManager.php';
require_once '../include/utils.php';
require_once 'constants.php';
$db_manager=DBManager::getInstance();

if($action==$ACTION_COURSES_ADD_FORM){?>
    <form action="courses.php?<?= "$ACTION_COURSES_KEY=$ACTION_COURSES_ADD_SUBMIT" ?>" method="POST">
        <h1>Add new Course</h1>
        <div class="form-group">
            <label for="<?= DBContract::$Courses_Col_Title?>">Course title</label>
            <input placeholder="Jump course"
                   type="text" class="form-control"
                   name="<?= DBContract::$Courses_Col_Title?>"
                   id="<?= DBContract::$Courses_Col_Title?>"
                   data-validate="1"
                   data-validate-pattern="^[a-zA-Z]\w{2,}$"
                   data-validate-message="Course title must contain at least 3 characters"
                   required>
        </div>
        <div class="form-group">
            <label for="<?= DBContract::$Courses_Col_MentorName?>">Mentor name</label>
            <input placeholder="Mr Jack" type="text" class="form-control"
                   name="<?= DBContract::$Courses_Col_MentorName?>"
                   id="<?= DBContract::$Courses_Col_MentorName?>"
                   data-validate="1"
                   data-validate-pattern="^[a-zA-Z]\w{2,}$"
                   data-validate-message="Mentor name must contain at least 3 characters"
                   required>
        </div>
        <div class="form-group">
            <label for="<?= DBContract::$Courses_Col_Date?>">Course Date</label>
            <input placeholder="2022-10-07" type="date" class="form-control" name="<?= DBContract::$Courses_Col_Date?>" id="<?= DBContract::$Courses_Col_Date?>" required>
        </div>
        <div class="form-group">
            <label for="<?= DBContract::$Courses_Col_Duration?>">Course Duration</label>
            <input type="time" min="00:15" max="08:00" value="01:00" class="form-control" name="<?= DBContract::$Courses_Col_Duration?>" id="<?= DBContract::$Courses_Col_Duration?>">
        </div>
        <input type="submit" class="btn btn-primary" value="Save">
    </form>
<?php }
elseif($action==$ACTION_COURSES_EDIT_FORM){
    $course=$db_manager->getCourseById($selected_course_id);
    ?>
    <form action="courses.php?<?= "$ACTION_COURSES_KEY=$ACTION_COURSES_EDIT_SUBMIT&$SELECTED_COURSE_ID_KEY=$selected_course_id" ?>" method="POST">
        <h1>Edit <?= $course[DBContract::$Courses_Col_Title]?> Course</h1>
        <div class="form-group">
            <label for="<?= DBContract::$Courses_Col_Title?>">Course title</label>
            <input  data-validate="1"
                    data-validate-pattern="^[a-zA-Z]\w{2,}$"
                    data-validate-message="Course title must contain at least 3 characters"
                    placeholder="Jump course"
                    type="text" class="form-control"
                    name="<?= DBContract::$Courses_Col_Title?>"
                    id="<?= DBContract::$Courses_Col_Title?>"
                    value="<?= $course[DBContract::$Courses_Col_Title]?>" required>
        </div>
        <div class="form-group">
            <label for="<?= DBContract::$Courses_Col_MentorName?>">Mentor name</label>
            <input placeholder="Mr Jack"
                   type="text"
                   class="form-control"
                   name="<?= DBContract::$Courses_Col_MentorName?>"
                   id="<?= DBContract::$Courses_Col_MentorName?>"
                   value="<?= $course[DBContract::$Courses_Col_MentorName]?>"
                   data-validate="1"
                   data-validate-pattern="^[a-zA-Z]\w{2,}$"
                   data-validate-message="Mentor name must contain at least 3 characters"
                   required>
        </div>
        <div class="form-group">
            <label for="<?= DBContract::$Courses_Col_Date?>">Course Date</label>
            <input placeholder="2022-10-07" type="date" class="form-control" name="<?= DBContract::$Courses_Col_Date?>" id="<?= DBContract::$Courses_Col_Date?>" value="<?= explode(' ',$course[DBContract::$Courses_Col_Date])[0]?>" required>
        </div>
        <div class="form-group">
            <label for="<?= DBContract::$Courses_Col_Duration?>">Course Duration</label>
            <input type="time" min="00:15" max="08:00" value="01:00" class="form-control" name="<?= DBContract::$Courses_Col_Duration?>" id="<?= DBContract::$Courses_Col_Duration?>" value="<?= $course[DBContract::$Courses_Col_Duration]?>">
        </div>
        <input type="submit" class="btn btn-primary" value="Save">
    </form>
    <?php
}
else echo 'action not handled yet';?>