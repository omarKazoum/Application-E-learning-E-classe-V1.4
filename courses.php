<?php
require_once 'include/DBManager.php';
require_once 'include/utils.php';
redirectToLoginIfNotLogged();

$db_manager=DBManager::getInstance();
$ACTION_COURSES_LIST='courses_view';
$ACTION_COURSES_EDIT_FORM='cef';
$ACTION_COURSES_EDIT_SUBMIT='ces';
$ACTION_COURSES_ADD_FORM='caf';
$ACTION_COURSES_ADD_SUBMIT='cas';
$ACTION_COURSES_DELETE='cd';
$ACTION_COURSES_KEY='a';
$SELECTED_COURSE_ID_KEY='c';
$selected_course_id=isset($_GET[$SELECTED_COURSE_ID_KEY])?$_GET[$SELECTED_COURSE_ID_KEY]:-1;
$action=isset($_GET[$ACTION_COURSES_KEY])?$_GET[$ACTION_COURSES_KEY]:$ACTION_COURSES_LIST;

$MSG_KEY='m';
$msg=isset($_GET[$MSG_KEY])?$_GET[$MSG_KEY]:false;
$MSG_TYPE_KEY='mt';
$MSG_TYPE_POSITIVE='mtp';
$MSG_TYPE_NEGATIVE='mtn';
$msg_type=isset($_GET[$MSG_TYPE_KEY])?$_GET[$MSG_TYPE_KEY]:false;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/payments.css">
    <title>Courses</title>
</head>
<body>
<main class="container-fluid bg-gray">
    <div class="row">
        <?php include 'sidebar.php'; ?>
        <div class="col content">
            <?php include 'header.php'; ?>
            <div class="main-content row p-2 d-flex align-items-center">
                <div class="row p-2 d-flex align-items-center">
                    <?php
                        if($msg){ ?>
                        <div class="alert <?= ($msg_type==$MSG_TYPE_NEGATIVE?'alert-danger':'').($msg_type==$MSG_TYPE_POSITIVE?'alert-success':'')?>">
                            <?= $msg?>
                        </div>
                    <?php }?>
                    <?php if($action==$ACTION_COURSES_LIST){?>
                                <div class="col-12 main-content-toolbar d-flex pb-2 justify-content-between align-items-center border-bottom-light">
                                    <h1 class="h4 fw-bold">Available Courses </h1>
                                    <div class="toolbar-left-part">
                                        <a class="sort ic ic-sort btn btn-sort" title="sort button" href="courses.php?<?= "$ORDER_KEY=$order_value_opposite"?>"></a>
                                        <a href="courses.php?<?= "$ACTION_COURSES_KEY=$ACTION_COURSES_ADD_FORM"?>" class="btn btn-primary">Add A course</a>
                                    </div>
                                </div>
                                <div class="col-12 table-header d-none d-lg-flex row mb-2 ps-lg-4">
                                    <span class="col-3 text-start ps-3">Title</span>
                                    <span class="col-3 text-start">Mentor Name</span>
                                    <span class="col-2 text-start">Date programmed</span>
                                    <span class="col-2 text-start">Duration</span>
                                </div>
                                <div class="col-12 cards">
                                    <?php
                                    // let's load data from database
                                    $courses=DBManager::getInstance()->getAllCourses($order_value);
                                    // now let's print the data
                                    foreach($courses as $course){
                                        ?>
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body row d-flex flex-column flex-lg-row">
                                                    <span class="col-md-3 text-start">
                                                        <?php echo $course[DBContract::$Courses_Col_Title];?>
                                                    </span>
                                                    <span class="col-md-3 text-start">
                                                        <?php echo $course[DBContract::$Courses_Col_MentorName];?>
                                                    </span>
                                                    <span class="col-md-2 text-start">
                                                        <?php echo $course[DBContract::$Courses_Col_Date];?>
                                                    </span>
                                                    <span class="col-md-2 text-start">
                                                        <?php echo $course[DBContract::$Courses_Col_Duration];?>
                                                    </span>

                                                    <span class="col-lg-2 btns">
                                                        <a class="ic ic-edit btn" title="course edit button" href="courses.php?<?= "$ACTION_COURSES_KEY=$ACTION_COURSES_EDIT_FORM&$SELECTED_COURSE_ID_KEY=".$course[DBContract::$Courses_Col_Id] ?>"></a>
                                                        <a class="ic ic-delete btn" title="course delete" href="courses.php?<?= "$ACTION_COURSES_KEY=$ACTION_COURSES_DELETE&$SELECTED_COURSE_ID_KEY=".$course[DBContract::$Courses_Col_Id] ?>"></a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }if(count($courses)==0){?>
                                    <div class="alert alert-warning">
                                        There are no courses available please add some by clicking on "Add A Course" button
                                    </div>
                                    </div>
                         <?php }
                        }
                            elseif($action==$ACTION_COURSES_DELETE){
                                    //let's delete selected course
                                    $db_manager->deleteCourse($selected_course_id);
                                    redirect_with_js('courses.php');
                             }
                             elseif($action==$ACTION_COURSES_ADD_FORM){?>
                                 <form action="courses.php?<?= "$ACTION_COURSES_KEY=$ACTION_COURSES_ADD_SUBMIT" ?>" method="POST">
                                <h1>Add new Course</h1>
                                <div class="form-group">
                                    <label for="<?= DBContract::$Courses_Col_Title?>">Course title</label>
                                    <input placeholder="Jump course" type="text" class="form-control" name="<?= DBContract::$Courses_Col_Title?>" id="<?= DBContract::$Courses_Col_Title?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="<?= DBContract::$Courses_Col_MentorName?>">Mentor name</label>
                                    <input placeholder="Mr Jack" type="text" class="form-control" name="<?= DBContract::$Courses_Col_MentorName?>" id="<?= DBContract::$Courses_Col_MentorName?>" required>
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
                            elseif($action==$ACTION_COURSES_ADD_SUBMIT){
                                     if(areAllCourseFieldsSetAndValid()) {
                                        $db_manager->insertCourse(array(
                                            DBContract::$Courses_Col_Title=>$_POST[DBContract::$Courses_Col_Title],
                                            DBContract::$Courses_Col_MentorName=>$_POST[DBContract::$Courses_Col_MentorName],
                                            DBContract::$Courses_Col_Date=>$_POST[DBContract::$Courses_Col_Date],
                                            DBContract::$Courses_Col_Duration=>$_POST[DBContract::$Courses_Col_Duration],
                                        ));
                                        redirect_with_js("courses.php?$ACTION_COURSES_KEY=$ACTION_COURSES_LIST&$MSG_TYPE_KEY=course added successfully&$MSG_TYPE_KEY=$MSG_TYPE_POSITIVE");
                                    }else
                                        redirect_with_js("courses.php?$ACTION_COURSES_KEY=$ACTION_COURSES_ADD_FORM&$MSG_TYPE_KEY=failed to add course please make sure you have filled all  fields&$MSG_TYPE_KEY=$MSG_TYPE_NEGATIVE");
                                    }
                        elseif($action==$ACTION_COURSES_EDIT_FORM){
                                    $course=$db_manager->getCourseById($selected_course_id);
                                ?>
                        <form action="courses.php?<?= "$ACTION_COURSES_KEY=$ACTION_COURSES_EDIT_SUBMIT&$SELECTED_COURSE_ID_KEY=$selected_course_id" ?>" method="POST">
                            <h1>Edit <?= $course[DBContract::$Courses_Col_Title]?> Course</h1>
                            <div class="form-group">
                                <label for="<?= DBContract::$Courses_Col_Title?>">Course title</label>
                                <input placeholder="Jump course" type="text" class="form-control" name="<?= DBContract::$Courses_Col_Title?>" id="<?= DBContract::$Courses_Col_Title?>" value="<?= $course[DBContract::$Courses_Col_Title]?>" required>
                            </div>
                            <div class="form-group">
                                <label for="<?= DBContract::$Courses_Col_MentorName?>">Mentor name</label>
                                <input placeholder="Mr Jack" type="text" class="form-control" name="<?= DBContract::$Courses_Col_MentorName?>" id="<?= DBContract::$Courses_Col_MentorName?>" value="<?= $course[DBContract::$Courses_Col_MentorName]?>" required>
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
                        elseif($action==$ACTION_COURSES_EDIT_SUBMIT){
                            if(areAllCourseFieldsSetAndValid()) {
                                $db_manager->updateCourse($selected_course_id,array(
                                    DBContract::$Courses_Col_Title=>$_POST[DBContract::$Courses_Col_Title],
                                    DBContract::$Courses_Col_MentorName=>$_POST[DBContract::$Courses_Col_MentorName],
                                    DBContract::$Courses_Col_Date=>$_POST[DBContract::$Courses_Col_Date],
                                    DBContract::$Courses_Col_Duration=>$_POST[DBContract::$Courses_Col_Duration],
                                ));
                                 redirect_with_js("courses.php?$ACTION_COURSES_KEY=$ACTION_COURSES_LIST&$MSG_TYPE_KEY=course updated successfully&$MSG_TYPE_KEY=$MSG_TYPE_POSITIVE");
                            }else
                                 redirect_with_js("courses.php?$ACTION_COURSES_KEY=$ACTION_COURSES_ADD_FORM&$MSG_TYPE_KEY=failed to updated course please make sure you have filled all  fields&$MSG_TYPE_KEY=$MSG_TYPE_NEGATIVE");
                            }
                            else echo 'action not handled yet';?>
            </div>
        </div>
    </div>
</main>
<?php include 'footer.php'?>
</body>
</html>