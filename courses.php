<?php
require_once 'include/DBManager.php';
$db_manager=DBManager::getInstance();
$ACTION_COURSES_LIST='courses_view';
$ACTION_COURSES_EDIT_FORM='cef';
$ACTION_COURSES_EDIT_SUBMIT='ces';
$ACTION_COURSES_ADD_FORM='caf';
$ACTION_COURSES_ADD_SUBMIT='cas';
$ACTION_COURSES_DELETE='cd';

$ACTION_COURSES_KEY='a';

$action=isset($_GET[$ACTION_COURSES_KEY])?$_GET[$ACTION_COURSES_KEY]:$ACTION_COURSES_LIST;
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
                    <div class="col-12 main-content-toolbar d-flex pb-2 justify-content-between align-items-center border-bottom-light">
                        <?php if($action==$ACTION_COURSES_LIST){?>
                        <h1 class="h4 fw-bold">Payment Details</h1>
                        <div class="toolbar-left-part">
                            <a class="sort ic ic-sort btn btn-sort" title="sort button"></a>
                        </div>

                        <div class="table-header d-none d-lg-flex row mb-2 ps-2">
                                <span class="col-1 text-start ps-3">
                                    Name
                                </span>
                            <span class="col-2 text-start">
                                    Payment Schedule
                                </span>
                            <span class="col-2 text-start">
                                    Bill Number
                                </span>
                            <span class="col-2 text-start">
                                   Amount Paid
                                </span>
                            <span class="col-2 text-start">
                                    Balance amount
                                </span>
                            <span class="col-2 text-start">Date</span>
                        </div>
                        <div class="col-12 cards">
                            <?php
                            // let's load data from database
                            $courses=DBManager::getInstance()->getAllCourses();
                            // now let's print the data
                            foreach($courses as $course){
                                ?>
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body row d-flex flex-column flex-lg-row">
                                    <span class="col-lg-1 text-start">
                                        <?php echo $course[DBContract::$PaymentDetails_Col_Name];?>
                                    </span>
                                                    <span class="col-lg-2 text-start">
                                       <?php echo $course[DBContract::$PaymentDetails_Col_PaymentSchechule];?>
                                    </span>
                                                    <span class="col-lg-2 text-start">
                                        <?php echo $course[DBContract::$PaymentDetails_Col_BillNbr];?>
                                    </span>
                                                    <span class="col-lg-2 text-start">
                                        <?php echo 'DHS '.$course[DBContract::$PaymentDetails_Col_AmountPaid];?>
                                    </span>
                                                    <span class="col-lg-2 text-start">
                                        <?php echo 'DHS '.$course[DBContract::$PaymentDetails_Col_BalanceAmount];?>
                                    </span>
                                                    <span class="col-lg-2 text-start">
                                         <?php echo $course[DBContract::$PaymentDetails_Col_Date];?>
                                    </span>
                                                    <span class="col-lg-1 btns">
                                        <a class="ic ic-eye btn btn-details" title="details button" href="payments.php?<?= $ACTION_KEY.'='.$ACTION_VIEW_PAYMENT_DETAILS.'&'.DBContract::$PaymentDetails_Col_Id.'='.$course[DBContract::$PaymentDetails_Col_Id] ?>">
                                        </a>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                    </div>
                        <?php }else{?>
                            let's handle another action type !

                        <?php }?>
            </div>
        </div>
    </div>
</main>
</body>
</html>