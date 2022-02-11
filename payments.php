<?php
require_once 'include/DBManager.php';
require_once 'include/utils.php';
redirectToLoginIfnotLogged();
$ACTION_VIEW_PAYMENTS_LIST='avpl';
$ACTION_VIEW_PAYMENT_DETAILS='avpd';
$ACTION_KEY='a';
$action=$_GET[$ACTION_KEY]??$ACTION_VIEW_PAYMENTS_LIST;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payments</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/payments.css">
</head>
<body>
<main class="container-fluid bg-gray">
    <div class="row">
        <?php include 'sidebar.php';?>
        <div class="col content">
            <?php include 'header.php';?>
            <div class="main-content row p-2 d-flex align-items-center">
                <div class="col-12 main-content-toolbar d-flex pb-2 justify-content-between align-items-center border-bottom-light">
                    <h1 class="h4 fw-bold">Payment Details</h1>
                    <div class="toolbar-left-part">
                        <a class="sort ic ic-sort btn btn-sort" title="sort button" href="payments.php?<?= "$ORDER_KEY=$order_value_opposite"?>"></a>
                    </div>
                </div>
            </div>
            <?php if($action==$ACTION_VIEW_PAYMENTS_LIST){?>
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
                <span class="col-2 text-start">
                    Date
                </span>
            </div>
            <div class="col-12 cards">
                <?php
                    // let's load data from database
                    $payments=DBManager::getInstance()->getAllPayments($order_value);
                    // now let's print the data
                    foreach($payments as $payment){
                ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body row d-flex flex-column flex-lg-row">
                            <span class="col-lg-1 text-start">
                                <?php echo $payment[DBContract::$PaymentDetails_Col_Name];?>
                            </span>
                            <span class="col-lg-2 text-start">
                               <?php echo $payment[DBContract::$PaymentDetails_Col_PaymentSchechule];?>
                            </span>
                            <span class="col-lg-2 text-start">
                                <?php echo $payment[DBContract::$PaymentDetails_Col_BillNbr];?>
                            </span>
                            <span class="col-lg-2 text-start">
                                <?php echo 'DHS '.$payment[DBContract::$PaymentDetails_Col_AmountPaid];?>
                            </span>
                            <span class="col-lg-2 text-start">
                                <?php echo 'DHS '.$payment[DBContract::$PaymentDetails_Col_BalanceAmount];?>
                            </span>
                            <span class="col-lg-2 text-start">
                                 <?php echo $payment[DBContract::$PaymentDetails_Col_Date];?>
                            </span>
                            <span class="col-lg-1 btns">
                                <a class="ic ic-eye btn btn-details" title="details button" href="payments.php?<?= $ACTION_KEY.'='.$ACTION_VIEW_PAYMENT_DETAILS.'&'.DBContract::$PaymentDetails_Col_Id.'='.$payment[DBContract::$PaymentDetails_Col_Id] ?>">
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
            <?php }elseif($action==$ACTION_VIEW_PAYMENT_DETAILS){
                        if(!isset($_GET[DBContract::$PaymentDetails_Col_Id]) ){?>
                                <div class="alert alert-warning">
                                    No Payment specified
                                </div>
                                <?php }else{

                                    $payment=DBManager::getInstance()->getPaymentById($_GET[DBContract::$PaymentDetails_Col_Id]);
                                ?>
                            <form action="" class="col-12 col-md-6 offset-md-3">
                                <div class="form-group">
                                    <label for="<?= DBContract::$PaymentDetails_Col_Name ?>">Payment name</label>
                                    <input type="text" class="form-control" id="<?= DBContract::$PaymentDetails_Col_Name ?>" disabled
                                    value="<?= $payment[DBContract::$PaymentDetails_Col_Name] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="<?= DBContract::$PaymentDetails_Col_PaymentSchechule ?>">Payment schedule</label>
                                    <input type="text" class="form-control" id="<?= DBContract::$PaymentDetails_Col_PaymentSchechule ?>" disabled
                                           value="<?= $payment[DBContract::$PaymentDetails_Col_PaymentSchechule] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="<?= DBContract::$PaymentDetails_Col_BillNbr ?>">Bill Number</label>
                                    <input type="text" class="form-control" id="<?= DBContract::$PaymentDetails_Col_BillNbr ?>" disabled
                                           value="<?= $payment[DBContract::$PaymentDetails_Col_BillNbr] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="<?= DBContract::$PaymentDetails_Col_AmountPaid ?>">Amount paid</label>
                                    <input type="text" class="form-control" id="<?= DBContract::$PaymentDetails_Col_AmountPaid ?>" disabled
                                           value="<?= $payment[DBContract::$PaymentDetails_Col_AmountPaid] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="<?= DBContract::$PaymentDetails_Col_BalanceAmount ?>">Balance amount</label>
                                    <input type="text" class="form-control" id="<?= DBContract::$PaymentDetails_Col_BalanceAmount ?>" disabled
                                           value="<?= $payment[DBContract::$PaymentDetails_Col_BalanceAmount] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="<?= DBContract::$PaymentDetails_Col_Date ?>">Date</label>
                                    <input type="text" class="form-control" id="<?= DBContract::$PaymentDetails_Col_Date ?>" disabled
                                           value="<?= $payment[DBContract::$PaymentDetails_Col_Date] ?>">
                                </div>
                                <a href="payments.php" class="btn btn-primary" >Go back</a>
                            </form>
                                <?php
                                }
                }
            ?>
        </div>
    </div>
</main>
<?php include 'footer.php'?>
</body>
</html>